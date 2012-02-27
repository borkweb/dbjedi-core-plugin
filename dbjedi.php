<?php
/*
Plugin Name: Dark Jedi Brotherhood
Plugin URI: http://www.darkjedibrotherhood.com
Description: The Core functionality for the Dark Jedi Brotherhood site
Version: 1.0
Author: Matthew Batchelder
Author URI: http://borkweb.com
License: MIT
*/

require plugin_dir_path( __FILE__ ) . '/autoload.php';

// set the plugin dir
DJB\WordPress::plugin_dir( plugin_dir_path( __FILE__ ) );

add_action( 'init', array( 'DJB\WordPress', 'init' ) );
