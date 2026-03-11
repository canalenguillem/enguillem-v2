<?php get_header(); ?>

<?php while (have_posts()) : the_post();
    $post_id  = get_the_ID();
    $views    = (int) get_post_meta($post_id, 'post_views', true);
    $is_tut   = (get_post_type() === 'tutorial');
    $cats     = $is_tut
        ? get_the_terms($post_id, 'categoria-tutoriales')
        : get_the_category();
    $cat      = ($cats && !is_wp_error($cats)) ? $cats[0] : null;
    $cat_name = $cat ? $cat->name : ($is_tut ? 'Tutorial' : 'Blog');
    $cat_link = $cat ? get_term_link($cat) : '#';

    // Tiempo estimado de lectura
    $content   = get_the_content();
    $words     = str_word_count(strip_tags($content));
    $read_time = max(1, round($words / 200));
?>

<!-- Barra de progreso de lectura -->
<div id="read-progress" style="position:fixed;top:0;left:0;height:3px;width:0%;background:var(--accent);z-index:200;transition:width 0.1s linear;"></div>

<!-- Hero -->
<div class="single-hero">
    <?php if (has_post_thumbnail()) : ?>
        <div class="single-hero-img">
            <?php the_post_thumbnail('large'); ?>
            <div class="single-hero-overlay"></div>
        </div>
    <?php endif; ?>
    <div class="container single-hero-content">
        <?php if (current_user_can('administrator')) : ?>
            <div class="admin-views" style="margin-bottom:16px">Visitas: <strong><?php echo $views; ?></strong></div>
        <?php endif; ?>
        <a href="<?php echo esc_url($cat_link); ?>" class="single-tag"><?php echo esc_html($cat_name); ?></a>
        <h1 class="single-title"><?php the_title(); ?></h1>
        <div class="single-meta">
            <span><?php echo get_the_date('d M Y'); ?></span>
            <span>Por <?php the_author(); ?></span>
            <span><?php echo $read_time; ?> min de lectura</span>
        </div>
    </div>
</div>

<!-- Contenido + Sidebar -->
<div class="container single-wrap">

    <!-- Contenido principal -->
    <article class="single-content">
        <div class="entry-content" id="entry-content">
            <?php the_content(); ?>
        </div>

        <!-- Navegación prev/next -->
        <nav class="single-nav">
            <div class="single-nav-prev">
                <?php previous_post_link('<span class="single-nav-label">← Anterior</span><br>%link', '%title'); ?>
            </div>
            <div class="single-nav-next">
                <?php next_post_link('<span class="single-nav-label">Siguiente →</span><br>%link', '%title'); ?>
            </div>
        </nav>
    </article>

    <!-- Sidebar -->
    <aside class="single-sidebar">

        <!-- Índice / TOC -->
        <div class="sidebar-widget" id="toc-widget" style="display:none">
            <div class="sidebar-widget-title">
                <span class="section-label" style="margin:0">// índice</span>
            </div>
            <nav id="toc-nav"></nav>
        </div>

        <!-- Tutoriales relacionados -->
        <?php
        $related_args = [
            'post_type'      => get_post_type(),
            'posts_per_page' => 5,
            'post_status'    => 'publish',
            'post__not_in'   => [$post_id],
            'orderby'        => 'meta_value_num',
            'meta_key'       => 'post_views',
            'order'          => 'DESC',
        ];
        if ($cat) {
            $related_args['tax_query'] = [[
                'taxonomy' => $is_tut ? 'categoria-tutoriales' : 'category',
                'field'    => 'term_id',
                'terms'    => $cat->term_id,
            ]];
        }
        $related = new WP_Query($related_args);
        if ($related->have_posts()) :
        ?>
        <div class="sidebar-widget">
            <div class="sidebar-widget-title">
                <span class="section-label" style="margin:0">// relacionados</span>
            </div>
            <ul class="related-list">
                <?php while ($related->have_posts()) : $related->the_post(); ?>
                <li class="related-item">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="related-thumb">
                            <?php the_post_thumbnail('thumbnail'); ?>
                        </a>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>" class="related-title"><?php the_title(); ?></a>
                </li>
                <?php endwhile; wp_reset_postdata(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Share links -->
        <div class="sidebar-widget">
            <div class="sidebar-widget-title">
                <span class="section-label" style="margin:0">// compartir</span>
            </div>
            <div class="share-buttons">
                <?php
                $share_url   = urlencode(get_permalink());
                $share_title = urlencode(get_the_title());
                ?>
                <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener" class="share-btn share-x">X / Twitter</a>
                <a href="https://www.linkedin.com/shareArticle?url=<?php echo $share_url; ?>&title=<?php echo $share_title; ?>" target="_blank" rel="noopener" class="share-btn share-li">LinkedIn</a>
                <a href="https://wa.me/?text=<?php echo $share_title; ?>%20<?php echo $share_url; ?>" target="_blank" rel="noopener" class="share-btn share-wa">WhatsApp</a>
            </div>
        </div>

    </aside>
</div>

<!-- Más tutoriales relacionados (abajo) -->
<?php
$bottom_related = new WP_Query([
    'post_type'      => get_post_type(),
    'posts_per_page' => 4,
    'post_status'    => 'publish',
    'post__not_in'   => [$post_id],
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'post_views',
    'order'          => 'DESC',
    'tax_query'      => $cat ? [[
        'taxonomy' => $is_tut ? 'categoria-tutoriales' : 'category',
        'field'    => 'term_id',
        'terms'    => $cat->term_id,
    ]] : [],
]);
if ($bottom_related->have_posts()) :
?>
<section style="border-top:1px solid var(--border);padding:56px 0">
    <div class="container">
        <span class="section-label">// más en <?php echo esc_html($cat_name); ?></span>
        <h2 class="section-title">También te puede interesar</h2>
        <div class="cards-grid">
            <?php while ($bottom_related->have_posts()) : $bottom_related->the_post();
                $r_views = (int) get_post_meta(get_the_ID(), 'post_views', true);
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
                    <span class="card-tag"><?php echo esc_html($cat_name); ?></span>
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
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
