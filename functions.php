<?php
function tiny_theme_scripts() {
    
    // Main style
    wp_enqueue_style( 'tiny-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

    // Main js
    wp_enqueue_script( 'tiny-js', get_template_directory_uri() . '/js/tiny.js', array(), wp_get_theme()->get( 'Version' ) , true);

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'tiny_theme_scripts' );

/**
 * JavaScript detection - js class in html element
 */
function tiny_js_detector() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'tiny_js_detector', 0 );

// Theme defaults and support for various WordPress features.
function tiny_setup() {

    /* Theme textdomain/translation */
    load_theme_textdomain( 'tiny', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );
    
    // No hard-coded <title> tag in the document head, and expect WordPress to provide it for us.
    add_theme_support( 'title-tag' );
    
    // Post thumbnails
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary-menu' => esc_html__( 'Primary', 'tiny' ),
    ) );
    
    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    // WP code custom background - registered in sass as well
    add_theme_support( 'custom-background', apply_filters( 'tiny_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );
    
    // Custom logo
    add_theme_support( 'custom-logo', apply_filters( 'tiny_custom_logo_args', array(
        'height'      => 247,
        'width'       => 153,
        'flex-width'  => true,
        'flex-height' => true,
        'header-text' => array( 'site-title' ),
    ) ) );

    // Core block visual styles. Gutenberg
    add_theme_support( 'wp-block-styles' );
    
    // Styling the editor (edtor-styles.css)
    add_theme_support( 'editor-styles' );

    // Full and wide align images.
    add_theme_support( 'align-wide' );

    // Custom color scheme.
    add_theme_support( 'editor-color-palette', apply_filters( 'tiny_editor_color_palette', array(
        array(
            'name'  => __( 'Flame', 'tiny' ),
            'slug'  => 'flame',
            'color' => '#F15025',
        ),
        array(
            'name'  => __( 'Flame Light', 'tiny' ),
            'slug'  => 'flame-light',
            'color' => '#FFE6D7',
        ),
        array(
            'name'  => __( 'Easy blue', 'tiny' ),
            'slug'  => 'easy-blue',
            'color' => '#11648D',
        )
    ) ) );

    // Custom font sizes
    add_theme_support( 'editor-font-sizes', apply_filters( 'tiny_editor_font_sizes', array(
        array(
            'name' => __( 'small', 'tiny' ),
            'shortName' => __( 'S', 'tiny' ),
            'size' => 12,
            'slug' => 'small'
        ),
        array(
            'name' => __( 'regular', 'tiny' ),
            'shortName' => __( 'M', 'tiny' ),
            'size' => 16,
            'slug' => 'regular'
        ),
        array(
            'name' => __( 'large', 'tiny' ),
            'shortName' => __( 'L', 'tiny' ),
            'size' => 36,
            'slug' => 'large'
        ),
        array(
            'name' => __( 'larger', 'tiny' ),
            'shortName' => __( 'XL', 'tiny' ),
            'size' => 50,
            'slug' => 'larger'
        )
    ) ) );
    
    // Add support for responsive embeds.
    add_theme_support( 'responsive-embeds' );

    // Breadcrumbs https://kb.yoast.com/kb/add-theme-support-for-yoast-seo-breadcrumbs/
    add_theme_support( 'yoast-seo-breadcrumbs' );
}
add_action( 'after_setup_theme', 'tiny_setup' );

// Register editor styles
function tiny_add_editor_styles() {
    add_editor_style();
}
add_action( 'admin_init', 'tiny_add_editor_styles' );

// Display breadcrumbs - used in templates
function tiny_breadcrumbs() {
    if ( function_exists('yoast_breadcrumb') ) {
        ob_start();
        yoast_breadcrumb( '<p id="breadcrumbs" class="yoast-breadcrumbs inverse-link">','</p>' );
        $result = ob_get_clean();
    }
    return $result;
}

// Register sidebar
function tiny_register_sidebars() {
    
    $shared_args = array(
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    );
    
    
    // Sidebar
    register_sidebar( wp_parse_args( array(
        'name'          => __( 'Main Sidebar', 'tiny' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'tiny' ),
        ), $shared_args )
    );

    //Footer
    register_sidebars(3, wp_parse_args( array(
        'name'          => __( 'Footer Area %d', 'tiny' ),
        'id'            => 'footerarea',
        'description'   => __( 'This area is shown as no %d in the footer area.', 'tiny' ),
        ), $shared_args )
    );
}
add_action( 'widgets_init', 'tiny_register_sidebars' );

// Check if there are any pagination links in a single post
function tiny_is_paginated_post() {
	global $multipage;
	return 0 !== $multipage;
}

// Set content width for the editor
if ( ! isset( $content_width ) ) {
	$content_width = 700;
}

// Check for a specific template
function tiny_is_template( $template ){
    if ( !is_singular() ){
        return false;
    }
    return is_page_template( 'template-' . $template . '.php' );
}

// Stop empty search from displaying everything in results
function tiny_handle_empty_search( $search, $q ) {
    if( ! is_admin() && empty( $search ) && $q->is_search() && $q->is_main_query() ) {
        $search .=" AND 0=1 ";
    }
    return $search;
}
add_filter('posts_search','tiny_handle_empty_search', 10, 2);

?>