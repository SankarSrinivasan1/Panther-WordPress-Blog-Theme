<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Panther
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

$sticky = get_theme_mod('sticky_widgets', 'on');
?>

<aside id="secondary" class="widget-area" role="complementary" data-sticky="<?php echo esc_attr($sticky); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
