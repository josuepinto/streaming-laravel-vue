// ==========================================
// 🚀 main.js (punto de entrada de la app Vue)
// ==========================================
// Este archivo:
// ✅ Crea la aplicación Vue
// ✅ Monta el enrutador
// ✅ Registra el Service Worker
// ✅ Lanza un mensaje para cargar películas y novedades en IndexedDB
// ✅ Solicita permiso para notificaciones (08_01)
// ✅ Lanza la verificación de novedades en segundo plano (08_01)
//
// 📌 Relacionado con criterios:
// - 07_01: Guardar películas en HD con IndexedDB
// - 08_01: Guardar videos en IndexedDB si no están en HD
// - 08_01: Notificacions de novedades nuevas cada 5 min
// ==========================================


// ✅ Importar Vue y componentes principales
import { createApp } from 'vue'                  // Constructor principal de la app
import App from './App.vue'                      // Componente raíz de Vue (App.vue)
import router from './router'                    // Archivo de rutas con vue-router
import 'bootstrap/dist/css/bootstrap.min.css'    // Importación de estilos Bootstrap


// ✅ Crear la instancia de la app y montar Vue
const app = createApp(App);   // Inicializa la app
app.use(router);              // Usa el sistema de rutas
app.mount('#app');            // Monta la app en el <div id="app"> del vue.blade.php


// ==========================================
// 📦 Registrar el Service Worker (SW)
// ==========================================
// Esto permite que la app tenga:
// - Cacheo local de películas (IndexedDB)
// - Posibilidad de trabajar offline
// - Sincronización de novedades y HD
// - Y notificaciones push cada 5 minutos
// ==========================================
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/service-worker.js')  // Ruta al archivo público
    .then(reg => {
      console.log('✅ Service Worker registrado');

      // ✅ Cargar películas y novedades (criterio 07_01 y parte de 08_01)
      reg.active?.postMessage('cache-movies');

      // ✅ Iniciar comprobaciones periódicas cada 5 minutos desde el SW
      // Esto lanza las notificaciones automáticas si hay novedades (criterio 08_01)
      reg.active?.postMessage('start-notifications');
    })
    .catch(err => console.error('❌ Error registrando SW:', err));
}


// ==========================================
// 🔔 Solicitar permiso de notificaciones (08_01)
// ==========================================
// Esto es necesario para que el navegador muestre notificaciones push.
// Solo lo pedimos si el navegador lo soporta y aún no está concedido.
// ==========================================
if ('Notification' in window && Notification.permission !== 'granted') {
  Notification.requestPermission().then(permission => {
    console.log('🔔 Permiso de notificación:', permission);
  });
}
