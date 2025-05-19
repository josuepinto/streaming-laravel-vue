<template>
  <div class="container mt-4">
    <h2 class="mb-3">{{ movie.title }}</h2>

    <img :src="movie.image" alt="Movie Banner" class="img-fluid mb-3" />

    <p><strong>Genre:</strong> {{ movie.genre }}</p>
    <p><strong>Year:</strong> {{ movie.year }}</p>
    <p><strong>Actor:</strong> {{ movie.actor }}</p>
    <p><strong>Director:</strong> {{ movie.director }}</p>
    <p class="mb-4">{{ movie.description }}</p>

    <div class="ratio ratio-16x9 mb-4">
      <iframe
        :src="movie.video_url"
        frameborder="0"
        allowfullscreen
      ></iframe>
    </div>

    <button class="btn btn-secondary" @click="goBack">← Back to list</button>
  </div>
</template>

<script>
import { getMovieFromIndexedDB, saveMovieToIndexedDB } from '../videoService.js'


export default {
  data() {
    return {
      movie: {}
    }
  },
  async mounted() {
    const id = this.$route.params.id

    // Primero intentamos cargar desde IndexedDB
    const fromIndexedDB = await getMovieFromIndexedDB(id)

    if (fromIndexedDB && fromIndexedDB.video_url) {
      console.log('🎥 Video cargado desde IndexedDB');
      this.movie = fromIndexedDB
    } else {
      // Si no está, lo pedimos al backend
      console.log('🌐 Cargando desde API de Laravel...');
      fetch(`/api/movies/${id}`)
        .then(res => res.json())
        .then(data => {
          this.movie = data
          saveMovieToIndexedDB(data) // lo guardamos en HD para el futuro
        })
        .catch(err => console.error('Error loading movie:', err))
    }
  },
  methods: {
    goBack() {
      const savedURL = sessionStorage.getItem('lastMovieListURL') || '/api/movies'
      this.$router.push({ name: 'Home' })
      this.$nextTick(() => {
        sessionStorage.setItem('goToURL', savedURL)
      })
    }
  }
}
</script>
