<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */

 function custom_excerpt_length( $length ) {
	return 120;
}
add_filter( 'excerpt_length', __NAMESPACE__ . '\\custom_excerpt_length', 999 );

function excerpt_more() {
  return '';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

function add_image_class($class){
  $class .= ' img-fluid';
  return $class;
}
add_filter('get_image_tag_class',__NAMESPACE__ . '\\add_image_class');

/*ACF*/
add_filter('acf/settings/path', __NAMESPACE__. '\my_acf_settings_path');
function my_acf_settings_path( $path ) {

 $path = get_stylesheet_directory() . '/acf/';

 return $path;
}

add_filter('acf/settings/dir', __NAMESPACE__ . '\my_acf_settings_dir');
function my_acf_settings_dir( $dir ) {

 $dir = get_stylesheet_directory_uri() . '/acf/';

 return $dir;
}
//add_filter('acf/settings/show_admin', '__return_false');
include_once( get_stylesheet_directory() . '/acf/acf.php' );
