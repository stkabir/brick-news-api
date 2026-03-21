# Brick News API

REST API backend para el portal de noticias Brickell News. Construida con Laravel + Filament.

## Requisitos

- PHP 8.2+
- Composer
- MySQL / MariaDB

## Instalación

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```

## Desarrollo

```bash
composer run dev   # Inicia servidor en http://localhost:8000 + Vite
```

## Panel de administración

Disponible en `/admin`. Requiere usuario Filament. Ver `docs/manual-usuario.md` para guía completa.

## Variables de entorno clave

| Variable | Descripción | Default |
|---|---|---|
| `DB_DATABASE` | Nombre de la base de datos | `laravel` |
| `DB_USERNAME` | Usuario de la base de datos | `root` |
| `DB_PASSWORD` | Contraseña de la base de datos | — |
| `APP_URL` | URL base de la aplicación | `http://localhost` |

## Endpoints

| Método | Ruta | Descripción |
|---|---|---|
| `GET` | `/api/articles` | Listar artículos |
| `GET` | `/api/articles/{slug}` | Obtener artículo por slug |
| `GET` | `/api/categories` | Listar categorías |
| `GET` | `/api/sections` | Listar secciones |
| `GET` | `/api/search?q=` | Buscar artículos |

### Filtros disponibles en `/api/articles`

| Parámetro | Ejemplo | Descripción |
|---|---|---|
| `category` | `?category=business` | Filtrar por slug de categoría |
| `section` | `?section=trending` | Filtrar por slug de sección |

Los artículos se ordenan por `priority` (desc) y luego por `date` (desc).

## Modelos

### Article

| Campo | Tipo | Descripción |
|---|---|---|
| `slug` | string | Identificador único (URL-friendly) |
| `title_en` / `title_es` | string | Título en inglés / español |
| `summary_en` / `summary_es` | text | Resumen en inglés / español |
| `body_en` / `body_es` | longtext | Cuerpo completo en inglés / español |
| `image` | string | URL de la imagen destacada |
| `category_id` | FK | Categoría del artículo |
| `section_id` | FK nullable | Sección explícita del artículo (anula la sección por defecto de la categoría) |
| `author` | string | Nombre del autor |
| `date` | date | Fecha de publicación |
| `featured` | boolean | Artículo destacado |
| `priority` | integer | Prioridad de visualización (mayor = primero) |

### Category

| Campo | Tipo | Descripción |
|---|---|---|
| `slug` | string | Identificador único |
| `title_en` / `title_es` | string | Nombre en inglés / español |
| `section_id` | FK nullable | Sección por defecto para todos los artículos de esta categoría |

### Section

| Campo | Tipo | Descripción |
|---|---|---|
| `slug` | string | Identificador único |
| `title_en` / `title_es` | string | Nombre en inglés / español |
| `description_en` / `description_es` | text | Descripción opcional |
| `section_layout` | enum | Layout: `grid`, `list`, `sidebar` |
| `order` | integer | Orden de aparición en el frontend |

### Secciones activas

| Slug | Layout | Zona en el frontend |
|---|---|---|
| `trending` | `grid` | Carrusel Trending Developments |
| `top-stories` | `list` | More News — columna izquierda (lista) |
| `featured` | `sidebar` | More News — columna central/derecha (tarjetas) |

## Lógica de distribución por secciones

La sección donde aparece un artículo se determina con la siguiente cadena de prioridad:

1. **Sección directa del artículo** (`articles.section_id`) — tiene precedencia.
2. **Sección por defecto de la categoría** (`categories.section_id`) — se aplica cuando el artículo no tiene sección asignada.
3. **Sin sección** — el artículo solo aparece en el grid principal de la portada.

El `ArticleResource` aplica esto con:

```php
'section' => $this->section?->slug ?? $this->category?->section?->slug,
```

### Configuración actual de categorías

| Categoría | Sección por defecto |
|---|---|
| Business | featured |
| Events | trending |
| Headline News | top-stories |
| Lifestyle | featured |
| News | top-stories |
| Real Estate | trending |
| Home | *(ninguna)* |

## Migraciones relevantes

| Migración | Descripción |
|---|---|
| `2026_03_20_000000` | Agrega `section_id` (FK nullable) a `articles` |
| `2026_03_20_000001` | Agrega `section_id` (FK nullable) a `categories` |
