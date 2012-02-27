<?php

namespace DJB\Admin;

class Species {
	static $post_type = 'species';
	static $class = 'DJB\Admin\Species';

	public static function register_post_type() {
		$labels = array(
			'name' => _x('Species', 'post type general name'),
			'singular_name' => _x('Species', 'post type singular name'),
			'add_new' => _x('Add New', 'species'),
			'add_new_item' => __('Add New Species'),
			'edit_item' => __('Edit Species'),
			'new_item' => __('New Species'),
			'all_items' => __('Species'),
			'view_item' => __('View Species'),
			'search_items' => __('Search Species'),
			'not_found' => __('No species found'),
			'not_found_in_trash' => __('No species found in Trash'),
			'parent_item_colon' => '',
			'menu_name' => 'Species',
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'menu_icon' => null,
			'show_ui' => true,
			'show_in_menu' => 'djb-data',
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array(
				'title',
				'custom-fields',
			),
		);

		register_post_type( static::$post_type, $args );

		add_filter('manage_edit-' . static::$post_type . '_columns', array( static::$class, 'wp_admin_columns' ) );

		add_action( 'pre_get_posts', array( static::$class, 'wp_get_posts' ), 1 );
	}//end register_custom_post_type

	public static function wp_admin_columns( $old_columns ) {
		$columns = array();

		$columns['cb'] = '<input type="checkbox" />';
		$columns['title'] = _x('Species', 'column name');

		return $columns;
	}//end wp_admin_columns

	public static function wp_get_posts( &$query ) {
		if( $query->query_vars['post_type'] === static::$post_type ) {
			$query->set('orderby', 'title');
			$query->set('order', 'asc');
		}//end if
	}//end wp_get_posts
}//end class DJB\Admin\Species
