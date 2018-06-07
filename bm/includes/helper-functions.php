<?php
/**
 * Store Pro.
 *
 * This file adds helper functions used in the Store Pro Theme.
 *
 * @package      Store Pro
 * @link         https://seothemes.net/store-pro
 * @author       Seo Themes
 * @copyright    Copyright © 2017 Seo Themes
 * @license      GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Ensure $number is an absolute integer (whole number,
 * zero or greater). If the input is an absolute integer,
 * return it; otherwise, return the default.
 *
 * @param  int $number The input number.
 * @param  obj $setting The setting id.
 * @return int Absolute integer.
 */
function sp_sanitize_number( $number, $setting ) {

	$number = absint( $number );

	return ( $number ? $number : $setting->default );
}

/**
 * Calculate the color contrast.
 *
 * @param  string $color The input color.
 * @return string Hex color code for contrast color
 */
function sp_color_contrast( $color ) {
	$hexcolor = str_replace( '#', '', $color );
	$red      = hexdec( substr( $hexcolor, 0, 2 ) );
	$green    = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue     = hexdec( substr( $hexcolor, 4, 2 ) );
	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );
	return ( $luminosity > 200 ) ? '#2c2d33' : '#ffffff';
}

/**
 * Calculate the color brightness.
 *
 * @param  string $color The input color.
 * @param  string $change The amount to change.
 * @return string Hex color code for the color brightness
 */
function sp_color_brightness( $color, $change ) {
	$hexcolor = str_replace( '#', '', $color );
	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );
	$red   = max( 0, min( 255, $red + $change ) );
	$green = max( 0, min( 255, $green + $change ) );
	$blue  = max( 0, min( 255, $blue + $change ) );
	return '#' . dechex( $red ) . dechex( $green ) . dechex( $blue );
}

/**
 * Add flexible widget CSS classes.
 *
 * @param  string $id Widget area ID.
 * @return string $class Flexible widgets CSS class.
 */
function sp_flexible_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		$count = count( $sidebars_widgets[ $id ] );
	} else {
		$count = 0;
	}

	$class = '';

	if ( 6 === $count ) {
		$class = ' flexible-widgets-6';
	} elseif ( 0 === $count % 5 ) {
		$class = ' flexible-widgets-5';
	} elseif ( 0 === $count % 4 ) {
		$class = ' flexible-widgets-4';
	} elseif ( 0 === $count % 3 ) {
		$class = ' flexible-widgets-3';
	} elseif ( 0 === $count % 2 ) {
		$class = ' flexible-widgets-2';
	} else {
		$class = '';
	}
	return $class;
}

/**
 * Quick and dirty way to mostly minify CSS.
 *
 * @author Gary Jones
 * @link https://github.com/GaryJones/Simple-PHP-CSS-Minification
 * @param string $css CSS to minify.
 * @return string Minified CSS.
 */
function sp_minify_css( $css ) {

	// Normalize whitespace.
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove spaces before and after comment.
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );

	// Remove comment blocks, everything between /* and */, unless preserved with /*! ... */ or /** ... */.
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );

	// Remove ; before }.
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } */ >.
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

	// Remove space before , ; { } ( ) >.
	$css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px).
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0).
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	// Converts all zeros value into short-hand.
	$css = preg_replace( '/0 0 0 0/', '0', $css );

	// Shorten 6-character hex color codes to 3-character where possible.
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

	return trim( $css );
}

/**
 * Return an empty variable.
 *
 * @param  array $atts Given attributes.
 * @return array $atts Empty attributes.
 */
function sp_return_empty( $atts ) {

	$atts = '';
	return $atts;
}

/**
 * Emulate hover effects on mobile devices.
 *
 * @param  string $attr On touch start attribute.
 * @return string
 */
function sp_add_ontouchstart( $attr ) {
	$attr['ontouchstart'] = ' ';
	return $attr;
}

/**
 * Add schema microdata to title-area.
 *
 * @param  array $args Array of arguments.
 * @return array $args Additional arguments.
 */
function sp_title_area( $args ) {
	$args['itemscope'] = 'itemscope';
	$args['itemtype'] = 'http://schema.org/Organization';
	return $args;
}

/**
 * Correct site-title schema microdata.
 *
 * @param  array $args Array of arguments.
 * @return array $args New arguments.
 */
function sp_site_title( $args ) {
	$args['itemprop'] = 'name';
	return $args;
}

/**
 * Reduce the Primary Navigation Menu to three levels depth.
 * (For mega menu).
 *
 * @param  array $args Menu args.
 * @return array $args New menu args.
 */
function sp_primary_menu_args( $args ) {

	if ( 'primary' !== $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 3;

	return $args;
}

/**
 * Display descriptions in Primary Navigation Menu.
 *
 * @param string $output  HTML output for the menu item.
 * @param object $item    Menu item object.
 * @param int    $depth   Depth in menu structure.
 * @param object $args    Arguments passed to wp_nav_menu().
 * @return string $output
 */
function sp_menu_description( $output, $item, $depth, $args ) {

	if ( 1 === $depth && ' ' !== $item->description && '' !== $item->description ) {
		$button = apply_filters( 'sp_menu_button', '<button class="small">Read more</button>' );
		$output = str_replace( '</a>', '<p itemprop="description">' . $item->description . '</p>' . $button . '</a>', $output );
	}
	return $output;
}

/**
 * Callback for Genesis 'wp_nav_menu_items' filter.
 *
 * @param string   $menu The menu html.
 * @param stdClass $args the current menu args.
 * @return string  $menu The menu html
 */
function sp_nav_breadcrumb( $menu, $args ) {

	if ( 'secondary' !== $args->theme_location ) {
		return $menu;
	}

	ob_start();
	genesis_do_breadcrumbs();
	$breadcrumbs = ob_get_clean();

	$menu .= '</ul>' . $breadcrumbs;

	return $menu;

}

/**
 * Remove Genesis Blog & Archive Page Templates.
 *
 * @param  array $page_templates All page templates.
 * @return array Modified templates.
 */
function sp_remove_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}

/**
 * Modify breadcrumb arguments.
 *
 * @param  array $args Original breadcrumb args.
 * @return array Cleaned breadcrumbs.
 */
function sp_breadcrumb_args( $args ) {
	$args['prefix'] = '<div class="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList"><div class="wrap">';
	$args['suffix'] = '</div></div>';
	$args['labels']['prefix'] = '';
	$args['labels']['author'] = '';
	$args['labels']['category'] = '';
	$args['labels']['tag'] = '';
	$args['labels']['date'] = '';
	$args['labels']['tax'] = '';
	$args['labels']['post_type'] = '';
	return $args;
}

/**
 * Remove […] from the read more link.
 *
 * @param  string $more Default read more link.
 * @return string Filtered read more link.
 */
function sp_excerpt_more( $more ) {

	global $post;
	return '...  <a class="excerpt-read-more" href="' . get_permalink( $post->ID ) . '" title="' . __( 'Read ', 'store-pro' ) . esc_attr( get_the_title( $post->ID ) ) . '">' . __( 'Read more &raquo;', 'store-pro' ) . '</a>';
}

/**
 * Display featured image before post content on blog.
 *
 * @return array Featured image size.
 */
function sp_display_featured_image() {

	// Check display featured image option.
	$genesis_settings = get_option( 'genesis-settings' );

	if ( ( ! is_archive() && ! is_home() && ! is_page_template( 'page_blog.php' ) ) || ( 1 !== $genesis_settings['content_archive_thumbnail'] ) ) {
		return;
	}
	add_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );
}

/**
 * Change the footer text.
 *
 * @param  string $creds Defaults.
 * @return string Custom footer credits.
 */
function sp_footer_credits( $creds ) {
	$creds = '[footer_copyright] Store Pro by <a href="https://seothemes.net" title="Seo Themes">Seo Themes</a>';
	return $creds;
}
