<?php
/**
 * Store Pro Theme.
 *
 * @package      Store Pro
 * @link         https://seothemes.net/store-pro
 * @author       Seo Themes
 * @copyright    Copyright © 2017 Seo Themes
 * @license      GPL-2.0+
 */

// Child theme (do not remove).
include_once( get_template_directory() . '/lib/init.php' );

// Set Localization (do not remove).
load_child_theme_textdomain( 'store-pro', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'store-pro' ) );

// Adds Viewport support for mobile
add_theme_support( 'genesis-responsive-viewport' );

// Theme constants.
define( 'CHILD_THEME_NAME', 'store-pro' );
define( 'CHILD_THEME_URL', 'http://www.seothemes.net/store-pro' );
define( 'CHILD_THEME_VERSION', '0.1.0' );

// Remove unused functionality.
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'header-right' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Enable support for structural wraps.
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'menu-primary',
	'menu-secondary',
	'site-inner',
	'footer-widgets',
	'footer',
) );

// Enable Accessibility support.
add_theme_support( 'genesis-accessibility', array(
	'404-page',
	'drop-down-menu',
	'headings',
	'rems',
	'search-form',
	'skip-links',
) );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus' , array(
	'primary' => __( 'Primary Menu', 'store-pro' ),
	'secondary' => __( 'Secondary Menu', 'store-pro' ),
) );

// Enable HTML5 markup structure.
add_theme_support( 'html5', array(
	'caption',
	'comment-form',
	'comment-list',
	'gallery',
	'search-form',
) );

// Add support for post formats.
add_theme_support( 'post-formats', array(
	'aside',
	'audio',
	'chat',
	'gallery',
	'image',
	'link',
	'quote',
	'status',
	'video',
) );

// Enable support for post thumbnails.
add_theme_support( 'post-thumbnails' );

// Enable automatic output of WordPress title tags.
add_theme_support( 'title-tag' );

// Enable selective refresh and Customizer edit icons.
add_theme_support( 'customize-selective-refresh-widgets' );

// Enable theme support for custom background image.
add_theme_support( 'custom-background' );

// Enable logo option in Customizer > Site Identity.
add_theme_support( 'custom-logo', array(
	'height'      => 60,
	'width'       => 200,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( '.site-title', '.site-description' ),
) );

// Enable support for custom header image or video.
add_theme_support( 'custom-header', array(
	'header-selector' 	=> '.front-page-1',
	'default_image'    	=> get_stylesheet_directory_uri() . '/assets/images/hero.jpg',
	'header-text'     	=> false,
	'width'           	=> 1920,
	'height'          	=> 1080,
	'flex-height'     	=> true,
	'flex-width'		=> true,
	'video'				=> true,
) );

// Register default header (just in case).
register_default_headers( array(
	'child' => array(
		'url'           => '%2$s/assets/images/hero.jpg',
		'thumbnail_url' => '%2$s/assets/images/hero.jpg',
		'description'   => __( 'Hero Image', 'store-pro' ),
	),
) );

// Enable theme support for WooCommerce plugin.
add_theme_support( 'woocommerce' );

// Enable theme support for Cleaner Gallery plugin.
add_theme_support( 'cleaner-gallery' );

/**
 * Load custom scripts and styles.
 */
function sp_enqueue_scripts_styles() {

	// Google fonts.
	//wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Playfair+Display:400i|Hind|Oswald:600,300,400|Poppins:600,400 ', array(), CHILD_THEME_VERSION );
	
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Roboto:300,400,500,700', array(), CHILD_THEME_VERSION );

	// Line awesome.
	wp_enqueue_style( 'line-awesome', 'https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome-font-awesome.min.css' );

	// Theme scripts.
	wp_enqueue_script( 'store-pro', get_stylesheet_directory_uri() . '/assets/scripts/min/store-pro.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'sp_enqueue_scripts_styles' );

// Remove unwanted action hooks.
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_post_content', 'genesis_do_post_image' );

// Add custom action hooks.
add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', 99 );
add_action( 'genesis_site_title', 'the_custom_logo', 0 );
add_action( 'genesis_header', 'genesis_do_nav', 10 );
add_action( 'genesis_before', 'sp_display_featured_image' );

// Add filters.
add_filter( 'nav_menu_description', 'wp_kses_post' );
add_filter( 'excerpt_more', 'sp_excerpt_more' );
add_filter( 'wp_nav_menu_args', 'sp_primary_menu_args' );
add_filter( 'walker_nav_menu_start_el', 'sp_menu_description', 10, 4 );
add_filter( 'wp_nav_menu_items', 'sp_nav_breadcrumb', 10, 2 );
add_filter( 'theme_page_templates', 'sp_remove_page_templates' );
add_filter( 'genesis_markup_content-sidebar-wrap', 'sp_return_empty' );
add_filter( 'genesis_edit_post_link' , '__return_false' );
add_filter( 'genesis_attr_body', 'sp_add_ontouchstart' );
add_filter( 'genesis_attr_title-area', 'sp_title_area' );
add_filter( 'genesis_attr_site-title', 'sp_site_title' );
add_filter( 'genesis_breadcrumb_args', 'sp_breadcrumb_args' );
add_filter( 'genesis_footer_creds_text', 'sp_footer_credits' );

// Theme includes.
include_once( get_stylesheet_directory() . '/includes/theme-defaults.php' );
include_once( get_stylesheet_directory() . '/includes/helper-functions.php' );
include_once( get_stylesheet_directory() . '/includes/plugin-activation.php' );
include_once( get_stylesheet_directory() . '/includes/widget-areas.php' );
include_once( get_stylesheet_directory() . '/includes/woocommerce.php' );
include_once( get_stylesheet_directory() . '/includes/customizer-settings.php' );
include_once( get_stylesheet_directory() . '/includes/customizer-output.php' );



remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_filter( 'woocommerce_subcategory_count_html', '__return_null' );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );


/**
 * Move WooCommerce Related Products to a tab
 *
 * Copy code to theme functions.php
 */

// Remove standard Related Products section
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
 
/**
 * Add Tab
 *
 * Set the priority to position the tab
 * Default is 25, this adds the tab between additional info tab and reviews tab
 
add_filter( 'woocommerce_product_tabs' , 'woocommerce_related_products_tab' );
function woocommerce_related_products_tab( $tabs ) {

	$tabs['related_products'] = array(
				'title'    => 'Related Products',
				'priority' => 25,
				'callback' => 'woocommerce_product_related_products_tab'
	);

	return $tabs;
}
 */
// Related Products callback
function woocommerce_product_related_products_tab() {
	echo do_shortcode('[related_products]');
}

add_filter( 'woocommerce_product_tabs', 'wp_woo_rename_reviews_tab', 98);
function wp_woo_rename_reviews_tab($tabs) {
    global $product;
    $check_product_review_count = $product->get_review_count();
    if ( $check_product_review_count == 0 ) {
        $tabs['reviews']['title'] = 'Reviews';
    } else {
        $tabs['reviews']['title'] = 'Reviews('.$check_product_review_count.')';
    }
    return $tabs;
}


/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 30 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 30;
  return $cols;
}


add_filter( 'add_to_cart_text', 'woo_custom_single_add_to_cart_text' );                // < 2.1
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_single_add_to_cart_text' );  // 2.1 +
  
function woo_custom_single_add_to_cart_text() {
  
    return __( 'Add to Bag', 'woocommerce' );

}

// remove reviews tab
add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
    function wcs_woo_remove_reviews_tab($tabs) {
    unset($tabs['reviews']);
    return $tabs;
}

//change related products heading

function my_text_strings( $translated_text, $text, $domain ) {
	switch ( $translated_text ) {
		case 'Related products' :
			$translated_text = __( 'Related tools', 'woocommerce' );
			break;
	}
	return $translated_text;
}
add_filter( 'gettext', 'my_text_strings', 20, 3 );


//move woocommerce price below description
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );

