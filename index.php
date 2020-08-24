<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Panther
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php endif; ?>

			<div class="posts-wrapper">

			<?php $i = 1; ?>
				<div class="posts-row clearfix">
				<?php
				while ( have_posts() ): the_post();

				get_template_part( 'template-parts/content', get_post_format() );

				$text = get_theme_mod('loop_text', __( '<p>LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT.</p><a class="button" target="_blank" href="http://example.org">LEARN MORE</a>', 'panther' ));
				if( ($i == 2) && ($text != '') ) : ?>
				<div class="loop-ribbon">
					<?php echo wp_kses_post($text); ?>
				</div>
				<?php endif;	

				if( $i % 2 == 0 ) { 
					echo '</div><div class="posts-row clearfix">';
				} 
				$i++;
				endwhile; ?>
				</div>
			</div>

			<?php
			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
