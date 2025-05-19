<template>
  <div class="container mt-4">
    <h2 class="mb-4 text-center">🎬 Movie List</h2>

    <div v-if="movies.data && movies.data.length" class="row">
      <div
        v-for="movie in movies.data"
        :key="movie.id"
        class="col-md-4 mb-4"
      >
        <router-link
          :to="`/movie/${movie.id}`"
          class="text-decoration-none text-dark"
        >
          <div class="card h-100">
            <img
              :src="movie.image"
              class="card-img-top"
              alt="Movie Image"
              style="object-fit: cover; height: 400px"
            />
            <div class="card-body">
              <h5 class="card-title">{{ movie.title }}</h5>
              <p class="card-text">{{ movie.description }}</p>
              <p class="mb-1"><strong>Genre:</strong> {{ movie.genre }}</p>
              <p class="mb-1"><strong>Year:</strong> {{ movie.year }}</p>
              <p class="mb-1"><strong>Actor:</strong> {{ movie.actor }}</p>
              <p class="mb-1"><strong>Director:</strong> {{ movie.director }}</p>
            </div>
          </div>
        </router-link>
      </div>
    </div>

    <div class="mt-4 text-center" v-if="movies.total > movies.per_page">
      <button
        class="btn btn-secondary me-2"
        @click="changePage(movies.prev_page_url)"
        :disabled="!movies.prev_page_url"
      >
        ← Previous
      </button>
      <button
        class="btn btn-primary"
        @click="changePage(movies.next_page_url)"
        :disabled="!movies.next_page_url"
      >
        Next →
      </button>
    </div>

    <div v-if="!movies.data || !movies.data.length" class="text-center mt-5">
      <p>No movies available.</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      movies: {}
    }
  },
mounted() {
  const storedURL = sessionStorage.getItem('goToURL') || '/api/movies'
  this.getMovies(storedURL)
  sessionStorage.removeItem('goToURL')
},

  methods: {
    getMovies(url) {
      fetch(url)
        .then(res => res.json())
        .then(data => (this.movies = data))
        .catch(err => console.error('Error loading movies:', err))
    },
    changePage(url) {
  if (url) {
    sessionStorage.setItem('lastMovieListURL', url)
    this.getMovies(url)
  }
}

  }
}
</script>
