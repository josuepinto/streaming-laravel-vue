<template>
  <div>
    <!-- ✅ NAVBAR PRINCIPAL: navegación superior con Bootstrap -->
    <nav class="navbar bg-secondary border-bottom border-body navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
      <div class="container-fluid">
        <!-- ✅ Logo del sitio -->
        <img src="/image/logo.jpeg" alt="Logo" height="36" class="me-2" />
        <span class="navbar-brand text-white">PiFlix</span>

        <!-- ✅ Botón hamburguesa en versión móvil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- ✅ Contenido del navbar -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <!-- ✅ Enlace a la lista de películas (Home) -->
            <li class="nav-item">
              <router-link to="/" class="nav-link" exact>Home</router-link>
            </li>

            <!-- ✅ Enlace a novedades desde último login (criterio 04_01) -->
            <li class="nav-item">
              <router-link to="/novelties" class="nav-link">🆕 Novedades</router-link>
            </li>

            <!-- ✅ Enlace al panel de administración -->
            <li><router-link to="/admin/panel" class="nav-link">Admin</router-link></li>

            <!-- ✅ Cierre de sesión -->
            <li class="nav-item">
              <a class="nav-link" href="/logout">🚪 Logout</a>
            </li>
          </ul>

          <!-- ✅ Buscador (cumple con 06_01) -->
          <form class="d-flex" @submit.prevent="searchMovies">
            <!-- Campo para introducir texto de búsqueda -->
            <input
              v-model="searchQuery"
              class="form-control me-2"
              type="search"
              placeholder="Search movies or series"
            />
            <!-- Botón para enviar el formulario -->
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>

        </div>
      </div>
    </nav>

    <!-- ✅ CONTENIDO PRINCIPAL: será reemplazado por <router-view> -->
    <main class="container py-4">
      <router-view />
    </main>

    <!-- ✅ FOOTER FINAL -->
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
      searchQuery: '' // Variable para guardar el texto del buscador
    }
  },
  methods: {
    // ✅ Cuando el usuario busca, redirige a '/' con la query ?q=
    searchMovies() {
      this.$router.push({ path: '/', query: { q: this.searchQuery } });
    }
  }
}
</script>
