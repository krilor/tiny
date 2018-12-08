<?php
function tiny_theme_scripts() {
    
    // Main style
    wp_enqueue_style( 'tiny-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

    // TODO print style
    //wp_enqueue_style( 'tiny-print-style', get_template_directory_uri() . '/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'tiny_theme_scripts' );

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
        'menu-top' => esc_html__( 'Primary', 'tiny' ),
    ) );
    
    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    // WP code custom background
    add_theme_support( 'custom-background', apply_filters( 'tiny_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );
    
    // Custom logo
    add_theme_support( 'custom-logo', apply_filters( 'tiny_custom_logo_args', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
        'header-text' => array( 'header-text' ),
    ) ) );

    // Core block visual styles. Gutenberg
    add_theme_support( 'wp-block-styles' );

    // Full and wide align images.
    add_theme_support( 'align-wide' );

    // Custom color scheme.
    add_theme_support( 'editor-color-palette', apply_filters( 'tiny_editor_color_palette', array(
        array(
            'name'  => __( 'Strong Blue', 'tiny' ),
            'slug'  => 'strong-blue',
            'color' => '#0073aa',
        ),
        array(
            'name'  => __( 'Lighter Blue', 'tiny' ),
            'slug'  => 'lighter-blue',
            'color' => '#229fd8',
        ),
        array(
            'name'  => __( 'Very Light Gray', 'tiny' ),
            'slug'  => 'very-light-gray',
            'color' => '#eee',
        ),
        array(
            'name'  => __( 'Very Dark Gray', 'tiny' ),
            'slug'  => 'very-dark-gray',
            'color' => '#444',
        ),
    ) ) );
    
    // Add support for responsive embeds.
    add_theme_support( 'responsive-embeds' );
}

add_action( 'after_setup_theme', 'tiny_setup' );
?>