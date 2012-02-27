<?php

function includes_djb_register( $prefix = null, $basedir = null ) {
	static $directories = array();

	if( $prefix && $basedir ) {
		$directories[$prefix] = $basedir;
	}

	return $directories;
}

function includes_djb_autoload( $class ) {
	static $base_dir = null;

	if( null === $base_dir ) {
		$base_dir = dirname( __FILE__ );
	}

	// translate namespaces: PSU\Foo becomes PSU_Foo
	$class = str_replace( '\\', '_', $class );

	// whitelisting for now, maybe later we just check for the file
	$prefix_whitelist = includes_djb_register();

	$prefix = null;

	if( ( $pos = strpos( $class, '_' ) ) !== false ) {
		$prefix = substr( $class, 0, $pos );
	} else {
		$prefix = $class;
	}

	if( isset( $prefix_whitelist[$prefix] ) ) {
		$file = $prefix_whitelist[$prefix] . '/' . str_replace( '_', '/', $class ) . '.php';

		if( file_exists( $file ) ) {
			require_once $file;
			return;
		}
	}
}
spl_autoload_register( 'includes_djb_autoload' );

if ( ! defined( 'DJB_LIB_DIR' ) ) {
	define( 'DJB_LIB_DIR', dirname(__FILE__) . '/lib' );
}

includes_djb_register( 'DJB', DJB_LIB_DIR );
