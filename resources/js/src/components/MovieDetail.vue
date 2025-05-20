<template>
  <div class="container mt-4">
    <!-- Título de la película -->
    <h2 class="mb-3">{{ movie.title }}</h2>

    <!-- ✅ Criterio 08_01: Imagen cargada correctamente desde carpeta pública -->
    <!-- Verificamos si movie.image es relativo (como 'image/xxx.jpg') y se renderiza con '/' delante -->
    <img :src="`/${movie.image}`" alt="Movie Banner" class="img-fluid mb-3" />

    <!-- Información textual de la película -->
    <p><strong>Genre:</strong> {{ movie.genre }}</p>
    <p><strong>Year:</strong> {{ movie.year }}</p>
    <p><strong>Actor:</strong> {{ movie.actor }}</p>
    <p><strong>Director:</strong> {{ movie.director }}</p>
    <p class="mb-4">{{ movie.description }}</p>

    <!-- ✅ Criterio 08_01: Reproducción del video desde la URL embebida (YouTube) -->
    <div class="ratio ratio-16x9 mb-4">
      <iframe
        :src="movie.video_url"
        frameborder="0"
        allowfullscreen
      ></iframe>
    </div>

    <!-- Botón para regresar a la lista -->
    <button class="btn btn-secondary" @click="goBack">← Back to list</button>
  </div>
</template>

<script>
// ✅ Importamos funciones para uso de IndexedDB local
import { getMovieFromIndexedDB, saveMovieToIndexedDB } from '../videoService.js'

export default {
  data() {
    return {
      movie: {} // Aquí se guarda toda la información de la película
    }
  },
  async mounted() {
    const id = this.$route.params.id // Obtenemos ID de la ruta

    // ✅ Primero intentamos cargar desde IndexedDB (para modo offline)
    const fromIndexedDB = await getMovieFromIndexedDB(id)

    if (fromIndexedDB && fromIndexedDB.video_url) {
      // Si la película ya está guardada en local, la usamos
      console.log('🎥 Video cargado desde IndexedDB')
      this.movie = fromIndexedDB
    } else {
      // ✅ Si no está en IndexedDB, pedimos al backend Laravel y guardamos
      console.log('🌐 Cargando desde API de Laravel...')
      fetch(`/api/movies/${id}`)
        .then(res => res.json())
        .then(data => {
          this.movie = data
          saveMovieToIndexedDB(data) // Guardamos en IndexedDB para siguiente acceso
        })
        .catch(err => console.error('Error loading movie:', err))
    }
  },
  methods: {
    // ✅ Permite regresar a la página que se guardó anteriormente
    goBack() {
      const savedURL = sessionStorage.getItem('lastMovieListURL') || '/api/movies'
      this.$router.push({ name: 'Home' }) // Redirige a ruta principal Vue
      this.$nextTick(() => {
        sessionStorage.setItem('goToURL', savedURL) // Guardamos la ruta original
      })
    },

    // ⚠️ Función no utilizada actualmente, pero útil si en el futuro quieres validar o generar rutas completas
    getImageUrl(image) {
      if (!image) return '' // Evita errores con campos vacíos
      if (image.startsWith('http')) return image // Si ya es una URL absoluta
      return `/image/${image}` // Si es nombre de archivo, añadimos la ruta
    }
  }
}
</script>
