<?php


/* ---------------------------------------------------------------------------------------------
   THEME SETUP
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_setup' ) ) {

	function purpleWP_setup() {

		// Automatic feed
		add_theme_support( 'automatic-feed-links' );

		// Set content-width
		global $content_width;
		if ( ! isset( $content_width ) ) $content_width = 620;

		// Post thumbnails
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size ( 150, 150, true );
		add_image_size('category-thumb',300,9999);

		add_image_size( 'post-image', 973, 9999 );
		add_image_size( 'post-thumb', 508, 9999 );

		// Post formats
		add_theme_support( 'post-formats', array( 'gallery', 'image', 'video' ) );

		// Jetpack infinite scroll
		add_theme_support( 'infinite-scroll', array(
			'type' 		=> 'click',
			'container'	=> 'posts',
			'footer' 	=> false,
		) );

		// Title tag
		add_theme_support('title-tag');

		// Add nav menu
		register_nav_menu( 'primary', __( 'Primary Menu', 'purpleWP' ) );

		// Make the theme translation ready
		load_theme_textdomain( 'purpleWP', get_template_directory() . '/languages' );

		$locale = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";

		if ( is_readable( $locale_file ) ) {
			require_once( $locale_file );
		}

	}
	add_action( 'after_setup_theme', 'purpleWP_setup' );

}


/* ---------------------------------------------------------------------------------------------
   ENQUEUE SCRIPTS
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_load_javascript_files' ) ) {

	function purpleWP_load_javascript_files() {

		if ( ! is_admin() ) {
			wp_register_script( 'purpleWP_flexslider', get_template_directory_uri() . '/js/flexslider.js', '', true );

			wp_enqueue_script( 'purpleWP_global', get_template_directory_uri() . '/js/global.js', array( 'jquery', 'masonry', 'imagesloaded', 'purpleWP_flexslider' ), '', true );

			if ( is_singular() ) wp_enqueue_script( "comment-reply" );
		}
	}

	add_action( 'wp_enqueue_scripts', 'purpleWP_load_javascript_files' );

}


/* ---------------------------------------------------------------------------------------------
   ENQUEUE STYLES
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_load_style' ) ) {

	function purpleWP_load_style() {

		if ( ! is_admin() ) {

			$dependencies = array();

			/**
			 * Translators: If there are characters in your language that are not
			 * supported by the theme fonts, translate this to 'off'. Do not translate
			 * into your own language.
			 */
			$google_fonts = _x( 'on', 'Google Fonts: on or off', 'purpleWP' );

			if ( 'off' !== $google_fonts ) {

				wp_register_style( 'purpleWP_googleFonts', '//fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic' );

				$dependencies[] = 'purpleWP_googleFonts';

			}

			wp_register_style( 'purpleWP_genericons', get_stylesheet_directory_uri() . '/genericons/genericons.css' );

			$dependencies[] = 'purpleWP_genericons';

			wp_enqueue_style( 'purpleWP_style', get_stylesheet_uri(), $dependencies );
		}

	}
	add_action( 'wp_print_styles', 'purpleWP_load_style' );

}


/* ---------------------------------------------------------------------------------------------
   ADD EDITOR STYLES
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_add_editor_styles' ) ) {

	function purpleWP_add_editor_styles() {

		add_editor_style( 'purpleWP-editor-styles.css' );

		/**
		 * Translators: If there are characters in your language that are not
		 * supported by the theme fonts, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$google_fonts = _x( 'on', 'Google Fonts: on or off', 'purpleWP' );

		if ( 'off' !== $google_fonts ) {
			$font_url = '//fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic';
			add_editor_style( str_replace( ',', '%2C', $font_url ) );
		}

	}
	add_action( 'init', 'purpleWP_add_editor_styles' );

}


/* ---------------------------------------------------------------------------------------------
   REGISTER WIDGET AREAS
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_sidebar_registration' ) ) {

	function purpleWP_sidebar_registration() {

		register_sidebar( array(
			'name' 			=> __( 'Sidebar', 'purpleWP' ),
			'id' 			=> 'sidebar',
			'description' 	=> __( 'Widgets in this area will be shown in the sidebar.', 'purpleWP' ),
			'before_title' 	=> '<h3 class="widget-title">',
			'after_title' 	=> '</h3>',
			'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
			'after_widget' 	=> '</div><div class="clear"></div></div>'
		) );
		
		


	}
	add_action( 'wpb_widgets_init', 'purpleWP_sidebar_registration' );

}

function my_custom_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Custom', 'your-theme-domain' ),
            'id' => 'custom-side-bar',
            'description' => __( 'Custom Sidebar', 'your-theme-domain' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'my_custom_sidebar' );


function wpb_widgets_init(){
	register_sidebar(array(
		'name'   =>  'Custom Header Widget Area',
		'id'     =>  'custom-header-widget',
		'before_widget'  => '<div class= "chw-title">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="chw-title">',
		'after_title'   => '</h2>',
	));
	
// 	register_sidebar(array(
// 		'name'   =>  'Custom Widget Area',
// 		'id'     =>  'sidebar-2',
// 		'before_widget'  => '<div class= "side-title">',
// 		'after_widget'  => '</div>',
// 		'before_title'  => '<h2 class="side-title">',
// 		'after_title'   => '</h2>',
// 	));
	
	
}
add_action('widgets_init','wpb_widgets_init');




/* ---------------------------------------------------------------------------------------------
   ADD THEME WIDGETS
   --------------------------------------------------------------------------------------------- */


require_once( get_template_directory() . '/widgets/dribbble-widget.php' );
require_once( get_template_directory() . '/widgets/flickr-widget.php' );
require_once( get_template_directory() . '/widgets/recent-comments.php' );
require_once( get_template_directory() . '/widgets/recent-posts.php' );


/* ---------------------------------------------------------------------------------------------
   DELIST WIDGETS REPLACED BY THEME ONES
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_unregister_default_widgets' ) ) {

	function purpleWP_unregister_default_widgets() {
		unregister_widget( 'WP_Widget_Recent_Comments' );
		unregister_widget( 'WP_Widget_Recent_Posts' );
	}
	add_action( 'widgets_init', 'purpleWP_unregister_default_widgets', 11 );

}


/* ---------------------------------------------------------------------------------------------
   CHECK FOR JAVASCRIPT SUPPORT
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_html_js_class' ) ) {

	function purpleWP_html_js_class () {
		echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>'. "\n";
	}
	add_action( 'wp_head', 'purpleWP_html_js_class', 1 );

}


/* ---------------------------------------------------------------------------------------------
   ADD CLASSES TO PAGINATION
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_posts_link_attributes_1' ) ) {

	function purpleWP_posts_link_attributes_1() {
		return 'class="archive-nav-older fleft"';
	}
	add_filter( 'next_posts_link_attributes', 'purpleWP_posts_link_attributes_1' );

}


if ( ! function_exists( 'purpleWP_posts_link_attributes_2' ) ) {

	function purpleWP_posts_link_attributes_2() {
		return 'class="archive-nav-newer fright"';
	}
	add_filter( 'previous_posts_link_attributes', 'purpleWP_posts_link_attributes_2' );

}


/* ---------------------------------------------------------------------------------------------
   CHANGE LENGTH OF EXCERPTS
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_custom_excerpt_length' ) ) {

	function purpleWP_custom_excerpt_length( $length ) {
		return 28;
	}
	add_filter( 'excerpt_length', 'purpleWP_custom_excerpt_length', 999 );

}


/* ---------------------------------------------------------------------------------------------
   CHANGE EXCERPT SUFFIX
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_new_excerpt_more' ) ) {

	function purpleWP_new_excerpt_more( $more ) {
		return '...';
	}
	add_filter( 'excerpt_more', 'purpleWP_new_excerpt_more' );

}

/********************************
 * except
 * ******/
// Changing excerpt more
   function new_excerpt_more($more) {
   global $post;
   return '… <button class="read-more"> <a href="'. get_permalink($post->ID) . '">' . 'Read More &raquo;' . '</a></button>';
   }
   add_filter('excerpt_more', 'new_excerpt_more');

/* ---------------------------------------------------------------------------------------------
   BODY CLASSES
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_body_classes' ) ) {

	function purpleWP_body_classes( $classes ){

		// Check for mobile visitor
		$classes[] = wp_is_mobile() ? 'wp-is-mobile' : 'wp-is-not-mobile';

		return $classes;
	}
	add_filter( 'body_class', 'purpleWP_body_classes' );

}


/* ---------------------------------------------------------------------------------------------
   GET COMMENT EXCERPT
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_get_comment_excerpt' ) ) {

	function purpleWP_get_comment_excerpt( $comment_ID = 0, $num_words = 20 ) {
		$comment = get_comment( $comment_ID );
		$comment_text = strip_tags( $comment->comment_content );
		$blah = explode( ' ', $comment_text );
		if ( count( $blah ) > $num_words ) {
			$k = $num_words;
			$use_dotdotdot = 1;
		} else {
			$k = count( $blah );
			$use_dotdotdot = 0;
		}
		$excerpt = '';
		for ( $i = 0; $i < $k; $i++ ) {
			$excerpt .= $blah[$i] . ' ';
		}
		$excerpt .= ( $use_dotdotdot ) ? '...' : '';
		return apply_filters( 'get_comment_excerpt', $excerpt );
	}

}


/* ---------------------------------------------------------------------------------------------
   ADD ADMIN CSS
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_admin_css' ) ) {

	function purpleWP_admin_css() {
	echo '
		<style type="text/css">

			#postimagediv #set-post-thumbnail img {
				max-width: 100%;
				height: auto;
			}

		</style>';
	}
	add_action( 'admin_head', 'purpleWP_admin_css' );

}


/* ---------------------------------------------------------------------------------------------
   FLEXSLIDER FUNCTION
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_flexslider' ) ) {

	function purpleWP_flexslider( $size = 'thumbnail' ) {

		$attachment_parent = is_page() ? $post->ID : get_the_ID();

		$image_args = array(
			'numberposts'    => -1, // show all
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_parent'    => $attachment_parent,
			'post_type'      => 'attachment',
			'post_status'    => null,
			'post_mime_type' => 'image',
		);

		$images = get_posts( $image_args );

		if ( $images ) : ?>

			<div class="flexslider">

				<ul class="slides">

					<?php foreach( $images as $image ) :

						$attimg = wp_get_attachment_image( $image->ID, $size ); ?>

						<li>
							<?php echo $attimg; ?>
						</li>

					<?php endforeach; ?>

				</ul>

			</div>

			<?php

		endif;
	}

}


/* ---------------------------------------------------------------------------------------------
   COMMENT FUNCTION
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_comment' ) ) {
	function purpleWP_comment( $comment, $args, $depth ) {
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
		?>

		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

			<?php __( 'Pingback:', 'purpleWP' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'purpleWP' ), '<span class="edit-link">', '</span>' ); ?>

		</li>
		<?php
				break;
			default :
			global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

			<div id="comment-<?php comment_ID(); ?>" class="comment">

				<div class="comment-header">

					<?php echo get_avatar( $comment, 160 ); ?>

					<div class="comment-header-inner">

						<h4><?php echo get_comment_author_link(); ?></h4>

						<div class="comment-meta">
							<a class="comment-date-link" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" title="<?php printf( _x( '$s at $s', 'Variables: comment date, comment time', 'purpleWP' ), get_comment_date(), get_comment_time() ); ?>"><?php echo get_comment_date( get_option( 'date_format' ) ); ?></a>
						</div><!-- .comment-meta -->

					</div><!-- .comment-header-inner -->

				</div>

				<div class="comment-content post-content">

					<?php comment_text(); ?>

				</div><!-- .comment-content -->

				<div class="comment-actions">

					<?php if ( 0 == $comment->comment_approved ) : ?>

						<p class="comment-awaiting-moderation fright"><?php _e( 'Your comment is awaiting moderation.', 'purpleWP' ); ?></p>

					<?php endif; ?>

					<div class="fleft">

						<?php
						comment_reply_link( array(
							'reply_text' 	=> __( 'Reply', 'purpleWP' ),
							'depth'			=> $depth,
							'max_depth' 	=> $args['max_depth'],
							'before'		=> '',
							'after'			=> ''
							)
						);
						edit_comment_link( __( 'Edit', 'purpleWP' ), '<span class="sep">/</span>', '' );
						?>

					</div>

					<div class="clear"></div>

				</div><!-- .comment-actions -->

			</div><!-- .comment-## -->

		<?php
			break;
		endswitch;
	}
}


/* ---------------------------------------------------------------------------------------------
   THEME OPTIONS
   --------------------------------------------------------------------------------------------- */


class purpleWP_Customize {

   public static function purpleWP_register( $wp_customize ) {

      //1. Define a new section (if desired) to the Theme Customizer
      $wp_customize->add_section( 'purpleWP_options',
         array(
            'title' 		=> __( 'Options for purpleWP', 'purpleWP' ), //Visible title of section
            'priority' 		=> 35, //Determines what order this appears in
            'capability' 	=> 'edit_theme_options', //Capability needed to tweak
            'description' 	=> __( 'Allows you to customize theme settings for purpleWP.', 'purpleWP' ), //Descriptive tooltip
         )
      );

      $wp_customize->add_section( 'purpleWP_logo_section' , array(
		    'title'       => __( 'Logo', 'purpleWP' ),
		    'priority'    => 40,
		    'description' => __('Upload a logo to replace the default site title in the sidebar/header', 'purpleWP'),
	  ) );


      //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'accent_color', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' 			=> '#019EBD', //Default setting/value to save
            'type' 				=> 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'transport' 		=> 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'sanitize_hex_color'
         )
      );

	  $wp_customize->add_setting( 'purpleWP_logo',
      	array(
      		'sanitize_callback' => 'esc_url_raw'
      	)
      );


      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'purpleWP_accent_color', //Set a unique ID for the control
         array(
            'label' 	=> __( 'Accent Color', 'purpleWP' ), //Admin-visible name of the control
            'section' 	=> 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' 	=> 'accent_color', //Which setting to load and manipulate (serialized is okay)
            'priority' 	=> 10, //Determines the order this control appears in for the specified section
         )
      ) );

      $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'purpleWP_logo', array(
		    'label'    => __( 'Logo', 'purpleWP' ),
		    'section'  => 'purpleWP_logo_section',
		    'settings' => 'purpleWP_logo',
	  ) ) );

      //4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
      $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
      $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
   }

   public static function purpleWP_header_output() {

		echo '<!-- Customizer CSS -->';

		echo '<style type="text/css">';
			self::purpleWP_generate_css( 'body a', 'color', 'accent_color' );
			self::purpleWP_generate_css( 'body a:hover', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.main-menu .current-menu-item:before', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.main-menu .current_page_item:before', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.widget-content .textwidget a:hover', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.widget_purpleWP_recent_posts a:hover .title', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.widget_purpleWP_recent_comments a:hover .title', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.widget_archive li a:hover', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.widget_categories li a:hover', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.widget_meta li a:hover', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.widget_nav_menu li a:hover', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.widget_rss .widget-content ul a.rsswidget:hover', 'color', 'accent_color' );
			self::purpleWP_generate_css( '#wp-calendar thead', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.widget_tag_cloud a:hover', 'background', 'accent_color' );
			self::purpleWP_generate_css( '.search-button:hover .genericon', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.flex-direction-nav a:hover', 'background-color', 'accent_color' );
			self::purpleWP_generate_css( 'a.post-quote:hover', 'background', 'accent_color' );
			self::purpleWP_generate_css( '.posts .post-title a:hover', 'color', 'accent_color' );

			self::purpleWP_generate_css( '.post-content a', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.post-content a:hover', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.post-content a:hover', 'border-bottom-color', 'accent_color' );
			self::purpleWP_generate_css( '.post-content blockquote:before', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.post-content fieldset legend', 'background', 'accent_color' );
			self::purpleWP_generate_css( '.post-content input[type="submit"]:hover', 'background', 'accent_color' );
			self::purpleWP_generate_css( '.post-content input[type="button"]:hover', 'background', 'accent_color' );
			self::purpleWP_generate_css( '.post-content input[type="reset"]:hover', 'background', 'accent_color' );

			self::purpleWP_generate_css( '.post-content .has-accent-color', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.post-content .has-accent-background-color', 'background-color', 'accent_color' );

			self::purpleWP_generate_css( '.page-links a:hover', 'background', 'accent_color' );
			self::purpleWP_generate_css( '.comments .pingbacks li a:hover', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.comment-header h4 a:hover', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.bypostauthor.commet .comment-header:before', 'background', 'accent_color' );
			self::purpleWP_generate_css( '.form-submit #submit:hover', 'background-color', 'accent_color' );

			self::purpleWP_generate_css( '.nav-toggle.active', 'background-color', 'accent_color' );
			self::purpleWP_generate_css( '.mobile-menu .current-menu-item:before', 'color', 'accent_color' );
			self::purpleWP_generate_css( '.mobile-menu .current_page_item:before', 'color', 'accent_color' );

			self::purpleWP_generate_css( 'body#tinymce.wp-editor a', 'color', 'accent_color' );
			self::purpleWP_generate_css( 'body#tinymce.wp-editor a:hover', 'color', 'accent_color' );
			self::purpleWP_generate_css( 'body#tinymce.wp-editor fieldset legend', 'background', 'accent_color' );
			self::purpleWP_generate_css( 'body#tinymce.wp-editor blockquote:before', 'color', 'accent_color' );
		echo '</style>';

		echo '<!--/Customizer CSS-->';

   }

   public static function purpleWP_live_preview() {
      wp_enqueue_script(
           'purpleWP-themecustomizer', // Give the script a unique ID
           get_template_directory_uri() . '/js/theme-customizer.js', // Define the path to the JS file
           array(  'jquery', 'customize-preview' ), // Define dependencies
           '', // Define a version (optional)
           true // Specify whether to put in footer (leave this true)
      );
   }

   public static function purpleWP_generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      if ( ! empty( $mod ) ) {
         $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            echo $return;
         }
      }
      return $return;
    }
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'purpleWP_Customize' , 'purpleWP_register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'purpleWP_Customize' , 'purpleWP_header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'purpleWP_Customize' , 'purpleWP_live_preview' ) );


/* ---------------------------------------------------------------------------------------------
   SPECIFY GUTENBERG SUPPORT
------------------------------------------------------------------------------------------------ */


if ( ! function_exists( 'purpleWP_add_gutenberg_features' ) ) :

	function purpleWP_add_gutenberg_features() {

		/* Gutenberg Features --------------------------------------- */

		add_theme_support( 'align-wide' );

		/* Gutenberg Palette --------------------------------------- */

		$accent_color = get_theme_mod( 'accent_color' ) ? get_theme_mod( 'accent_color' ) : '#019EBD';

		add_theme_support( 'editor-color-palette', array(
			array(
				'name' 	=> _x( 'Accent', 'Name of the accent color in the Gutenberg palette', 'purpleWP' ),
				'slug' 	=> 'accent',
				'color' => $accent_color,
			),
			array(
				'name' 	=> _x( 'Black', 'Name of the black color in the Gutenberg palette', 'purpleWP' ),
				'slug' 	=> 'black',
				'color' => '#333',
			),
			array(
				'name' 	=> _x( 'Dark Gray', 'Name of the dark gray color in the Gutenberg palette', 'purpleWP' ),
				'slug' 	=> 'dark-gray',
				'color' => '#555',
			),
			array(
				'name' 	=> _x( 'Medium Gray', 'Name of the medium gray color in the Gutenberg palette', 'purpleWP' ),
				'slug' 	=> 'medium-gray',
				'color' => '#777',
			),
			array(
				'name' 	=> _x( 'Light Gray', 'Name of the light gray color in the Gutenberg palette', 'purpleWP' ),
				'slug' 	=> 'light-gray',
				'color' => '#999',
			),
			array(
				'name' 	=> _x( 'White', 'Name of the white color in the Gutenberg palette', 'purpleWP' ),
				'slug' 	=> 'white',
				'color' => '#fff',
			),
		) );

		/* Gutenberg Font Sizes --------------------------------------- */

		add_theme_support( 'editor-font-sizes', array(
			array(
				'name' 		=> _x( 'Small', 'Name of the small font size in Gutenberg', 'purpleWP' ),
				'shortName' => _x( 'S', 'Short name of the small font size in the Gutenberg editor.', 'purpleWP' ),
				'size' 		=> 16,
				'slug' 		=> 'small',
			),
			array(
				'name' 		=> _x( 'Regular', 'Name of the regular font size in Gutenberg', 'purpleWP' ),
				'shortName' => _x( 'M', 'Short name of the regular font size in the Gutenberg editor.', 'purpleWP' ),
				'size' 		=> 18,
				'slug' 		=> 'regular',
			),
			array(
				'name' 		=> _x( 'Large', 'Name of the large font size in Gutenberg', 'purpleWP' ),
				'shortName' => _x( 'L', 'Short name of the large font size in the Gutenberg editor.', 'purpleWP' ),
				'size' 		=> 24,
				'slug' 		=> 'large',
			),
			array(
				'name' 		=> _x( 'Larger', 'Name of the larger font size in Gutenberg', 'purpleWP' ),
				'shortName' => _x( 'XL', 'Short name of the larger font size in the Gutenberg editor.', 'purpleWP' ),
				'size' 		=> 27,
				'slug' 		=> 'larger',
			),
		) );

	}
	add_action( 'after_setup_theme', 'purpleWP_add_gutenberg_features' );

endif;


/* ---------------------------------------------------------------------------------------------
   GUTENBERG EDITOR STYLES
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'purpleWP_block_editor_styles' ) ) :

	function purpleWP_block_editor_styles() {

		$dependencies = array();

		/**
		 * Translators: If there are characters in your language that are not
		 * supported by the theme fonts, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$google_fonts = _x( 'on', 'Google Fonts: on or off', 'purpleWP' );

		if ( 'off' !== $google_fonts ) {

			// Register Google Fonts
			wp_register_style( 'purpleWP-block-editor-styles-font', '//fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic', false, 1.0, 'all' );
			$dependencies[] = 'purpleWP-block-editor-styles-font';

		}

		wp_register_style( 'purpleWP-block-editor-styles-genericons', get_stylesheet_directory_uri() . '/genericons/genericons.css' );
		$dependencies[] = 'purpleWP-block-editor-styles-genericons';

		// Enqueue the editor styles
		wp_enqueue_style( 'purpleWP-block-editor-styles', get_theme_file_uri( '/purpleWP-gutenberg-editor-style.css' ), $dependencies, '1.0', 'all' );

	}
	add_action( 'enqueue_block_editor_assets', 'purpleWP_block_editor_styles', 1 );

endif;

?>
