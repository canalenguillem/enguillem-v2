<?php get_header(); ?>

<?php
// Admin counter
$fp_id = get_option('page_on_front');
$fp_views = (int) get_post_meta($fp_id, 'post_views', true);
?>

<!-- ===== HERO ===== -->
<section class="site-hero">
    <div class="container">
        <div class="hero-inner">

            <!-- Terminal -->
            <div class="hero-terminal">
                <div class="terminal-bar">
                    <span class="terminal-dot red"></span>
                    <span class="terminal-dot amber"></span>
                    <span class="terminal-dot green"></span>
                    <span class="terminal-title">enguillem@server:~</span>
                </div>
                <div class="terminal-body">
                    <div class="terminal-line">
                        <span class="terminal-prompt">❯</span>
                        <span class="terminal-cmd">whoami</span>
                    </div>
                    <div class="terminal-line">
                        <span class="terminal-output accent">guillem — sysadmin, DevOps &amp; IA</span>
                    </div>
                    <div class="terminal-line" style="margin-top:8px">
                        <span class="terminal-prompt">❯</span>
                        <span class="terminal-cmd">ls ./contenido/</span>
                    </div>
                    <div class="terminal-line">
                        <span class="terminal-output green">tutoriales/&nbsp;&nbsp;blog/&nbsp;&nbsp;cursos/</span>
                    </div>
                    <div class="terminal-line" style="margin-top:8px">
                        <span class="terminal-prompt">❯</span>
                        <span class="terminal-cmd">cat descripcion.txt</span>
                    </div>
                    <div class="terminal-line">
                        <span class="terminal-output">Guías prácticas de Linux, servidores</span>
                    </div>
                    <div class="terminal-line">
                        <span class="terminal-output">y DevOps en español.</span>
                    </div>
                    <div class="terminal-line" style="margin-top:8px">
                        <span class="terminal-prompt">❯</span>
                        <span class="terminal-cursor"></span>
                    </div>
                </div>
            </div>

            <!-- Tagline -->
            <div class="hero-content">
                <?php if (current_user_can('administrator')) : ?>
                    <div class="admin-views" style="margin-bottom:20px">
                        Visitas homepage: <strong><?php echo $fp_views; ?></strong>
                    </div>
                <?php endif; ?>
                <h1>Aprende <em>Linux</em>, servidores e <em>IA</em> con guías paso a paso</h1>
                <p>Tutoriales prácticos en español para administradores de sistemas, DevOps y entusiastas de la tecnología.</p>
                <div class="hero-actions">
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('tutoriales'))); ?>" class="btn btn-primary">Ver tutoriales</a>
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('curso-de-inteligencia-artificial'))); ?>" class="btn btn-outline">Curso de IA →</a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ===== TUTORIALES MÁS VISTOS ===== -->
<section class="section">
    <div class="container">
        <span class="section-label">// tutoriales_más_vistos</span>
        <h2 class="section-title">Tutoriales <span>Más Vistos</span></h2>

        <div class="cards-grid">
            <?php
            $q = new WP_Query([
                'post_type'      => 'tutorial',
                'posts_per_page' => 8,
                'post_status'    => 'publish',
                'meta_key'       => 'post_views',
                'orderby'        => 'meta_value_num',
                'order'          => 'DESC',
            ]);
            while ($q->have_posts()) : $q->the_post();
                $views = (int) get_post_meta(get_the_ID(), 'post_views', true);
                $cats  = get_the_terms(get_the_ID(), 'categoria-tutoriales');
                $cat   = ($cats && !is_wp_error($cats)) ? $cats[0]->name : 'Tutorial';
            ?>
            <article class="card">
                <div class="card-thumb">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>" class="card-thumb-placeholder"><?php the_title(); ?></a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <span class="card-tag"><?php echo esc_html($cat); ?></span>
                    <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="card-meta">
                        <span><?php echo get_the_date('d M Y'); ?></span>
                        <?php if (current_user_can('administrator')) : ?>
                            <span class="card-views">👁 <?php echo $views; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<!-- ===== CTA CURSO ===== -->
<?php if (!is_page('curso-de-inteligencia-artificial')) : ?>
<div class="container">
    <div class="cta-banner">
        <div class="cta-banner-text">
            <h3>🎓 Aprende Inteligencia Artificial con Python</h3>
            <p>Curso completo en Udemy — Crea proyectos reales con OpenAI, FastAPI y Telegram.</p>
        </div>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('curso-de-inteligencia-artificial'))); ?>" class="btn btn-green">Ver el curso →</a>
    </div>
</div>
<?php endif; ?>

<!-- ===== ARTÍCULOS MÁS LEÍDOS ===== -->
<section class="section">
    <div class="container">
        <span class="section-label">// artículos_más_leídos</span>
        <h2 class="section-title">Artículos <span>Más Leídos</span></h2>

        <div class="cards-grid">
            <?php
            $q2 = new WP_Query([
                'post_type'      => 'post',
                'posts_per_page' => 8,
                'post_status'    => 'publish',
                'meta_key'       => 'post_views',
                'orderby'        => 'meta_value_num',
                'order'          => 'DESC',
            ]);
            while ($q2->have_posts()) : $q2->the_post();
                $views2 = (int) get_post_meta(get_the_ID(), 'post_views', true);
                $cats2  = get_the_category();
                $cat2   = $cats2 ? $cats2[0]->name : 'Blog';
            ?>
            <article class="card">
                <div class="card-thumb">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>" class="card-thumb-placeholder"><?php the_title(); ?></a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <span class="card-tag"><?php echo esc_html($cat2); ?></span>
                    <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="card-meta">
                        <span><?php echo get_the_date('d M Y'); ?></span>
                        <?php if (current_user_can('administrator')) : ?>
                            <span class="card-views">👁 <?php echo $views2; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<!-- ===== ÚLTIMOS TUTORIALES ===== -->
<section class="section" style="padding-top:0">
    <div class="container">
        <span class="section-label">// últimos_tutoriales</span>
        <h2 class="section-title">Últimos <span>Tutoriales</span></h2>

        <div class="cards-grid">
            <?php
            $q3 = new WP_Query([
                'post_type'      => 'tutorial',
                'posts_per_page' => 4,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ]);
            while ($q3->have_posts()) : $q3->the_post();
                $cats3 = get_the_terms(get_the_ID(), 'categoria-tutoriales');
                $cat3  = ($cats3 && !is_wp_error($cats3)) ? $cats3[0]->name : 'Tutorial';
            ?>
            <article class="card">
                <div class="card-thumb">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>" class="card-thumb-placeholder"><?php the_title(); ?></a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <span class="card-tag"><?php echo esc_html($cat3); ?></span>
                    <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="card-meta">
                        <span><?php echo get_the_date('d M Y'); ?></span>
                    </div>
                </div>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
