<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Panther
 */

?>

		</div>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="top-button">
			<span>
			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 99.999997 77.999998">
				<g transform="translate(0,-974.36223)"><path d="m 1.1618378,1051.501 16.5756452,-25.0045 32.262508,-48.66815 32.262508,48.66815 16.575643,25.0045"/></g>
			</svg>
			</span>
		</div>
		<p class="site-title footer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>	
		<div class="container info-wrapper">	
			<div class="site-info">
			    
			    
				<?php create_copyright(); ?>
				
				
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
