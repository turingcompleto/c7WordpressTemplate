<?php
/**
 * Asmobius Architecture Theme Functions
 */

// Theme Setup
function asmobius_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    // Soporte para logo personalizado con tamaño definido
add_theme_support('custom-logo', array(
    'height'      => 100,
    'width'       => 200,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array('site-title', 'site-description'),
));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'asmobius'),
        'footer' => __('Footer Menu', 'asmobius'),
    ));

    // Set image sizes
    add_image_size('project-thumb', 800, 600, true);
    add_image_size('hero-slide', 1920, 1080, true);
}
add_action('after_setup_theme', 'asmobius_setup');

// Enqueue Styles and Scripts
function asmobius_scripts() {
    // Google Fonts - Nunito Sans
    wp_enqueue_style('asmobius-fonts', 'https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap', array(), null);
    
    // Styles
    wp_enqueue_style('asmobius-style', get_stylesheet_uri(), array('asmobius-fonts'), '1.0.0');
    
    // GSAP para animaciones avanzadas
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), '3.12.2', true);
    
    // Scripts
    wp_enqueue_script('asmobius-main', get_template_directory_uri() . '/js/main.js', array('jquery', 'gsap'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('asmobius-main', 'asmobius_ajax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('asmobius_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'asmobius_scripts');

// Register Widget Areas
function asmobius_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Widget Area 1', 'asmobius'),
        'id'            => 'footer-1',
        'description'   => __('Appears in the footer section', 'asmobius'),
        'before_widget' => '<div class="footer-section">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget Area 2', 'asmobius'),
        'id'            => 'footer-2',
        'description'   => __('Appears in the footer section', 'asmobius'),
        'before_widget' => '<div class="footer-section">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget Area 3', 'asmobius'),
        'id'            => 'footer-3',
        'description'   => __('Appears in the footer section', 'asmobius'),
        'before_widget' => '<div class="footer-section">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'asmobius_widgets_init');

// Register Custom Post Type: Projects
function asmobius_register_projects() {
    $labels = array(
        'name'               => __('Projects', 'asmobius'),
        'singular_name'      => __('Project', 'asmobius'),
        'add_new'            => __('Add New', 'asmobius'),
        'add_new_item'       => __('Add New Project', 'asmobius'),
        'edit_item'          => __('Edit Project', 'asmobius'),
        'new_item'           => __('New Project', 'asmobius'),
        'view_item'          => __('View Project', 'asmobius'),
        'search_items'       => __('Search Projects', 'asmobius'),
        'not_found'          => __('No projects found', 'asmobius'),
        'not_found_in_trash' => __('No projects found in Trash', 'asmobius'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'publicly_queryable' => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'projects'),
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'       => true,
    );

    register_post_type('project', $args);
}
add_action('init', 'asmobius_register_projects');

// Register Custom Taxonomy: Project Categories
function asmobius_register_project_taxonomy() {
    $labels = array(
        'name'              => __('Project Categories', 'asmobius'),
        'singular_name'     => __('Project Category', 'asmobius'),
        'search_items'      => __('Search Project Categories', 'asmobius'),
        'all_items'         => __('All Project Categories', 'asmobius'),
        'edit_item'         => __('Edit Project Category', 'asmobius'),
        'update_item'       => __('Update Project Category', 'asmobius'),
        'add_new_item'      => __('Add New Project Category', 'asmobius'),
        'new_item_name'     => __('New Project Category Name', 'asmobius'),
        'menu_name'         => __('Project Categories', 'asmobius'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'project-category'),
        'show_in_rest'      => true,
    );

    register_taxonomy('project_category', array('project'), $args);
}
add_action('init', 'asmobius_register_project_taxonomy');

// Add Custom Meta Boxes
function asmobius_add_project_meta_boxes() {
    add_meta_box(
        'project_details',
        __('Project Details', 'asmobius'),
        'asmobius_project_details_callback',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'asmobius_add_project_meta_boxes');

function asmobius_project_details_callback($post) {
    wp_nonce_field('asmobius_save_project_details', 'asmobius_project_details_nonce');
    
    $location = get_post_meta($post->ID, '_project_location', true);
    $year = get_post_meta($post->ID, '_project_year', true);
    $area = get_post_meta($post->ID, '_project_area', true);
    ?>
    <p>
        <label for="project_location"><strong><?php _e('Location:', 'asmobius'); ?></strong></label><br>
        <input type="text" id="project_location" name="project_location" value="<?php echo esc_attr($location); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="project_year"><strong><?php _e('Year:', 'asmobius'); ?></strong></label><br>
        <input type="text" id="project_year" name="project_year" value="<?php echo esc_attr($year); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="project_area"><strong><?php _e('Area (sqm):', 'asmobius'); ?></strong></label><br>
        <input type="text" id="project_area" name="project_area" value="<?php echo esc_attr($area); ?>" style="width: 100%;">
    </p>
    <?php
}

function asmobius_save_project_details($post_id) {
    if (!isset($_POST['asmobius_project_details_nonce']) || 
        !wp_verify_nonce($_POST['asmobius_project_details_nonce'], 'asmobius_save_project_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['project_location'])) {
        update_post_meta($post_id, '_project_location', sanitize_text_field($_POST['project_location']));
    }

    if (isset($_POST['project_year'])) {
        update_post_meta($post_id, '_project_year', sanitize_text_field($_POST['project_year']));
    }

    if (isset($_POST['project_area'])) {
        update_post_meta($post_id, '_project_area', sanitize_text_field($_POST['project_area']));
    }
}
add_action('save_post', 'asmobius_save_project_details');

// Customizer Settings
function asmobius_customize_register($wp_customize) {
    // Logo Section
    $wp_customize->add_section('asmobius_logos', array(
        'title'    => __('Logos (Dark & Light)', 'asmobius'),
        'priority' => 25,
    ));

    // Dark Logo (para fondos claros)
    $wp_customize->add_setting('dark_logo', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'dark_logo', array(
        'label'       => __('Dark Logo', 'asmobius'),
        'description' => __('Logo oscuro para usar en fondos claros (con textura)', 'asmobius'),
        'section'     => 'asmobius_logos',
        'mime_type'   => 'image',
    )));

    // Light Logo (para fondos oscuros)
    $wp_customize->add_setting('light_logo', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'light_logo', array(
        'label'       => __('Light Logo', 'asmobius'),
        'description' => __('Logo claro/blanco para usar en fondos oscuros (hero, header scrolled)', 'asmobius'),
        'section'     => 'asmobius_logos',
        'mime_type'   => 'image',
    )));

    // Hero Section
    $wp_customize->add_section('asmobius_hero', array(
        'title'    => __('Hero Section', 'asmobius'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('hero_title', array(
        'default'           => 'Architecture & Design',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'    => __('Hero Title', 'asmobius'),
        'section'  => 'asmobius_hero',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('hero_description', array(
        'default'           => 'Creating timeless spaces',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('hero_description', array(
        'label'    => __('Hero Description', 'asmobius'),
        'section'  => 'asmobius_hero',
        'type'     => 'textarea',
    ));

    // About Section
    $wp_customize->add_section('asmobius_about', array(
        'title'    => __('About Us Section (Homepage)', 'asmobius'),
        'priority' => 40,
    ));

    // About - Mostrar/Ocultar sección
    $wp_customize->add_setting('about_show_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('about_show_section', array(
        'label'    => __('Show About Section on Homepage', 'asmobius'),
        'section'  => 'asmobius_about',
        'type'     => 'checkbox',
    ));

    // About - Título
    $wp_customize->add_setting('about_title', array(
        'default'           => 'About Us',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('about_title', array(
        'label'    => __('Section Title', 'asmobius'),
        'section'  => 'asmobius_about',
        'type'     => 'text',
    ));

    // About - Contenido
    $wp_customize->add_setting('about_content', array(
        'default'           => 'We are a creative architecture studio dedicated to designing innovative and sustainable spaces that enhance the human experience.',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('about_content', array(
        'label'       => __('About Text', 'asmobius'),
        'description' => __('Enter the text content for the about section', 'asmobius'),
        'section'     => 'asmobius_about',
        'type'        => 'textarea',
    ));

    // About - Imagen de fondo
    $wp_customize->add_setting('about_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'about_image', array(
        'label'       => __('Background Image', 'asmobius'),
        'description' => __('Upload an image for the about section background', 'asmobius'),
        'section'     => 'asmobius_about',
        'mime_type'   => 'image',
    )));

    // About - Texto del botón
    $wp_customize->add_setting('about_button_text', array(
        'default'           => 'Learn More',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('about_button_text', array(
        'label'    => __('Button Text', 'asmobius'),
        'section'  => 'asmobius_about',
        'type'     => 'text',
    ));

    // About - URL del botón
    $wp_customize->add_setting('about_button_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('about_button_url', array(
        'label'       => __('Button URL', 'asmobius'),
        'description' => __('Enter the full URL (e.g., https://example.com/about) or leave empty to hide button', 'asmobius'),
        'section'     => 'asmobius_about',
        'type'        => 'url',
    ));
}
add_action('customize_register', 'asmobius_customize_register');

// Excerpt Length
function asmobius_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'asmobius_excerpt_length');

// Excerpt More
function asmobius_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'asmobius_excerpt_more');

// Agregar Meta Box para Hero Slider
function asmobius_hero_slider_meta_box() {
    add_meta_box(
        'hero_slider_box',
        __('Hero Slider', 'asmobius'),
        'asmobius_hero_slider_callback',
        'project',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'asmobius_hero_slider_meta_box');

// Contenido del Meta Box
function asmobius_hero_slider_callback($post) {
    wp_nonce_field('asmobius_hero_slider_nonce', 'hero_slider_nonce');
    $value = get_post_meta($post->ID, '_hero_slide', true);
    ?>
    <label style="display: block; margin: 10px 0;">
        <input type="checkbox" name="hero_slide" value="1" <?php checked($value, '1'); ?> />
        <?php _e('Show in Hero Slider', 'asmobius'); ?>
    </label>
    <p style="font-size: 12px; color: #666; margin: 10px 0 0 0;">
        <?php _e('Check this box to display this project in the homepage hero slider.', 'asmobius'); ?>
    </p>
    <?php
}

// Guardar el Meta Box
function asmobius_save_hero_slider($post_id) {
    if (!isset($_POST['hero_slider_nonce']) || 
        !wp_verify_nonce($_POST['hero_slider_nonce'], 'asmobius_hero_slider_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['hero_slide'])) {
        update_post_meta($post_id, '_hero_slide', '1');
    } else {
        delete_post_meta($post_id, '_hero_slide');
    }
}
add_action('save_post_project', 'asmobius_save_hero_slider');
?>