<?php

namespace DJB\Importer;

class Species extends \DJB\Importer {
	public $post_type = 'species';
	public $page_title = 'Species';

	public function data() {
		$sql = "
			SELECT optionname post_title,
             optionid legacy_id
			  FROM options
			 WHERE optionlistid = 6
			 ORDER BY optionname
		";

		$data = \DJB::db('olddjb')->GetAll( $sql );
		return $data;
	}//end data
}//end Species
