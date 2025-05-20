// ================================
// 🎞️ videoService.js
// ================================
// Este archivo contiene funciones reutilizables para
// guardar y recuperar películas específicas desde IndexedDB.
// Se utiliza principalmente en el componente MovieDetail.vue
// para mostrar el video en modo offline si ya ha sido cacheado.

// 🔗 Criterio de evaluación relacionado:
// ✅ 08_01: Videos → Si el video está guardado en HD (IndexedDB), usarlo. Si no, obtenerlo del servidor Laravel.

// Importamos la función openDB desde nuestro archivo de base de datos
import { openDB } from './indexedDB.js'; // usamos tu mismo archivo de DB

// Definimos el nombre del store donde se guardan las películas
const STORE_NAME = 'movies'; // Usamos el mismo store que en indexedDB.js

// ================================
// 1️⃣ getMovieFromIndexedDB(id)
// ================================
// Recupera una película por su ID desde IndexedDB
export async function getMovieFromIndexedDB(id) {
  const db = await openDB(); // Abrimos conexión con la DB

  return new Promise((resolve, reject) => {
    const tx = db.transaction(STORE_NAME, 'readonly'); // Transacción de solo lectura
    const store = tx.objectStore(STORE_NAME);          // Accedemos al store de películas

    const request = store.get(Number(id)); // Solicitamos la película por su ID

    // Si se encuentra correctamente, devolvemos el resultado
    request.onsuccess = () => resolve(request.result);

    // Si hay error, lo reportamos
    request.onerror = () => reject('❌ Error al leer IndexedDB');
  });
}

// ================================
// 2️⃣ saveMovieToIndexedDB(movie)
// ================================
// Guarda (o actualiza) una película completa en IndexedDB
export async function saveMovieToIndexedDB(movie) {
  const db = await openDB(); // Abrimos conexión
  const tx = db.transaction(STORE_NAME, 'readwrite'); // Transacción de escritura
  const store = tx.objectStore(STORE_NAME); // Accedemos al store

  store.put(movie); // put inserta o actualiza por ID

  return tx.complete; // Esperamos a que la transacción finalice
}
