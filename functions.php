<?php

/**
 * Panther functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Panther
 */

if ( !function_exists( 'pan_fs' ) ) {
    // Create a helper function for easy SDK access.
    function pan_fs()
    {
        global  $pan_fs ;
        
        if ( !isset( $pan_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $pan_fs = fs_dynamic_init( array(
                'id'               => '6830',
                'slug'             => 'panther',
                'type'             => 'theme',
                'public_key'       => 'pk_a7b7eeb17d533ec23f61ae6edaf64',
                'is_premium'       => false,
                'premium_suffix'   => 'Panther Pro',
                'has_addons'       => false,
                'has_paid_plans'   => true,
                'is_org_compliant' => false,
                'trial'            => array(
                'days'               => 14,
                'is_require_payment' => false,
            ),
                'menu'             => array(
                'first-path' => 'themes.php',
                'support'    => false,
            ),
                'is_live'          => true,
            ) );
        }
        
        return $pan_fs;
    }
    
    // Init Freemius.
    pan_fs();
    // Signal that SDK was initiated.
    do_action( 'pan_fs_loaded' );
}

if ( !function_exists( 'panther_setup' ) ) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function panther_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on panther, use a find and replace
         * to change 'panther' to the name of your theme in all the template files.
         */
        load_theme_textdomain( 'panther', get_template_directory() . '/languages' );
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );
        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );
        add_image_size( 'panther-above-post-thumb', 1300 );
        add_image_size( 'panther-large-thumb', 880 );
        add_image_size( 'panther-small-thumb', 450 );
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary', 'panther' ),
            'social'  => __( 'Social', 'panther' ),
        ) );
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        ) );
        /*
         * Enable support for Post Formats.
         * See https://developer.wordpress.org/themes/functionality/post-formats/
         */
        add_theme_support( 'post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link'
        ) );
        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'panther_custom_background_args', array(
            'default-color' => '000000',
            'default-image' => '',
        ) ) );
        add_theme_support( 'custom-logo', array(
            'height'     => apply_filters( 'panther_logo_height', '150' ),
            'width'      => apply_filters( 'panther_logo_width', '300' ),
            'flex-width' => true,
        ) );
    }

}
add_action( 'after_setup_theme', 'panther_setup' );
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function panther_content_width()
{
    $GLOBALS['content_width'] = apply_filters( 'panther_content_width', 640 );
}

add_action( 'after_setup_theme', 'panther_content_width', 0 );
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function panther_widgets_init()
{
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'panther' ),
        'id'            => 'sidebar-1',
        'description'   => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
    register_widget( 'Panther_About_Me' );
    register_widget( 'Panther_Recent_Posts' );
    register_widget( 'Panther_Video' );
}

add_action( 'widgets_init', 'panther_widgets_init' );
require get_template_directory() . "/widgets/about-me.php";
require get_template_directory() . "/widgets/recent-posts.php";
require get_template_directory() . "/widgets/video-widget.php";
/**
 * Enqueue scripts and styles.
 */
function panther_scripts()
{
    wp_enqueue_style( 'panther-style', get_stylesheet_uri() );
    wp_enqueue_style(
        'panther-icons',
        get_template_directory_uri() . '/fonts/css/fontello.css',
        array(),
        true
    );
    $body_font = get_theme_mod( 'body_fonts', '//fonts.googleapis.com/css?family=Merriweather:300,300italic,700,700italic' );
    $headings_font = get_theme_mod( 'headings_fonts', '//fonts.googleapis.com/css?family=Playfair+Display:400,400italic,700,700italic' );
    wp_enqueue_style( 'panther-body-fonts', esc_url( $body_font ) );
    wp_enqueue_style( 'panther-headings-fonts', esc_url( $headings_font ) );
    wp_enqueue_script(
        'panther-skip-link-focus-fix',
        get_template_directory_uri() . '/js/skip-link-focus-fix.js',
        array(),
        '20151215',
        true
    );
    wp_enqueue_script(
        'panther-scripts',
        get_template_directory_uri() . '/js/scripts.min.js',
        array( 'jquery' ),
        '',
        true
    );
    wp_enqueue_script(
        'panther-main',
        get_template_directory_uri() . '/js/main.min.js',
        array( 'jquery' ),
        '',
        true
    );
    wp_enqueue_script(
        'html5shiv',
        get_template_directory_uri() . '/js/html5shiv.js',
        array(),
        '',
        true
    );
    wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

add_action( 'wp_enqueue_scripts', 'panther_scripts' );
/**
 * Enqueue Bootstrap
 */
function panther_enqueue_bootstrap()
{
    wp_enqueue_style(
        'panther-bootstrap',
        get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css',
        array(),
        true
    );
}

add_action( 'wp_enqueue_scripts', 'panther_enqueue_bootstrap', 9 );
/**
 * Get first post category
 */
function panther_get_first_cat()
{
    $category = get_the_category();
    if ( $category ) {
        echo  '<span class="first-cat">' . __( 'Posted in ', 'panther' ) . '<a href="' . get_category_link( $category[0]->term_id ) . '" title="' . sprintf( __( 'View all posts in %s', 'panther' ), $category[0]->name ) . '" ' . '>' . $category[0]->name . '</a></span>' ;
    }
}

/**
 * Excerpt length
 */
function panther_excerpt_length( $length )
{
    $excerpt = get_theme_mod( 'exc_length', '20' );
    return absint( $excerpt );
}

add_filter( 'excerpt_length', 'panther_excerpt_length', 999 );
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * Styles
 */
require get_template_directory() . '/inc/styles.php';
/**
 * Extra functions
 */
require get_template_directory() . '/inc/functions.php';