<?php
/**
 * OnePress functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package OnePress
 */

if ( ! function_exists( 'onepress_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function onepress_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on OnePress, use a find and replace
		 * to change 'onepress' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'onepress', get_template_directory() . '/languages' );

		/*
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Excerpt for page
		 */
		add_post_type_support( 'page', 'excerpt' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'onepress-blog-small', 300, 150, true );
		add_image_size( 'onepress-small', 480, 300, true );
		add_image_size( 'onepress-medium', 640, 400, true );

		/*
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus(
			array(
				'primary'      => esc_html__( 'Primary Menu', 'onepress' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * WooCommerce support.
		 */
		add_theme_support( 'woocommerce' );

		/**
		 * Add theme Support custom logo
		 *
		 * @since WP 4.5
		 * @sin 1.2.1
		 */

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 36,
				'width'       => 160,
				'flex-height' => true,
				'flex-width'  => true,
			// 'header-text' => array( 'site-title',  'site-description' ), //
			)
		);

		// Recommend plugins.
		add_theme_support(
			'recommend-plugins',
			array(
				'wpforms-lite' => array(
					'name' => esc_html__( 'Contact Form by WPForms', 'onepress' ),
					'active_filename' => 'wpforms-lite/wpforms.php',
				),
				'famethemes-demo-importer' => array(
					'name' => esc_html__( 'Famethemes Demo Importer', 'onepress' ),
					'active_filename' => 'famethemes-demo-importer/famethemes-demo-importer.php',
				),
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for WooCommerce.
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		/**
		 * Add support for Gutenberg.
		 *
		 * @link https://wordpress.org/gutenberg/handbook/reference/theme-support/
		 */
		add_theme_support( 'editor-styles' );
		add_theme_support( 'align-wide' );

		/*
		 * This theme styles the visual editor to resemble the theme style.
		 */
		add_editor_style( array( 'editor-style.css', onepress_fonts_url() ) );
	}
endif;
add_action( 'after_setup_theme', 'onepress_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function onepress_content_width() {
	/**
	 * Support dynamic content width
	 *
	 * @since 2.1.1
	 */
	$width = absint( get_theme_mod( 'single_layout_content_width' ) );
	if ( $width <= 0 ) {
		$width = 800;
	}
	$GLOBALS['content_width'] = apply_filters( 'onepress_content_width', $width );
}
add_action( 'after_setup_theme', 'onepress_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function onepress_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'onepress' ),
			'id'            => 'sidebar-1',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'WooCommerce Sidebar', 'onepress' ),
				'id'            => 'sidebar-shop',
				'description'   => '',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array(
				'name' => sprintf( __( 'Footer %s', 'onepress' ), $i ),
				'id' => 'footer-' . $i,
				'description' => '',
				'before_widget' => '<aside id="%1$s" class="footer-widget widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h2 class="widget-title">',
				'after_title' => '</h2>',
			)
		);
	}

}
add_action( 'widgets_init', 'onepress_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function onepress_scripts() {

	$theme = wp_get_theme( 'onepress' );
	$version = $theme->get( 'Version' );

	if ( ! get_theme_mod( 'onepress_disable_g_font' ) ) {
		wp_enqueue_style( 'onepress-fonts', onepress_fonts_url(), array(), $version );
	}

	wp_enqueue_style( 'onepress-animate', get_template_directory_uri() . '/assets/css/animate.min.css', array(), $version );
	wp_enqueue_style( 'onepress-fa', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.7.0' );
	wp_enqueue_style( 'onepress-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', false, $version );
	wp_enqueue_style( 'onepress-style', get_template_directory_uri() . '/style.css' );

	$custom_css = onepress_custom_inline_style();
	wp_add_inline_style( 'onepress-style', $custom_css );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'onepress-js-plugins', get_template_directory_uri() . '/assets/js/plugins.js', array( 'jquery' ), $version, true );
	wp_enqueue_script( 'onepress-js-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), $version, true );
	wp_enqueue_script( 'custom-jquery', get_template_directory_uri() . '/assets/js/custom.js');

	// Animation from settings.
	$onepress_js_settings = array(
		'onepress_disable_animation'     => get_theme_mod( 'onepress_animation_disable' ),
		'onepress_disable_sticky_header' => get_theme_mod( 'onepress_sticky_header_disable' ),
		'onepress_vertical_align_menu'   => get_theme_mod( 'onepress_vertical_align_menu' ),
		'hero_animation'                 => get_theme_mod( 'onepress_hero_option_animation', 'flipInX' ),
		'hero_speed'                     => intval( get_theme_mod( 'onepress_hero_option_speed', 5000 ) ),
		'hero_fade'                      => intval( get_theme_mod( 'onepress_hero_slider_fade', 750 ) ),
		'hero_duration'                  => intval( get_theme_mod( 'onepress_hero_slider_duration', 5000 ) ),
		'hero_disable_preload'           => get_theme_mod( 'onepress_hero_disable_preload', false ) ? true : false,
		'is_home'                        => '',
		'gallery_enable'                 => '',
		'is_rtl' => is_rtl(),
	);

	// Load gallery scripts.
	$galley_disable  = get_theme_mod( 'onepress_gallery_disable' ) == 1 ? true : false;
	$is_shop = false;
	if ( function_exists( 'is_woocommerce' ) ) {
		if ( is_woocommerce() ) {
			$is_shop = true;
		}
	}

	// Don't load scripts for woocommerce because it don't need.
	if ( ! $is_shop ) {
		if ( ! $galley_disable || is_customize_preview() ) {
			$onepress_js_settings['gallery_enable'] = 1;
			$display = get_theme_mod( 'onepress_gallery_display', 'grid' );
			if ( ! is_customize_preview() ) {
				switch ( $display ) {
					case 'masonry':
						wp_enqueue_script( 'onepress-gallery-masonry', get_template_directory_uri() . '/assets/js/isotope.pkgd.min.js', array(), $version, true );
						break;
					case 'justified':
						wp_enqueue_script( 'onepress-gallery-justified', get_template_directory_uri() . '/assets/js/jquery.justifiedGallery.min.js', array(), $version, true );
						break;
					case 'slider':
					case 'carousel':
						wp_enqueue_script( 'onepress-gallery-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), $version, true );
						break;
					default:
						break;
				}
			} else {
				wp_enqueue_script( 'onepress-gallery-masonry', get_template_directory_uri() . '/assets/js/isotope.pkgd.min.js', array(), $version, true );
				wp_enqueue_script( 'onepress-gallery-justified', get_template_directory_uri() . '/assets/js/jquery.justifiedGallery.min.js', array(), $version, true );
				wp_enqueue_script( 'onepress-gallery-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), $version, true );
			}
		}
		wp_enqueue_style( 'onepress-gallery-lightgallery', get_template_directory_uri() . '/assets/css/lightgallery.css' );
	}

	wp_enqueue_script( 'onepress-theme', get_template_directory_uri() . '/assets/js/theme.js', array(), $version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_front_page() && is_page_template( 'template-frontpage.php' ) ) {
		if ( get_theme_mod( 'onepress_header_scroll_logo' ) ) {
			$onepress_js_settings['is_home'] = 1;
		}
	}
	wp_localize_script( 'jquery', 'onepress_js_settings', $onepress_js_settings );

}
add_action( 'wp_enqueue_scripts', 'onepress_scripts' );


if ( ! function_exists( 'onepress_fonts_url' ) ) :
	/**
	 * Register default Google fonts
	 */
	function onepress_fonts_url() {
		$fonts_url = '';

		/*
		* Translators: If there are characters in your language that are not
		* supported by Open Sans, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$open_sans = _x( 'on', 'Open Sans font: on or off', 'onepress' );

		/*
		* Translators: If there are characters in your language that are not
		* supported by Raleway, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$raleway = _x( 'on', 'Raleway font: on or off', 'onepress' );

		if ( 'off' !== $raleway || 'off' !== $open_sans ) {
			$font_families = array();

			if ( 'off' !== $raleway ) {
				$font_families[] = 'Raleway:400,500,600,700,300,100,800,900';
			}

			if ( 'off' !== $open_sans ) {
				$font_families[] = 'Open Sans:400,300,300italic,400italic,600,600italic,700,700italic';
			}

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
endif;



/**
 * Glabel OnePress loop properties
 *
 * @since 2.1.0
 */
global $onepress_loop_props;
$onepress_loop_props = array();

/**
 * Set onepress loop property.
 *
 * @since 2.1.0
 *
 * @param string $prop
 * @param string $value
 */
function onepress_loop_set_prop( $prop, $value ) {
	global $onepress_loop_props;
	$onepress_loop_props[ $prop ] = $value;
}


/**
 * Get onepress loop property
 *
 * @since 2.1.0
 *
 * @param $prop
 * @param bool $default
 *
 * @return bool|mixed
 */
function onepress_loop_get_prop( $prop, $default = false ) {
	global $onepress_loop_props;
	if ( isset( $onepress_loop_props[ $prop ] ) ) {
		return apply_filters( 'onepress_loop_get_prop', $onepress_loop_props[ $prop ], $prop );
	}

	return apply_filters( 'onepress_loop_get_prop', $default, $prop );
}

/**
 * Remove onepress loop property
 *
 * @since 2.1.0
 *
 * @param $prop
 */
function onepress_loop_remove_prop( $prop ) {
	global $onepress_loop_props;
	if ( isset( $onepress_loop_props[ $prop ] ) ) {
		unset( $onepress_loop_props[ $prop ] );
	}

}

/**
 * Trim the excerpt with custom length
 *
 * @since 2.1.0
 *
 * @see wp_trim_excerpt
 * @param $text
 * @param null $excerpt_length
 * @return string
 */
function onepress_trim_excerpt( $text, $excerpt_length = null ) {
	$text = strip_shortcodes( $text );
	/** This filter is documented in wp-includes/post-template.php */
	$text = apply_filters( 'the_content', $text );
	$text = str_replace( ']]>', ']]&gt;', $text );

	if ( ! $excerpt_length ) {
		/**
		 * Filters the number of words in an excerpt.
		 *
		 * @since 2.7.0
		 *
		 * @param int $number The number of words. Default 55.
		 */
		$excerpt_length = apply_filters( 'excerpt_length', 55 );
	}

	/**
	 * Filters the string in the "more" link displayed after a trimmed excerpt.
	 *
	 * @since 2.9.0
	 *
	 * @param string $more_string The string shown within the more link.
	 */
	$excerpt_more = apply_filters( 'excerpt_more', ' ' . '&hellip;' );

	return wp_trim_words( $text, $excerpt_length, $excerpt_more );

}

/**
 * Display the excerpt
 *
 * @param string $type
 * @param bool   $length
 */
function onepress_the_excerpt( $type = false, $length = false ) {

	$type = onepress_loop_get_prop( 'excerpt_type', 'excerpt' );
	$length = onepress_loop_get_prop( 'excerpt_length', false );

	switch ( $type ) {
		case 'excerpt':
			the_excerpt();
			break;
		case 'more_tag':
			the_content( '', true );
			break;
		case 'content':
			the_content( '', false );
			break;
		default:
			$text = '';
			global $post;
			if ( $post ) {
				if ( $post->post_excerpt ) {
					$text = $post->post_excerpt;
				} else {
					$text = $post->post_content;
				}
			}
			$excerpt = onepress_trim_excerpt( $text, $length );
			if ( $excerpt ) {
				// WPCS: XSS OK.
				echo apply_filters( 'the_excerpt', $excerpt );
			} else {
				the_excerpt();
			}
	}
}

/**
 * Config class
 *
 * @since 2.1.1
 */
require get_template_directory() . '/inc/class-config.php';

/**
 * Load Sanitize
 */
require get_template_directory() . '/inc/sanitize.php';

/**
 * Custom Metabox  for this theme.
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Dots Navigation class
 *
 * @since 2.1.0
 */
require get_template_directory() . '/inc/class-sections-navigation.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add theme info page
 */
require get_template_directory() . '/inc/admin/dashboard.php';

/**
 * Editor Style
 *
 * @since 2.2.1
 */
require get_template_directory() . '/inc/admin/class-editor.php';

/* Add Profile Extra fields */
add_action( 'show_user_profile', 'custom_extra_profile_fields' );
add_action( 'edit_user_profile', 'custom_extra_profile_fields' );
function custom_extra_profile_fields( $user ) {
	?>
	<h3><?php esc_html_e( 'Personal Information', 'onepress' ); ?></h3>

	<table class="form-table">
		<tr>
			<?php $val_scp = esc_attr( get_the_author_meta( 'superc_patient_user', $user->ID ) ); ?>
			<?php
			if ($val_scp == 'Yes') {
				$ch = 'checked';
			}else{
				$ch = '';
			}
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery('#superc_patient_user').on('change', function(e){
						if(jQuery(this).is(':checked')){
							jQuery(this).val('Yes');
						}else{
							jQuery(this).val('');
						}
					});
				});
			</script>
			<th><label for="superc_patient_user"><?php esc_html_e( 'Im a Super Care Patient', 'onepress' ); ?></label></th>
			<td><input type="checkbox" id="superc_patient_user" name="superc_patient_user" <?php echo $ch; ?> value="<?php echo esc_attr( get_the_author_meta( 'superc_patient_user', $user->ID ) ); ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="full_name_user"><?php esc_html_e( 'Full Name', 'onepress' ); ?></label></th>
			<td><input type="text" id="full_name_user" name="full_name_user" value="<?php echo esc_attr( get_the_author_meta( 'full_name_user', $user->ID ) ); ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="phone_user"><?php esc_html_e( 'Phone', 'onepress' ); ?></label></th>
			<td><input type="text" id="phone_user" name="phone_user" value="<?php echo esc_attr( get_the_author_meta( 'phone_user', $user->ID ) ); ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="address_user"><?php esc_html_e( 'Address', 'onepress' ); ?></label></th>
			<td><input type="text" id="address_user" name="address_user" value="<?php echo esc_attr( get_the_author_meta( 'address_user', $user->ID ) ); ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="city_user"><?php esc_html_e( 'City', 'onepress' ); ?></label></th>
			<td><input type="text" id="city_user" name="city_user" value="<?php echo esc_attr( get_the_author_meta( 'city_user', $user->ID ) ); ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="state_user"><?php esc_html_e( 'State', 'onepress' ); ?></label></th>
			<td><input type="text" id="state_user" name="state_user" value="<?php echo esc_attr( get_the_author_meta( 'state_user', $user->ID ) ); ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="zip_code_user"><?php esc_html_e( 'Zip Code', 'onepress' ); ?></label></th>
			<td><input type="text" id="zip_code_user" name="zip_code_user" value="<?php echo esc_attr( get_the_author_meta( 'zip_code_user', $user->ID ) ); ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="account_id_user"><?php esc_html_e( 'Account ID', 'onepress' ); ?></label></th>
			<td><input type="text" id="account_id_user" name="account_id_user" value="<?php echo esc_attr( get_the_author_meta( 'account_id_user', $user->ID ) ); ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="insurance_user"><?php esc_html_e( 'Insurance', 'onepress' ); ?></label></th>
			<td>
				<select id="insurance_user" name="insurance_user">
					<?php
					$form_id = '28';
					$form = GFAPI::get_form( $form_id );
					$field = GFFormsModel::get_field( $form, 12 );
					$selects = $field->choices;
					foreach ($selects as $select) {
						$current_v = esc_attr( get_the_author_meta( 'insurance_user', $user->ID ) );
						if($current_v == $select['value']){
							?>
							<option value="<?php echo $select['value']; ?>" selected><?php echo $select['text']; ?></option>
							<?php
						}else{
							?>
							<option value="<?php echo $select['value']; ?>"><?php echo $select['text']; ?></option>
							<?php
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="physician_name_user"><?php esc_html_e( 'Physician Name', 'onepress' ); ?></label></th>
			<td><input type="text" id="physician_name_user" name="physician_name_user" value="<?php echo esc_attr( get_the_author_meta( 'physician_name_user', $user->ID ) ); ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="pap_device_user"><?php esc_html_e( 'PAP Device Selection', 'onepress' ); ?></label></th>
			<td>
				<select id="pap_device_user" name="pap_device_user">
					<?php
					$form_id = '28';
					$form = GFAPI::get_form( $form_id );
					$field = GFFormsModel::get_field( $form, 13 );
					$selects = $field->choices;
					foreach ($selects as $select) {
						$current_v = esc_attr( get_the_author_meta( 'pap_device_user', $user->ID ) );
						if($current_v == $select['value']){
							?>
							<option value="<?php echo $select['value']; ?>" selected><?php echo $select['text']; ?></option>
							<?php
						}else{
							?>
							<option value="<?php echo $select['value']; ?>"><?php echo $select['text']; ?></option>
							<?php
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="mask_user"><?php esc_html_e( 'Mask Selection', 'onepress' ); ?></label></th>
			<td>
				<select id="mask_user" name="mask_user">
					<?php
					$form_id = '28';
					$form = GFAPI::get_form( $form_id );
					$field = GFFormsModel::get_field( $form, 14 );
					$selects = $field->choices;
					foreach ($selects as $select) {
						$current_v = esc_attr( get_the_author_meta( 'mask_user', $user->ID ) );
						if($current_v == $select['value']){
							?>
							<option value="<?php echo $select['value']; ?>" selected><?php echo $select['text']; ?></option>
							<?php
						}else{
							?>
							<option value="<?php echo $select['value']; ?>"><?php echo $select['text']; ?></option>
							<?php
						}
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="rx_copy_user"><?php esc_html_e( 'Copy of Rx', 'onepress' ); ?></label></th>
			<td><input type="text" id="rx_copy_user" name="rx_copy_user" value="<?php echo esc_attr( get_the_author_meta( 'rx_copy_user', $user->ID ) ); ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="insurance_card_user"><?php esc_html_e( 'Copy of Insurance Card', 'onepress' ); ?></label></th>
			<td><input type="text" id="insurance_card_user" name="insurance_card_user" value="<?php echo esc_attr( get_the_author_meta( 'insurance_card_user', $user->ID ) ); ?>" class="regular-text" /></td>
		</tr>
	</table>
	<?php
}

add_action( 'personal_options_update', 'saving_custom_profile_fields' );
add_action( 'edit_user_profile_update', 'saving_custom_profile_fields' );
function saving_custom_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return FALSE;

	global $wpdb;

	update_usermeta( $user_id, 'superc_patient_user', $_POST['superc_patient_user'] );
	update_usermeta( $user_id, 'full_name_user', $_POST['full_name_user'] );
	update_usermeta( $user_id, 'phone_user', $_POST['phone_user'] );
	update_usermeta( $user_id, 'address_user', $_POST['address_user'] );
	update_usermeta( $user_id, 'city_user', $_POST['city_user'] );
	update_usermeta( $user_id, 'state_user', $_POST['state_user'] );
	update_usermeta( $user_id, 'zip_code_user', $_POST['zip_code_user'] );
	update_usermeta( $user_id, 'account_id_user', $_POST['account_id_user'] );
	update_usermeta( $user_id, 'insurance_user', $_POST['insurance_user'] );
	update_usermeta( $user_id, 'physician_name_user', $_POST['physician_name_user'] );
	update_usermeta( $user_id, 'pap_device_user', $_POST['pap_device_user'] );
	update_usermeta( $user_id, 'mask_user', $_POST['mask_user'] );
	update_usermeta( $user_id, 'rx_copy_user', $_POST['rx_copy_user'] );
	update_usermeta( $user_id, 'insurance_card_user', $_POST['insurance_card_user'] );

	$wpdb->query($wpdb->prepare("UPDATE wp_user_orders SET customer_address = %s, customer_city = %s, customer_state = %s, customer_zip = %s WHERE customer_id = %s", $_POST['address_user'], $_POST['city_user'], $_POST['state_user'], $_POST['zip_code_user'], $user_id));

}

/* Shortcode get current user */
add_shortcode('user_supercare', 'current_supercare_user');
function current_supercare_user(){
	$out = '';
	$current_user = wp_get_current_user();
	$get_fullname = get_the_author_meta( 'full_name_user', $current_user->ID ) ? get_the_author_meta( 'full_name_user', $current_user->ID ) : '';
	if ($get_fullname) {
		$out .= $get_fullname;
	}else{
		$out .= $current_user->display_name;
	}

	return $out;
}

/* Shortcode get current user */
add_shortcode('supercare_products', 'supercare_products_function');
function supercare_products_function(){
	$out = '';
	$args = array(
 		'post_type' => 'products',
 		'showposts' => -1
 	);
 	$res_prev = 'At least 3 months ago';
 	$res_next = 'More than 6 months ago';
 	$curr_res = $_POST['input_10'];
 	$out .= $prods;
 	//$out .= $show_p;
	$wp_query = new WP_Query( $args );
	if($wp_query->have_posts()):
		$out .= '<div class="list-products '.$curr_res.'">';
			$out .= '<table>';
			$out .= '<thead>';
				$out .= '<tr><th colspan="2">CPAP Supply Replacement Schedule</th></tr>';
			$out .= '</thead>';
			while ( $wp_query->have_posts() ) : $wp_query->the_post();
				if ($res_next == $curr_res) {
					if ($_POST['input_20_1'] == get_the_title() || $_POST['input_20_2'] == get_the_title() || $_POST['input_20_3'] == get_the_title() || $_POST['input_20_4'] == get_the_title() || $_POST['input_20_5'] == get_the_title() || $_POST['input_20_6'] == get_the_title() || $_POST['input_20_7'] == get_the_title() || $_POST['input_20_8'] == get_the_title() || $_POST['input_20_9'] == get_the_title() || $_POST['input_20_11'] == get_the_title() || $_POST['input_20_12'] == get_the_title() || $_POST['input_20_13'] == get_the_title() || $_POST['input_20_14'] == get_the_title() || $_POST['input_20_15'] == get_the_title() || $_POST['input_20_16'] == get_the_title() || $_POST['input_20_17'] == get_the_title() || $_POST['input_20_18'] == get_the_title() || $_POST['input_20_19'] == get_the_title() || $_POST['input_20_21'] == get_the_title() || $_POST['input_20_22'] == get_the_title() || $_POST['input_20_23'] == get_the_title()) {
						if (get_field('replacement_schedule') === $res_next) {
							$out .= '<tr>';
								$out .= '<td>'.get_the_title().'</td>';
								$out .= '<td>'.get_field('replacement_amount').' per month</td>';
							$out .= '</tr>';
						}elseif (get_field('replacement_schedule') === $res_prev) {
							$out .= '<tr>';
								$out .= '<td>'.get_the_title().'</td>';
								$out .= '<td>'.get_field('replacement_amount').' per 6 months</td>';
							$out .= '</tr>';
						}
					}
				}else{
					if ($_POST['input_20_1'] == get_the_title() || $_POST['input_20_2'] == get_the_title() || $_POST['input_20_3'] == get_the_title() || $_POST['input_20_4'] == get_the_title() || $_POST['input_20_5'] == get_the_title() || $_POST['input_20_6'] == get_the_title() || $_POST['input_20_7'] == get_the_title() || $_POST['input_20_8'] == get_the_title() || $_POST['input_20_9'] == get_the_title() || $_POST['input_20_11'] == get_the_title() || $_POST['input_20_12'] == get_the_title() || $_POST['input_20_13'] == get_the_title() || $_POST['input_20_14'] == get_the_title() || $_POST['input_20_15'] == get_the_title() || $_POST['input_20_16'] == get_the_title() || $_POST['input_20_17'] == get_the_title() || $_POST['input_20_18'] == get_the_title() || $_POST['input_20_19'] == get_the_title() || $_POST['input_20_21'] == get_the_title() || $_POST['input_20_22'] == get_the_title() || $_POST['input_20_23'] == get_the_title()) {
						if (get_field('replacement_schedule') === $res_prev) {
							$out .= '<tr>';
								$out .= '<td>'.get_the_title().'</td>';
								$out .= '<td>'.get_field('replacement_amount').' per month</td>';
							$out .= '</tr>';
						}
					}
				}
			endwhile;
			$out .= '</table>';
		$out .= '</div>';
	endif;
	return $out;
}
/* Shortcode get current user */
add_shortcode('supercare_products_c', 'supercare_products_function_c');
function supercare_products_function_c(){
	$out = '';
	$args = array(
 		'post_type' => 'products',
 		'showposts' => -1
 	);
 	$res_prev = 'At least 3 months ago';
 	$res_next = 'More than 6 months ago';
 	$resp_1 = $_POST['input_3'];
 	$resp_2 = $_POST['input_4'];
 	$resp_3 = $_POST['input_5'];
 	$resp_4 = $_POST['input_6'];
 	if ($resp_1 == 'No' || $resp_2 == 'Yes' || $resp_3 == 'No' || $resp_4 == 'No') {
 		$out .= '<div class="gform_confirmation_wrapper"><div class="gform_confirmation_message"><img class="wp-image-5377 aligncenter" src="'.get_site_url().'/wp-content/uploads/2019/08/error-confirmation.png" alt="" width="80" height="80" />
		<h3 style="text-align: center;">Sorry</h3>
		<p style="text-align: center;">Based on your answers, insurance will not cover this resupply request.</p>
		<p style="text-align: center;"><a class="top-bt" href="'.get_site_url().'/isleep-resupply-orders/">Go back and edit answers</a></p>
		&nbsp;

		<a href="#"><img class="size-full wp-image-5378 aligncenter" src="'.get_site_url().'/wp-content/uploads/2019/08/banner-p.png" alt="" width="1352" height="190" /></a>

		&nbsp;
		<h4>You Can Try Again When You Are Within the guidelines provided by Medicare and private insurance companies:</h4>
		<ol>
		 	<li>You have used your device for at least 21 nights during the last consecutive 30 days</li>
		 	<li>You do not have any unused supplies on hand</li>
		 	<li>You are ordering supplies because they are worn and need to be replaced</li>
		 	<li>Do you own your PAP device?</li>
		</ol>
		&nbsp;
		<p style="text-align: center;">'.do_shortcode('[logout_link]').'</p></div></div>';
		$out .= '<style>
		.form-page-header,.select-style,.gform_page_footer{display:none;}
		body.page-template-template-orders .gform_wrapper div.gform_body ul.gform_fields .gform_confirmation_wrapper .gform_confirmation_message ol li{
			list-style-type:none!important;
			margin-bottom: 13px!important;
		}
		</style>';
 	}else{
 		//$out .= $show_p;
		$wp_query = new WP_Query( $args );
		if($wp_query->have_posts()):
			$out .= '<div class="list-products">
<table>
<thead><tr><th colspan="2">CPAP Supply Replacement Schedule</th></tr></thead>
<tbody>
<tr>
<td>Full Face Mask</td>
<td>1 per 3 months</td>
</tr>
<tr>
<td>Full Face Cushion</td>
<td>1 per month</td>
</tr>
<tr>
<td>Nasal Mask</td>
<td>1 per 3 months</td>
</tr>
<tr>
<td>Nasal Cushions</td>
<td>2 per month</td>
</tr>
<tr>
<td>Nasal Pillow Mask</td>
<td>1 per 3 months</td>
</tr>
<tr>
<td>Pillow Cushions</td>
<td>2 per month</td>
</tr>
<tr>
<td>Headgear</td>
<td>1 per 6 months</td>
</tr>
<tr>
<td>Standard Tubing</td>
<td>1 per 3 months</td>
</tr>
<tr>
<td>Heated Tubing</td>
<td>1 per 6 months</td>
</tr>
<tr>
<td>Disposable Filters</td>
<td>2 per month</td>
</tr>
<tr>
<td>Non-Disposable Filters</td>
<td>1 per 6 months</td>
</tr>
<tr>
<td>Water Chamber</td>
<td>1 per 6 months</td>
</tr>
</tbody>
</table>
</div>';
		endif;
 	}
	return $out;
}
/* Shortcode link */
add_shortcode('logout_link', 'logout_link_function');
function logout_link_function(){
	$out = '';
	$out .= '<a href="'.wp_logout_url( get_permalink() ).'" class="logout-bt">Log Out</a>';
	return $out;
}

/* Custom Post Type Product */
add_action('init', 'register_c_post_type' );
function register_c_post_type(){
	register_post_type( 'products',
        array(
            'labels' => array(
                'name' => __( 'Products' ),
                'singular_name' => __( 'Products' ),
                'add_new_item'  => __( 'Add a Product' ),
                'add_new'       => __( 'Add Products' ),
                'edit_item'     => __( 'Edit Product' ),
            ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'can_export'          => true,
            'supports'            => array( 'editor', 'author', 'title' ,'thumbnail', 'custom-fields', 'excerpt' )
        )
    );
    register_taxonomy('type', 
        'products',
        array(
            'hierarchical' => true,
            'show_ui' => true,
            'label' => 'Type',
        )
    );
    /**/
}

/* Get result */
add_filter( 'gform_pre_render_32', 'wps_populate_person' );
add_filter( 'gform_pre_validation_32', 'wps_populate_person' );
add_filter( 'gform_pre_submission_filter_32', 'wps_populate_person' );
add_filter( 'gform_admin_pre_render_32', 'wps_populate_person' );
//add_filter('gform_pre_render_29', 'wps_populate_person');
function wps_populate_person( $form ){
    foreach( $form['fields'] as &$field ) {
    	if ($field['id'] == '18' ){
    		$custom_value = rgpost('input_18');
    	}
        if ('radio' != $field['type'] || false === strpos($field['cssClass'],'customopt') || !rgar($field,'allowsPrepopulate')){
        	continue;
        }else{
        	$field['choices'] = array();
        	$field['choices'] = array(array( 'text' => $custom_value, 'value' => $custom_value, 'isSelected' => true ));
        }
        //$query = new WP_Query(array('s'=>'Disponsable Filter','post_type' => 'products','gform_search' => true));
        /*if ( empty($query->posts) ) {
			$field['choices'] = array(array( 'text' => 'No Persons Found', 'value' => '' ));
		}else{*/
            //foreach( $query->posts as $post ){
    	//$field['choices'] = array(array( 'text' => $custom_value, 'value' => $custom_value, 'isSelected' => 1 ));
            //}
		//}
		//$field['enableOtherChoice'] = 1;
		break;
	}
	return $form;
}

add_filter('gform_pre_render_32', 'populate_checkbox');
function populate_checkbox( $form ){
    foreach( $form['fields'] as &$field ) {
    	if ($field['id'] == '20' ){
    		$counter = 0;
    		$counter2 = 0;
    		$my_choices = array();
    		$my_inputs = array();
    		foreach ($field['choices'] as $choice) {
    			$counter++;
    			if ($counter == 10 || $counter == 20) {
					$counter++;
				}
    			if (rgpost('input_20_'.$counter)) {
    				$my_choices[] = array('text' => rgpost('input_20_'.$counter), 'value' => rgpost('input_20_'.$counter), 'isSelected' => 1);
    				$my_inputs[] = array('label' => rgpost('input_20_'.$counter), 'id' => '27.'.$counter);
    			}
    		}
    	}
		if ('checkbox' != $field['type'] || false === strpos($field['cssClass'],'selectedproducts') || !rgar($field,'allowsPrepopulate')){
            continue;
		}else{
			$field['choices'] = $my_choices;
    		$field['inputs'] = $my_inputs;
		}
		break;
	}
	return $form;
}
/***********/

/* Shortcode link */
add_shortcode('your-last-order', 'sch_your_last_order');
function sch_your_last_order(){
	ob_start();
	$args = array(
 		'post_type' => 'products',
 		'showposts' => -1
 	);
 	$res_prev = 'At least 3 months ago';
 	$res_next = 'More than 6 months ago';
 	$curr_res = $_POST['input_10'];
 	//$out .= $show_p;
	$wp_query = new WP_Query( $args );
	if($wp_query->have_posts()):
		echo "<script type='text/javascript'>
		jQuery(document).ready(function(){
			/*jQuery('#input_32_18 li:nth-child(1) input').attr('checked', false);*/
			jQuery('input[name=input_18]').on('change', function(){
				if (jQuery(this).val() == 'Full Face (covers nose and mouth)') {
					var counter = 0;
					jQuery('#input_32_20 li').each(function(){
						counter++;
						if (counter == 1){
							jQuery(this).find('input').attr('disabled', false);
							jQuery(this).find('input').removeClass('no-s');
						}else{
							if (counter == 3) {
								counter = 0;
							}
							jQuery(this).find('input').attr('disabled', true);
							jQuery(this).find('input').attr('checked', false);
							jQuery(this).find('input').addClass('no-s');
						}
					});
				}
				if (jQuery(this).val() == 'Nasal (covers nose)') {
					var counter = 0;
					jQuery('#input_32_20 li').each(function(){
						counter++;
						if (counter == 2){
							jQuery(this).find('input').attr('disabled', false);
							jQuery(this).find('input').removeClass('no-s');
						}else{
							if (counter == 3) {
								counter = 0;
							}
							jQuery(this).find('input').attr('disabled', true);
							jQuery(this).find('input').attr('checked', false);
							jQuery(this).find('input').addClass('no-s');
						}
					});
				}
				if (jQuery(this).val() == 'Nasal Pillow (covers nostrils)') {
					var counter = 0;
					jQuery('#input_32_20 li').each(function(){
						counter++;
						if (counter == 3){
							jQuery(this).find('input').attr('disabled', false);
							jQuery(this).find('input').removeClass('no-s');
							counter = 0;
						}else{
							jQuery(this).find('input').addClass('no-s');
							jQuery(this).find('input').attr('disabled', true);
							jQuery(this).find('input').attr('checked', false);
						}
					});
				}
			});
		});
		</script>";
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			if (get_field('replacement_schedule') === $res_next && $curr_res === 'At least 3 months ago') :
				$title = get_the_title();
				echo '<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery("input[name=input_18]").on("change", function(){
							jQuery("#input_32_20 li").each(function(){
								if (jQuery(this).find("input").val() === "'.$title.'") {
									jQuery(this).find("input").attr("checked", false);
									jQuery(this).find("input").attr("disabled", true);
									jQuery(this).find("input").addClass("no-s");
								}
							});
						});
					});
				</script>';
			endif;
		endwhile;
	endif;
	
	?>
	<div class="box-info">
		<!--<?php echo add_filter('gform_field_value_first_opt', 'custom_get_param'); ?>-->
		<div class="row">
			<div class="col-sm-6">Last time you ordered supplies</div>
			<div class="col-sm-6 text-right"><strong><?php echo $curr_res; ?></strong></div>
		</div>
	</div>
	<?php
	$out = ob_get_clean();
	return $out;
}

/*********************************
*	Select autofill
*********************************/
add_shortcode('autofill_order', 'autofill_order_function');
function autofill_order_function($atts, $content){
	$out = '';
	$current_user = wp_get_current_user();
	$autofill = $_POST['input_30'];
	$current_page = rgpost('gform_source_page_number_32') ? rgpost('gform_source_page_number_32') : 1;
	global $wpdb;
	$last_order = $wpdb->get_results("SELECT * FROM wp_user_orders WHERE customer_id = $current_user->ID ORDER BY id DESC LIMIT 1");

	if ($autofill == 'Send me the exact same supplies as I am currently using and am eligible for') {
		foreach($last_order as $last){
			$entry_id .= $last->entry_id;
			$style = $last->customer_cpap_m_style;
			$supplies = $last->customer_supplies;
			$notes = $last->notes;
		}
		if ($style) {
			/**/
			$mysupplies = explode(',', $supplies);
			foreach ($mysupplies as $value) {
				$out .= '<script>
				jQuery(document).ready(function(){
					jQuery("#input_32_20 li").each(function(){
						if(jQuery(this).find("input").val() == "'.$value.'"){
							jQuery(this).find("input").trigger("click");
							jQuery(this).find("input").prop("checked", true);
						}
					});
				});
				</script>';
			}
			$out .= '<script>
			jQuery(document).ready(function(){
				jQuery("#input_32_18 li").each(function(){
					if(jQuery(this).find("input").val() == "'.$style.'"){
						jQuery(this).find("input").prop("checked", true);
						jQuery(this).find("input").trigger("click");
					}
				});
				jQuery("#input_32_17").val("'.$notes.'");
				jQuery("#input_32_20 li input,#input_32_18 li input").on("click", function(e){
					e.preventDefault();
				});
			});
			</script>';

			if ($style == 'Nasal (covers nose)'){
				$out .= "<script type='text/javascript'>
				jQuery(document).ready(function(){
					var counter = 0;
					jQuery('#input_32_20 li').each(function(){
						counter++;
						if (counter == 2){
							
						}else{
							jQuery(this).find('input').attr('disabled', true);
							jQuery(this).find('input').attr('checked', false);
							jQuery(this).find('input').addClass('no-s');
							if (counter == 3) {
								counter = 0;
							}
						}
					});
				});
				</script>";
			}elseif ($style == 'Nasal Pillow (covers nostrils)') {
				$out .= "<script type='text/javascript'>
				jQuery(document).ready(function(){
					var counter = 0;
					jQuery('#input_32_20 li').each(function(){
						counter++;
						if (counter == 3){
							counter = 0;
						}else{
							jQuery(this).find('input').attr('disabled', true);
							jQuery(this).find('input').attr('checked', false);
							jQuery(this).find('input').addClass('no-s');
						}
					});
				});
				</script>";
			}else{
				$out .= "<script type='text/javascript'>
				jQuery(document).ready(function(){
					var counter = 0;
					jQuery('#input_32_20 li').each(function(){
						counter++;
						if (counter == 1){
						}else{
							jQuery(this).find('input').attr('disabled', true);
							jQuery(this).find('input').attr('checked', false);
							jQuery(this).find('input').addClass('no-s');
							if (counter == 3) {
								counter = 0;
							}
						}
					});
				});
				</script>";
			}
			/**/
		}
	}elseif ($autofill == 'I want to change my style of mask and order other supplies I am eligible for' && $_POST['input_18'] == '') {
		foreach($last_order as $last){
			$entry_id .= $last->entry_id;
			$supplies = $last->customer_supplies;
			$style = $last->customer_cpap_m_style;
			$notes = $last->notes;
		}
		if ($style) {
			/**/
			$mysupplies = explode(',', $supplies);
			foreach ($mysupplies as $value) {
				$out .= '<script>
				jQuery(window).on("load", function(){
					jQuery("#input_32_20 li").each(function(){
						if(jQuery(this).find("input").val() == "'.$value.'"){
							jQuery(this).find("input").trigger("click");
							jQuery(this).find("input").prop("checked", true);
						}
					});
				});
				</script>';
			}
			$out .= '<script>
			jQuery(window).on("load", function(){
				jQuery("#input_32_18 li").each(function(){
					if(jQuery(this).find("input").val() == "'.$style.'"){
						jQuery(this).find("input").attr("disabled", true);
					}
				});
				jQuery("#input_32_17").val("'.$notes.'");
			});
			</script>';
			if ($style == 'Nasal (covers nose)') {
				$out .= "<script type='text/javascript'>
				jQuery(window).on('load', function(){
					var counter = 0;
					jQuery('#input_32_20 li').each(function(){
						counter++;
						if (counter == 2){
							jQuery(this).find('input').attr('disabled', true);
							jQuery(this).find('input').attr('checked', false);
							jQuery(this).find('input').addClass('no-s');
						}else{
							if (counter == 3) {
								counter = 0;
							}
						}
					});
				});
				</script>";
			}elseif ($style == 'Nasal Pillow (covers nostrils)') {
				$out .= "<script type='text/javascript'>
				jQuery(window).on('load', function(){
					var counter = 0;
					jQuery('#input_32_20 li').each(function(){
						counter++;
						if (counter == 3){
							jQuery(this).find('input').attr('disabled', true);
							jQuery(this).find('input').attr('checked', false);
							jQuery(this).find('input').addClass('no-s');
							counter = 0;
						}
					});
				});
				</script>";
			}else{
				$out .= "<script type='text/javascript'>
				jQuery(window).on('load', function(){
					var counter = 0;
					jQuery('#input_32_20 li').each(function(){
						counter++;
						if (counter == 1){
							jQuery(this).find('input').attr('disabled', true);
							jQuery(this).find('input').attr('checked', false);
							jQuery(this).find('input').addClass('no-s');
						}else{
							if (counter == 3) {
								counter = 0;
							}
						}
					});
				});
				</script>";
			}
			/**/
		}
	}elseif($autofill == 'I want to change my style of mask and order other supplies I am eligible for' && $_POST['input_18']){
		$out .= "<script type='text/javascript'>
				jQuery(window).on('load', function(){
					jQuery('#input_32_18 li').each(function(){
						if(jQuery(this).find('input').val() == '".$_POST['input_18']."'){
							jQuery(this).find('input').prop('checked', true);
							jQuery(this).find('input').trigger('click');
						}
					});
				});
				</script>";
	}else{}

	return $out;
}

/*********************************/
add_action( 'gform_after_submission_32', 'after_submission_add_info', 10, 2 );
function after_submission_add_info( $entry, $form ){
	$m_style = rgar( $entry, '18' );
	$notes = rgar( $entry, '17' );
	$supplies = array();
	$supplies[] = rgar( $entry, '20.1' );
	$supplies[] = rgar( $entry, '20.2' );
	$supplies[] = rgar( $entry, '20.3' );
	$supplies[] = rgar( $entry, '20.4' );
	$supplies[] = rgar( $entry, '20.5' );
	$supplies[] = rgar( $entry, '20.6' );
	$supplies[] = rgar( $entry, '20.7' );
	$supplies[] = rgar( $entry, '20.8' );
	$supplies[] = rgar( $entry, '20.9' );
	$supplies[] = rgar( $entry, '20.11' );
	$supplies[] = rgar( $entry, '20.12' );
	$supplies[] = rgar( $entry, '20.13' );
	$supplies[] = rgar( $entry, '20.14' );
	$supplies[] = rgar( $entry, '20.15' );
	$supplies[] = rgar( $entry, '20.16' );
	$supplies[] = rgar( $entry, '20.17' );
	$supplies[] = rgar( $entry, '20.18' );
	$supplies[] = rgar( $entry, '20.19' );
	$supplies[] = rgar( $entry, '20.21' );
	$supplies[] = rgar( $entry, '20.22' );
	$supplies[] = rgar( $entry, '20.23' );
	$final_suplies = implode(",", array_filter($supplies));
	$charge = rgar( $entry, '24.1' ) ? 'Yes' : 'No';
	$current_date = current_time('Y-m-d');
	$item_number = 1;
	global $wpdb;
	$numRows = $wpdb->get_var( "SELECT COUNT(*) FROM wp_user_orders");
	$last_row = $wpdb->get_results("SELECT * FROM wp_user_orders ORDER BY id DESC LIMIT 1");
	$last_id = '';
	foreach($last_row as $last){
		$last_id = $last->id;
	}
	$last_f_id = substr($last_id, -5);
	if ($last_f_id) {
		$numRows = (int)$last_f_id;
	}else{
		$numRows = 0;
	}
	$numRows++;
	$current_user = wp_get_current_user();
	$customer_id = $current_user->ID;
	$customer_email = $current_user->user_email;
	$customer_address = esc_attr( get_the_author_meta( 'address_user', $customer_id ) );
	$customer_city = esc_attr( get_the_author_meta( 'city_user', $customer_id ) );
	$customer_state = esc_attr( get_the_author_meta( 'state_user', $customer_id ) );
	$customer_insurance_name = esc_attr( get_the_author_meta( 'insurance_user', $customer_id ) );
	$customer_zip = esc_attr( get_the_author_meta( 'zip_code_user', $customer_id ) );
	$customer_cpap_m_style = esc_attr( get_the_author_meta( 'zip_code_user', $customer_id ) );
	$final_id = str_pad($numRows, 5, '0', STR_PAD_LEFT);
	$table = 'wp_user_orders';
	$data = array(
		'id' => $current_date.'-'.$final_id,
		'order_date' => $current_date,
		'customer_id' => $customer_id,
		'customer_email' => $customer_email,
		'customer_address' => $customer_address,
		'customer_city' => $customer_city,
		'customer_state' => $customer_state,
		'customer_zip' => $customer_zip,
		'customer_insurance_name' => $customer_insurance_name,
		'customer_last_order' => $current_date,
		'customer_cpap_m_style' => $m_style,
		'customer_supplies' => $final_suplies,
		'customer_charge_co_insurance' => $charge,
		'notes' => $notes,
		'entry_id' => $entry['id'],
	);

	$wpdb->insert($table,$data);
	//$my_id = $wpdb->insert_id;
}
/*********************************/
/* Shortcode order ID */
add_shortcode('order_cid', 'order_cid_function');
function order_cid_function($atts,$content){
	$cid = $content ? $content : '';
	$out = '';
	if ($cid) {
		global $wpdb;
		$total_items = $wpdb->get_results("SELECT * FROM wp_user_orders ORDER BY id DESC LIMIT 1");
		foreach($total_items as $last){
			$last_id = $last->id;
		}
		$last_f_id = substr($last_id, -5);
		if ($last_f_id) {
			$numRows = (int)$last_f_id;
		}else{
			$numRows = 0;
		}
		$numRows++;
		$current_date = current_time('Y-m-d');
		$final_id = str_pad($numRows, 5, '0', STR_PAD_LEFT);
		$out .= '<strong>'.$current_date.'-'.$final_id.'</strong>';
	}
	return $out;
}

/*****************************+
*	redirect after login
******************************/
add_filter('login_redirect', 'my_login_redirect', 10, 3 );
function my_login_redirect( $url, $request, $user ){
	if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
		if(in_array( 'customer', (array) $user->roles )) {
			$url = home_url('/isleep-resupply-orders/');
		}else{
			$url = admin_url();
		}
	}
	return $url;
}





add_shortcode('submited_order', 'submited_order_function');
function submited_order_function($atts,$content){
	$cid = $content ? $content : '';
	$out = '';
	if ($cid) {
		$entry = RGFormsModel::get_lead($content);
		if ($entry['18'] == 'Full Face (covers nose and mouth)') {
			$cclass = 'full-f';
		}
		if ($entry['18'] == 'Nasal (covers nose)') {
			$cclass = 'nasal';
		}
		if ($entry['18'] == 'Nasal Pillow (covers nostrils)') {
			$cclass = 'nasal-p';
		}
		$out .= '<div class="container-fff '.$cclass.'">CPAP Mask Style: <strong>'.$entry['18'].'</strong></div>';
		$out .= '<div class="list-pds">';
		if ($entry['20.1']) {
			$out .= '<div>'.$entry['20.1'].'</div>';
		}
		if ($entry['20.2']) {
			$out .= '<div>'.$entry['20.2'].'</div>';
		}
		if ($entry['20.3']) {
			$out .= '<div>'.$entry['20.3'].'</div>';
		}
		if ($entry['20.4']) {
			$out .= '<div>'.$entry['20.4'].'</div>';
		}
		if ($entry['20.5']) {
			$out .= '<div>'.$entry['20.5'].'</div>';
		}
		if ($entry['20.6']) {
			$out .= '<div>'.$entry['20.6'].'</div>';
		}
		if ($entry['20.7']) {
			$out .= '<div>'.$entry['20.7'].'</div>';
		}
		if ($entry['20.8']) {
			$out .= '<div>'.$entry['20.8'].'</div>';
		}
		if ($entry['20.9']) {
			$out .= '<div>'.$entry['20.9'].'</div>';
		}
		if ($entry['20.11']) {
			$out .= '<div>'.$entry['20.11'].'</div>';
		}
		if ($entry['20.12']) {
			$out .= '<div>'.$entry['20.12'].'</div>';
		}
		if ($entry['20.13']) {
			$out .= '<div>'.$entry['20.13'].'</div>';
		}
		if ($entry['20.14']) {
			$out .= '<div>'.$entry['20.14'].'</div>';
		}
		if ($entry['20.15']) {
			$out .= '<div>'.$entry['20.15'].'</div>';
		}
		if ($entry['20.16']) {
			$out .= '<div>'.$entry['20.16'].'</div>';
		}
		if ($entry['20.17']) {
			$out .= '<div>'.$entry['20.17'].'</div>';
		}
		if ($entry['20.18']) {
			$out .= '<div>'.$entry['20.18'].'</div>';
		}
		if ($entry['20.19']) {
			$out .= '<div>'.$entry['20.19'].'</div>';
		}
		if ($entry['20.21']) {
			$out .= '<div>'.$entry['20.21'].'</div>';
		}
		if ($entry['20.22']) {
			$out .= '<div>'.$entry['20.22'].'</div>';
		}
		if ($entry['20.23']) {
			$out .= '<div>'.$entry['20.23'].'</div>';
		}
		$out .= '</div>';
	}
	return $out;
}

add_action( 'gform_after_submission_28', 'after_submission_add_user_fields', 10, 2 );
function after_submission_add_user_fields( $entry, $form ){
	$email = rgar( $entry, '2' );
	$rx = str_replace(str_split('[]"'), '', rgar( $entry, '15' ));
	$copyic = str_replace(str_split('[]"'), '', rgar( $entry, '16' ));
	$user = get_user_by( 'email', $email );
	update_usermeta( $user->ID, 'rx_copy_user', $rx );
	update_usermeta( $user->ID, 'insurance_card_user', $copyic );
}










