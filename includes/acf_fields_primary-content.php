<?php 
/* =======================
 * Primary Content Area
 * ==================== */

/**
 * Include ACF Plugins
 */
include_once( get_stylesheet_directory() . '/includes/plugins/acf-accordion/acf-accordion.php' );
include_once( get_stylesheet_directory() . '/includes/plugins/acf-rgba-color/acf-rgba-color.php' );
include_once( get_stylesheet_directory() . '/includes/plugins/acf-typography/acf-typography.php' );

add_filter( 'acf/accordion/dir', 'acf_accordion_dir' );
function acf_accordion_dir( $dir ) {
    $dir = get_stylesheet_directory_uri() . '/includes/plugins/acf-accordion/';

    return $dir;
}
add_filter( 'acf/rgba_color/dir', 'acf_rgba_color_dir' );
function acf_rgba_color_dir( $dir ) {
    $dir = get_stylesheet_directory_uri() . '/includes/plugins/acf-rgba-color/';

    return $dir;
}

add_filter( 'acf/typography/dir', 'acf_typography_dir' );
function acf_typography_dir( $dir ) {
    $dir = get_stylesheet_directory_uri() . '/includes/plugins/acf-typography/';

    return $dir;
}

/**
 * Turn On Chaching
 */
if ( !is_admin() ) {
	#include( get_stylesheet_directory() . '/includes/primary-content/pc-cache.php' );
}

/**
 * Add custom image sizes
 */
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'pc-medium', 700, 700, true ); 
	add_image_size( 'pc-small', 500, 500, true ); 
}

/**
 * Enqueue Styles
 */
add_action( 'wp_enqueue_scripts', 'tourtiger_styles_pca');
function tourtiger_styles_pca() {
  	wp_enqueue_style('pc-constructor', get_stylesheet_directory_uri() . '/includes/primary-content/dependences/pc.css', array(), null, false );
  	wp_enqueue_style( 'pc-roboto', 'https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700' );
}

/**
 * Enqueue Google Maps API
 */
function google_api_acf_init() {
	
	acf_update_setting( 'google_api_key', 'AIzaSyBPKkzpIMMXwxRMfArXDyzKZiRqdBVsfu0' );
}

add_action('acf/init', 'google_api_acf_init');

/**
 * ACF Global Options
 */
if(function_exists('acf_add_options_sub_page')) { 
	$primary_content = acf_add_options_page(array(
		'page_title'   => 'Primary Styles',
		'menu_title'   => 'Primary Styles',
		'menu_slug'    => 'acf-options-primary-area-styles',
		'icon_url'     => 'dashicons-align-left',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Blog',
		'menu_title' 	=> 'Blog styles',
		'parent_slug' 	=> $primary_content['menu_slug'],
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Flexi & Product',
		'menu_title' 	=> 'Flexi & Product styles',
		'parent_slug' 	=> $primary_content['menu_slug'],
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Content Card',
		'menu_title' 	=> 'Content Card styles',
		'parent_slug' 	=> $primary_content['menu_slug'],
	));

}

/**
 * ACF Fielad PHP
 */
if( function_exists('acf_add_local_field_group') ):
	include( get_stylesheet_directory() . '/includes/primary-content/dependences/pc-constructor.php' );
	include( get_stylesheet_directory() . '/includes/primary-content/dependences/pc-styling-cards.php' );
	include( get_stylesheet_directory() . '/includes/primary-content/dependences/pc-hero-area.php' );
endif;

/**
 * Get css via ACF Font
 * @param  string $font - ACF Field
 * @return array        - [0] - Link to Google font; [1] - css styles  
 */
function pc_init_font_css( $font = '' ) {
	if ( $font ) {
		$css = array( false, '' );

		if ( $font['font-family'] ) {
			$css[0] = "</style><style>@import url('https://fonts.googleapis.com/css?family=" . $font['font-family'] . "');";
			$css[1] .= "font-family:'" . $font['font-family'] . "';";
		}

		$css[1] .= $font['font-weight'] ? "font-weight:" . $font['font-weight'] . ";" : '';
		$css[1] .= $font['font_size'] ? "font-size:" . $font['font_size'] . "px;" : '';
		$css[1] .= $font['line_height'] ? "line-height:" . $font['line_height'] . "px;" : '';
		$css[1] .= $font['font_style'] ? "font-style:" . $font['font_style'] . ";" : '';
		$css[1] .= $font['text_align'] ? "text-align:" . $font['text_align'] . ";" : '';

		return $css;

	} else {
		return false;
	}
}

/**
 * This function builds css styles for forms
 * @param  string $font       Font ACF Fiels 
 * @param  string $color      Color value
 * @param  string $background Color value
 * @param  string $border     Color value
 * @return string             return string with styles
 */
function pc_content_init_form( $font='', $color='', $background='', $border='' ) {
	if ( $font['font-family'] ) {
		$css[0] = "</style><style>@import url('https://fonts.googleapis.com/css?family=" . $font['font-family'] . "');";
	 	$css[1] .= "font-family:'" . $font['font-family'] . "';";
	}

	$css[1] .= $font['font-weight'] ? "font-weight:" . $font['font-weight'] . ";" : '';
	$css[1] .= $font['font_size'] ? "font-size:" . $font['font_size'] . "px;" : '';
	$css[1] .= $font['line_height'] ? "line-height:" . $font['line_height'] . "px;" : '';
	$css[1] .= $font['font_style'] ? "font-style:" . $font['font_style'] . ";" : '';
	$css[1] .= $font['text_align'] ? "text-align:" . $font['text_align'] . ";" : '';

	$css[1] .= $color ? 'color:' . $color . ';' : '';
	$css[1] .= $background ? 'background-color:' . $background . ';' : '';
	$css[1] .= $border ? 'border-color:' . $border . ';' : '';

	return $css;
}

?>
