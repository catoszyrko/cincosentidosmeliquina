<?php
declare(strict_types=1);

/**
 * Cinco Sentidos Meliquina — Hostería y Casa de Té. Contenido y tokens del sitio.
 *
 * Fuentes: sitio anterior cincosentidosmeliquina.com.ar, página de Facebook,
 * ficha de Google Maps, Tripadvisor e Interpatagonia. Lo que no se pudo
 * confirmar no se publica.
 */

return [
    'company' => [
        'name' => 'Cinco Sentidos Meliquina',
        'short' => 'Cinco Sentidos',
        'legal' => 'Hostería y Casa de Té Cinco Sentidos',
        'tagline' => 'Hostería y Casa de Té en Villa Lago Meliquina',
        'founded' => '2014',
        'locale' => 'es-AR',
        'og_locale' => 'es_AR',
        'url' => 'https://cincosentidosmeliquina.com.ar',
        'canonical_host' => 'cincosentidosmeliquina.com.ar',
        'alias_hosts' => ['www.cincosentidosmeliquina.com.ar'],
        'google_site_verification' => '',
        'logo' => 'img/brand/logo.png',
        'logo_light' => 'img/brand/logo-white.png',
        'mark' => 'img/brand/mark.png',
        'favicon' => 'img/brand/favicon.png',
        'favicon_32' => 'img/brand/favicon-32.png',
        'og_image' => 'img/content/og-cinco-sentidos.jpg',
        'base_path' => '',
    ],

    'colors' => [
        'primary' => '#4558C9',
        'primary_deep' => '#34449F',
        'brand' => '#5268E2',
        'accent' => '#4558C9',
        'accent_hover' => '#34449F',
        'mint' => '#A9D9C8',
        'mint_deep' => '#4E8F7B',
        'navy' => '#2B231E',
        'navy_deep' => '#1F1915',
        'cyan' => '#A9D9C8',
        'teal' => '#5E9C88',
        'sky' => '#C9D3F5',
        'text' => '#26211D',
        'muted' => '#6E655C',
        'bg' => '#FFFCF7',
        'bg_soft' => '#F5EEE3',
        'bg_tint' => '#EAF3EE',
        'line' => '#E7DED1',
        'white' => '#ffffff',
    ],

    'fonts' => [
        'sans' => 'Figtree',
        'display' => 'DM Serif Display',
        'google' => 'https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Figtree:wght@400;500;600;700&display=swap',
    ],

    'contact' => [
        'email' => 'hosteriacincosentidos@gmail.com',
        'email_alt' => '',
        'whatsapp' => '5491162520693',
        'whatsapp_display' => '+54 9 11 6252-0693',
        'whatsapp_message' => 'Hola, quiero hacer una consulta sobre Cinco Sentidos Meliquina.',
        'phone' => '+54 9 11 6252-0693',
        'instagram' => 'https://www.instagram.com/cincosentidosmeliquina/',
        'facebook' => 'https://www.facebook.com/cincosentidosmeliquina',
        'tripadvisor' => 'https://www.tripadvisor.com/Restaurant_Review-g312843-d8752563-Reviews-Cinco_Sentidos_Casa_de_Te_Meliquina-San_Martin_de_los_Andes_Province_of_Neuquen_P.html',
        'tiktok' => '',
        'linkedin' => '',
        'blog' => '',
        'address' => 'Ruta Provincial 63, a 1.100 m del lago. Villa Lago Meliquina, San Martín de los Andes, Neuquén (Q8370)',
        'address_short' => 'Ruta 63, Villa Lago Meliquina, Neuquén',
        'hours' => 'Casa de Té: de 15 a 19 h',
        'maps_url' => 'https://maps.google.com/maps?cid=17462579006814433526',
        'maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12156.583634001681!2d-71.25911731209673!3d-40.38345870104524!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf2578b16035e30f6!2sCinco%20Sentidos%20Casa%20de%20T%C3%A9!5e0!3m2!1ses!2sar!4v1579358352946!5m2!1ses!2sar',
        'lat' => '-40.3861027',
        'lng' => '-71.2480841',
    ],

    'schema' => [
        'type' => 'BedAndBreakfast',
        'alternate_names' => ['Hostería Cinco Sentidos', 'Cinco Sentidos Casa de Té', 'Cinco Sentidos Meliquina'],
        'locality' => 'Villa Lago Meliquina',
        'region' => 'Neuquén',
        'region_code' => 'AR-Q',
        'postal_code' => 'Q8370',
        'amenities' => ['Desayuno casero', 'WiFi', 'Calefacción por radiadores', 'Baño privado', 'Parrilla', 'Estacionamiento'],
        'cafe' => [
            'name' => 'Cinco Sentidos Casa de Té',
            'cuisine' => 'Pastelería, meriendas, té y café especial',
            'opening_hours' => 'Mo-Su 15:00-19:00',
        ],
    ],

    'seo' => [
        'title' => 'Hostería y Casa de Té en Villa Lago Meliquina | Cinco Sentidos',
        'description' => 'Hostería con desayuno casero y Casa de Té en Villa Lago Meliquina, a 40 km de San Martín de los Andes. Habitaciones dobles de 28 m² con vista a las montañas. Reservá por WhatsApp.',
        'keywords' => 'hostería meliquina, casa de té meliquina, villa lago meliquina alojamiento, hospedaje meliquina, cinco sentidos meliquina, merienda meliquina, hostería san martín de los andes, ruta 63 meliquina',
        'og_title' => 'Cinco Sentidos · Hostería y Casa de Té en Villa Lago Meliquina',
        'og_description' => 'Habitaciones dobles con desayuno casero y una casa de té donde todo es de elaboración propia. A 40 km de San Martín de los Andes, rodeados de montañas.',
        'robots' => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
    ],

    'analytics' => [
        'gtm_id' => '',
        'ga_id' => '',
    ],

    'database' => [
        // Completar con la base MySQL del hosting (cPanel → Bases de datos MySQL).
        // Mientras esté vacío, las consultas se guardan como JSON en data/leads/.
        'host' => 'localhost',
        'name' => '',
        'user' => '',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],

    'database_local' => [
        // Se usa cuando el sitio se sirve desde alguno de estos hosts (MAMP).
        'hosts' => ['localhost:8888', '127.0.0.1:8888'],
        'host' => 'localhost',
        'port' => 8889,
        'name' => 'cincosentidosdb',
        'user' => 'root',
        'pass' => 'root',
        'charset' => 'utf8mb4',
    ],

    'admin' => [
        'email' => 'info@estudiolimay.com',
        'password' => 'akua1256',
        'migrate_token' => 'akua1256',
    ],

    'header_cta' => [
        'label' => 'Reservar',
        'href' => '#reservas',
    ],

    'nav' => [
        ['id' => 'hosteria', 'label' => 'Hostería', 'href' => '#hosteria'],
        ['id' => 'casa-de-te', 'label' => 'Casa de Té', 'href' => '#casa-de-te'],
        ['id' => 'nosotros', 'label' => 'Nosotros', 'href' => '#nosotros'],
        ['id' => 'galeria', 'label' => 'Galería', 'href' => '#galeria'],
        ['id' => 'meliquina', 'label' => 'Meliquina', 'href' => '#meliquina'],
        ['id' => 'ubicacion', 'label' => 'Cómo llegar', 'href' => '#ubicacion'],
    ],

    'hero' => [
        'kicker' => 'Villa Lago Meliquina · Neuquén',
        'title' => 'Conectá con los cinco sentidos en Villa Lago Meliquina',
        'title_em' => 'cinco sentidos',
        'text' => 'Una hostería pensada para parejas y amigos, y una casa de té donde todo es de elaboración propia, con recetas de familia y productos locales. A 40 km de San Martín de los Andes, por la Ruta 63.',
        'cta' => 'Consultar disponibilidad',
        'cta_href' => '#reservas',
        'cta_secondary' => 'Conocer la Casa de Té',
        'cta_secondary_href' => '#casa-de-te',
        'image' => 'img/content/hosteria-exterior-montanas.jpg',
        'image_alt' => 'Casa de madera de Cinco Sentidos con jardín florido y montañas de Meliquina al fondo',
        'inset' => 'img/tea/te-y-galletas-caseras.jpg',
        'inset_alt' => 'Tetera de porcelana, taza de té y galletas caseras sobre una mesa al aire libre',
        'badge_title' => 'Casa de Té',
        'badge_text' => 'Por la tarde, de 15 a 19 h',
        'facts' => [
            ['value' => 'Desayuno casero', 'label' => 'incluido en la estadía'],
            ['value' => '28 m²', 'label' => 'cada habitación doble'],
            ['value' => '1.100 m', 'label' => 'del lago Meliquina'],
            ['value' => '40 km', 'label' => 'de San Martín de los Andes'],
        ],
    ],

    'form' => [
        'id' => 'reservas',
        'kicker' => 'Reservas',
        'title' => 'Consultá disponibilidad',
        'card_title' => 'Tu consulta',
        'subtitle' => 'Completá tus datos y se abre WhatsApp con la consulta lista para enviar. Te respondemos con disponibilidad y tarifa.',
        'submit' => 'Consultar por WhatsApp',
        'disclaimer' => 'Te redirigimos a WhatsApp con los datos de esta consulta.',
        'wa_intro' => 'Hola, quiero consultar disponibilidad en la Hostería Cinco Sentidos.',
        'room_label' => 'Habitación',
        'budget_label' => '',
        'success' => '',
        'error' => 'Completá los campos obligatorios.',
        'via' => 'whatsapp',
        'fields' => [
            ['name' => 'nombre', 'label' => 'Nombre', 'placeholder' => 'Tu nombre', 'type' => 'text', 'required' => true, 'autocomplete' => 'name', 'group' => 'datos'],
            ['name' => 'huespedes', 'label' => 'Personas', 'placeholder' => 'Ej. 2', 'type' => 'number', 'required' => true, 'autocomplete' => 'off', 'attrs' => ['min' => '1', 'max' => '20'], 'group' => 'datos'],
            ['name' => 'contacto', 'label' => 'WhatsApp o email (opcional)', 'placeholder' => 'Para poder responderte', 'type' => 'text', 'required' => false, 'autocomplete' => 'on', 'attrs' => ['maxlength' => '120']],
            ['name' => 'checkin', 'label' => 'Llegada', 'placeholder' => '', 'type' => 'date', 'required' => true, 'autocomplete' => 'off', 'group' => 'fechas'],
            ['name' => 'checkout', 'label' => 'Salida', 'placeholder' => '', 'type' => 'date', 'required' => true, 'autocomplete' => 'off', 'group' => 'fechas'],
            [
                'name' => 'casa',
                'label' => 'Habitación',
                'type' => 'select',
                'required' => false,
                'options' => [
                    '' => 'A definir',
                    'Doble' => 'Doble · cama de 2 × 2 m',
                    'Camas separadas' => 'Doble · dos camas separadas',
                    'Más de una' => 'Más de una habitación',
                ],
            ],
            ['name' => 'mensaje', 'label' => 'Mensaje (opcional)', 'placeholder' => 'Algo que quieras contarnos.', 'type' => 'textarea', 'required' => false],
        ],
    ],

    'stats' => [
        ['value' => '2013', 'label' => 'llegamos a Meliquina'],
        ['value' => '28 m²', 'label' => 'cada habitación doble'],
        ['value' => '15–19 h', 'label' => 'abre la Casa de Té'],
        ['value' => '40 km', 'label' => 'de San Martín de los Andes'],
    ],

    'lodging' => [
        'id' => 'propuesta',
        'kicker' => 'Dos maneras de visitarnos',
        'title' => 'Quedate a dormir o vení a merendar',
        'text' => 'Cinco Sentidos es una hostería y una casa de té en el mismo lugar, atendidas por nosotros, en Villa Lago Meliquina.',
        'cta' => 'Ver más',
        'detail_cta' => 'Consultar por WhatsApp',
        'items' => [
            [
                'slug' => 'hosteria',
                'name' => 'Hostería',
                'form_value' => '',
                'booking' => true,
                'role' => 'Habitaciones dobles amplias, con baño privado y desayuno casero en nuestra Casa de Té.',
                'capacity' => 'Para parejas o amigos',
                'photo' => 'img/rooms/habitacion-doble-acolchado-floral.jpg',
                'image_alt' => 'Habitación doble de la Hostería Cinco Sentidos con acolchado floral y ventana al jardín',
                'wa_message' => 'Hola, quiero consultar disponibilidad en la Hostería Cinco Sentidos. Fechas: … Cantidad de personas: …',
                'seo_title' => 'Hostería en Villa Lago Meliquina con desayuno casero | Cinco Sentidos',
                'seo_description' => 'Hostería Cinco Sentidos en Villa Lago Meliquina: habitaciones dobles de 28 m², cama de 2 × 2 m o camas separadas, baño privado y desayuno casero. A 40 km de San Martín de los Andes.',
                'description' => [
                    'Hostería Cinco Sentidos nació de quienes nos visitaban a la hora del té y buscaban en Meliquina un lugar para descansar, desconectarse del estrés de la rutina y conectarse con uno mismo. Por eso la pensamos para parejas y para grupos de amigos o amigas.',
                    'Las habitaciones son amplias, con camas para descansar de verdad y vista al jardín y a las montañas. Cada mañana, el desayuno se prepara en nuestra Casa de Té con recetas heredadas de la familia y productos locales.',
                ],
                'amenities' => [
                    'Desayuno casero y completo en nuestra Casa de Té',
                    'Baño privado y luz y agua caliente las 24 horas',
                    'Calefacción por radiadores',
                    'Conexión libre a internet',
                    'TV con Netflix, o sin TV',
                    'Limpieza diaria y recambio de toallas cada 4 días',
                    'SUM con cocina, heladera y parrillas',
                ],
                'info_title' => 'Habitaciones',
                'info' => [
                    'Habitación doble: 28 m², cama de 2 × 2 m',
                    'Habitación doble con camas separadas: 28 m², dos camas de 1 × 2 m',
                    'Vista al jardín y a las montañas',
                    'A 1.100 m del lago, sobre la Ruta 63',
                ],
                'gallery' => [
                    ['src' => 'img/rooms/habitacion-doble-cama-king.jpg', 'alt' => 'Habitación doble con cama de 2 × 2 m, almohadones y techo de madera'],
                    ['src' => 'img/rooms/habitacion-camas-separadas.jpg', 'alt' => 'Habitación doble con dos camas separadas y sillón verde'],
                    ['src' => 'img/rooms/habitacion-doble-acolchado-floral.jpg', 'alt' => 'Habitación doble con acolchado floral y ventana al jardín'],
                    ['src' => 'img/rooms/bano-privado.jpg', 'alt' => 'Baño privado de una habitación de la hostería'],
                    ['src' => 'img/rooms/habitacion-doble-vista-jardin.jpg', 'alt' => 'Habitación doble con cama grande y apliques de luz cálida'],
                    ['src' => 'img/rooms/sum-cocina-huespedes.jpg', 'alt' => 'Cocina equipada del SUM para huéspedes con revestimiento de madera'],
                    ['src' => 'img/rooms/jardin-y-montanas.jpg', 'alt' => 'Jardín de la hostería con construcción de techo verde y montañas'],
                    ['src' => 'img/content/hosteria-exterior-montanas.jpg', 'alt' => 'Casa de madera de Cinco Sentidos con jardín y montañas'],
                    ['src' => 'img/tea/merienda-en-el-jardin.jpg', 'alt' => 'Desayuno casero con café, tortas y flores en una mesa del jardín'],
                ],
            ],
            [
                'slug' => 'casa-de-te',
                'name' => 'Casa de Té',
                'form_value' => '',
                'booking' => false,
                'role' => 'Pastelería, meriendas, té y café especial. Todo de elaboración propia.',
                'capacity' => 'Por la tarde, de 15 a 19 h',
                'photo' => 'img/tea/casa-de-te-salon-ventanales.jpg',
                'image_alt' => 'Salón de la Casa de Té Cinco Sentidos con ventanales al bosque y mesas color agua',
                'wa_message' => 'Hola, quiero hacer una consulta sobre la Casa de Té Cinco Sentidos.',
                'seo_title' => 'Casa de Té en Villa Lago Meliquina: meriendas y pastelería | Cinco Sentidos',
                'seo_description' => 'Casa de Té Cinco Sentidos en Villa Lago Meliquina: pastelería, meriendas, té y café especial de elaboración propia. Abre por la tarde, de 15 a 19 h, sobre la Ruta 63.',
                'description' => [
                    'Abrimos nuestra primera casa de té en diciembre de 2014: muy chiquita, pero súper cálida. Todo se elaboraba en nuestra cabaña, al fondo del salón, y de a poco muchos clientes pasaron a ser amigos.',
                    'La casa de té de hoy la pensamos detalle por detalle: la puerta de entrada, el vitraux, la barra de adobe, los muebles antiguos de la familia y una estufa rocket que, con 3 horas de fuego en pleno invierno, calefacciona el día entero.',
                ],
                'amenities' => [
                    'Pastelería y meriendas de elaboración propia',
                    'Té y café especial',
                    'Recetas heredadas de nuestra familia',
                    'Productos de nuestra huerta orgánica y de la zona',
                    'Salón con ventanales al jardín y a las montañas',
                ],
                'info_title' => 'Horario y ubicación',
                'info' => [
                    'Abrimos por la tarde, de 15 a 19 h',
                    'Los días pueden variar según la época del año: si venís de lejos, escribinos antes',
                    'Ruta 63, a 1.100 m del lago Meliquina',
                    'Abierta al público: no hace falta estar hospedado',
                ],
                'gallery' => [
                    ['src' => 'img/tea/casa-de-te-salon-ventanales.jpg', 'alt' => 'Salón de la Casa de Té con ventanales al bosque'],
                    ['src' => 'img/tea/barra-de-tortas.jpg', 'alt' => 'Barra color agua con tortas caseras bajo campanas de vidrio'],
                    ['src' => 'img/tea/te-y-galletas-caseras.jpg', 'alt' => 'Tetera de porcelana, taza de té y galletas caseras'],
                    ['src' => 'img/tea/casa-de-te-salon-estufa.jpg', 'alt' => 'Salón de la Casa de Té con estufa y banquetas de tronco'],
                    ['src' => 'img/tea/mesa-junto-a-la-ventana.jpg', 'alt' => 'Mesa puesta junto a la ventana con vista al jardín'],
                    ['src' => 'img/tea/casa-de-te-mesas-color-agua.jpg', 'alt' => 'Mesas color agua, sillas de madera y estufa encendida'],
                    ['src' => 'img/tea/salon-con-banquetas-de-tronco.jpg', 'alt' => 'Rincón con sillones, mesa larga y banquetas de tronco'],
                    ['src' => 'img/tea/merienda-en-el-jardin.jpg', 'alt' => 'Merienda con café, tortas y flores en una mesa del jardín'],
                    ['src' => 'img/tea/licuado-y-cookies.jpg', 'alt' => 'Licuado y cookies caseras en una mesa al aire libre'],
                ],
            ],
        ],
    ],

    'why' => [
        'id' => 'nosotros',
        'kicker' => 'Nosotros',
        'title' => 'Una familia que eligió Meliquina para vivir',
        'text' => 'En enero de 2013 descubrimos Villa Lago Meliquina: un lago planchado como un espejo y caminos de cuento entre la naturaleza. Ese mismo año nos mudamos para siempre, y desde entonces construimos, de a poco, la casa de té y la hostería que hoy atendemos nosotros mismos.',
        'image' => 'img/gallery/familia-en-la-cabana.jpg',
        'image_alt' => 'La familia de Cinco Sentidos sentada en el porche de su cabaña de madera',
        'image_secondary' => 'img/gallery/flores-del-invernadero.jpg',
        'image_secondary_alt' => 'Caléndulas en flor dentro del invernadero de la huerta',
        'items' => [
            [
                'title' => 'Huerta biointensiva',
                'text' => 'Trabajamos la tierra sin agroquímicos ni pesticidas. En la huerta y el invernadero crecen manzanos, perales, cerezos, membrillos, frambuesas, grosellas y moras.',
            ],
            [
                'title' => 'Recetas de familia',
                'text' => 'Desayunos y meriendas elaborados a diario con recetas heredadas de nuestras familias y productos locales.',
            ],
            [
                'title' => 'Energía consciente',
                'text' => 'Como en todo Meliquina, cuidamos el consumo: reciclamos, compostamos y calefaccionamos con una estufa rocket que usa el mínimo de leña.',
            ],
            [
                'title' => 'Detalles con historia',
                'text' => 'La vajilla de nuestras abuelas, muebles antiguos de la familia y el trabajo de artesanos en la iluminación y las bachas.',
            ],
        ],
    ],

    'rooms' => [
        'id' => 'hosteria',
        'kicker' => 'Hostería',
        'title' => 'Habitaciones amplias, camas para descansar de verdad',
        'text' => 'A pocos kilómetros de San Martín de los Andes, por la Ruta 63 camino a Paso Córdoba. Dos tipos de habitación doble, con baño privado y vista al jardín y a las montañas.',
        'cta' => 'Ver la hostería',
        'items' => [
            [
                'name' => 'Habitación doble',
                'photo' => 'img/rooms/habitacion-doble-cama-king.jpg',
                'image_alt' => 'Habitación doble con cama de 2 × 2 m y techo de madera',
                'specs' => [
                    ['label' => 'Tamaño', 'value' => '28 m²'],
                    ['label' => 'Cama', 'value' => '2 × 2 m'],
                    ['label' => 'Baño', 'value' => 'Privado'],
                ],
                'form_value' => 'Doble',
            ],
            [
                'name' => 'Doble con camas separadas',
                'photo' => 'img/rooms/habitacion-camas-separadas.jpg',
                'image_alt' => 'Habitación doble con dos camas separadas de 1 × 2 m',
                'specs' => [
                    ['label' => 'Tamaño', 'value' => '28 m²'],
                    ['label' => 'Camas', 'value' => '2 de 1 × 2 m'],
                    ['label' => 'Baño', 'value' => 'Privado'],
                ],
                'form_value' => 'Camas separadas',
            ],
        ],
    ],

    'features' => [
        'id' => 'comodidades',
        'kicker' => 'Comodidades',
        'title' => 'Todo lo necesario para una estadía tranquila',
        'text' => 'Incluido en todas las habitaciones de la hostería.',
        'cta' => 'Consultar disponibilidad',
        'items' => [
            ['icon' => 'cup', 'title' => 'Desayuno casero', 'text' => 'Completo y servido en nuestra Casa de Té, con recetas de familia.'],
            ['icon' => 'flame', 'title' => 'Calefacción', 'text' => 'Calefacción por radiadores en cada habitación.'],
            ['icon' => 'wifi', 'title' => 'Internet libre', 'text' => 'Conexión WiFi sin cargo en la hostería.'],
            ['icon' => 'tv', 'title' => 'TV con Netflix, o sin TV', 'text' => 'Para ver algo a la noche o para desconectarte del todo.'],
            ['icon' => 'droplet', 'title' => 'Baño privado', 'text' => 'Con luz y agua caliente las 24 horas.'],
            ['icon' => 'sparkle', 'title' => 'Limpieza diaria', 'text' => 'Y recambio de toallas cada 4 días.'],
            ['icon' => 'home', 'title' => 'SUM con cocina', 'text' => 'Espacio común con cocina, heladera y parrillas.'],
            ['icon' => 'car', 'title' => 'Estacionamiento', 'text' => 'Lugar para dejar el auto sin cargo.'],
        ],
    ],

    'method' => [
        'id' => 'casa-de-te',
        'kicker' => 'Casa de Té',
        'title' => 'La hora del té, con todo hecho en casa',
        'text' => 'Pastelería, meriendas, té y café especial. Todo de elaboración propia, en un salón que fuimos armando detalle por detalle desde 2014.',
        'result_title' => 'Horario',
        'result_text' => 'Abrimos por la tarde, de 15 a 19 h. Los días pueden variar según la época del año: si venís de lejos, escribinos antes.',
        'cta' => 'Consultar por WhatsApp',
        'detail_cta' => 'Conocer la Casa de Té',
        'image' => 'img/tea/casa-de-te-salon-ventanales.jpg',
        'image_alt' => 'Salón de la Casa de Té con ventanales al bosque, mesas color agua y banquetas de tronco',
        'side_images' => [
            ['src' => 'img/tea/barra-de-tortas.jpg', 'alt' => 'Barra color agua con tortas caseras bajo campanas de vidrio'],
            ['src' => 'img/tea/merienda-en-el-jardin.jpg', 'alt' => 'Merienda con café, tortas y flores en una mesa del jardín'],
        ],
        'steps' => [
            ['n' => '01', 'title' => 'Pastelería propia', 'text' => 'Tortas, galletas y delicias para la merienda, preparadas en nuestra cocina.'],
            ['n' => '02', 'title' => 'Té y café especial', 'text' => 'Para acompañar la tarde, adentro junto a la estufa o afuera, en el jardín.'],
            ['n' => '03', 'title' => 'Una casa hecha con detalles', 'text' => 'Vitraux, barra de adobe, muebles antiguos de la familia y piezas de artesanos.'],
            ['n' => '04', 'title' => 'Rodeados de montañas', 'text' => 'Ventanales al jardín y al bosque: paisajes y sabores que te conecten.'],
        ],
    ],

    'gallery' => [
        'id' => 'galeria',
        'kicker' => 'Galería',
        'title' => 'Nosotros, el lugar y quienes nos visitaron',
        'text' => 'Fotos de la casa de té, la hostería, el lago y de algunas de las personas que pasaron por Cinco Sentidos.',
        'items' => [
            ['src' => 'img/tea/casa-de-te-salon-estufa.jpg', 'alt' => 'Salón de la Casa de Té con estufa y banquetas de tronco'],
            ['src' => 'img/gallery/lago-meliquina.jpg', 'alt' => 'Lago Meliquina planchado como un espejo, con montañas y cielo despejado'],
            ['src' => 'img/tea/tetera-de-porcelana.jpg', 'alt' => 'Tetera de porcelana con flores y tazas sobre una mesa de la Casa de Té'],
            ['src' => 'img/tea/casa-de-te-mesas-color-agua.jpg', 'alt' => 'Mesas color agua, sillas de madera y estufa encendida en la Casa de Té'],
            ['src' => 'img/rooms/habitacion-doble-acolchado-floral.jpg', 'alt' => 'Habitación doble con acolchado floral y ventana al jardín'],
            ['src' => 'img/gallery/kayak-lago-meliquina.jpg', 'alt' => 'Dos personas remando en kayak por el lago Meliquina'],
            ['src' => 'img/gallery/amigos-a-la-hora-del-te.jpg', 'alt' => 'Grupo de amigos merendando en la Casa de Té'],
            ['src' => 'img/tea/licuado-y-cookies.jpg', 'alt' => 'Licuado y cookies caseras en una mesa al aire libre'],
            ['src' => 'img/gallery/invierno-con-nieve.jpg', 'alt' => 'Familia en la nieve en Meliquina durante el invierno'],
            ['src' => 'img/tea/mesa-junto-a-la-ventana.jpg', 'alt' => 'Mesa puesta junto a la ventana con vista al jardín'],
            ['src' => 'img/gallery/visitas-en-la-casa-de-te.jpg', 'alt' => 'Visitantes compartiendo una merienda en la Casa de Té'],
            ['src' => 'img/rooms/jardin-y-montanas.jpg', 'alt' => 'Jardín con construcción de techo verde y montañas'],
            ['src' => 'img/tea/salon-con-banquetas-de-tronco.jpg', 'alt' => 'Rincón con sillones, mesa larga y banquetas de tronco'],
            ['src' => 'img/gallery/familia-de-viaje.jpg', 'alt' => 'La familia de Cinco Sentidos en un viaje por la ruta'],
        ],
    ],

    'testimonials' => [
        'id' => 'opiniones',
        'kicker' => 'Opiniones',
        'title' => 'Lo que cuentan quienes nos visitaron',
        'text' => 'Reseñas publicadas en Google por huéspedes de la hostería y visitantes de la casa de té. Las citamos tal cual, apenas recortadas.',
        'badges' => [
            ['label' => 'Hostería en Google', 'rating' => '4,9', 'url' => 'https://www.google.com/maps/search/?api=1&query=Hoster%C3%ADa+Cinco+Sentidos+Villa+Lago+Meliquina'],
            ['label' => 'Casa de Té en Google', 'rating' => '4,8', 'url' => 'https://maps.google.com/maps?cid=17462579006814433526'],
        ],
        'items' => [
            [
                'tag' => 'Hostería',
                'role' => 'Enero 2026',
                'stars' => 5,
                'text' => 'Mauro y Yose reflejan la calma y belleza de Villa Meliquina dentro de una hostería que denota calidad, cuidado al detalle, comodidad y limpieza. El desayuno casero es de lo mejor que hayamos visto y probado.',
            ],
            [
                'tag' => 'Casa de Té',
                'role' => 'Febrero 2026',
                'stars' => 5,
                'text' => 'Excelente espacio tanto adentro como en el patio, donde como su nombre lo indica se destacan los tés que se preparan con hierbas y flores de cosecha propia. Se comen muy buenas tortas, galletitas y alfajores.',
            ],
            [
                'tag' => 'Hostería',
                'role' => 'Febrero 2026',
                'stars' => 5,
                'text' => 'Hermosa hostería, la comodidad de las camas, ambientación, tranquilidad… El desayuno es excelente; saludable, casero y rico. Hermoso el jardín, las flores le dan todo el detalle. ¡Volveremos!',
            ],
            [
                'tag' => 'Casa de Té',
                'role' => 'Febrero 2026',
                'stars' => 5,
                'text' => '¡Muy rico todo! Tienen muchas opciones sin TACC. Pedimos varios tés para probar y un exprimido de pomelo. Una carrot cake, una de peras y almendras, y una de chocolate y jengibre.',
            ],
            [
                'tag' => 'Hostería',
                'role' => 'Diciembre 2025',
                'stars' => 5,
                'text' => 'Un lugar ideal para relajarse y conectar con la naturaleza. La habitación muy cómoda, todo funcionaba perfecto y el desayuno súper completo, tal cual lo muestran en las fotos.',
            ],
            [
                'tag' => 'Hostería',
                'role' => 'Febrero 2026',
                'stars' => 5,
                'text' => 'El lugar no puede ser más lindo y acogedor. Cada detalle está perfectamente cuidado. Las vistas a las montañas son inmejorables, ofreciendo una sensación de paz y (des)conexión que muchos buscamos.',
            ],
        ],
    ],

    'history' => [
        'id' => 'historia',
        'kicker' => 'Nuestra historia',
        'title' => 'De un sueño a la casa de té y la hostería',
        'text' => 'Te esperamos para seguir escribiendo juntos esta historia.',
        'image' => 'img/gallery/familia-en-la-casa-de-te.jpg',
        'image_alt' => 'La familia de Cinco Sentidos detrás de la barra de la Casa de Té',
        'items' => [
            [
                'year' => '2013',
                'title' => 'Descubrimos Villa Lago Meliquina',
                'text' => 'En enero entramos al pueblo y supimos que queríamos vivir acá: casas con energías alternativas, vecinos que reciclan y compostan, y paisajes que nos dijeron que este era nuestro lugar.',
            ],
            [
                'year' => '2013',
                'title' => 'Nos mudamos',
                'text' => 'En diciembre nos instalamos para siempre. Al poco tiempo descubrimos el método de huerta biointensivo de la mano de Fernando Pia y empezamos nuestra huerta.',
            ],
            [
                'year' => '2014',
                'title' => '¡Empezamos!',
                'text' => 'Llegó Valentino, nuestro primer hijo. Juntamos sillas, mesas y la vajilla de nuestras abuelas, y en diciembre abrimos la primera Casa de Té: muy chiquita, pero súper cálida.',
            ],
            [
                'year' => '2015',
                'title' => 'La base, lo primero',
                'text' => 'Comenzamos a construir lo que hoy es la Casa de Té, acompañados por viajeros, familia y amigos que nos apoyaron para seguir adelante.',
            ],
            [
                'year' => '2016',
                'title' => 'Crece la familia y la huerta',
                'text' => 'Nació Salvador, nuestro segundo hijo. Construimos el invernadero, plantamos frutales y diseñamos la nueva Casa de Té con una estufa rocket que calefacciona el día entero.',
            ],
            [
                'year' => '2019',
                'title' => 'Nace la Hostería',
                'text' => 'Muchos de quienes venían a tomar el té buscaban dónde descansar en Meliquina. Así nació la Hostería Cinco Sentidos, con habitaciones amplias y desayunos caseros.',
            ],
        ],
    ],

    'area' => [
        'id' => 'meliquina',
        'kicker' => 'Villa Lago Meliquina',
        'title' => 'Qué hacer en Meliquina',
        'text' => 'Un lugar ideal para actividades deportivas y recreativas, en verano y en invierno.',
        'photos' => [
            ['src' => 'img/gallery/lago-meliquina.jpg', 'alt' => 'Orilla del lago Meliquina con montañas y agua calma'],
            ['src' => 'img/gallery/kayak-lago-meliquina.jpg', 'alt' => 'Kayak en el lago Meliquina'],
            ['src' => 'img/gallery/invierno-con-nieve.jpg', 'alt' => 'Paisaje nevado de Meliquina en invierno'],
        ],
        'items' => [
            ['icon' => 'fish', 'title' => 'Pesca con mosca', 'text' => 'En el lago Meliquina y en el río.'],
            ['icon' => 'boat', 'title' => 'Deportes en el lago', 'text' => 'Kitesurf, windsurf, remo y más, para hacer o aprender.'],
            ['icon' => 'snow', 'title' => 'Esquí y snowboard', 'text' => 'En el Cerro Chapelco, a 30 km de la villa.'],
            ['icon' => 'bike', 'title' => 'Ciclismo', 'text' => 'Si traés tu bici, la villa tiene paisajes únicos para recorrer.'],
            ['icon' => 'mountain', 'title' => 'Trekking', 'text' => 'Caminos ideales para salir a caminar.'],
            ['icon' => 'leaf', 'title' => 'Yoga, tai chi y aves', 'text' => 'Paisajes propicios para practicar y para el avistaje de aves.'],
            ['icon' => 'camera', 'title' => 'Fotografía', 'text' => 'Un entorno único para salir a sacar fotos.'],
        ],
    ],

    'location' => [
        'id' => 'ubicacion',
        'kicker' => 'Cómo llegar',
        'title' => 'Sobre la Ruta 63, a 1.100 m del lago',
        'text' => 'Estamos en Villa Lago Meliquina, Neuquén, a 40 km de San Martín de los Andes. Pasando el lago, hacé 1.100 m sobre la Ruta 63.',
        'routes' => [
            [
                'title' => 'Desde San Martín de los Andes',
                'text' => '23 km por la Ruta 40 (ex 234) y, en la intersección con la Ruta 63, doblá a la izquierda. Luego 14 km por ripio firme hasta Villa Lago Meliquina.',
            ],
            [
                'title' => 'Desde Bariloche',
                'text' => 'Por la Ruta 40 hacia el norte, haciendo Siete Lagos. Pasando el lago Machónico, en el puesto de Gendarmería, tomá la Ruta 63 a la derecha y hacé 14 km de ripio firme.',
            ],
            [
                'title' => 'Por Paso Córdoba',
                'text' => 'Otra opción desde Bariloche es la Ruta 237 y luego unos 50 km de ripio con poco mantenimiento, pero con paisajes únicos.',
            ],
        ],
        'tips' => [],
    ],

    'faq' => [
        'id' => 'faq',
        'kicker' => 'Preguntas frecuentes',
        'title' => 'Antes de venir',
        'text' => 'Si hay algo que no encontrás acá, escribinos por WhatsApp o por email. Nos encanta recibir mensajes.',
        'items' => [
            [
                'q' => '¿El desayuno está incluido?',
                'a' => 'Sí. Los huéspedes de la hostería desayunan en nuestra Casa de Té: un desayuno casero y completo, preparado a diario con recetas heredadas de la familia y productos locales.',
            ],
            [
                'q' => '¿Puedo ir a la Casa de Té sin hospedarme?',
                'a' => "Sí. La Casa de Té está abierta al público por la tarde, de 15 a 19 h, con pastelería, meriendas, té y café especial.\n\nLos días pueden variar según la época del año. Si venís de lejos, escribinos antes por WhatsApp.",
            ],
            [
                'q' => '¿Para quién está pensada la hostería?',
                'a' => 'Para parejas y grupos de amigos o amigas que buscan descansar, desconectarse del estrés de la rutina y estar en contacto con la naturaleza.',
            ],
            [
                'q' => '¿Cómo son las habitaciones?',
                'a' => 'Hay habitaciones dobles de 28 m² con cama de 2 × 2 m y habitaciones dobles con dos camas separadas de 1 × 2 m. Todas tienen baño privado, calefacción por radiadores, internet y vista al jardín y a las montañas.',
            ],
            [
                'q' => '¿Puedo cocinar durante la estadía?',
                'a' => 'Sí. Hay un SUM con cocina, heladera y parrillas para los huéspedes.',
            ],
            [
                'q' => '¿Cómo llego desde San Martín de los Andes?',
                'a' => 'En auto, 23 km por la Ruta 40 (ex 234) y en la intersección con la Ruta 63 doblá a la izquierda. Luego 14 km por ripio firme hasta Villa Lago Meliquina. Pasando el lago, hacé 1.100 m sobre la Ruta 63.',
            ],
            [
                'q' => '¿Cuáles son las tarifas?',
                'a' => 'Dependen de la fecha, la habitación y la cantidad de noches. Escribinos por WhatsApp o email con tus fechas y te respondemos con disponibilidad y tarifa.',
            ],
        ],
    ],

    'cta' => [
        'title' => '¿Venís a Meliquina?',
        'text' => 'Escribinos por WhatsApp o por email con tus fechas. Te contamos la disponibilidad de la hostería y los horarios de la Casa de Té.',
        'button' => 'Escribir por WhatsApp',
        'button_href' => 'whatsapp',
    ],

    'footer' => [
        'blurb' => 'Hostería y Casa de Té en Villa Lago Meliquina, a 40 km de San Martín de los Andes. Rodeados de montañas, con paisajes y sabores que te conecten.',
        'columns' => [
            [
                'title' => 'Cinco Sentidos',
                'links' => [
                    ['label' => 'Hostería', 'href' => 'hosteria'],
                    ['label' => 'Casa de Té', 'href' => 'casa-de-te'],
                    ['label' => 'Nuestra historia', 'href' => '#historia'],
                    ['label' => 'Galería', 'href' => '#galeria'],
                ],
            ],
            [
                'title' => 'Visitanos',
                'links' => [
                    ['label' => 'Consultar disponibilidad', 'href' => '#reservas'],
                    ['label' => 'WhatsApp', 'href' => 'whatsapp'],
                    ['label' => 'Cómo llegar', 'href' => '#ubicacion'],
                    ['label' => 'Preguntas frecuentes', 'href' => '#faq'],
                ],
            ],
            [
                'title' => 'Seguinos',
                'links' => [
                    ['label' => 'Instagram', 'href' => 'https://www.instagram.com/cincosentidosmeliquina/', 'external' => true],
                    ['label' => 'Facebook', 'href' => 'https://www.facebook.com/cincosentidosmeliquina', 'external' => true],
                    ['label' => 'Tripadvisor', 'href' => 'https://www.tripadvisor.com/Restaurant_Review-g312843-d8752563-Reviews-Cinco_Sentidos_Casa_de_Te_Meliquina-San_Martin_de_los_Andes_Province_of_Neuquen_P.html', 'external' => true],
                    ['label' => 'Google Maps', 'href' => 'https://maps.google.com/maps?cid=17462579006814433526', 'external' => true],
                ],
            ],
        ],
        'copyright' => 'Cinco Sentidos Meliquina. Todos los derechos reservados.',
        'credit_prefix' => 'desarrollado por:',
        'credit_label' => 'estudiolimay.com',
        'credit_url' => 'https://estudiolimay.com',
    ],

    'privacy' => [
        'title' => 'Política de privacidad',
        'updated' => 'Noviembre 2026',
        'intro' => 'Cómo Cinco Sentidos Meliquina trata los datos que nos enviás desde cincosentidosmeliquina.com.ar al consultar disponibilidad en la hostería.',
        'sections' => [
            [
                'title' => 'Qué datos reunimos',
                'text' => 'El formulario guarda tu nombre, la cantidad de personas, las fechas, la habitación de interés, un dato de contacto opcional y el mensaje, para poder responderte. Con esos mismos datos se abre WhatsApp.',
            ],
            [
                'title' => 'Para qué los usamos',
                'text' => 'Únicamente para responder tu consulta y coordinar la reserva. No vendemos ni compartimos tus datos con terceros.',
            ],
            [
                'title' => 'Conservación',
                'text' => 'Conservamos la consulta para el seguimiento de la reserva. El mensaje también viaja por WhatsApp.',
            ],
            [
                'title' => 'Tus derechos',
                'text' => 'Podés acceder, corregir o suprimir tus datos escribiéndonos a hosteriacincosentidos@gmail.com o por WhatsApp.',
            ],
        ],
    ],
];
