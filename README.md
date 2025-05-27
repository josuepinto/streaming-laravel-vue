# 🎬 Plataforma de Streaming – Laravel + Vue

<p align="center">
  Proyecto colaborativo del ciclo DAW para construir una plataforma de streaming.<br>
  Incluye backend en Laravel y frontend SPA en Vue.js.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-9.x-red?logo=laravel&style=for-the-badge"/>
  <img src="https://img.shields.io/badge/Vue.js-3.x-41B883?logo=vue.js&logoColor=white&style=for-the-badge"/>
  <img src="https://img.shields.io/badge/Docker-Enabled-2496ED?logo=docker&style=for-the-badge"/>
</p>

---

## 🧾 Estructura del Repositorio

Este repositorio contiene dos ramas principales:

- `main`: Lógica de backend en Laravel (CRUD, migraciones, seeders, login)
- `m6_vue_creacion_de_vistas`: Interfaz SPA completa desarrollada en Vue.js

---

## 🚀 Funcionalidades Implementadas

### ✅ Backend Laravel:
- CRUD completo de **series y capítulos**
- Migraciones y seeders para series y episodios
- Panel de administración para series
- API REST para consumo desde Vue
- Integración de Laravel Breeze

### ✅ Frontend Vue (SPA):
- Lista paginada de películas/series con detalles
- Retorno automático a la misma posición
- Buscador conectado con base de datos Laravel
- Formulario de edición con fecha, géneros dinámicos y preview de imagen
- Novedades desde último acceso del usuario
- IndexedDB con Service Worker para soporte offline
- Notificaciones de novedades cada 5 minutos
- Reproductor de vídeos desde YouTube

---

## 👨‍💻 Mi Contribución

Este proyecto fue desarrollado en colaboración.

**Mi rol:**
- Desarrollo completo del módulo de **Series y Capítulos** en Laravel.
- **Toda la parte frontend en Vue.js**, incluyendo funcionalidades de Service Worker, IndexedDB, formularios, vídeos y notificaciones.
- Evaluado con una nota final de **8,68 / 10** por el profesor Ginés Martínez.

---

## 🛠️ Tecnologías Utilizadas

- **Laravel 9** – Backend API, migraciones y autenticación
- **Vue.js 3** – SPA completa (componentes, rutas, fetch)
- **PHP 8.1 (Laravel Sail)**
- **MySQL/MariaDB**
- **Bootstrap 5**
- **Docker + Laravel Sail**
- **Service Worker / IndexedDB**
- **GitLab CI/CD**

---

## 🐳 Instalación del Entorno

Este proyecto usa Laravel Sail (Docker). Sigue los pasos:

### 1. Clona el repositorio

```bash
git clone https://github.com/josuepinto/streaming-laravel-vue.git
cd streaming-laravel-vue
```

### 2. Instala Laravel Sail

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v ./:/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

### 3. Levanta los contenedores

```bash
./vendor/bin/sail up -d
```

### 4. Instala dependencias

```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

### 5. Migra y llena la base de datos

```bash
./vendor/bin/sail php artisan migrate:fresh --seed
```

### 6. Abre la aplicación

👉 [https://localhost](https://localhost)

---

## 🤝 Créditos

- 👨‍💻 **Josue Pinto** – Desarrollo de series, capítulos, y frontend completo con Vue  
- 🧑‍💻 **Mushtaq** – Desarrollo del módulo de películas y autenticación

---

## 📄 Licencia

Este proyecto es de uso académico y puede ser reutilizado con fines educativos o de aprendizaje.
