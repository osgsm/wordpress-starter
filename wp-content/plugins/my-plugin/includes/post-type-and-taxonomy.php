<?php
/**
 * Register Post types and taxonomies
 *
 * @package my-plugin
 */

/**
 * Custom post types
 */
( function () {
	$post_types = array(
		array(
			'slug'          => 'news',
			'name'          => 'News',
			'singular_name' => 'News',
			'menu_name'     => 'ニュース',
			'icon'          => 'admin-post',
			'support'       => array(
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'revisions',
				'author',
			),
		),
		array(
			'slug'          => 'blog',
			'name'          => 'Blog',
			'singular_name' => 'Blog',
			'menu_name'     => 'ブログ',
			'icon'          => 'book',
			'support'       => array(
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'revisions',
				'author',
			),
		),
	);

	/**
	 * Register Post types
	 */
	add_action(
		'init',
		function () use ( $post_types ) {
			foreach ( $post_types as $post_type ) {
				$slug          = $post_type['slug'];
				$name          = $post_type['name'];
				$singular_name = $post_type['singular_name'] ?? $name;
				$menu_name     = $post_type['menu_name'];
				$icon          = $post_type['icon'];
				$has_archive   = $post_type['has_archive'] ?? true;
				$taxonomies    = array_merge( array(), $post_type['taxonomies'] ?? array() );
				$supports      = $post_type['support'] ?? array(
					'title',
					'editor',
					// 'thumbnail',
					// 'custom-fields',
					'revisions',
					'author',
				);

				register_post_type(
					$slug,
					array(
						'labels'                => array(
							'name'               => $name,
							'singular_name'      => $singular_name,
							'menu_name'          => $menu_name,
							'name_admin_bar'     => $menu_name,
							'all_items'          => "{$menu_name}一覧",
							'add_new_item'       => "新規{$menu_name}を追加",
							'edit_item'          => "{$menu_name}を編集",
							'view_item'          => "{$menu_name}を表示",
							'search_items'       => "{$menu_name}を検索",
							'not_found'          => "{$menu_name}が見つかりませんでした。",
							'not_found_in_trash' => "ゴミ箱内に{$menu_name}が見つかりませんでした。",
						),
						'description'           => '',
						'public'                => true,
						'publicly_queryable'    => true,
						'show_ui'               => true,
						'show_in_rest'          => true,
						'rest_base'             => '',
						'rest_controller_class' => 'WP_REST_Posts_Controller',
						'rest_namespace'        => 'wp/v2',
						'has_archive'           => $has_archive,
						'show_in_menu'          => true,
						'show_in_nav_menus'     => true,
						'menu_icon'             => "dashicons-${icon}",
						'menu_position'         => 5,
						'delete_with_user'      => false,
						'exclude_from_search'   => false,
						'capability_type'       => 'post',
						'map_meta_cap'          => true,
						'hierarchical'          => false,
						'can_export'            => true,
						'rewrite'               => array(
							'slug'       => $slug,
							'with_front' => true,
						),
						'query_var'             => true,
						'supports'              => $supports,
						'taxonomies'            => $taxonomies,
						'show_in_graphql'       => true,
					)
				);
			}
		},
		10,
		0
	);

	/**
	 * Add rewrite rules for custom posts.
	 * For example:
	 *   - /news/20/
	 *   - /blog/10/
	 */
	add_action(
		'init',
		function () use ( $post_types ) {
			foreach ( $post_types as $post_type ) {
				$slug = $post_type['slug'];
				add_rewrite_tag( "%{$slug}_id%", '([0-9]+)', "post_type={$slug}&p=" );
				add_permastruct( "{$slug}_id", "/{$slug}/%{$slug}_id%", array( 'with_front' => false ) );
			}
		},
		9,
		0
	);

	add_filter(
		'post_type_link',
		function ( $post_link, $post ) use ( $post_types ) {
			foreach ( $post_types as $post_type ) {
				if ( get_post_type( $post ) === $post_type['slug'] ) {
					return str_replace( $post->post_name, $post->ID, $post_link );
				}
			}
			return $post_link;
		},
		10,
		2
	);
} )();

/**
 * Custom taxonomies
 */
( function () {
	$taxonomies = array(
		array(
			'slug'        => 'blog_category',
			'label'       => 'カテゴリー',
			'object_type' => 'blog',
			'rewrite'     => array(
				'slug' => 'blog',
			),
		),
		array(
			'slug'         => 'blog_tag',
			'label'        => 'タグ',
			'object_type'  => 'blog',
			'hierarchical' => false,
			'rewrite'      => array(
				'slug' => 'blog/tag',
			),
		),
		array(
			'slug'        => 'news_category',
			'label'       => 'カテゴリー',
			'object_type' => 'news',
			'rewrite'     => array(
				'slug' => 'news',
			),
		),
		array(
			'slug'         => 'news_tag',
			'label'        => 'タグ',
			'object_type'  => 'news',
			'hierarchical' => false,
			'rewrite'      => array(
				'slug' => 'news/tag',
			),
		),
	);

	/**
	 * Register taxonomies
	 */
	add_action(
		'init',
		function () use ( $taxonomies ) {
			foreach ( $taxonomies as $taxonomy ) {
				$slug         = $taxonomy['slug'];
				$label        = $taxonomy['label'];
				$object_type  = $taxonomy['object_type'];
				$hierarchical = $taxonomy['hierarchical'] ?? true;
				$rewrite      = array_merge(
					array(
						'slug'       => $slug,
						'with_front' => true,
					),
					$taxonomy['rewrite'] ?? array()
				);

				register_taxonomy(
					$slug,
					$object_type,
					array(
						'label'                 => $label,
						'labels'                => array(
							'name'          => $label,
							'singular_name' => $label,
							'add_new_item'  => "新規{$label}を追加",
							'parent_item'   => "親{$label}",
							'edit_item'     => "{$label}を編集",
						),
						'public'                => true,
						'publicly_queryable'    => true,
						'hierarchical'          => $hierarchical,
						'show_ui'               => true,
						'show_in_menu'          => true,
						'show_in_nav_menus'     => true,
						'query_var'             => true,
						'rewrite'               => $rewrite,
						'show_admin_column'     => false,
						'show_in_rest'          => true,
						'show_tagcloud'         => false,
						'rest_base'             => $slug,
						'rest_controller_class' => 'WP_REST_Terms_Controller',
						'rest_namespace'        => 'wp/v2',
						'show_in_quick_edit'    => false,
						'sort'                  => false,
						'show_in_graphql'       => false,
					)
				);
			}
		}
	);

	/**
	 * Add rewrite rules for custom taxonomy archives.
	 * For example:
	 *   - /pr/release/
	 *   - /pr/tag/fintech/
	 *   - /magazine/fintech/
	 */
	add_action(
		'init',
		function () use ( $taxonomies ) {
			foreach ( $taxonomies as $taxonomy ) {
				$object_type   = $taxonomy['object_type'];
				$taxonomy_slug = $taxonomy['slug'];
				$rewrite_slug  = $taxonomy['rewrite']['slug'];

				add_rewrite_tag( "%{$taxonomy_slug}%", '([^/]+)', "post_type={$object_type}&{$taxonomy_slug}=" );
				add_permastruct(
					"{$taxonomy_slug}",
					"/{$rewrite_slug}/%{$taxonomy_slug}%",
					array(
						'with_front' => false,
					)
				);
			}
		},
		9,
		0
	);
} )();
