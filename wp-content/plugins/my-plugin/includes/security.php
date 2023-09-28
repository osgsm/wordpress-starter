<?php
/**
 * Use theme version instead of WordPress and plugin version.
 *
 * @package my-plugin
 */

remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

/**
 * Remove WordPress and plugin version.
 *
 * @param string $src The source URL of the enqueued style.
 *
 * @return string
 */
function myplugin_remove_style_script_ver( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = add_query_arg( 'ver', wp_get_theme()->get( 'Version' ), $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'myplugin_remove_style_script_ver' );
add_filter( 'script_loader_src', 'myplugin_remove_style_script_ver' );
