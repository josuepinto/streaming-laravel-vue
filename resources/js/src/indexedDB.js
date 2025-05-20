// ================================
// 📁 indexedDB.js
// ================================
// Este archivo contiene funciones para interactuar con IndexedDB,
// permitiendo guardar películas localmente (offline-first).
// 🔗 Criterio de evaluación relacionado: 07_01 (IndexedDB)

// Nombre y versión de la base de datos
const DB_NAME = 'PiFlixDB';
const DB_VERSION = 2; // Versionamos la DB para poder añadir stores si es necesario
const STORE_NAME = 'movies'; // Nombre del almacén de películas

// ================================
// 1️⃣ Abrir o crear la base de datos
// ================================
export function openDB() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open(DB_NAME, DB_VERSION);

    // ❌ Si hay error al abrir la base de datos
    request.onerror = (event) => {
      console.error('❌ Error opening IndexedDB:', event.target.error);
      reject(event.target.error);
    };

    // ✅ Si se abre correctamente
    request.onsuccess = (event) => {
      console.log('✅ IndexedDB opened');
      resolve(event.target.result); // devolvemos la instancia DB
    };

    // 🆕 Se ejecuta al crear la DB por primera vez o al cambiar la versión
    request.onupgradeneeded = (event) => {
      const db = event.target.result;

      // Creamos el store 'movies' si no existe
      if (!db.objectStoreNames.contains(STORE_NAME)) {
        db.createObjectStore(STORE_NAME, { keyPath: 'id' }); // usaremos el id como clave primaria
        console.log('📁 Store created:', STORE_NAME);
      }
    };
  });
}

// ================================
// 2️⃣ Guardar películas en IndexedDB
// ================================
export async function saveMoviesToDB(movies) {
  const db = await openDB(); // abrir conexión
  const tx = db.transaction(STORE_NAME, 'readwrite'); // transacción en modo escritura
  const store = tx.objectStore(STORE_NAME); // accedemos al store de películas

  // 🔁 Guardamos cada película por su ID
  movies.forEach(movie => {
    store.put(movie); // put: crea o reemplaza si ya existe
  });

  return tx.complete; // devolvemos la promesa que representa el fin de la transacción
}

// ================================
// 3️⃣ Leer todas las películas guardadas
// ================================
export function getAllMovies() {
  return openDB().then(db => {
    return new Promise((resolve) => {
      const tx = db.transaction(STORE_NAME, 'readonly'); // solo lectura
      const store = tx.objectStore(STORE_NAME);
      const request = store.getAll(); // obtenemos todo el contenido del store

      request.onsuccess = () => resolve(request.result); // devolvemos el array de películas
    });
  });
}
