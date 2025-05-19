import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import 'bootstrap/dist/css/bootstrap.min.css'

const app = createApp(App)
app.use(router)
app.mount('#app')

// Registrar el Service Worker si el navegador lo soporta
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/service-worker.js')
    .then(reg => {
      console.log('✅ Service Worker registrado');
      // enviar mensaje para cargar películas
      reg.active?.postMessage('cache-movies');
    })
    .catch(err => console.error('❌ Error registrando SW:', err));
}
