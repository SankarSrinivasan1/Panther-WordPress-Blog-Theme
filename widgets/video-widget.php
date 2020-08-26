<?php

class Panther_Video extends WP_Widget {
	
	function __construct() {
		$widget_ops = array('classname' => 'panther_video_widget', 'description' => __( 'Display an oEmbed video.', 'panther') );
		parent::__construct('panther_video', __('Panther: Video', 'panther'), $widget_ops);
		$this->alt_option_name = 'panther_video';

	}

	// widget form creation
	function form($instance) {

	// Check values
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$url    = isset( $instance['url'] ) ? esc_url( $instance['url'] ) : '';
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'panther'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Add the URL of the video (from Youtube or Vimeo):', 'panther' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo $url; ?>" size="3" /></p>
	
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['url'] = esc_url_raw($new_instance['url']);

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['panther_video']) )
			delete_option('panther_video');		  
		  
		return $instance;
	}
	
	// display widget
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'panther_video', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$url   = isset( $instance['url'] ) ? esc_url( $instance['url'] ) : '';

		echo $before_widget;
		
		if ( $title ) echo $before_title . $title . $after_title;
		
		if( ($url) ) {
			echo wp_oembed_get($url);
		}
		echo $after_widget;


		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'panther_video', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}	