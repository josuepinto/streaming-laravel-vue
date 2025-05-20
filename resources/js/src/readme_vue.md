# PiFlix - Proyecto Vue + Laravel + IndexedDB + SW

**Desarrollado por:** Josue Pinto  
**Frameworks:** Laravel (backend), Vue 3 (frontend)  
**Funcionalidades:** CRUD de películas, novedades, búsqueda, IndexedDB, Service Worker

---

## 📁 Estructura del Proyecto

```bash
├── public/
│   ├── service-worker.js
│   └── sw-indexedDB.js
├── resources/js/
│   ├── src/
│   │   ├── App.vue
│   │   ├── main.js
│   │   ├── router/index.js
│   │   ├── videoService.js
│   │   ├── indexedDB.js
│   │   └── components/
│   │       ├── MovieList.vue
│   │       ├── MovieDetail.vue
│   │       ├── EditMovie.vue
│   │       └── Novelties.vue
```

---

## 🧩 Funcionalidades por Criterio

### ✅ 03_01: Lista y Detalle de Películas
- `MovieList.vue`: muestra películas paginadas.
- `MovieDetail.vue`: detalle individual con botón para volver a la lista conservando la página.

### ✅ 04_01: Novedades desde último login + Bootstrap
- Laravel actualiza `last_login` al iniciar sesión.
- API `/api/novelties` devuelve novedades.
- `Novelties.vue` muestra novedades con cards Bootstrap.

### ✅ 05_01: Formulario de edición completo
- `EditMovie.vue`: formulario que incluye:
  - Checkbox dinámico para género.
  - Input tipo fecha para año.
  - Redirección a MovieList.vue mostrando cambios.

### ✅ 06_01: Carga películas y búsqueda desde Laravel
- `/api/movies/search?q=...` consulta desde Vue.
- Integrado en MovieList.vue con watcher sobre `$route.query.q`.

### ✅ 07_01: Guardar en HD vía IndexedDB
- `sw-indexedDB.js`: gestiona base PiFlixDB con store `movies`.
- `service-worker.js`:
  - Al recibir `cache-movies`, descarga películas y novedades.
  - Guarda todo localmente con paginación.

### ✅ 08_01: Video desde HD o Laravel
- `videoService.js`: permite obtener y guardar por ID en IndexedDB.
- `MovieDetail.vue`:
  - Si encuentra la película en IndexedDB, la usa.
  - Si no, la obtiene desde Laravel y la guarda.
  - Muestra video con `<iframe :src="movie.video_url" />`

---

## 🛠 Recomendaciones Técnicas

- Usa navegador Chromium moderno.
- Asegúrate de lanzar `sail npm run dev` y que Vite compile sin errores.
- Si IndexedDB tiene errores de versión:
  - Elimina base desde DevTools → Application → IndexedDB → Delete DB.

---

## 📜 Créditos
Este proyecto se desarrolló como práctica para el módulo M07/M08 (Despliegue y Cliente) del ciclo DAW - Escola del Treball.
