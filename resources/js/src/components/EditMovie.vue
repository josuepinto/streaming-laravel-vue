<template>
  <div class="container mt-4">
    <h2 class="mb-4">✏️ Edit Movie</h2>

    <!-- FORMULARIO -->
    <div class="form-group mb-3">
      <label>Title</label>
      <input type="text" class="form-control" v-model="movie.title" />
    </div>

    <div class="form-group mb-3">
      <label>Description</label>
      <textarea class="form-control" v-model="movie.description"></textarea>
    </div>

    <div class="form-group mb-3">
      <label>Actor</label>
      <input type="text" class="form-control" v-model="movie.actor" />
    </div>

    <div class="form-group mb-3">
      <label>Director</label>
      <input type="text" class="form-control" v-model="movie.director" />
    </div>

    <!-- SELECT DE IMAGEN -->
    <div class="form-group mb-3">
      <label>Image</label>
      <select class="form-select" v-model="movie.image">
        <option v-for="img in imageList" :key="img" :value="`image/${img}`">{{ img }}</option>
      </select>
      <div v-if="movie.image" class="mt-2 text-center">
        <img :src="`/${movie.image}`" class="img-fluid rounded" style="max-height: 300px" />
      </div>
    </div>

    <div class="form-group mb-3">
      <label>Video URL</label>
      <input type="text" class="form-control" v-model="movie.video_url" />
    </div>

    <!-- GÉNERO -->
    <div class="form-group mb-3">
      <label>Genre</label><br />
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

    <!-- AÑO -->
    <div class="form-group mb-4">
      <label>Year</label>
      <input
        type="number"
        class="form-control"
        v-model="movie.year"
        min="1900"
        max="2100"
        placeholder="Enter year like 2025"
      />
    </div>

    <!-- BOTONES -->
    <button class="btn btn-success me-2" @click="updateMovie">💾 Save Changes</button>
    <router-link to="/" class="btn btn-secondary">← Back</router-link>
  </div>
</template>

<script>
export default {
  data() {
    return {
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
      genres: ['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi'],
      imageList: [] // aquí se cargarán las imágenes disponibles
    }
  },
  mounted() {
    // Cargar datos de la película
    fetch(`/api/movies/${this.$route.params.id}`)
      .then(res => res.json())
      .then(data => {
        this.movie = data
      })

    // Cargar imágenes disponibles
    fetch('/api/images')
      .then(res => res.json())
      .then(data => {
        this.imageList = data
      })
  },
  methods: {
    updateMovie() {
      fetch(`/api/movies/${this.$route.params.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.movie)
      })
        .then(() => {
          this.$router.push('/')
        })
        .catch(error => {
          console.error('Update error:', error)
        })
    }
  }
}
</script>
