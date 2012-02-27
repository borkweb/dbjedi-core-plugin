<?php

namespace DJB\Importer;

class Ranks extends \DJB\Importer {
	public $post_type = 'ranks';
	public $page_title = 'Ranks';

	public function data() {
		$sql = "
			SELECT name post_title,
						 abbr,
						 sort_order,
						 ordr the_order,
						 saberpoints saber_points,
						 handtohandpoints hand_to_hand_points,
						 forcepoints force_points,
						 skillpoints skill_points,
						 disciplinepoints discipline_points,
						 rank_id legacy_id
			  FROM ranks
			 ORDER BY sort_order
		";

		$data = \DJB::db('olddjb')->GetAll( $sql );
		return $data;
	}//end data
}//end Ranks
