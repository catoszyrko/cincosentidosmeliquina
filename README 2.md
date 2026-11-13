# Isla Pura Vida Tigre

Sitio PHP de una página (más privacidad y 404) para el alojamiento **Isla Pura Vida Tigre**, en el Delta. Sin React ni Node en producción.

## Arranque local

```bash
php -S localhost:8080 router.php
```

Abrí [http://localhost:8080](http://localhost:8080).

Si lo servís desde un subdirectorio (MAMP) y CSS/JS no cargan, en `inc/config.php`:

```php
'base_path' => 'islapuravida',
```

## Contenido

Todo el copy, contacto, SEO y fotos se editan en `inc/config.php` y `assets/img/`.

Las fotos del predio salen de listados públicos de Isla Pura Vida / Casa Maui (mismo predio en Arroyo Toro). No son bancos de stock.

## Datos pendientes de completar

No se inventó información. Completar a mano cuando exista fuente oficial:

- **Email** — no aparece un correo público verificado. El formulario guarda la consulta en `data/leads/` y no envía mail hasta que cargues `contact.email`.
- **WhatsApp / teléfono** — `+54 9 11 5575-4950` (`5491155754950`). El formulario de reservas abre WhatsApp con los datos cargados.
- **Instagram** — se enlazó `instagram.com/islapuravidatigre`. Instagram pide login y no se pudo leer la bio ni confirmar el handle con capturas.
- **Horarios de check-in / check-out de Casa Pura Vida** — solo se encontraron horarios en la ficha de Casa Maui (consulta 10–20 h; check-in 8–20; check-out 10–20; mínima 2 noches).
- **Tarifas, seña, cancelación, mascotas, ropa de cama** — no hay políticas públicas vigentes verificadas.
- **Gastronomía propia** — no aparece restaurante ni desayuno incluido.
- **Horarios de lancha** — hay varios en el día; no se publicó una tabla confiable. Coordinar al reservar.
- **Analytics** — `gtm_id` / `ga_id` vacíos a propósito.

## Arquitectura

```
inc/config.php           ← contenido, colores, SEO, contacto
inc/helpers.php          ← urls, assets, schema, iconos
inc/forms.php            ← CSRF, validación, leads
includes/                ← header, footer, formulario
includes/sections/       ← bloques de la home
views/                   ← home, privacidad, 404
assets/css/app.css
assets/js/app.js
assets/img/              ← logo, hero, casas, galería
data/leads/              ← JSON de cada consulta
```
