<?php

// =========================================================
// SETUP
// =========================================================

function enguillem_v2_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption']);
    register_nav_menus(['top_menu' => 'Menú Principal']);
    add_filter('big_image_size_threshold', '__return_false');
}
add_action('after_setup_theme', 'enguillem_v2_setup');

// =========================================================
// ASSETS
// =========================================================

function enguillem_v2_assets() {
    // Fonts
    wp_enqueue_style(
        'enguillem-v2-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap',
        [], null
    );

    // Main stylesheet
    wp_enqueue_style(
        'enguillem-v2-style',
        get_stylesheet_uri(),
        ['enguillem-v2-fonts'],
        filemtime(get_stylesheet_directory() . '/style.css')
    );

    // Main JS
    wp_enqueue_script(
        'enguillem-v2-main',
        get_template_directory_uri() . '/js/main.js',
        [], filemtime(get_template_directory() . '/js/main.js'), true
    );

    wp_localize_script('enguillem-v2-main', 'pg', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'apiBase' => get_rest_url(null, 'pg/v1/'),
    ]);
}
add_action('wp_enqueue_scripts', 'enguillem_v2_assets');

// =========================================================
// CPT: TUTORIAL
// =========================================================

function enguillem_v2_cpt() {
    register_post_type('tutorial', [
        'labels' => [
            'name'          => 'Tutoriales',
            'singular_name' => 'Tutorial',
            'add_new_item'  => 'Añadir Tutorial',
            'edit_item'     => 'Editar Tutorial',
        ],
        'public'            => true,
        'publicly_queryable'=> true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'supports'          => ['title', 'editor', 'thumbnail', 'revisions'],
        'menu_icon'         => 'dashicons-welcome-learn-more',
        'has_archive'       => true,
        'rewrite'           => ['slug' => 'tutoriales'],
        'capability_type'   => 'post',
        'map_meta_cap'      => true,
        'export'            => true,
    ]);
}
add_action('init', 'enguillem_v2_cpt');

// =========================================================
// TAXONOMY: CATEGORIA-TUTORIALES
// =========================================================

function enguillem_v2_taxonomy() {
    register_taxonomy('categoria-tutoriales', ['tutorial'], [
        'labels' => [
            'name'          => 'Categorías de Tutoriales',
            'singular_name' => 'Categoría',
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'categoria-tutoriales'],
    ]);
}
add_action('init', 'enguillem_v2_taxonomy');

// =========================================================
// VIEW COUNTERS
// =========================================================

function enguillem_v2_count_tutorial() {
    if (!is_singular('tutorial') || current_user_can('administrator')) return;
    $id = get_the_ID();
    if (isset($_COOKIE['post_viewed_' . $id])) return;
    $views = (int) get_post_meta($id, 'post_views', true);
    update_post_meta($id, 'post_views', $views + 1);
    setcookie('post_viewed_' . $id, '1', time() + 3600, '/');
}
add_action('wp_head', 'enguillem_v2_count_tutorial');

function enguillem_v2_count_post() {
    if (!is_singular('post') || current_user_can('administrator')) return;
    $id = get_the_ID();
    if (isset($_COOKIE['post_viewed_' . $id])) return;
    $views = (int) get_post_meta($id, 'post_views', true);
    update_post_meta($id, 'post_views', $views + 1);
    setcookie('post_viewed_' . $id, '1', time() + 3600, '/');
}
add_action('wp_head', 'enguillem_v2_count_post');

function enguillem_v2_count_frontpage() {
    if (!is_front_page() || current_user_can('administrator')) return;
    if (isset($_COOKIE['front_page_viewed'])) return;
    $id = get_option('page_on_front');
    $views = (int) get_post_meta($id, 'post_views', true);
    update_post_meta($id, 'post_views', $views + 1);
    setcookie('front_page_viewed', '1', time() + 3600, '/');
}
add_action('wp_head', 'enguillem_v2_count_frontpage');

// =========================================================
// AJAX: FILTRO TUTORIALES
// =========================================================

function enguillem_v2_filtro_tutoriales() {
    $categoria = isset($_POST['categoria']) ? sanitize_text_field($_POST['categoria']) : '';

    $args = [
        'post_type'      => 'tutorial',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ];

    if ($categoria && $categoria !== 'all') {
        $args['tax_query'] = [[
            'taxonomy' => 'categoria-tutoriales',
            'field'    => 'slug',
            'terms'    => $categoria,
        ]];
    }

    $query = new WP_Query($args);
    $results = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $results[] = [
                'id'    => get_the_ID(),
                'title' => get_the_title(),
                'link'  => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: '',
                'views' => (int) get_post_meta(get_the_ID(), 'post_views', true),
            ];
        }
        wp_reset_postdata();
    }

    wp_send_json_success($results);
}
add_action('wp_ajax_filtreTutorials', 'enguillem_v2_filtro_tutoriales');
add_action('wp_ajax_nopriv_filtreTutorials', 'enguillem_v2_filtro_tutoriales');

// =========================================================
// REST API: NOVEDADES
// =========================================================

function enguillem_v2_rest_routes() {
    register_rest_route('pg/v1', '/novedades/(?P<cantidad>\d+)', [
        'methods'             => 'GET',
        'callback'            => 'enguillem_v2_novedades_cb',
        'permission_callback' => '__return_true',
        'args'                => [
            'cantidad' => ['sanitize_callback' => 'absint'],
        ],
    ]);
}
add_action('rest_api_init', 'enguillem_v2_rest_routes');

function enguillem_v2_novedades_cb($request) {
    $cantidad = min((int) $request['cantidad'], 20);
    $query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => $cantidad,
        'post_status'    => 'publish',
    ]);
    $results = [];
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $results[] = [
                'title' => get_the_title(),
                'link'  => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: '',
            ];
        }
        wp_reset_postdata();
    }
    return rest_ensure_response($results);
}

// =========================================================
// POSTS PER PAGE (home)
// =========================================================

function enguillem_v2_posts_per_page($query) {
    if ($query->is_home() && $query->is_main_query()) {
        $query->set('posts_per_page', 8);
    }
}
add_action('pre_get_posts', 'enguillem_v2_posts_per_page');
