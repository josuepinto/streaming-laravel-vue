<template>
  <div class="container mt-4">
    <!-- ✅ Título principal de la vista de novedades -->
    <h2 class="mb-4 text-center">🆕 New Movies Since Your Last Login</h2>

    <!-- ✅ Si hay novedades (películas nuevas desde último login) -->
    <div v-if="novelties.length" class="row">
      <!-- ✅ Iteramos cada novedad -->
      <div v-for="movie in novelties" :key="movie.id" class="col-md-4 mb-4">
        <!-- ✅ Enlace al detalle de película -->
        <router-link :to="`/movie/${movie.id}`" class="text-decoration-none text-dark">
          <div class="card h-100">
            <!-- ✅ Imagen de la película -->
            <img :src="movie.image" class="card-img-top" style="height: 400px; object-fit: cover;" />

            <!-- ✅ Contenido de la tarjeta -->
            <div class="card-body">
              <h5 class="card-title">{{ movie.title }}</h5>
              <p>{{ movie.description }}</p>
              <p><strong>Year:</strong> {{ movie.year }}</p>
              <p><strong>Genre:</strong> {{ movie.genre }}</p>
            </div>
          </div>
        </router-link>
      </div>
    </div>

    <!-- ✅ Si no hay películas nuevas -->
    <div v-else class="text-center">
      <p>No new movies added since your last login.</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      novelties: [] // ⬅️ Array que contendrá las películas nuevas desde último acceso
    }
  },
  mounted() {
    // ✅ Al montar el componente, hacemos petición al backend Laravel
    fetch('/api/novelties', {
      credentials: 'include', // Enviar cookies de sesión (imprescindible si usamos Session en Laravel)
      headers: {
        'Accept': 'application/json'
      }
    })
      .then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`); // Validamos que la respuesta sea OK
        return res.json();
      })
      .then(data => {
        // ✅ Guardamos las novedades en el array
        this.novelties = data;
      })
      .catch(err => {
        console.error('Error loading novelties:', err); // Errores si el backend falla
      });
  }
}
</script>
