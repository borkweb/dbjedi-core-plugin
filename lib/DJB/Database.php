<?php

namespace DJB;

require_once '/srv/www/beta.darkjedibrotherhood.com/public_html/application/third_party/adodb/adodb-exceptions.inc.php';
require_once '/srv/www/beta.darkjedibrotherhood.com/public_html/application/third_party/adodb/adodb.inc.php';

define('ADODB_ASSOC_CASE', 0);

/**
 * DJBDatabase.class.php
 *
 * @author		Matthew Batchelder (Orv Dessrx) <borkweb@gmail.com>
 * @copyright 2009, Dark Jedi Brotherhood
 */

class Database {
	/**
	* Connects to database and returns object
	*
	* TODO: support other return types
	* 
	* @param string $connect Connection parameters.
	* @param string $type Type of object to return
	* @return mixed
	*/
	public static function connect($connect, $type = 'adodb') {
		include('/srv/www/beta.darkjedibrotherhood.com/database_connections/' . $connect . '.php');
		include('/srv/www/beta.darkjedibrotherhood.com/database_connections/memcache.php');

		// expand the connection string
		$params = explode('/', $connect);
		
		// grab the first param as the connector
		$params['connect'] = $params[0];
		$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
		$ADODB_CACHE_DIR = '/srv/www/beta.darkjedibrotherhood.com/temp/ADOdb_cache';
		if( ! file_exists( $ADODB_CACHE_DIR ) ) {
			mkdir( $ADODB_CACHE_DIR );
		}//end if

		switch($params['connect'])
		{
			case 'olddjb':
				$db = &ADONewConnection('mssql');
				$db->SetFetchMode(ADODB_FETCH_ASSOC);
				@$db->Connect($_DB[$params['connect']]['server'], $_DB[$params['connect']]['username'], base64_decode($_DB[$params['connect']]['password']), $_DB[$params['connect']]['database']);

				/*
				$db = &ADONewConnection('odbc_mssql');
				$db->SetFetchMode(ADODB_FETCH_ASSOC);
				//@$db->Connect('Driver={SQL Server};Server=72.18.131.169:1533;Database=realdb_sql;', $_DB[$params['connect']]['username'], base64_decode($_DB[$params['connect']]['password']));
				@$db->Connect('odbc-realdb', $_DB[$params['connect']]['username'], base64_decode($_DB[$params['connect']]['password']));
				 */
				break;
			case 'djb':
				// initialize the database object and connect to the server
				$db = &ADONewConnection('mysql');
				$db->SetFetchMode(ADODB_FETCH_ASSOC);
				@$db->Connect($_DB[$params['connect']]['server'], $_DB[$params['connect']]['username'], base64_decode($_DB[$params['connect']]['password']), $_DB[$params['connect']]['database']);
				break;
		}//end switch

		$db->memCache = $config['adodb_memcache'];
		$db->memCacheHost = $config['adodb_memcache_host'];
		$db->memCachePort = $config['adodb_memcache_port'];
		$db->memCacheCompress = $config['adodb_memcache_compress'];
		
		// unset the password
		unset($db->password);
		if(!$db->IsConnected()) throw new Exception("Unable to connect to {$connect}");
		// if debug was specified in the connect string, turn it on!
		$db->debug = in_array('debug', $params) ? true : false;
		
		return $db;
	}//end constructor
}//end DJB_Database
