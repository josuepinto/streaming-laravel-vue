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
export default {
  data() {
    return {
      movie: {}
    }
  },
  mounted() {
    const id = this.$route.params.id
    fetch(`/api/movies/${id}`)
      .then(res => res.json())
      .then(data => (this.movie = data))
      .catch(err => console.error('Error loading movie:', err))
  },
  methods: {
    goBack() {
      const savedURL = sessionStorage.getItem('lastMovieListURL') || '/api/movies'
      // Redirige al listado forzando la recarga con la URL paginada guardada
      this.$router.push({ name: 'Home' })
      this.$nextTick(() => {
        sessionStorage.setItem('goToURL', savedURL)
      })
    }
  }
}
</script>
