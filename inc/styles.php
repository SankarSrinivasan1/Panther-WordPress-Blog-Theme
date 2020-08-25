<?php
/**
 * @package Panther
 */


//Dynamic styles
function panther_custom_styles($custom) {

	$custom = '';

	$title_decs = get_theme_mod('remove_title_decs', 0);
	if ( $title_decs == 1 ) {
		$custom .= ".site-title:first-letter { color: initial; border: 0; }"."\n";
	}

	//Colors
	$primary_color = get_theme_mod( 'primary_color', '#dd3333' );
	if ( $primary_color != '#d2ae90' ) {
		$custom .= ".social-navigation li a,.site-title:first-letter,.featured-cats-title,.panther_recent_posts_widget h4 a:hover,a,.main-navigation a:hover { color:" . esc_attr($primary_color) . "}"."\n";
		$custom .= "a.read-more,.social-navigation li a:hover,.featured-cats .container,.carousel-inner .entry-thumb::after,.carousel-title,.carousel-cat,.owl-theme .owl-controls .owl-page.active span,.posts-wrapper .entry-title a::after,.top-button span,.tagcloud a,.widget-title::before,.posts-navigation div div a:hover,.post-navigation div div a:hover,.main-navigation li a::after,button,.button,input[type=\"button\"],input[type=\"reset\"],input[type=\"submit\"],button:hover,.button:hover,input[type=\"button\"]:hover,input[type=\"reset\"]:hover,input[type=\"submit\"]:hover { background-color:" . esc_attr($primary_color) . "}"."\n";
		$custom .= ".owl-theme .owl-controls .owl-page span, .social-navigation li a { border-color:" . esc_attr($primary_color) . "}"."\n";
	}

	$site_title = get_theme_mod( 'site_title', '#000000' );
	$custom 	.= ".site-title a,.site-title a:hover { color:" . esc_attr($site_title) . "}"."\n";
	$site_desc 	= get_theme_mod( 'site_description', '#000000' );
	$custom 	.= ".site-description { color:" . esc_attr($site_desc) . "}"."\n";
	$menu_bg    = get_theme_mod( 'menu_bg', '#000000' );
	$custom 	.= ".main-navigation, .main-navigation ul ul { background-color:" . esc_attr($menu_bg) . "}"."\n";
	$body_text 	= get_theme_mod( 'body_text_color', '#000000' );
	$custom 	.= "body, .widget, .widget a, .widget select { color:" . esc_attr($body_text) . "}"."\n";
	$footer_bg 	= get_theme_mod( 'footer_bg', '#000000' );
	$custom 	.= ".site-footer, .site-footer .container { background-color:" . esc_attr($footer_bg) . "}"."\n";
	$title_panels 	= get_theme_mod( 'title_panels', '#000000' );
	$custom 	.= ".posts-wrapper .entry-header, .loop-ribbon { background-color:" . esc_attr($title_panels) . "}"."\n";
	$header_bg 	= get_theme_mod( 'header_bg', '#ffffff' );
	$custom 	.= ".site-header { background-color:" . esc_attr($header_bg) . "}"."\n";
	$menu_items	= get_theme_mod( 'menu_items', '#ffffff' );
	$custom 	.= ".main-navigation a { color:" . esc_attr($menu_items) . "}"."\n";



	//Fonts
	$body_fonts 	= get_theme_mod('body_font_family', 'font-family: \'Merriweather\', sans-serif;');
	$headings_fonts = get_theme_mod('headings_font_family', 'font-family: \'Playfair Display\', serif;');
	$custom 		.= "body {" . wp_kses_post($body_fonts) . "}"."\n";
	$custom 		.= "h1, h2, h3, h4, h5, h6, .site-title {" . wp_kses_post($headings_fonts) . "}"."\n";
    
    $site_title_size = get_theme_mod( 'site_title_size', '78' );
    $custom .= ".site-title { font-size:" . intval($site_title_size) . "px; }"."\n";
    $site_desc_size = get_theme_mod( 'site_desc_size', '16' );
    $custom .= ".site-description { font-size:" . intval($site_desc_size) . "px; }"."\n";
	$h1_size = get_theme_mod( 'h1_size', '36' );
	$custom .= "h1 { font-size:" . intval($h1_size) . "px; }"."\n";
    $h2_size = get_theme_mod( 'h2_size', '30' );
    $custom .= "h2 { font-size:" . intval($h2_size) . "px; }"."\n";
    $h3_size = get_theme_mod( 'h3_size', '24' );
    $custom .= "h3 { font-size:" . intval($h3_size) . "px; }"."\n";
    $h4_size = get_theme_mod( 'h4_size', '16' );
    $custom .= "h4 { font-size:" . intval($h4_size) . "px; }"."\n";
    $h5_size = get_theme_mod( 'h5_size', '14' );
    $custom .= "h5 { font-size:" . intval($h5_size) . "px; }"."\n";
    $h6_size = get_theme_mod( 'h6_size', '12' );
    $custom .= "h6 { font-size:" . intval($h6_size) . "px; }"."\n";
    $body_size = get_theme_mod( 'body_size', '16' );
    $custom .= "body { font-size:" . intval($body_size) . "px; }"."\n";
    
	//Output all the styles
	wp_add_inline_style( 'panther-style', $custom );	
}
add_action( 'wp_enqueue_scripts', 'panther_custom_styles' );