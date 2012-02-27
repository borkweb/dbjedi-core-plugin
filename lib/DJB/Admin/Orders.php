<?php

namespace DJB\Admin;

class Orders {
	static $post_type = 'orders';
	static $class = 'DJB\Admin\Orders';

	public static function register_post_type() {
		$labels = array(
			'name' => _x('Orders', 'post type general name'),
			'singular_name' => _x('Orders', 'post type singular name'),
			'add_new' => _x('Add New', 'orders'),
			'add_new_item' => __('Add New Order'),
			'edit_item' => __('Edit Order'),
			'new_item' => __('New Order'),
			'all_items' => __('Orders'),
			'view_item' => __('View Orders'),
			'search_items' => __('Search Orders'),
			'not_found' => __('No orders found'),
			'not_found_in_trash' => __('No orders found in Trash'),
			'parent_item_colon' => '',
			'menu_name' => 'Orders',
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
		$columns['title'] = _x('Order', 'column name');
		$columns['path'] = __('Path');

		return $columns;
	}//end wp_admin_columns

	public static function wp_admin_custom_column( $column, $post_id ) {
		switch( $column ) {
			case 'path':
				echo get_post_meta( $post_id, 'path', true );
				break;
		}//end switch
	}//end wp_admin_columns

	public static function wp_get_posts( &$query ) {
		if( $query->query_vars['post_type'] === static::$post_type ) {
			$query->set('orderby', 'title');
			$query->set('order', 'asc');
		}//end if
	}//end wp_get_posts
}//end class DJB\Orders
