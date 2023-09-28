<?php
/**
 * Register Post types.
 *
 * @package my-plugin
 */

add_action(
	'init',
	function () {
		$post_types = array(
			array(
				'slug'          => 'news',
				'name'          => 'ニュース',
				'singular_name' => 'ニュース',
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
		);

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
						'name'               => __( $name, 'my-plugin' ),
						'singular_name'      => __( $singular_name, 'my-plugin' ),
						'menu_name'          => __( $menu_name, 'my-plugin' ),
						'name_admin_bar'     => __( $menu_name, 'my-plugin' ),
						'all_items'          => __( "{$menu_name}一覧", 'my-plugin' ),
						'add_new_item'       => __( "新規{$menu_name}を追加", 'my-plugin' ),
						'edit_item'          => __( "{$menu_name}を編集", 'my-plugin' ),
						'view_item'          => __( "{$menu_name}を表示", 'my-plugin' ),
						'search_items'       => __( "{$menu_name}を検索", 'my-plugin' ),
						'not_found'          => __( "{$menu_name}が見つかりませんでした。", 'my-plugin' ),
						'not_found_in_trash' => __( "ゴミ箱内に{$menu_name}が見つかりませんでした。", 'my-plugin' ),
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
