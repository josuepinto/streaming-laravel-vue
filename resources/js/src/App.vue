<template>
  <div>
    <div v-if="!sessionChecked && !skipSessionCheck" class="text-center mt-5">
      <span class="spinner-border text-primary"></span>
    </div>

    <!-- Solo mostramos Vue Router cuando la sesión fue verificada -->
    <router-view v-if="sessionChecked && loggedIn || skipSessionCheck" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      sessionChecked: false,
      loggedIn: false,
      skipSessionCheck: false
    }
  },
  async mounted() {
    const currentPath = window.location.pathname

    // No hacer control de sesión en login y register
    if (['/login', '/register'].includes(currentPath)) {
      this.skipSessionCheck = true
      return
    }

    try {
      const res = await fetch('/api/check-session')
      const data = await res.json()
      this.loggedIn = data.loggedIn
      this.sessionChecked = true

      if (!data.loggedIn) {
        window.location.href = '/register'
      }
    } catch (error) {
      console.error('Error comprobando sesión:', error)
      window.location.href = '/register'
    }
  }
}
</script>
