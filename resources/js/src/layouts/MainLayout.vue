<template>
  <div>
    <!-- NAVBAR -->
    <nav class="navbar bg-secondary border-bottom border-body navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
      <div class="container-fluid">
        <img src="/image/logo.jpeg" alt="Logo" height="36" class="me-2" />
        <span class="navbar-brand text-white">PiFlix</span>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link to="/" class="nav-link" exact>Home</router-link>
            </li>
            <!-- Puedes añadir más rutas aquí -->
          </ul>

          <!-- ⚠ Este buscador apunta a Laravel directamente -->
          <form class="d-flex" @submit.prevent="searchMovies">
            <input v-model="searchQuery" class="form-control me-2" type="search" placeholder="Search movies or series" />
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>

    <!-- CONTENIDO -->
    <main class="container py-4">
      <router-view />
    </main>

    <!-- FOOTER -->
    <footer class="bg-body-tertiary text-center">
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2025 Copyright:
        <a class="text-body" href="https://mdbootstrap.com/">PiFlix</a>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'MainLayout',
  data() {
    return {
      searchQuery: ''
    }
  },
  methods: {
    searchMovies() {
      // Puedes manejar la búsqueda como quieras, o emitir evento, o usar Vuex, etc.
      alert(`Buscar: ${this.searchQuery}`)
    }
  }
}
</script>
