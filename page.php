<?php get_header(); ?>

<?php while (have_posts()) : the_post();
    $post_id = get_the_ID();
    $views   = (int) get_post_meta($post_id, 'page_views', true);
?>

<div class="container">
    <div class="page-header">
        <?php if (current_user_can('administrator') && $views) : ?>
            <div class="admin-views">Visitas: <strong><?php echo $views; ?></strong></div>
        <?php endif; ?>
        <h1><?php the_title(); ?></h1>
    </div>

    <div class="entry-content" style="padding-bottom:72px">
        <?php the_content(); ?>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
