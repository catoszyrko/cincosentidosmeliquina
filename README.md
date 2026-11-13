# Cinco Sentidos Meliquina

Sitio PHP de la **Hostería y Casa de Té Cinco Sentidos**, en Villa Lago Meliquina (Neuquén). Home de una página, páginas de detalle para la Hostería y la Casa de Té, privacidad y 404. Sin React ni Node: corre en cualquier hosting PHP estándar.

## Arranque local

```bash
php -S localhost:8080 router.php
```

Abrí [http://localhost:8080](http://localhost:8080).

Si lo servís desde un subdirectorio (MAMP) y CSS/JS no cargan, en `inc/config.php`:

```php
'base_path' => 'cincosentidosmeliquina',
```

## Contenido

Todo el copy, contacto, SEO, colores y fotos se editan en `inc/config.php` y `assets/img/`.

Fuentes usadas (no se inventó información):

- **Sitio anterior** ([cincosentidosmeliquina.com.ar](https://cincosentidosmeliquina.com.ar/)): textos de la hostería y la casa de té, historia, habitaciones, comodidades, cómo llegar, actividades, contacto, mapa, logo y la mayoría de las fotos.
- **Facebook** ([página pública](https://www.facebook.com/cincosentidosmeliquina)): foto del exterior con montañas.
- **Google Maps y Tripadvisor**: horario de la Casa de Té, calificaciones (4,9 hostería y 4,8 casa de té) y las reseñas citadas, textuales y apenas recortadas.
- **Instagram**: pide login para leer el perfil; solo se enlaza.

Fotos en `assets/img/`, con nombres descriptivos:

```
brand/     logo, logo blanco, favicon
content/   exterior de la hostería, imagen para redes (og)
rooms/     habitaciones, baño, SUM, jardín
tea/       salón y mesas de la casa de té
gallery/   lago, familia, visitas, invierno
```

## Pendientes para el dueño

- **Base de datos**: `database` está vacío a propósito. Sin MySQL, cada consulta se guarda como JSON en `data/leads/`. Para usar MySQL, cargá los datos y corré `migrate.php?token=…`.
- **Admin**: cambiar `admin.password` y `admin.migrate_token` en `inc/config.php` antes de publicar.
- **Analytics**: `gtm_id` / `ga_id` vacíos a propósito (el ID del sitio anterior no se reutilizó).
- **Horario de la Casa de Té**: figura de 15 a 19 h, todos los días (Google Maps / Tripadvisor). Revisar por temporada.
- **Calificaciones y reseñas**: copiadas de Google en noviembre de 2026. Conviene actualizarlas cada tanto.
- **Tarifas**: no hay precios publicados; el formulario abre WhatsApp para consultarlas.

## SEO y Google Search Console

Por ahora el sitio no redirige a ningún dominio: responde en el dominio desde el que se lo visita, y canonical, sitemap y robots usan ese mismo dominio. El `.htaccess` solo redirige `index.php` e `index.html` (URL del sitio anterior) a `/`.

Cuando el sitio esté publicado en `cincosentidosmeliquina.com.ar` con SSL, conviene unificar todo en `https://cincosentidosmeliquina.com.ar/` (sin www), antes de cargarlo en Search Console:

1. En `inc/config.php`, poner `'force_canonical_host' => true`.
2. En `.htaccess`, descomentar el bloque "Dominio único".

- `/sitemap.xml`: home, Hostería, Casa de Té y privacidad, con `lastmod` por página y las fotos de cada una (sitemap de imágenes). Se genera solo desde `inc/config.php`.
- `/robots.txt`: permite todo salvo `/admin/` y los endpoints del formulario, y declara el sitemap.
- Cada página tiene title, description, canonical, Open Graph y datos estructurados (BedAndBreakfast, CafeOrCoffeeShop con horario, WebSite, WebPage, FAQPage en la home, BreadcrumbList en las páginas de detalle). La 404 es `noindex`.

Alta en Search Console, una vez publicado:

1. Entrá a [Search Console](https://search.google.com/search-console) → **Agregar propiedad** → **Dominio** → `cincosentidosmeliquina.com.ar`.
2. Copiá el registro TXT que te da Google y cargalo en la zona DNS del dominio (panel de Donweb). Puede tardar unas horas en verificarse.
   - Alternativa: propiedad de tipo **Prefijo de URL** con `https://cincosentidosmeliquina.com.ar/` y método **Etiqueta HTML**. Pegá solo el valor de `content="…"` en `company.google_site_verification` de `inc/config.php` y subí el cambio.
3. **Sitemaps** → agregar `sitemap.xml` → Enviar.
4. **Inspección de URLs** → probá `/`, `/hosteria/` y `/casa-de-te/` → **Solicitar indexación**.
5. Opcional: validá los datos estructurados en [Prueba de resultados enriquecidos](https://search.google.com/test/rich-results).

Fuera del sitio, lo que más pesa para búsquedas locales es el **Perfil de Empresa de Google** (las fichas de Maps de la hostería y la casa de té): conviene que tengan este sitio web cargado y el mismo teléfono y dirección.

## Arquitectura

```
inc/config.php           ← contenido, colores, SEO, contacto, schema
inc/helpers.php          ← urls, assets, schema.org, iconos, render
inc/forms.php            ← CSRF, validación, leads, mensaje de WhatsApp
inc/admin.php            ← panel /admin (consultas y clics)
includes/                ← head, header, footer, formulario
includes/sections/       ← bloques de la home (hero, lodging, rooms, method…)
views/                   ← home, detalle (house), privacidad, 404
hosteria/, casa-de-te/   ← páginas de detalle (render_house)
assets/css/app.css
assets/js/app.js         ← menú, acordeón, lightbox, formulario, tracking
data/leads/              ← JSON de cada consulta (fallback sin MySQL)
```

Orden de la home: definido en `views/home.php`.
