import { createRouter, createWebHistory } from 'vue-router'
import MovieList from '../components/MovieList.vue'
import MovieDetail from '../components/MovieDetail.vue'
import MainLayout from '../layouts/MainLayout.vue'


const routes = [
 {
  path: '/',
  component: MainLayout,
  children: [
    { path: '', name: 'Home', component: MovieList },
    { path: 'movie/:id', name: 'MovieDetail', component: MovieDetail }
  ]
}

]


const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
