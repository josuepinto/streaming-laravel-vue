// service-worker.js

// Importamos la lógica de IndexedDB
importScripts('/sw-indexedDB.js');

// Evento de instalación del SW
self.addEventListener('install', event => {
  console.log('📦 Service Worker installing...');
  event.waitUntil(self.skipWaiting());
});

self.addEventListener('activate', event => {
  console.log('🚀 Service Worker activated');
  event.waitUntil(clients.claim());
});

// Cuando recibe el mensaje para guardar todo
self.addEventListener('message', event => {
  if (event.data === 'cache-movies') {
    cacheAllMovies(); // llama a la función que hace todo
  }
});

async function cacheAllMovies() {
  console.log('🎥 Cargando películas desde Laravel...');

  let allMovies = [];
  let page = 1;
  let hasMore = true;

  // Paginación para traer todas las películas
  while (hasMore) {
    const response = await fetch(`/api/movies?page=${page}`);
    const data = await response.json();

    if (data.data && data.data.length) {
      allMovies = allMovies.concat(data.data);
      page++;
      hasMore = page <= data.last_page;
    } else {
      hasMore = false;
    }
  }

  console.log(`📁 Guardando ${allMovies.length} películas en IndexedDB...`);
  try {
    await saveMoviesToDB(allMovies);
    console.log('✅ Películas guardadas con éxito');
  } catch (err) {
    console.error('❌ Error guardando películas:', err);
  }

  // 🔥 NOVEDADES 🔥
  try {
    const response = await fetch('/api/novelties');
    const novelties = await response.json();
    console.log(`📁 Guardando ${novelties.length} novedades en IndexedDB...`);
    await saveMoviesToDB(novelties);
    console.log('✅ Novedades guardadas con éxito');
  } catch (err) {
    console.error('❌ Error guardando novedades:', err);
  }
}
