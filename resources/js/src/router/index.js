// ✅ Importamos la función para crear el enrutador con historial tipo HTML5
import { createRouter, createWebHistory } from 'vue-router'

// ✅ Importamos los componentes de Vue que estarán asociados a rutas
import MovieList from '../components/MovieList.vue'         // Lista principal de películas
import MovieDetail from '../components/MovieDetail.vue'     // Detalle de una película
import MainLayout from '../layouts/MainLayout.vue'          // Layout general (navbar, footer, etc.)
import Novelties from '../components/Novelties.vue'         // Películas nuevas desde último acceso
import EditMovie from '../components/EditMovie.vue'         // Formulario de edición de películas

// ✅ Definimos las rutas de la aplicación
const routes = [
  {
    // Ruta principal del sitio
    path: '/',
    component: MainLayout, // Layout global para estas rutas hijas

    // ✅ Rutas hijas que se cargarán dentro de <router-view /> en MainLayout.vue
    children: [
      { 
        path: '', // Equivale a '/'
        name: 'Home',
        component: MovieList // Página principal: muestra películas paginadas
        // 🔹 Relacionado con 03_01, 06_01
      },

      {
        path: 'movie/:id',
        name: 'MovieDetail',
        component: MovieDetail // Página de detalle de una película
        // 🔹 Relacionado con 03_01, 08_01 (ver detalles, vídeo)
      },

      {
        path: 'novelties',
        name: 'Novelties',
        component: Novelties // Página que muestra películas nuevas desde el último acceso
        // 🔹 Relacionado con 04_01
      },

      {
        path: 'movie/:id/edit',
        name: 'EditMovie',
        component: EditMovie // Página para editar una película
        // 🔹 Relacionado con 05_01
      }
    ]
  }
]

// ✅ Creamos el enrutador con historial web
const router = createRouter({
  history: createWebHistory(), // Utiliza rutas normales tipo `/path` en vez de `#/path`
  routes                        // Asignamos las rutas definidas
})

// ✅ Exportamos el enrutador para usarlo en main.js
export default router
