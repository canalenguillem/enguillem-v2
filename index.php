<?php get_header(); ?>

<div class="container">
    <div class="page-header">
        <h1><?php wp_title(''); ?></h1>
    </div>

    <?php if (have_posts()) : ?>
        <div class="cards-grid">
            <?php while (have_posts()) : the_post(); ?>
            <article class="card">
                <div class="card-thumb">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>" class="card-thumb-placeholder"><?php the_title(); ?></a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="card-meta">
                        <span><?php echo get_the_date('d M Y'); ?></span>
                    </div>
                </div>
            </article>
            <?php endwhile; ?>
        </div>

        <div class="pagination">
            <?php echo paginate_links(['prev_text' => '← Anterior', 'next_text' => 'Siguiente →']); ?>
        </div>
    <?php else : ?>
        <p style="color:var(--text-muted);font-family:var(--font-mono);">// no hay contenido.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
