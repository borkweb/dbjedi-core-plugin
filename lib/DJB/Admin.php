<?php

namespace DJB;

class Admin {
	/**
	 * initialize the admin menu
	 */
	public static function admin_menu() {
		add_menu_page( 'DJB Data', 'DJB Data', 'manage_options', 'djb-data', array( 'DJB\Admin', 'page_data' ) );
		add_menu_page( 'DJB Importer', 'DJB Importer', 'manage_options', 'djb-data-importer', array( 'DJB\Admin', 'importer' ) );

		$importers = array(
			'orders' => 'Orders',
			'species' => 'Species',
			'ranks' => 'Ranks',
		);

		foreach( $importers as $slug => $name ) {
			add_submenu_page( 'djb-data-importer', $name, $name, 'manage_options', 'djb-data-importer-' . $slug, array( 'DJB\Admin', 'importer_' . $slug) );
		}//end foreach
	}//end admin_menu

	public static function page_data() {
	}//end page_data

	public static function importer() {
	}//end importer

	public static function importer_orders() {
		$importer = new Importer\Orders;

		$importer->page();
	}//end importer_orders

	public static function importer_ranks() {
		$importer = new Importer\Ranks;

		$importer->page();
	}//end importer_ranks

	public static function importer_species() {
		$importer = new Importer\Species;

		$importer->page();
	}//end importer_species
}//end DJB\Plugin
