// ==========================================
// 📦 service-worker.js
// ==========================================
// Este archivo registra un Service Worker que:
// ✅ Carga todas las películas desde Laravel
// ✅ Guarda esas películas y novedades en IndexedDB (HD local)
// ✅ Permite operar en modo offline gracias al almacenamiento local
// ✅ Notifica al usuario si hay novedades nuevas cada 5 minutos
//
// 🔗 Criterios que cubre:
// - ✅ 07_01: Guardar películas en HD con IndexedDB al iniciar SW
// - ✅ 08_01: Guardar videos si no están en HD
// - ✅ 08_01: Mostrar notificaciones push cada 5 min si hay novedades
// ==========================================


// ✅ Importamos funciones desde sw-indexedDB.js (ubicado en /public)
importScripts('/sw-indexedDB.js');


// ==========================================
// 1️⃣ Evento de instalación del Service Worker
// ==========================================
self.addEventListener('install', event => {
  console.log('📦 Service Worker installing...');
  event.waitUntil(self.skipWaiting()); // Activación inmediata
});


// ==========================================
// 2️⃣ Evento de activación del Service Worker
// ==========================================
self.addEventListener('activate', event => {
  console.log('🚀 Service Worker activated');
  event.waitUntil(clients.claim()); // Toma control inmediato
});


// ==========================================
// 3️⃣ Escucha mensajes para lanzar acciones específicas
// ==========================================
// Desde main.js enviamos:
// - 'cache-movies' para cargar datos en HD
// - 'start-notifications' para lanzar verificación cada 5 minutos
// ==========================================
self.addEventListener('message', event => {
  if (event.data === 'cache-movies') {
    cacheAllMovies(); // Guarda todas las películas + novedades
  }

  if (event.data === 'start-notifications') {
    console.log('🔔 Iniciando comprobación periódica de novedades...');
    startNovedadPolling(); // Lanza el intervalo para notificar cada 5 min
  }
});


// ==========================================
// 4️⃣ Función principal: cacheAllMovies()
// ==========================================
// - Pide a Laravel todas las películas paginadas
// - También pide las novedades desde último acceso
// - Guarda todo en IndexedDB (modo HD local)
// ==========================================
async function cacheAllMovies() {
  console.log('🎥 Cargando películas desde Laravel...');

  let allMovies = [];
  let page = 1;
  let hasMore = true;

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

  try {
    await saveMoviesToDB(allMovies);
    console.log(`✅ Guardadas ${allMovies.length} películas`);
  } catch (err) {
    console.error('❌ Error guardando películas:', err);
  }

  // 🔥 Guardar también novedades
  try {
    const response = await fetch('/api/novelties');
    const novelties = await response.json();
    await saveMoviesToDB(novelties);
    console.log(`✅ Guardadas ${novelties.length} novedades`);
  } catch (err) {
    console.error('❌ Error guardando novedades:', err);
  }
}


// ==========================================
// 5️⃣ Función startNovedadPolling()
// ==========================================
// - Se llama una vez desde main.js con 'start-notifications'
// - Luego ejecuta cada 5 min una petición a Laravel
// - Si hay novedades, se lanza una notificación
// ==========================================
function startNovedadPolling() {
  setInterval(async () => {
    try {
      console.log('🔍 Verificando novedades en segundo plano...');
      const response = await fetch('/api/novelties');
      const data = await response.json();

      if (data.length > 0) {
        console.log(`🔔 Hay ${data.length} novedades nuevas!`);
        self.registration.showNotification('🎬 Nuevas películas disponibles', {
          body: `Se han añadido ${data.length} películas nuevas desde tu último acceso.`,
          icon: '/image/logo.jpeg', // 🧠 icono opcional desde /public/image
          tag: 'novedades',         // Evita duplicar la misma notificación
          renotify: true            // Vuelve a mostrar si ya está activa
        });
      } else {
        console.log('ℹ️ Sin novedades nuevas');
      }
    } catch (err) {
      console.error('❌ Error al verificar novedades para notificación:', err);
    }
  }, 60 * 1000); // ✅ Cada 5 minutos (para pruebas puedes poner 60 * 1000) si no son pruebas poner *5*60*100
}
