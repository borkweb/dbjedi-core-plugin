<?php

namespace DJB;

class Importer {
	public function named_import( $post_type, $posts ) {
		global $wpdb;

		foreach( $posts as $post ) {
			$sql = "SELECT post_name FROM $wpdb->posts WHERE post_title = %s AND post_type = %s LIMIT 1";
			$exists = $wpdb->get_var( $wpdb->prepare( $sql, $post['post_title'], $post_type ) ); 

			if( ! $exists ) {
				$custom_fields = $post['custom_fields'];
				unset( $post['custom_fields'] );
				$post_id = wp_insert_post( $post, $wp_error );

				if( $custom_fields ) {
					foreach( $custom_fields as $key => $value ) {
						add_post_meta( $post_id, $key, $value, true );
					}//edn foreach
				}//end if
			}//end if
		}//end foreach
	}//end named_import

	public function posts( $data, $status ) {
		static $valid_fields = array(
			'ID',
			'menu_order',
			'comment_status',
			'ping_status',
			'pinged',
			'post_author',
			'post_category',
			'post_content',
			'post_date',
			'post_date_gmt',
			'post_excerpt',
			'post_name',
			'post_parent',
			'post_password',
			'post_status',
			'post_title',
			'post_type',
			'tags_input',
			'to_ping',
			'tax_input',
		);

		$posts = array();
		foreach( $data as $d ) {
			$post = array(
				'post_type' => $this->post_type,
				'post_status' => $status,
				'custom_fields' => array(),
			);

			foreach( $d as $key => $value ) {
				if( in_array( $key, $valid_fields ) ) {
					$post[ $key ] = $value;
				} else {
					$post[ 'custom_fields' ][ $key ] = $value;
				}
			}//end foreach

			$posts[] = $post;
		}//end foreach

		return $posts;
	}//end posts

	public function page() {
		if( $_GET['import'] ) {
			$method = $_POST['how'] ?: 'draft';
			$this->named_import( $this->post_type, $this->posts( $this->data(), $method ) );
		}//end if
?>
<div class="wrap">
	<h2><?php echo $this->page_title; ?> Importer</h2>
	<form method="post" action="admin.php?page=djb-data-importer-<?php echo $this->post_type; ?>&import=true">
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><?php echo $this->page_title; ?> in Old DJB Site</th>
			<td><?php echo count( $this->data() ); ?></td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php echo $this->page_title; ?> in New Site</th>
			<td>
<?php
		$loop = new \WP_Query( 'post_type='.$this->post_type );
		echo $loop->found_posts;
?>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">Import As:</th>
			<td>
				<select name="how">
					<option value="draft">Draft</option>
					<option value="publish">Published</option>
				</select>
			</td>
		</tr>
		</table>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Import') ?>" />
		</p>
	</form>
</div>
<?php
	}//end page
}//end class DJB\Importer
