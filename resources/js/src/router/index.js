import { createRouter, createWebHistory } from 'vue-router'
import MovieList from '../components/MovieList.vue'
import MovieDetail from '../components/MovieDetail.vue'
import MainLayout from '../layouts/MainLayout.vue'
import Novelties from '../components/Novelties.vue'
import EditMovie from '../components/EditMovie.vue'


const routes = [
 {
  path: '/',
  component: MainLayout,
  children: [
    { path: '', name: 'Home', component: MovieList },
    { path: 'movie/:id', name: 'MovieDetail', component: MovieDetail },
    { path: 'novelties', name: 'Novelties', component: Novelties },
    { path: 'movie/:id/edit', name: 'EditMovie', component: EditMovie }
  ]
}

]


const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
