// ================================
// 📦 sw-indexedDB.js
// ================================
// Este archivo define funciones para que el Service Worker
// pueda acceder y almacenar películas en IndexedDB.
// Es utilizado por `service-worker.js` para guardar en HD todas las películas
// y las novedades al iniciar la aplicación (modo offline).

// 🔗 Criterios de evaluación implicados:
// ✅ 07_01: Guardar pel·lícules en HD amb indexedDB → en iniciar SW, carregar store
// ✅ 08_01: Videos → guardar películas que incluyen URLs de vídeo


// ================================
// 📁 Configuración de la base de datos
// ================================
const DB_NAME = 'PiFlixDB';         // Nombre de la base de datos
const DB_VERSION = 2;               // Versión actual (subida a 2 si hubo cambios)
const STORE_NAME = 'movies';        // Nombre del store que contiene las películas


// ================================
// 1️⃣ openDB()
// ================================
// Abre o crea la base de datos si no existe
function openDB() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open(DB_NAME, DB_VERSION);

    // ⚠️ Error al abrir
    request.onerror = (event) => {
      console.error('❌ Error opening IndexedDB:', event.target.error);
      reject(event.target.error);
    };

    // ✅ Base de datos abierta correctamente
    request.onsuccess = (event) => {
      resolve(event.target.result);
    };

    // 🔧 Si es primera vez o hay cambio de versión
    request.onupgradeneeded = (event) => {
      const db = event.target.result;

      // Creamos el store si no existe
      if (!db.objectStoreNames.contains(STORE_NAME)) {
        db.createObjectStore(STORE_NAME, { keyPath: 'id' }); // clave primaria: id de película
      }
    };
  });
}


// ================================
// 2️⃣ saveMoviesToDB(movies)
// ================================
// Guarda un array de películas en IndexedDB
function saveMoviesToDB(movies) {
  return openDB().then(db => {
    return new Promise((resolve, reject) => {
      const tx = db.transaction(STORE_NAME, 'readwrite'); // Transacción en modo escritura
      const store = tx.objectStore(STORE_NAME);           // Accedemos al store

      // Guardamos cada película individualmente
      movies.forEach(movie => {
        store.put(movie); // put = insert o update por id
      });

      // ✅ Todo correcto
      tx.oncomplete = () => {
        resolve();
      };

      // ⚠️ Error en la transacción
      tx.onerror = (event) => {
        console.error('❌ Error en transacción:', event.target.error);
        reject(event.target.error);
      };
    });
  });
}


// ================================
// 3️⃣ Exponer funciones al Service Worker
// ================================
// Estas funciones estarán disponibles dentro de `service-worker.js`
self.saveMoviesToDB = saveMoviesToDB;
self.openDB = openDB;
