// ✅ DOCUMENTACIÓN FINAL DE CRITERIOS 03_01 a 08_01 — Vue + Laravel
// Proyecto: PiFlix — Aplicación de streaming con IndexedDB y Service Workers

/*
------------------------------------------------------------
🔷 03_01: Ver lista de películas paginada y detalle con retorno
------------------------------------------------------------
*/

// 📍 Archivo: MovieList.vue
// - Se muestra la lista paginada de películas.
// - Permite navegar entre páginas con botones y consultar el backend.
// - Cada película tiene enlace al detalle.

// 📍 Archivo: MovieDetail.vue
// - Carga los datos de la película por ID.
// - Muestra todos los campos incluyendo imagen y video.
// - El botón "Back to list" guarda la URL actual y vuelve a la lista manteniendo la posición.

// 📍 En router-view principal se recupera sessionStorage['goToURL'] si existe.

/*
------------------------------------------------------------
🔷 04_01: Ver novedades desde último acceso + Bootstrap
------------------------------------------------------------
*/

// 📍 Laravel (web.php):
Route::get('/api/novelties', function () {
  $userId = Session::get('user_id');
  $user = \App\Models\User::find($userId);
  return \App\Models\Movie::where('created_at', '>', $user->last_login)->get();
});

// 📍 Vue (Novelties.vue):
// - Se muestra una vista con las novedades desde último login.
// - Al iniciar sesión, Laravel actualiza last_login.
// - Se carga vía fetch `/api/novelties`.
// - Se aplica Bootstrap con cards para mostrar las novedades.

/*
------------------------------------------------------------
🔷 05_01: Formulario para modificar datos de película
------------------------------------------------------------
*/

// 📍 Archivo: EditMovie.vue
// - Formulario para editar una película.
// - Usa checkbox dinámicos para géneros.
// - Usa <input type="date"> para seleccionar el año.
// - Al guardar, actualiza la película vía API y vuelve a la lista mostrando los cambios.

/*
------------------------------------------------------------
🔷 06_01: Buscar películas desde Laravel y cargarlas en Vue
------------------------------------------------------------
*/

// 📍 Laravel (api.php):
Route::get('/movies/search', function (Request $request) {
  return \App\Models\Movie::where('title', 'like', "%{$request->q}%")->get();
});

// 📍 Vue:
// - En MovieList.vue, se detecta si existe `$route.query.q`
// - Se lanza fetch a `/api/movies/search?q=...` si hay término de búsqueda

/*
------------------------------------------------------------
🔷 07_01: Guardar películas en IndexedDB (HD) desde Service Worker
------------------------------------------------------------
*/

// 📍 Archivo: public/sw-indexedDB.js
const DB_NAME = 'PiFlixDB';
const DB_VERSION = 2;
const STORE_NAME = 'movies';

function openDB() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open(DB_NAME, DB_VERSION);
    request.onupgradeneeded = (e) => {
      const db = e.target.result;
      if (!db.objectStoreNames.contains(STORE_NAME)) {
        db.createObjectStore(STORE_NAME, { keyPath: 'id' });
      }
    };
    request.onsuccess = (e) => resolve(e.target.result);
    request.onerror = (e) => reject(e.target.error);
  });
}

function saveMoviesToDB(movies) {
  return openDB().then(db => {
    const tx = db.transaction(STORE_NAME, 'readwrite');
    const store = tx.objectStore(STORE_NAME);
    movies.forEach(movie => store.put(movie));
    return tx.complete;
  });
}

self.saveMoviesToDB = saveMoviesToDB;
self.openDB = openDB;

// 📍 Service Worker: public/service-worker.js
importScripts('/sw-indexedDB.js');

self.addEventListener('install', e => e.waitUntil(self.skipWaiting()));
self.addEventListener('activate', e => e.waitUntil(clients.claim()));

self.addEventListener('message', e => {
  if (e.data === 'cache-movies') cacheAllMovies();
});

async function cacheAllMovies() {
  let allMovies = [];
  let page = 1, hasMore = true;

  while (hasMore) {
    const response = await fetch(`/api/movies?page=${page}`);
    const data = await response.json();
    if (data.data?.length) {
      allMovies = allMovies.concat(data.data);
      page++;
      hasMore = page <= data.last_page;
    } else hasMore = false;
  }
  await saveMoviesToDB(allMovies);

  const res = await fetch('/api/novelties');
  const novelties = await res.json();
  await saveMoviesToDB(novelties);
}

/*
------------------------------------------------------------
🔷 08_01: Videos — cargar desde IndexedDB si existen
------------------------------------------------------------
*/

// 📍 Archivo: videoService.js
import { openDB } from './indexedDB.js';
const STORE = 'movies';

export async function getMovieFromIndexedDB(id) {
  const db = await openDB();
  return new Promise((resolve) => {
    const tx = db.transaction(STORE, 'readonly');
    const store = tx.objectStore(STORE);
    const req = store.get(Number(id));
    req.onsuccess = () => resolve(req.result);
  });
}

export async function saveMovieToIndexedDB(movie) {
  const db = await openDB();
  const tx = db.transaction(STORE, 'readwrite');
  tx.objectStore(STORE).put(movie);
  return tx.complete;
}

// 📍 MovieDetail.vue
// - Se carga primero desde IndexedDB por ID.
// - Si no está, se carga desde Laravel y se guarda en IndexedDB.
// - El video (`movie.video_url`) se muestra como <iframe> YouTube.

/*
📌 Estado Final: Todas las funcionalidades completadas según los criterios.
📌 Todas las rutas y archivos se mantienen sin romper nada previo.
*/
