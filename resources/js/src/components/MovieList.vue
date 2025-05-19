<template>
  <div class="container mt-4">
    <h2 class="mb-4 text-center">🎬 Movie List</h2>

    <!-- Mostrar lista si hay películas -->
    <div v-if="movies.length" class="row">
      <div v-for="movie in movies" :key="movie.id" class="col-md-4 mb-4">
        <div class="card h-100">
          <img :src="movie.image" class="card-img-top" style="height: 400px; object-fit: cover;" />
          <div class="card-body">
            <h5 class="card-title">{{ movie.title }}</h5>
            <p class="card-text">{{ movie.description }}</p>
            <p><strong>Genre:</strong> {{ movie.genre }}</p>
            <p><strong>Year:</strong> {{ movie.year }}</p>
            <p><strong>Actor:</strong> {{ movie.actor }}</p>
            <p><strong>Director:</strong> {{ movie.director }}</p>
          </div>
          <div class="card-footer d-flex justify-content-between">
            <router-link :to="`/movie/${movie.id}`" class="btn btn-primary">▶ Watch</router-link>
            <router-link :to="`/movie/${movie.id}/edit`" class="btn btn-warning">✏ Edit</router-link>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="text-center">
      <p>No movies available.</p>
    </div>

    <!-- Paginación -->
    <div class="text-center mt-4" v-if="!isSearch && totalPages > 1">
      <button
        class="btn btn-outline-secondary me-2"
        @click="changePage(currentPage - 1)"
        :disabled="currentPage === 1"
      >
        ← Previous
      </button>

      <button
        v-for="page in totalPages"
        :key="page"
        @click="changePage(page)"
        class="btn me-1"
        :class="{
          'btn-success': page === currentPage,
          'btn-outline-primary': page !== currentPage
        }"
      >
        {{ page }}
      </button>

      <button
        class="btn btn-outline-primary ms-2"
        @click="changePage(currentPage + 1)"
        :disabled="currentPage === totalPages"
      >
        Next →
      </button>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      movies: [],
      currentPage: 1,
      totalPages: 1,
      isSearch: false
    };
  },
  mounted() {
    this.loadMovies();
  },
  watch: {
    '$route.query.q': 'loadMovies'
  },
  methods: {
    loadMovies() {
      const search = this.$route.query.q;
      this.isSearch = !!search;

      const url = search
        ? `/api/movies/search?q=${encodeURIComponent(search)}`
        : `/api/movies?page=${this.currentPage}`;

      fetch(url)
        .then(res => res.json())
        .then(data => {
          if (this.isSearch) {
            this.movies = data;
            this.totalPages = 1;
          } else {
            this.movies = data.data;
            this.totalPages = data.last_page;
            this.currentPage = data.current_page;
          }
        });
    },
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
        this.loadMovies();
      }
    }
  }
}
</script>
