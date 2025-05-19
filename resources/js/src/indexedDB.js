// indexedDB.js

const DB_NAME = 'PiFlixDB';
const DB_VERSION = 1;
const STORE_NAME = 'movies';

// Abrir o crear la base de datos
export function openDB() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open(DB_NAME, DB_VERSION);

    request.onerror = (event) => {
      console.error('❌ Error opening IndexedDB:', event.target.error);
      reject(event.target.error);
    };

    request.onsuccess = (event) => {
      console.log('✅ IndexedDB opened');
      resolve(event.target.result);
    };

    // Se ejecuta si es la primera vez o si cambia la versión
    request.onupgradeneeded = (event) => {
      const db = event.target.result;
      if (!db.objectStoreNames.contains(STORE_NAME)) {
        db.createObjectStore(STORE_NAME, { keyPath: 'id' });
        console.log('📁 Store created:', STORE_NAME);
      }
    };
  });
}

// Guardar películas en la base de datos
export async function saveMoviesToDB(movies) {
  const db = await openDB();
  const tx = db.transaction(STORE_NAME, 'readwrite');
  const store = tx.objectStore(STORE_NAME);

  movies.forEach(movie => {
    store.put(movie);
  });

  return tx.complete;
}

// Leer todas las películas
export function getAllMovies() {
  return openDB().then(db => {
    return new Promise((resolve) => {
      const tx = db.transaction(STORE_NAME, 'readonly');
      const store = tx.objectStore(STORE_NAME);
      const request = store.getAll();

      request.onsuccess = () => resolve(request.result);
    });
  });
}
