<?php /* Template Name: Landing Curso IA */ ?>
<?php get_header(); ?>

<?php
// Contador de visitas (solo admin lo ve)
$post_id = get_the_ID();
$views = get_post_meta($post_id, 'page_views', true) ?: 0;
if (!isset($_COOKIE['visitado_' . $post_id])) {
    $views++;
    update_post_meta($post_id, 'page_views', $views);
    setcookie('visitado_' . $post_id, '1', time() + 3600, '/');
}

// Enlace de compra y precio — actualiza estas variables cuando cambien
$udemy_link    = 'https://www.udemy.com/course/crea-un-chatbot-con-chatgpt-openai-y-fastapi-con-python/?couponCode=3EC13BA07737BFE8698C';
$precio_actual = '14,99 €';
$precio_antes  = '89,99 €';
?>

<div class="lc-wrap">

    <?php if (current_user_can('administrator')) : ?>
        <div class="lc-admin-bar">
            Visitas a esta página: <strong><?php echo intval($views); ?></strong>
        </div>
    <?php endif; ?>

    <!-- ===== HERO ===== -->
    <section class="lc-hero">
        <div class="container text-center">
            <h1 class="lc-hero-title">
                🎓 ¡Aprende a Usar OpenAI con Python!<br>
                <span>Curso Completo en Udemy</span>
            </h1>
            <ul class="lc-hero-bullets">
                <li>✅ Más de 100 alumnos ya han comenzado este curso. ¡Únete ahora!</li>
                <li>🚀 Transforma tu carrera y crea proyectos de inteligencia artificial con Python.</li>
                <li>📣 🔥 ÚLTIMOS DÍAS CON DESCUENTO: <strong>SOLO <?php echo esc_html($precio_actual); ?></strong> (Antes <?php echo esc_html($precio_antes); ?>) 🔥</li>
            </ul>
            <a href="<?php echo esc_url($udemy_link); ?>" class="lc-btn-cta btn-primary" target="_blank" rel="noopener">
                ¡INSCRÍBETE AQUÍ Y AHORA POR SOLO <?php echo esc_html($precio_actual); ?>!
            </a>
        </div>
    </section>

    <!-- ===== VIDEO 1 ===== -->
    <section class="lc-section lc-bg-white">
        <div class="container text-center">
            <h2>⬇ Mira este video y descubre lo que puedes lograr con este curso ⬇</h2>
            <div class="lc-video-wrap">
                <iframe src="https://www.youtube.com/embed/qutRuYINZsk" title="Presentación del curso" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </section>

    <!-- ===== POR QUÉ ===== -->
    <section class="lc-section lc-bg-light">
        <div class="container">
            <h2 class="text-center">🏆 ¿Por qué este curso es para ti?</h2>
            <p class="text-center lc-lead">Este curso te lleva <strong>paso a paso</strong> desde los conceptos básicos hasta proyectos avanzados con OpenAI y Python. No necesitas experiencia previa en IA.</p>
            <p class="text-center"><strong>Aprenderás a:</strong></p>
            <ul class="lc-checklist">
                <li>✅ Usar la API de OpenAI para generar respuestas inteligentes en tus proyectos.</li>
                <li>✅ Crear un bot de Telegram con IA y automatizar tareas con Python.</li>
                <li>✅ Construir interfaces modernas con React para mejorar la experiencia de usuario.</li>
                <li>✅ Automatizar tareas con IA y optimizar flujos de trabajo.</li>
                <li>✅ Desarrollar un backend con FastAPI para gestionar datos de manera eficiente.</li>
                <li>✅ Crear proyectos reales que puedes aplicar en el mundo laboral.</li>
            </ul>
            <p class="text-center">🌟 Aprende con ejemplos prácticos y accede a una comunidad de más de 100 estudiantes.</p>
            <div class="text-center mt-4">
                <a href="<?php echo esc_url($udemy_link); ?>" class="lc-btn-cta" target="_blank" rel="noopener">
                    ¡INSCRÍBETE AQUÍ Y AHORA POR SOLO <?php echo esc_html($precio_actual); ?>!
                </a>
            </div>
        </div>
    </section>

    <!-- ===== VIDEO 2 ===== -->
    <section class="lc-section lc-bg-dark">
        <div class="container text-center">
            <h2 class="text-white">🔥 Ver un ejemplo en acción:</h2>
            <div class="lc-video-wrap">
                <iframe src="https://www.youtube.com/embed/rojY7bvZXZA" title="Ejemplo del curso" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </section>

    <!-- ===== CONTENIDO ===== -->
    <section class="lc-section lc-bg-white">
        <div class="container">
            <h2 class="text-center">📦 Contenido del Curso</h2>
            <p class="text-center lc-lead">Más de <strong>10 horas de contenido práctico</strong> en 75 clases detalladas y estructuradas.</p>
            <div class="lc-modules">
                <div class="lc-module">
                    <span class="lc-module-icon">📘</span>
                    <div>
                        <h4>Introducción <small>(6 clases – 36 min)</small></h4>
                        <p>Configuración inicial y herramientas esenciales.</p>
                    </div>
                </div>
                <div class="lc-module">
                    <span class="lc-module-icon">📘</span>
                    <div>
                        <h4>API de OpenAI con Python <small>(8 clases – 1h 34m)</small></h4>
                        <p>Aprende a generar texto, imágenes y respuestas inteligentes.</p>
                    </div>
                </div>
                <div class="lc-module">
                    <span class="lc-module-icon">📘</span>
                    <div>
                        <h4>Backend con FastAPI <small>(3 clases – 16 min)</small></h4>
                        <p>Construcción de servidores eficientes.</p>
                    </div>
                </div>
                <div class="lc-module">
                    <span class="lc-module-icon">📘</span>
                    <div>
                        <h4>Frontend con React <small>(7 clases – 3h 3m)</small></h4>
                        <p>Diseño de interfaces interactivas.</p>
                    </div>
                </div>
                <div class="lc-module">
                    <span class="lc-module-icon">📘</span>
                    <div>
                        <h4>Bot de Telegram con IA <small>(10 clases – 1h 18m)</small></h4>
                        <p>Implementación de IA en bots y automatización de tareas.</p>
                    </div>
                </div>
                <div class="lc-module">
                    <span class="lc-module-icon">📘</span>
                    <div>
                        <h4>Proyectos avanzados con OpenAI <small>(13 clases – 1h 39m)</small></h4>
                        <p>Generación de imágenes con IA y herramientas creativas.</p>
                    </div>
                </div>
                <div class="lc-module">
                    <span class="lc-module-icon">📘</span>
                    <div>
                        <h4>Despliegue y cierre <small>(6 clases – 56m)</small></h4>
                        <p>Publica tu app y optimiza tu código.</p>
                    </div>
                </div>
            </div>
            <p class="text-center mt-4">🌟 ¡Cada módulo incluye ejercicios prácticos para aplicar lo aprendido en proyectos reales!</p>
        </div>
    </section>

    <!-- ===== QUÉ OBTENDRÁS ===== -->
    <section class="lc-section lc-bg-navy">
        <div class="container">
            <h2 class="text-center text-white">🎁 ¿Qué obtendrás al inscribirte?</h2>
            <ul class="lc-checklist lc-checklist-light">
                <li>✔ Acceso completo al curso y a todas las actualizaciones futuras.</li>
                <li>✔ Certificado oficial de finalización.</li>
                <li>✔ Ejercicios prácticos y material descargable.</li>
                <li>✔ Acceso a una comunidad de estudiantes para resolver dudas.</li>
                <li>✔ Oferta especial por tiempo limitado: <strong>Solo <?php echo esc_html($precio_actual); ?></strong> (Valor original: <?php echo esc_html($precio_antes); ?>)</li>
            </ul>
            <p class="text-center text-white">🚨 ¡No pierdas esta oportunidad! Accede ahora y comienza a crear tus propios proyectos de IA.</p>
            <div class="text-center mt-4">
                <a href="<?php echo esc_url($udemy_link); ?>" class="lc-btn-cta" target="_blank" rel="noopener">
                    ¡ÚNETE AHORA Y EMPIEZA HOY!
                </a>
            </div>
        </div>
    </section>

    <!-- ===== OFERTA GRATUITA ===== -->
    <section class="lc-section lc-bg-light">
        <div class="container text-center">
            <h2>🎁 OFERTA VERSIÓN GRATUITA</h2>
            <p class="lc-lead">Si has llegado aquí, ¡te tengo una sorpresa! 🎉</p>
            <ul class="lc-checklist lc-checklist-center">
                <li>✅ Accede gratis al primer módulo del curso y decide si es para ti.</li>
                <li>✅ 100% gratis, sin compromiso.</li>
                <li>✅ Aprende los fundamentos de OpenAI y Python.</li>
                <li>✅ Descubre cómo funciona la IA en aplicaciones reales.</li>
            </ul>
            <a href="<?php echo esc_url($udemy_link); ?>" class="lc-btn-cta-outline mt-4 d-inline-block" target="_blank" rel="noopener">
                ACCEDER AHORA Y REGALARME EL PRIMER MÓDULO GRATIS
            </a>
        </div>
    </section>

</div><!-- .lc-wrap -->

<?php get_footer(); ?>
