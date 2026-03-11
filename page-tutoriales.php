<?php get_header(); ?>

<div class="container">
    <div class="page-header">
        <span class="section-label">// tutoriales</span>
        <h1>Todos los Tutoriales</h1>
    </div>

    <!-- Búsqueda -->
    <form class="search-tutorials" method="GET" id="search-form">
        <input
            type="text"
            name="s"
            id="search-input"
            placeholder="Buscar tutoriales..."
            value="<?php echo esc_attr(get_search_query()); ?>"
        >
        <button type="submit">Buscar</button>
    </form>

    <!-- Filtro por categoría -->
    <div class="filter-bar" id="filter-bar">
        <button class="filter-btn active" data-cat="all">Todos</button>
        <?php
        $cats = get_terms(['taxonomy' => 'categoria-tutoriales', 'hide_empty' => true]);
        foreach ($cats as $cat) : ?>
            <button class="filter-btn" data-cat="<?php echo esc_attr($cat->slug); ?>">
                <?php echo esc_html($cat->name); ?>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Grid de tutoriales -->
    <div class="cards-grid" id="tutorials-grid">
        <?php
        $paged = max(1, get_query_var('paged'));
        $search = sanitize_text_field(get_query_var('s'));

        $args = [
            'post_type'      => 'tutorial',
            'posts_per_page' => 12,
            'paged'          => $paged,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];

        if ($search) {
            $args['s'] = $search;
        }

        $q = new WP_Query($args);

        if ($q->have_posts()) :
            while ($q->have_posts()) : $q->the_post();
                $views = (int) get_post_meta(get_the_ID(), 'post_views', true);
                $cats  = get_the_terms(get_the_ID(), 'categoria-tutoriales');
                $cat   = ($cats && !is_wp_error($cats)) ? $cats[0]->name : 'Tutorial';
                $cat_slug = ($cats && !is_wp_error($cats)) ? $cats[0]->slug : '';
        ?>
        <article class="card" data-cat="<?php echo esc_attr($cat_slug); ?>">
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
        <?php
            endwhile;
        else :
        ?>
            <p style="color:var(--text-muted);font-family:var(--font-mono);grid-column:1/-1;">
                // no se encontraron tutoriales.
            </p>
        <?php endif; wp_reset_postdata(); ?>
    </div>

    <!-- Paginación -->
    <?php if ($q->max_num_pages > 1) : ?>
    <div class="pagination">
        <?php
        echo paginate_links([
            'total'     => $q->max_num_pages,
            'current'   => $paged,
            'prev_text' => '← Anterior',
            'next_text' => 'Siguiente →',
        ]);
        ?>
    </div>
    <?php endif; ?>

</div>

<script>
// Filtro por categoría (client-side sobre los resultados cargados)
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const cat = btn.dataset.cat;
        document.querySelectorAll('#tutorials-grid .card').forEach(card => {
            card.style.display = (cat === 'all' || card.dataset.cat === cat) ? '' : 'none';
        });
    });
});
</script>

<?php get_footer(); ?>
