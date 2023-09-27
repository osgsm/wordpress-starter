<?php
/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Gutenberg block.
 *
 * @package my-plugin
 */

/**
 * Adds my-plugin block category
 */
add_filter(
	'block_categories_all',
	function ( $categories ) {
		$categories[] = array(
			'slug'  => 'my-plugin',
			'title' => 'My Plugin',
		);

		return $categories;
	}
);

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
add_action(
	'init',
	function () {
		// Skip block registration if Gutenberg is not enabled/merged.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		$asset_path = __DIR__ . '/wp/build/index.asset.php';

		if ( ! file_exists( $asset_path ) ) {
			throw new Error(
				'You need to run `npm start` or `npm run build` for the "detail-table/table" block first.'
			);
		}

		$asset_file = require $asset_path;

		wp_register_script(
			'my-blocks',
			plugins_url( 'wp/build/index.js', __FILE__ ),
			$asset_file['dependencies'],
			$asset_file['version']
		);

		register_block_type(
			'my-plugin/blocks',
			array(
				'editor_script_handles' => array( 'my-blocks' ),
			)
		);
	}
);
