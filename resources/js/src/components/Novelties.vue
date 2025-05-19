<template>
  <div class="container mt-4">
    <h2 class="mb-4 text-center">🆕 New Movies Since Your Last Login</h2>

    <div v-if="novelties.length" class="row">
      <div v-for="movie in novelties" :key="movie.id" class="col-md-4 mb-4">
        <router-link :to="`/movie/${movie.id}`" class="text-decoration-none text-dark">
          <div class="card h-100">
            <img :src="movie.image" class="card-img-top" style="height: 400px; object-fit: cover;" />
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

    <div v-else class="text-center">
      <p>No new movies added since your last login.</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      novelties: []
    }
  },
  mounted() {
   fetch('/api/novelties', {
  credentials: 'include', // Enviar cookies cruzadas
  headers: {
    'Accept': 'application/json'
  }
})

      .then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
      })
      .then(data => this.novelties = data)
      .catch(err => console.error('Error loading novelties:', err));
  }
}
</script>
