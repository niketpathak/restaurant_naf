<?php
/**
 * _tk functions and definitions
 *
 * @package _tk
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 750; /* pixels */

if ( ! function_exists( '_tk_setup' ) ) :
/**
 * Set up theme defaults and register support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function _tk_setup() {
	global $cap, $content_width;

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	/**
	 * Add default posts and comments RSS feed links to head
	*/
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	*/
	add_theme_support( 'post-thumbnails' );

	/**
	 * Enable support for Post Formats
	*/
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	 * Setup the WordPress core custom background feature.
	*/
	add_theme_support( 'custom-background', apply_filters( '_tk_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on _tk, use a find and replace
	 * to change '_tk' to the name of your theme in all the template files
	*/
	load_theme_textdomain( '_tk', get_template_directory() . '/languages' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	*/
	register_nav_menus( array(
		'primary'  => __( 'Header bottom menu', '_tk' ),
	) );

}
endif; // _tk_setup
add_action( 'after_setup_theme', '_tk_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function _tk_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', '_tk' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', '_tk_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function _tk_scripts() {

	// Import the necessary TK Bootstrap WP CSS additions
	wp_enqueue_style( '_tk-bootstrap-wp', get_template_directory_uri() . '/includes/css/bootstrap-wp.css' );

	// load bootstrap css
    //wp_enqueue_style( '_tk-bootstrap', get_template_directory_uri() . '/includes/resources/bootstrap/css/bootstrap.min.css' );
	wp_enqueue_style( '_tk-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css' );

	// load Font Awesome css
	wp_enqueue_style( '_tk-font-awesome', get_template_directory_uri() . '/includes/css/font-awesome.min.css', false, '4.1.0' );

	// load _tk styles
	wp_enqueue_style( '_tk-style', get_stylesheet_uri() );

	//***************************************** npk Load custom CSS *****************************************//
	// load responsiveSlide styling
	wp_enqueue_style( '_theme_cust', get_template_directory_uri() . '/includes/css/theme_cust.css', false, '4.4.0' );
	wp_enqueue_style( '_responsiveslidesstyles', get_template_directory_uri() . '/includes/css/responsiveslides.css', false, '4.1.0' );
	wp_enqueue_style( '_override', get_template_directory_uri() . '/includes/css/override.css', false, '1.0.1' );


	// load bootstrap js
	wp_enqueue_script('_tk-bootstrapjs', get_template_directory_uri().'/includes/resources/bootstrap/js/bootstrap.min.js', array('jquery') );

	// load bootstrap wp js
	wp_enqueue_script( '_tk-bootstrapwp', get_template_directory_uri() . '/includes/js/bootstrap-wp.js', array('jquery') );

	wp_enqueue_script( '_tk-skip-link-focus-fix', get_template_directory_uri() . '/includes/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( '_tk-keyboard-image-navigation', get_template_directory_uri() . '/includes/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	//Load Angular Libraries (v1.4.7)
	wp_enqueue_script('angularjs', get_template_directory_uri() .'/node_modules/angular/angular.min.js');
	wp_enqueue_script('angularjs-route', get_template_directory_uri() .'/node_modules/angular-route/angular-route.min.js');
	wp_enqueue_script('angularjs-sanitize', get_stylesheet_directory_uri() . '/node_modules/angular-sanitize/angular-sanitize.min.js');
	wp_enqueue_script('angularjs-filter', get_stylesheet_directory_uri() . '/node_modules/angular-filter/dist/angular-filter.min.js');
	//Load angular-animate+UIbootstrap
    wp_enqueue_script('angular-animate', get_stylesheet_directory_uri() . '/node_modules/angular-animate/angular-animate.min.js');
    wp_enqueue_script('angularUI-bootstrap', get_stylesheet_directory_uri() . '/includes/resources/ui-bootstrap-tpls-2.0.0.min.js');
	//Load Underscore lib
	wp_enqueue_script('underscore-lib', get_stylesheet_directory_uri() . '/node_modules/underscore/underscore-min.js');
	//Load App
	wp_enqueue_script('app_restaurant', get_stylesheet_directory_uri() . '/js/app.js', array( 'angularjs', 'angularjs-route' ));
	wp_enqueue_script('ThemeService', get_stylesheet_directory_uri() . '/js/services/ThemeService.js');
	wp_enqueue_script('CachePagesService', get_stylesheet_directory_uri() . '/js/services/CachePagesService.js');
	wp_enqueue_script('CacheCategoryService', get_stylesheet_directory_uri() . '/js/services/CacheCategoryService.js');
	wp_enqueue_script('CacheMenuService', get_stylesheet_directory_uri() . '/js/services/CacheMenuService.js');
	wp_enqueue_script('MainController', get_stylesheet_directory_uri() . '/js/controllers/MainController.js');
	wp_enqueue_script('PostController', get_stylesheet_directory_uri() . '/js/controllers/PostController.js');
	wp_enqueue_script('PageController', get_stylesheet_directory_uri() . '/js/controllers/PageController.js');
	wp_enqueue_script('CategoryController', get_stylesheet_directory_uri() . '/js/controllers/CategoryController.js');
	wp_enqueue_script('MenuController', get_stylesheet_directory_uri() . '/js/controllers/MenuController.js');
	wp_enqueue_script('ReservationController', get_stylesheet_directory_uri() . '/js/controllers/ReservationController.js');
	wp_enqueue_script('TestController', get_stylesheet_directory_uri() . '/js/controllers/TestController.js');
	wp_enqueue_script('footerDirective', get_stylesheet_directory_uri() . '/js/directives/footerDirective.js');
	wp_enqueue_script('compileTemplateDirective', get_stylesheet_directory_uri() . '/js/directives/compileTemplateDirective.js');
	wp_enqueue_script('filters', get_stylesheet_directory_uri() . '/js/filters.js');

	//***************************************** npk Load custom JS *****************************************//

	wp_enqueue_script('resp_slider_script', get_template_directory_uri() . '/includes/js/responsiveslides.min.js');
	wp_enqueue_script('vanilla_jq', get_stylesheet_directory_uri() . '/js/vanilla_jq.js');

	wp_localize_script('app_restaurant', 'localized',
			array(
				'partials' => get_stylesheet_directory_uri() . '/partials/'
				)
	);

}
add_action( 'wp_enqueue_scripts', '_tk_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/includes/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/includes/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/includes/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
require get_template_directory() . '/includes/bootstrap-wp-navwalker.php';

/************************************************** CUST_NPK *********************************************/

/**
 * Get the value of the "Price" field
 *
 * @param array $object Details of current post.
 * @param string $field_name Name of field.
 * @param WP_REST_Request $request Current request
 *
 * @return mixed
 */
function slug_get_price( $object, $field_name, $request ) {
	return get_post_meta( $object[ 'id' ], $field_name, true );
}
function slug_register_price() {
	register_rest_field( 'post',
		'Price',
		array(
			'get_callback'    => 'slug_get_price',
			'update_callback' => null,
			'schema'          => null,
		)
	);
}
add_action( 'rest_api_init', 'slug_register_price' );

/**
 * Get featured Image
 * @param $post the input post
 * @return mixed Image url on success, otherwise false
 */
function ccw_get_thumbnail_url($post){
	if(has_post_thumbnail($post['id'])){
		$imgArray = wp_get_attachment_image_src( get_post_thumbnail_id( $post['id'] ), array(150,150) );
		$imgURL = $imgArray[0];
		return $imgURL;
	}else{
		return false;
	}
}
function ccw_insert_thumbnail_url() {
	register_rest_field( 'post',
		'featured_thumb',
		array(
			'get_callback'    => 'ccw_get_thumbnail_url',
			'update_callback' => null,
			'schema'          => null,
		)
	);
}
add_action( 'rest_api_init', 'ccw_insert_thumbnail_url' );

/**
 * Custom Admin Footer
 */
function remove_footer_admin () {
    echo '&copy; '.date("Y").' Developed by <a href="http://www.niketpathak.com" target="_blank">Niket Pathak</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

add_action( 'admin_bar_menu', 'toolbar_link_to_mypage', 999 );

/**
 * Contact/help from the developer
 * @param $wp_admin_bar
 */
function toolbar_link_to_mypage( $wp_admin_bar ) {
    $args = array(
        'id'    => 'npk',
        'title' => 'Developer Contact',
        'href'  => 'http://www.niketpathak.com',
        'meta'  => array( 'class' => 'my-toolbar-page' )
    );
    $wp_admin_bar->add_node( $args );
}

/**
 * Register a custom Reservation Page.
 */
function wpdocs_register_my_registration_menu_page() {
    add_menu_page(
        __( 'Custom Menu Title', 'textdomain' ),
        'Reservations',
        'manage_options',
        'reservation.php',
        '',
        get_template_directory_uri().'/includes/img/calendar.png',
        6
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_registration_menu_page' );