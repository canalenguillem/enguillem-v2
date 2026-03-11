<?php get_header(); ?>

<div class="container">
    <div class="page-header">
        <span class="section-label">// blog</span>
        <h1>Últimas entradas</h1>
    </div>

    <?php if (have_posts()) : ?>

        <div class="post-list">
            <?php while (have_posts()) : the_post();
                $views = (int) get_post_meta(get_the_ID(), 'post_views', true);
                $cats  = get_the_category();
                $cat   = $cats ? $cats[0]->name : 'Blog';
            ?>
            <article class="post-row">
                <div class="post-row-thumb">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>" style="display:flex;align-items:center;justify-content:center;height:100%;background:var(--bg-elevated);font-family:var(--font-mono);font-size:0.8rem;color:var(--accent);text-align:center;padding:12px;"><?php the_title(); ?></a>
                    <?php endif; ?>
                </div>
                <div class="post-row-body">
                    <span class="post-row-tag"><?php echo esc_html($cat); ?></span>
                    <h2 class="post-row-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p class="post-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                    <div class="post-row-meta">
                        <span><?php echo get_the_date('d M Y'); ?></span>
                        <span><?php the_author(); ?></span>
                        <?php if (current_user_can('administrator')) : ?>
                            <span>👁 <?php echo $views; ?> visitas</span>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endwhile; ?>
        </div>

        <!-- Paginación -->
        <div class="pagination">
            <?php
            echo paginate_links([
                'prev_text' => '← Anterior',
                'next_text' => 'Siguiente →',
                'type'      => 'list',
            ]);
            ?>
        </div>

    <?php else : ?>
        <p style="color:var(--text-muted);font-family:var(--font-mono);">// no hay entradas todavía.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
