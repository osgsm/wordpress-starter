<?php
/**
 * Customizations for admin
 *
 * @package my-plugin
 */

/**
 * Remove some admin menu
 */
add_action(
	'admin_menu',
	function () {
		remove_menu_page( 'edit.php' );
		// remove_menu_page( 'upload.php' );
		// remove_menu_page( 'edit.php?post_type=page' );
		remove_menu_page( 'edit-comments.php' );
		// remove_menu_page( 'tools.php' );
	}
);

add_action(
	'admin_bar_menu',
	function ( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'dashboard' );
		$wp_admin_bar->remove_node( 'appearance' );
		$wp_admin_bar->remove_node( 'customize' );
		// $wp_admin_bar->remove_node( 'updates' );
		$wp_admin_bar->remove_node( 'comments' );
		$wp_admin_bar->remove_node( 'new-post' );
		// $wp_admin_bar->remove_node( 'new-media' );
		// $wp_admin_bar->remove_node( 'new-page' );
		// $wp_admin_bar->remove_node( 'new-user' );
		// $wp_admin_bar->remove_node( 'new-content' );
		// $wp_admin_bar->remove_node( 'wp-logo' );
		// $wp_admin_bar->remove_node( 'site-name' );
		// $wp_admin_bar->remove_node( 'my-account' );
		// $wp_admin_bar->remove_node( 'search' );
	},
	99
);

/**
 * Reorder admin menu
 *
 * @param array $menu_order The current order of the admin menu.
 * @return array The new order of the admin menu.
 */
function my_plugin_menu_order( $menu_order ) {
	if ( ! $menu_order ) {
		return true;
	}

	return array(
		...array_unique(
			array(
				'index.php', // Dashboard.
				'separator1', // First separator.
				'edit.php?post_type=page', // Pages.
				'edit.php?post_type=news',
				'edit.php?post_type=blog',
				'upload.php', // Media.
				...$menu_order,
			)
		),
	);
}
add_filter( 'custom_menu_order', 'my_plugin_menu_order', 10, 1 );
add_filter( 'menu_order', 'my_plugin_menu_order', 10, 1 );
