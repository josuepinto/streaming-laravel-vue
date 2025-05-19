// sw-indexedDB.js

const DB_NAME = 'PiFlixDB';
const DB_VERSION = 1;
const STORE_NAME = 'movies';

// Abrir o crear la base de datos
function openDB() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open(DB_NAME, DB_VERSION);

    request.onerror = (event) => {
      console.error('❌ Error opening IndexedDB:', event.target.error);
      reject(event.target.error);
    };

    request.onsuccess = (event) => {
      resolve(event.target.result);
    };

    request.onupgradeneeded = (event) => {
      const db = event.target.result;
      if (!db.objectStoreNames.contains(STORE_NAME)) {
        db.createObjectStore(STORE_NAME, { keyPath: 'id' });
      }
    };
  });
}

// 💾 Guardar películas en IndexedDB
function saveMoviesToDB(movies) {
  return openDB().then(db => {
    return new Promise((resolve, reject) => {
      const tx = db.transaction(STORE_NAME, 'readwrite');
      const store = tx.objectStore(STORE_NAME);

      movies.forEach(movie => {
        store.put(movie);
      });

      tx.oncomplete = () => {
        resolve();
      };

      tx.onerror = (event) => {
        console.error('❌ Error en transacción:', event.target.error);
        reject(event.target.error);
      };
    });
  });
}

// 🟢 Hacer visibles las funciones para service-worker.js
self.saveMoviesToDB = saveMoviesToDB;
self.openDB = openDB;
