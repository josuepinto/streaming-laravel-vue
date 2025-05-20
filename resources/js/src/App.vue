<template>
  <div>
    <!-- 🔄 Muestra un spinner mientras se comprueba la sesión del usuario -->
    <div v-if="!sessionChecked && !skipSessionCheck" class="text-center mt-5">
      <span class="spinner-border text-primary"></span>
    </div>

    <!-- ✅ Mostramos el contenido del router (vistas) solo si:
         - la sesión fue verificada y está activa (sessionChecked && loggedIn), o
         - estamos en login o register (skipSessionCheck = true) -->
    <router-view v-if="sessionChecked && loggedIn || skipSessionCheck" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      sessionChecked: false,   // 🔍 Indica si ya se comprobó la sesión (espera backend)
      loggedIn: false,         // 🟢 Indica si el usuario está autenticado (existe sesión)
      skipSessionCheck: false  // ⛔ Sirve para evitar control de sesión en /login y /register
    }
  },

  async mounted() {
    const currentPath = window.location.pathname;

    // ✅ Si estamos en /login o /register, saltamos la verificación de sesión
    if (['/login', '/register'].includes(currentPath)) {
      this.skipSessionCheck = true;
      return;
    }

    // ✅ Petición al backend (Laravel) para comprobar si hay sesión activa
    try {
      const res = await fetch('/api/check-session');
      const data = await res.json();

      this.loggedIn = data.loggedIn;        // true si el usuario está logueado
      this.sessionChecked = true;           // ya hemos hecho la comprobación

      // 🔁 Si no hay sesión activa, redirige a la página de registro
      if (!data.loggedIn) {
        window.location.href = '/register';
      }
    } catch (error) {
      // ❌ Error de red o servidor: también redirigimos
      console.error('Error comprobando sesión:', error);
      window.location.href = '/register';
    }
  }
}
</script>
