// videoService.js

import { openDB } from './indexedDB.js'; // usamos tu mismo archivo de DB

const STORE_NAME = 'movies'; // Usamos el mismo store

// Función para buscar una película por ID en IndexedDB
export async function getMovieFromIndexedDB(id) {
  const db = await openDB();
  return new Promise((resolve, reject) => {
    const tx = db.transaction(STORE_NAME, 'readonly');
    const store = tx.objectStore(STORE_NAME);
    const request = store.get(Number(id));
    request.onsuccess = () => resolve(request.result);
    request.onerror = () => reject('❌ Error al leer IndexedDB');
  });
}

// Función para guardar una película (si viene de la API)
export async function saveMovieToIndexedDB(movie) {
  const db = await openDB();
  const tx = db.transaction(STORE_NAME, 'readwrite');
  const store = tx.objectStore(STORE_NAME);
  store.put(movie);
  return tx.complete;
}
