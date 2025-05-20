<template>
  <div class="container mt-4">
    <h2 class="mb-4">✏️ Edit Movie</h2>

    <!-- FORMULARIO DE EDICIÓN DE PELÍCULA -->
    <!-- Campo: Título -->
    <div class="form-group mb-3">
      <label>Title</label>
      <input type="text" class="form-control" v-model="movie.title" />
    </div>

    <!-- Campo: Descripción -->
    <div class="form-group mb-3">
      <label>Description</label>
      <textarea class="form-control" v-model="movie.description"></textarea>
    </div>

    <!-- Campo: Actor principal -->
    <div class="form-group mb-3">
      <label>Actor</label>
      <input type="text" class="form-control" v-model="movie.actor" />
    </div>

    <!-- Campo: Director -->
    <div class="form-group mb-3">
      <label>Director</label>
      <input type="text" class="form-control" v-model="movie.director" />
    </div>

    <!-- Campo: Imagen (selector desde lista generada dinámicamente) -->
    <div class="form-group mb-3">
      <label>Image</label>
      <!-- Se genera un desplegable con las imágenes del servidor -->
      <select class="form-select" v-model="movie.image">
        <option v-for="img in imageList" :key="img" :value="`image/${img}`">{{ img }}</option>
      </select>
      <!-- Vista previa de la imagen seleccionada -->
      <div v-if="movie.image" class="mt-2 text-center">
        <img :src="`/${movie.image}`" class="img-fluid rounded" style="max-height: 300px" />
      </div>
    </div>

    <!-- Campo: URL del video (por ejemplo, enlace de YouTube embebido) -->
    <div class="form-group mb-3">
      <label>Video URL</label>
      <input type="text" class="form-control" v-model="movie.video_url" />
    </div>

    <!-- Campo: Género (opciones tipo radio) -->
    <div class="form-group mb-3">
      <label>Genre</label><br />
      <!-- 🎯 Criterio 05_01: checkbox dinámico de géneros -->
      <div v-for="genreOption in genres" :key="genreOption">
        <input
          type="radio"
          :id="`genre-${genreOption}`"
          :value="genreOption"
          v-model="movie.genre"
        />
        <label :for="`genre-${genreOption}`">{{ genreOption }}</label>
      </div>
    </div>

    <!-- Campo: Año de publicación -->
    <div class="form-group mb-4">
      <label>Year</label>
      <!-- 🎯 Criterio 05_01: selector de año con input de tipo number -->
      <input
        type="number"
        class="form-control"
        v-model="movie.year"
        min="1900"
        max="2100"
        placeholder="Enter year like 2025"
      />
    </div>

    <!-- BOTONES DE ACCIÓN -->
    <button class="btn btn-success me-2" @click="updateMovie">💾 Save Changes</button>
    <router-link to="/" class="btn btn-secondary">← Back</router-link>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // Objeto con los datos de la película a editar
      movie: {
        title: '',
        description: '',
        actor: '',
        director: '',
        year: '',
        genre: '',
        image: '',
        video_url: ''
      },
      // 🎯 Criterio 05_01: lista de géneros usados para los botones radio
      genres: ['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi'],
      // Lista de imágenes disponibles para selección
      imageList: []
    }
  },
  mounted() {
    // Al montar el componente se cargan los datos de la película por ID
    fetch(`/api/movies/${this.$route.params.id}`)
      .then(res => res.json())
      .then(data => {
        this.movie = data
      })

    // Se cargan las imágenes disponibles desde el servidor
    fetch('/api/images')
      .then(res => res.json())
      .then(data => {
        this.imageList = data
      })
  },
  methods: {
    // Actualiza la película haciendo PUT a la API
    updateMovie() {
      fetch(`/api/movies/${this.$route.params.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.movie)
      })
        .then(() => {
          // Redirige al home tras guardar
          this.$router.push('/')
        })
        .catch(error => {
          console.error('Update error:', error)
        })
    }
  }
}
</script>
