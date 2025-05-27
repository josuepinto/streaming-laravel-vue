
````markdown
# 🎬 Plataforma de Streaming – Laravel + Vue

Proyecto colaborativo del ciclo DAW para construir una plataforma de streaming similar a Netflix, con funcionalidad tanto en backend (Laravel) como en frontend (Vue.js).

Este repositorio contiene dos ramas principales:

- `main`: Lógica de backend en Laravel (CRUD, migraciones, seeders, login)
- `m6_vue_creacion_de_vistas`: Interfaz SPA completa desarrollada en Vue.js

---

## 🚀 Funcionalidades implementadas

✅ Backend Laravel:
- CRUD completo de **series y capítulos**
- Migraciones y seeders para series y episodios
- Panel de administración para series
- API REST para el consumo desde Vue
- Integración de Laravel Breeze

✅ Frontend Vue (SPA):
- Lista paginada de películas/series con detalles
- Retorno automático a la misma posición
- Buscador conectado con la base de datos de Laravel
- Formulario de edición con fecha, géneros dinámicos y preview de imagen
- Novedades desde último acceso del usuario
- IndexedDB con Service Worker para soporte offline
- Notificaciones de novedades cada 5 minutos
- Reproductor de vídeos desde YouTube

---

## 👨‍💻 Mi contribución

Este proyecto fue desarrollado en colaboración.  
**Mi rol:**  
- Desarrollo completo del módulo de **Series y Capítulos** en Laravel.
- **Toda la parte frontend en Vue.js**, incluyendo funcionalidades de Service Worker, IndexedDB, formularios, vídeos y notificaciones.
- Evaluado con una nota final de **8,68 / 10** por el profesor Ginés Martínez.

---

## 🛠️ Tecnologías utilizadas

- **Laravel 9**
- **Vue.js 3**
- **PHP 8.1 (SAIL)**
- **MySQL/MariaDB**
- **Bootstrap**
- **Docker + Laravel Sail**
- **Service Worker / IndexedDB**
- **GitLab CI/CD**

---

## 🐳 Instalación del entorno

Este proyecto usa Laravel Sail (Docker) para facilitar la configuración.  
Sigue estos pasos:

### 1. Descargar el repositorio

```bash
git clone https://github.com/josuepinto/streaming-laravel-vue.git
cd streaming-laravel-vue
````

### 2. Instalar Laravel Sail

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v ./:/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

### 3. Levantar contenedor Docker

```bash
./vendor/bin/sail up -d
```

### 4. Instalar dependencias

```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

### 5. Migrar y poblar la base de datos

```bash
./vendor/bin/sail php artisan migrate:fresh --seed
```

### 6. Abrir la aplicación

Accede desde: [https://localhost](https://localhost)



## 🤝 Créditos

* **Josue Pinto** – Desarrollo de series, capítulos, y frontend completo con Vue
* **Mushtaq** – Desarrollo del módulo de películas y autenticación

---

## 📄 Licencia

Este proyecto es de uso académico y puede ser reutilizado para fines educativos.

````

---
