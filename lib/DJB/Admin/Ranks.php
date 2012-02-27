<?php

namespace DJB\Admin;

class Ranks {
	static $post_type = 'ranks';
	static $class = 'DJB\Admin\Ranks';

	public static function register_post_type() {
		$labels = array(
			'name' => _x('Ranks', 'post type general name'),
			'singular_name' => _x('Ranks', 'post type singular name'),
			'add_new' => _x('Add New', 'ranks'),
			'add_new_item' => __('Add New Rank'),
			'edit_item' => __('Edit Rank'),
			'new_item' => __('New Rank'),
			'all_items' => __('Ranks'),
			'view_item' => __('View Ranks'),
			'search_items' => __('Search Ranks'),
			'not_found' => __('No ranks found'),
			'not_found_in_trash' => __('No ranks found in Trash'),
			'parent_item_colon' => '',
			'menu_name' => 'Ranks',
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
		add_filter('manage_' . static::$post_type . '_posts_custom_column', array( static::$class, 'wp_admin_custom_column' ), 10, 2 );

		add_action( 'pre_get_posts', array( static::$class, 'wp_get_posts' ), 1 );
	}//end register_custom_post_type

	public static function wp_admin_columns( $old_columns ) {
		$columns = array();

		$columns['cb'] = '<input type="checkbox" />';
		$columns['title'] = _x('Ranks', 'column name');
		$columns['abbr'] = __('Abbreviation');
		$columns['the_order'] = __('Order');
		$columns['sort_order'] = __('Sort Order');

		return $columns;
	}//end wp_admin_columns

	public static function wp_admin_custom_column( $column, $post_id ) {
		switch( $column ) {
			case 'abbr':
				echo get_post_meta( $post_id, 'abbr', true );
				break;
			case 'the_order':
				echo get_post_meta( $post_id, 'the_order', true );
				break;
			case 'sort_order':
				echo get_post_meta( $post_id, 'sort_order', true );
				break;
		}//end switch
	}//end wp_admin_columns

	public static function wp_get_posts( &$query ) {
		if( $query->query_vars['post_type'] === static::$post_type ) {
			$query->set('meta_key', 'sort_order');
			$query->set('orderby', 'meta_value_num');
			$query->set('order', 'asc');
		}//end if
	}//end wp_get_posts
}//end class DJB\Ranks
