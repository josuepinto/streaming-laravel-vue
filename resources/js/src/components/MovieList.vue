<template>
  <div class="container mt-4">
    <!-- ✅ Título de la vista -->
    <h2 class="mb-4 text-center">🎬 Movie List</h2>

    <!-- ✅ Mostrar lista de películas si existen -->
    <div v-if="movies.length" class="row">
      <!-- ✅ Recorremos el array de películas -->
      <div v-for="movie in movies" :key="movie.id" class="col-md-4 mb-4">
        <div class="card h-100">
          <!-- ✅ Mostramos imagen -->
          <img :src="movie.image" class="card-img-top" style="height: 400px; object-fit: cover;" />
          
          <!-- ✅ Información principal de la película -->
          <div class="card-body">
            <h5 class="card-title">{{ movie.title }}</h5>
            <p class="card-text">{{ movie.description }}</p>
            <p><strong>Genre:</strong> {{ movie.genre }}</p>
            <p><strong>Year:</strong> {{ movie.year }}</p>
            <p><strong>Actor:</strong> {{ movie.actor }}</p>
            <p><strong>Director:</strong> {{ movie.director }}</p>
          </div>

          <!-- ✅ Enlaces a detalles y edición -->
          <div class="card-footer d-flex justify-content-between">
            <!-- Criterio 03_01: Ver detalles de una película -->
            <router-link :to="`/movie/${movie.id}`" class="btn btn-primary">▶ Watch</router-link>
            <!-- Criterio 05_01: Editar una película -->
            <router-link :to="`/movie/${movie.id}/edit`" class="btn btn-warning">✏ Edit</router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- ✅ Si no hay películas -->
    <div v-else class="text-center">
      <p>No movies available.</p>
    </div>

    <!-- ✅ Sistema de paginación -->
    <!-- Criterio 03_01: Lista paginada -->
    <div class="text-center mt-4" v-if="!isSearch && totalPages > 1">
      <button
        class="btn btn-outline-secondary me-2"
        @click="changePage(currentPage - 1)"
        :disabled="currentPage === 1"
      >
        ← Previous
      </button>

      <!-- ✅ Botones numéricos de paginación -->
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
      movies: [],         // Películas cargadas desde Laravel
      currentPage: 1,     // Página actual
      totalPages: 1,      // Total de páginas
      isSearch: false     // Si estamos en modo buscador
    };
  },

  // ✅ Cuando el componente se monta, se cargan las películas
  mounted() {
    this.loadMovies();
  },

  // ✅ Si cambia la URL (ej. si se hace una búsqueda), recarga la lista
  watch: {
    '$route.query.q': 'loadMovies'
  },

  methods: {
    // ✅ Cargar películas desde Laravel (criterio 06_01)
    loadMovies() {
      const search = this.$route.query.q;
      this.isSearch = !!search;

      // Si hay búsqueda, usamos la ruta personalizada del backend
      const url = search
        ? `/api/movies/search?q=${encodeURIComponent(search)}`
        : `/api/movies?page=${this.currentPage}`;

      fetch(url)
        .then(res => res.json())
        .then(data => {
          if (this.isSearch) {
            // Si es búsqueda, simplemente guardamos el array
            this.movies = data;
            this.totalPages = 1;
          } else {
            // ✅ Laravel devuelve un objeto paginado
            this.movies = data.data;
            this.totalPages = data.last_page;
            this.currentPage = data.current_page;
          }
        });
    },

    // ✅ Cambiar de página (criterio 03_01)
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
        this.loadMovies();
      }
    }
  }
}
</script>
