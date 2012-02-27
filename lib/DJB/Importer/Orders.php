<?php

namespace DJB\Importer;

class Orders extends \DJB\Importer {
	public $post_type = 'orders';
	public $page_title = 'Orders';

	public function data() {
		$data = array(
			array(
				'post_title' => 'Krath',
				'path' => 'Dark',
				'legacy_id' => 'Krath',
			),
			array(
				'post_title' => 'Obelisk',
				'path' => 'Dark',
				'legacy_id' => 'Obelisk',
			),
			array(
				'post_title' => 'Sith',
				'path' => 'Dark',
				'legacy_id' => 'Sith',
			),
			array(
				'post_title' => 'Consular',
				'path' => 'Light',
				'legacy_id' => 'Sith',
			),
			array(
				'post_title' => 'Guardian',
				'path' => 'Light',
				'legacy_id' => 'Obelisk',
			),
			array(
				'post_title' => 'Sentinel',
				'path' => 'Light',
				'legacy_id' => 'Krath',
			),
		);
		return $data;
	}//end data
}//end Orders
