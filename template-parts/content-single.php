<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Panther
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php $featured_image = get_theme_mod('single_featured_image', 'in-post'); ?>

	<?php if ( ($featured_image != 'above-post') && has_post_thumbnail() ) : ?>

		<header class="entry-header">
			<?php
				if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta clearfix">
					<?php panther_posted_on(); ?>
				</div><!-- .entry-meta -->
				<?php
				endif;
			?>		
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<?php if ( ( $featured_image == 'in-post' ) ) : ?>
			<div class="single-thumb">
				<?php the_post_thumbnail('panther-large-thumb'); ?>
			</div>
		<?php endif; ?>
	<?php elseif ( !has_post_thumbnail() ) : ?>
	<header class="entry-header">
		<?php
			if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta clearfix">
				<?php panther_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php
			endif;
		?>		
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<?php endif; ?>

	<div class="post-inner">
		<div class="entry-content">
			<?php 
				the_content();
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'panther' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
		
		<footer class="entry-footer clearfix">
		<?php if ( is_single() ) : ?>
			<?php panther_entry_footer(); ?>
		<?php else : ?>
			<?php panther_entry_comments(); ?>
			<span><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo esc_html__('Read More', 'panther'); ?></a></span>
		<?php endif; ?>
		</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->
