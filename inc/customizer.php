<?php
/**
 * Panther Theme Customizer.
 *
 * @package Panther
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function panther_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

    //Categories dropdown
    class Panther_Category_Dropdown extends WP_Customize_Control {
        private $cats = false;
        public function __construct($manager, $id, $args = array(), $options = array())
        {
            $this->cats = get_categories($options);
            parent::__construct( $manager, $id, $args );
        }
        public function render_content() {
            if(!empty($this->cats)) {
                    ?>
                        <label>
                          <span><?php echo esc_html( $this->label ); ?></span>
                          <select <?php $this->link(); ?>>
                               <?php
                                    foreach ( $this->cats as $cat )
                                    {
                                        printf('<option value="%s" %s>%s</option>', $cat->term_id, selected($this->value(), $cat->term_id, false), $cat->name);
                                    }
                               ?>
                          </select>
                        </label>
                    <?php
            }
        }
    }

    //Titles
    class Panther_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3><?php echo esc_html( $this->label ); ?></h3>
            <hr>
        <?php
        }
    }


    //Hide banner
    $wp_customize->add_setting(
        'remove_title_decs',
        array(
            'sanitize_callback' => 'panther_sanitize_checkbox',
            'default' => 0,
        )
    );
    $wp_customize->add_control(
        'remove_title_decs',
        array(
            'type' => 'checkbox',
            'label' => __('Remove site title decorations?', 'panther'),
            'section' => 'title_tagline',
            'priority' => 17,
        )
    );

    //___Featured categories___//
    $wp_customize->add_section(
        'panther_featured_cats',
        array(
            'title' => __('Featured categories', 'panther'),
            'priority' => 13,
        )
    );    
    $wp_customize->add_setting(
        'featured_cats_label',
        array(
            'sanitize_callback' => 'panther_sanitize_text',
            'default'           => __('Hot topics', 'panther')
        )
    );
    $wp_customize->add_control(
        'featured_cats_label',
        array(
            'label'         => __( 'Featured categories title', 'panther' ),
            'section'       => 'panther_featured_cats',
            'type'          => 'text',
            'priority'      => 9
        )
    );      

    for( $i= 1 ; $i <= 3 ; $i++ ) {
        $wp_customize->add_setting(
            'featured_cat_' . $i, array(
                'default' => get_option( 'default_category', '' ),
                'sanitize_callback' => 'panther_sanitize_int',
            )
        );
        $wp_customize->add_control(
            new Panther_Category_Dropdown(
                $wp_customize, 'featured_cat_' . $i, array(
                    'label' => __( 'Featured category ', 'panther' ) . $i,
                    'section' => 'panther_featured_cats',
                )
            )
        );
    }
    $wp_customize->add_setting(
          'hide_featured_cats',
          array(
            'sanitize_callback' => 'panther_sanitize_checkbox',
            'default' => 0,
          )
    );
    $wp_customize->add_control(
          'hide_featured_cats',
          array(
            'type' => 'checkbox',
            'label' => __('Hide the featured categories section?', 'panther'),
            'section' => 'panther_featured_cats',
            'priority' => 13,
          )
    );

    //___Carousel___//
    $wp_customize->add_section(
        'panther_carousel',
        array(
            'title' => __('Carousel', 'panther'),
            'priority' => 12,
        )
    );
    //Title
    $wp_customize->add_setting(
        'carousel_title',
        array(
            'sanitize_callback' => 'panther_sanitize_text',
            'default'           => __('Latest news', 'panther')
        )
    );
    $wp_customize->add_control(
        'carousel_title',
        array(
            'label'         => __( 'Carousel title', 'panther' ),
            'section'       => 'panther_carousel',
            'type'          => 'text',
            'priority'      => 10
        )
    );    
    //Post IDs
    $wp_customize->add_setting(
        'carousel_posts',
        array(
            'sanitize_callback' => 'panther_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'carousel_posts',
        array(
            'label'         => __( 'Posts IDs', 'panther' ),
            'description'   => __( 'Add a comma separated list of post IDs to display in the carousel (e.g. 344,345,932) - See how to find post IDs ', 'panther' ) . '<a href="https://github.com/SankarSrinivasan1/Panther-WordPress-Blog-Theme/" target="_blank">' . __('here', 'panther') . '</a>',
            'section'       => 'panther_carousel',
            'type'          => 'text',
            'priority'      => 11
        )
    );
    //Hide singles
    $wp_customize->add_setting(
          'hide_carousel_singles',
          array(
            'sanitize_callback' => 'panther_sanitize_checkbox',
            'default' => 1,
          )
    );
    $wp_customize->add_control(
          'hide_carousel_singles',
          array(
            'type' => 'checkbox',
            'label' => __('Hide the carousel on single posts?', 'panther'),
            'section' => 'panther_carousel',
            'priority' => 12,
          )
    );


    //___Blog___//
    $wp_customize->add_section(
        'panther_blog',
        array(
            'title' => __('Blog', 'panther'),
            'priority' => 15,
        )
    );

    $wp_customize->add_setting(
        'sticky_widgets',
        array(
            'default'           => 'on',
            'sanitize_callback' => 'panther_sanitize_sticky_widgets',
        )
    );
    $wp_customize->add_control(
        'sticky_widgets',
        array(
            'type'          => 'radio',
            'label'         => __('Sticky widgets', 'panther'),
            'section'       => 'panther_blog',
            'priority'      => 8,
            'choices'       => array(
                'on'    => __( 'On', 'panther' ),
                'off'   => __( 'Off', 'panther' ),
            ),
        )
    );

    $wp_customize->add_setting('panther_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Panther_Info( $wp_customize, 'single_posts', array(
        'label' => __('Single posts', 'panther'),
        'section' => 'panther_blog',
        'settings' => 'panther_options[info]',
        'priority' => 10
        ) )
    );   

    //Featured images
    $wp_customize->add_setting(
        'single_featured_image',
        array(
            'default'           => 'in-post',
            'sanitize_callback' => 'panther_sanitize_single_images',
        )
    );
    $wp_customize->add_control(
        'single_featured_image',
        array(
            'type'        => 'radio',
            'label'       => __('Featured images', 'panther'),
            'section'     => 'panther_blog',
            'description' => __('Featured image display for single posts', 'panther'),
            'choices' => array(
                'in-post'     => __('In post', 'panther'),
                'above-post'  => __('Above post (recommended only if you have large featured images)', 'panther'),
                'none'     	  => __('None', 'panther'),
            ),
            'priority' => 11
        )
    );

    $wp_customize->add_setting('panther_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Panther_Info( $wp_customize, 'archive_posts', array(
        'label' => __('Index and archives posts', 'panther'),
        'section' => 'panther_blog',
        'settings' => 'panther_options[info]',
        'priority' => 12
        ) )
    );

    //Ribbon
    $wp_customize->add_setting(
        'loop_text',
        array(
            'sanitize_callback' => 'panther_sanitize_text',
            'default'           => __( '<p>THIS IS AN EXAMPLE</p><a class="button" target="_blank" href="http://example.org">LEARN MORE</a>', 'panther' )
        )
    );
    $wp_customize->add_control(
        'loop_text',
        array(
            'label'         => __( 'Call to action area', 'panther' ),
            'description'   => __('This is the ribbon that displays on your homepage after the first two posts. HTML is supported. Leave empty to disable.', 'panther'),
            'section'       => 'panther_blog',
            'type'          => 'textarea',
            'priority'      => 13
        )
    );        
    $wp_customize->add_setting(
        'exc_length',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '20'
        )
    );
    $wp_customize->add_control(
        'exc_length',
        array(
            'label'         => __( 'Excerpt length', 'panther' ),
            'section'       => 'panther_blog',
            'type'          => 'text',
            'priority'      => 14
        )
    ); 
    //___Colors___//
    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => '#dd3333',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'         => __('Primary color', 'panther'),
                'section'       => 'colors',
                'priority'      => 12
            )
        )
    );
    $wp_customize->add_setting(
        'menu_bg',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_bg',
            array(
                'label'         => __('Menu background', 'panther'),
                'section'       => 'colors',
                'priority'      => 13
            )
        )
    );
    $wp_customize->add_setting(
        'menu_items',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_items',
            array(
                'label'         => __('Menu items', 'panther'),
                'section'       => 'colors',
                'priority'      => 14
            )
        )
    );
    $wp_customize->add_setting(
        'header_bg',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_bg',
            array(
                'label'         => __('Header background', 'panther'),
                'section'       => 'colors',
                'priority'      => 14
            )
        )
    );    
    $wp_customize->add_setting(
        'site_title',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_title',
            array(
                'label'         => __('Site title', 'panther'),
                'section'       => 'colors',
                'priority'      => 15
            )
        )
    );
    $wp_customize->add_setting(
        'site_description',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_description',
            array(
                'label'         => __('Site description', 'panther'),
                'section'       => 'colors',
                'priority'      => 16
            )
        )
    );   
    $wp_customize->add_setting(
        'title_panels',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'title_panels',
            array(
                'label' => __('Title panels', 'panther'),
                'section' => 'colors',
                'priority' => 17
            )
        )
    );
    $wp_customize->add_setting(
        'body_text_color',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'body_text_color',
            array(
                'label' => __('Body text', 'panther'),
                'section' => 'colors',
                'priority' => 18
            )
        )
    );
    $wp_customize->add_setting(
        'footer_bg',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_bg',
            array(
                'label' => __('Footer background', 'panther'),
                'section' => 'colors',
                'priority' => 19
            )
        )
    );

    //___Fonts___//
    $wp_customize->add_section(
        'panther_fonts',
        array(
            'title' => __('Fonts', 'panther'),
            'priority' => 15,
            'description'  => __('For help selecting fonts see the <a href="https://github.com/SankarSrinivasan1/Panther-WordPress-Blog-Theme/" target="_blank">documentation</a>. The font list is here: google.com/fonts', 'panther'),
        )
    );

    //Body fonts
    $wp_customize->add_setting(
        'body_fonts',
        array(
            'default'       => '//fonts.googleapis.com/css?family=Merriweather:300,300italic,700,700italic',            
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        'body_fonts',
        array(
            'label' => __( 'Body font', 'panther' ),
            'section' => 'panther_fonts',
            'type' => 'text',
            'priority' => 11
        )
    );

    //Body fonts family
    $wp_customize->add_setting(
        'body_font_family',
        array(
            'sanitize_callback' => 'panther_sanitize_text',
            'default' => 'font-family: \'Merriweather\', serif;',
        )
    );
    $wp_customize->add_control(
        'body_font_family',
        array(
            'label' => __( 'Body font family', 'panther' ),
            'section' => 'panther_fonts',
            'type' => 'text',
            'priority' => 12
        )
    );   
    //Headings fonts
    $wp_customize->add_setting(
        'headings_fonts',
        array(
            'default'       => '//fonts.googleapis.com/css?family=Playfair+Display:400,400italic,700,700italic',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        'headings_fonts',
        array(
            'label' => __( 'Headings font', 'panther' ),
            'section' => 'panther_fonts',
            'type' => 'text',
            'priority' => 14
        )
    );
    //Headings fonts family
    $wp_customize->add_setting(
        'headings_font_family',
        array(
            'sanitize_callback' => 'panther_sanitize_text',            
            'default' => 'font-family: \'Playfair Display\', serif;',
        )
    );
    $wp_customize->add_control(
        'headings_font_family',
        array(
            'label' => __( 'Headings font family', 'panther' ),
            'section' => 'panther_fonts',
            'type' => 'text',
            'priority' => 15
        )
    );

    // Site title
    $wp_customize->add_setting(
        'site_title_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '78',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'site_title_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'panther_fonts',
        'label'       => __('Site title', 'panther'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 80,
            'step'  => 1,
        ),
    ) ); 
    // Site description
    $wp_customize->add_setting(
        'site_desc_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '16',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'site_desc_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'panther_fonts',
        'label'       => __('Site description', 'panther'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 50,
            'step'  => 1,
        ),
    ) );         
    //H1 size
    $wp_customize->add_setting(
        'h1_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '36',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'h1_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'panther_fonts',
        'label'       => __('H1 font size', 'panther'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H2 size
    $wp_customize->add_setting(
        'h2_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '30',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'h2_size', array(
        'type'        => 'number',
        'priority'    => 18,
        'section'     => 'panther_fonts',
        'label'       => __('H2 font size', 'panther'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );

    //H3 size
    $wp_customize->add_setting(
        'h3_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '24',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'h3_size', array(
        'type'        => 'number',
        'priority'    => 19,
        'section'     => 'panther_fonts',
        'label'       => __('H3 font size', 'panther'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H4 size
    $wp_customize->add_setting(
        'h4_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '18',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'h4_size', array(
        'type'        => 'number',
        'priority'    => 20,
        'section'     => 'panther_fonts',
        'label'       => __('H4 font size', 'panther'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H5 size
    $wp_customize->add_setting(
        'h5_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '14',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'h5_size', array(
        'type'        => 'number',
        'priority'    => 21,
        'section'     => 'panther_fonts',
        'label'       => __('H5 font size', 'panther'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H6 size
    $wp_customize->add_setting(
        'h6_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '12',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'h6_size', array(
        'type'        => 'number',
        'priority'    => 22,
        'section'     => 'panther_fonts',
        'label'       => __('H6 font size', 'panther'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //Body
    $wp_customize->add_setting(
        'body_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '16',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'body_size', array(
        'type'        => 'number',
        'priority'    => 23,
        'section'     => 'panther_fonts',
        'label'       => __('Body font size', 'panther'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 24,
            'step'  => 1,
        ),
    ) );

}
add_action( 'customize_register', 'panther_customize_register' );


/**
* Sanitize
*/
//Featured images
function panther_sanitize_single_images( $input ) {
    if ( in_array( $input, array( 'in-post', 'above-post', 'none' ), true ) ) {
        return $input;
    }
}


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function panther_customize_preview_js() {
	wp_enqueue_script( 'panther_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20160509', true );
}
add_action( 'customize_preview_init', 'panther_customize_preview_js' );



//Checkboxes
function panther_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

//Integers
function panther_sanitize_int( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}

//Text
function panther_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

//Sticky widgets
function panther_sanitize_sticky_widgets( $input ) {
    if ( in_array( $input, array( 'on', 'off' ), true ) ) {
        return $input;
    }
}


function create_copyright() {
$all_posts = get_posts( 'post_status=publish&order=ASC' );
$first_post = $all_posts[0];
$first_date = $first_post->post_date_gmt;
_e( 'Copyright &copy; ' );
if ( substr( $first_date, 0, 4 ) == date( 'Y' ) ) {
echo date( 'Y' );
} else {
echo substr( $first_date, 0, 4 ) . "-" . date( 'Y' );
}
echo ' <strong>' . get_bloginfo( 'name' ) . '</strong> ';
_e( 'All rights reserved.' );
}






