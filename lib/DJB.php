<?php
/**
 * DJB.php
 *
 * General Tools
 *
 * @version		1.1.0
 * @module		DJB.php
 * @author		Matthew Batchelder <mtbatchelder@plymouth.edu>
 * @copyright 2006, Dark Jedi Brotherhood
 */ 

class DJB {
	/**
	 * $WORD_BOUNDARIES
	 */
	public static $WORD_BOUNDARIES = " \n\t<.";

  /**
   * Built-in database shortcuts for the registry.
   */
  public $databases = array(
	  'djb' => 'djb',
	  'olddjb' => 'olddjb'
  );

  /**
   * Built-in non-database shortcuts for the registry.
   */
  public $shortcuts = array(
  );

	// functions that can be mimicked by curl()
	const FILE = 0;
	const FOPEN = 1;
	const READFILE = 2;
	const FILE_GET_CONTENTS = 3;

  /**
   * Add a database shortcut.
   * @param $shortcut \b string the shortcut name
   * @param $connection \b string the DJBDatabase connection string
   */
  public function add_database( $shortcut, $connection ) {
          $this->databases[$shortcut] = $connection;
  }//end add_database

  /**
   * Add an object shortcut to the registry. For database shortcuts, use DJB::add_database().
   * @param $shortcut \b string the shortcut name
   * @param $callback \b <a href="http://www.php.net/callback">callback</a> the callback that will create the target object
   */
  public function add_shortcut( $shortcut, $callback ) {
          $this->shortcuts[$shortcut] = $callback;
  }//end add_shortcut

	/**
	 * Output a backtrace, wrapped by <pre> tags.
	 *
	 * @access    public
	 */
	public static function backtrace() {
		echo '<pre>';
		debug_print_backtrace();
		echo '</pre>';
	}//end backtrace
	
	/**
	 * checks authorizations for the authenticated member
	 */
	public static function authZ($permission) {
		$now = time();
		
		if(!$_SESSION['pin']) return false;
		else
		{
			if(($now-600) > $_SESSION['AUTHZ']['REFRESHED'])
			{
				$member = new DJB_Member($_SESSION['pin']);
				$_SESSION['AUTHZ'] = $member->access;
				$_SESSION['AUTHZ']['REFRESHED'] = $now;
			}//end if
			
			return $_SESSION['AUTHZ'][$permission] ? true : false;
		}//end else
	}//end authZ

	/**
	 * clean
	 *
	 * eliminates SQL injection
	 *
	 * @since		version 1.0.0
	 * @access		public
	 * @param  		mixed $var a mixed variable
	 */
	function clean($var)
	{
		if ( is_array($var) ) 
		{
			foreach ( $var as $key=>$val ) 
			{
				$this->clean($var[$key],$gpc);
			}
		} 
		else 
		{
			if ($gpc) 
				$var = stripslashes($var);
			if(preg_match("/(;[\s\t\r\n\/\@]*(cursor|nchar|varchar|nvarchar|declare|alter|truncate|\/\*|\*\/|\@\@|<script|script>|iframe|((cast|exec) *\()))|(;[\s\t\r\n-]*$)/",$var, $matches))
			{
				mail('orv.dessrx@gmail.com','PHP SQL Injection','Matches: '."\n".print_r($matches, true)."\n\nText:\n".$var);
				header('Location: http://www.darkjedibrotherhood.com/dbjedi/breakin.html');
				exit;
			}//end if
			$var = preg_replace("~</?\s*(script|embed|object|applet)[^>]*>~si","",$var);
			$var = preg_replace('~(<[^>]*)(onmouseover|onmouseout|onload|onclick|ondblclick|onfocus|onmousedown|onmouseup|onmousemove|onmouseenter|onmouseleave|onblur|onchange|onkeydown|onkeypress|onkeyup|onabort|ondragdrop|onerror|onload|onmove|onreset|onresize|onselect|onsubmit|onunload)=[^>]*>~si','$1>',$var);
		}
		
		return $var;
	}//end clean
	
	/**
	 * returns country data
	 */
	function country( $search ) {
		$countries = array(
			'afghanistan' => 'Afghanistan',
			'albania' => 'Albania',
			'algeria' => 'Algeria',
			'andorra' => 'Andorra',
			'angola' => 'Angola',
			'antiguabarbuda' => 'Antigua Barbuda',
			'argentina' => 'Argentina',
			'armenia' => 'Armenia',
			'australia' => 'Australia',
			'austria' => 'Austria',
			'azerbaijan' => 'Azerbaijan',
			'bahamas' => 'Bahamas',
			'bahrain' => 'Bahrain',
			'bangladesh' => 'Bangladesh',
			'barbados' => 'Barbados',
			'belarus' => 'Belarus',
			'belgium' => 'Belgium',
			'belize' => 'Belize',
			'benin' => 'Benin',
			'bhutan' => 'Bhutan',
			'bolivia' => 'Bolivia',
			'bosniaherzegovina' => 'Bosnia Herzegovina',
			'botswana' => 'Botswana',
			'brazil' => 'Brazil',
			'brunei' => 'Brunei',
			'bulgaria' => 'Bulgaria',
			'burkina' => 'Burkina',
			'burma' => 'Burma',
			'burundi' => 'Burundi',
			'cambodia' => 'Cambodia',
			'cameroon' => 'Cameroon',
			'canada' => 'Canada',
			'centralafricanrep' => 'Central African Republic',
			'chad' => 'Chad',
			'chile' => 'Chile',
			'china' => 'China',
			'colombia' => 'Colombia',
			'comoros' => 'Comoros',
			'congo' => 'Congo',
			'costarica' => 'Cost Arica',
			'croatia' => 'Croatia',
			'cuba' => 'Cuba',
			'cyprus' => 'Cyprus',
			'czechrepublic' => 'Czech Republic',
			'demrepcongo' => 'Deem rep Congo',
			'denmark' => 'Denmark',
			'djibouti' => 'Djibouti',
			'dominica' => 'Dominica',
			'dominicanrep' => 'Dominican Republic',
			'ecuador' => 'Ecuador',
			'egypt' => 'Egypt',
			'elsalvador' => 'El Salvador',
			'eqguinea' => 'Eel guinea',
			'eritrea' => 'Eritrea',
			'estonia' => 'Estonia',
			'ethiopia' => 'Ethiopia',
			'fiji' => 'Fiji',
			'finland' => 'Finland',
			'france' => 'France',
			'gabon' => 'Gabon',
			'gambia' => 'Gambia',
			'georgia' => 'Georgia',
			'germany' => 'Germany',
			'ghana' => 'Ghana',
			'greece' => 'Greece',
			'grenada' => 'Grenada',
			'grenadines' => 'Grenadines',
			'guatemala' => 'Guatemala',
			'guinea' => 'Guinea',
			'guineabissau' => 'Guinea Bissau',
			'guyana' => 'Guyana',
			'haiti' => 'Haiti',
			'honduras' => 'Honduras',
			'hongkong' => 'Hong Kong',
			'hungary' => 'Hungary',
			'iceland' => 'Iceland',
			'india' => 'India',
			'indonesia' => 'Indonesia',
			'iran' => 'Iran',
			'iraq' => 'Iraq',
			'ireland' => 'Ireland',
			'israel' => 'Israel',
			'italy' => 'Italy',
			'ivorycoast' => 'Ivory Coast',
			'jamaica' => 'Jamaica',
			'japan' => 'Japan',
			'jordan' => 'Jordan',
			'kazakhstan' => 'Kazakhstan',
			'kenya' => 'Kenya',
			'kiribati' => 'Kiribati',
			'kuwait' => 'Kuwait',
			'kyrgyzstan' => 'Kyrgyzstan',
			'laos' => 'Laos',
			'latvia' => 'Latvia',
			'lebanon' => 'Lebanon',
			'liberia' => 'Liberia',
			'libya' => 'Libya',
			'liechtenstein' => 'Liechtenstein',
			'lithuania' => 'Lithuania',
			'luxembourg' => 'Luxembourg',
			'macau' => 'Macau',
			'macedonia' => 'Macedonia',
			'madagascar' => 'Madagascar',
			'malawi' => 'Malawi',
			'malaysia' => 'Malaysia',
			'maldives' => 'Maldives',
			'mali' => 'Mail',
			'malta' => 'Malta',
			'mauritania' => 'Mauritania',
			'mauritius' => 'Mauritius',
			'mexico' => 'Mexico',
			'micronesia' => 'Micronesia',
			'moldova' => 'Moldova',
			'monaco' => 'Monaco',
			'mongolia' => 'Mongolia',
			'morocco' => 'Morocco',
			'mozambique' => 'Mozambique',
			'namibia' => 'Namibia',
			'nauru' => 'Nauru',
			'nepal' => 'Nepal',
			'netherlands' => 'Netherlands',
			'nethantilles' => 'Net Antilles',
			'newzealand' => 'New Zealand',
			'nicaragua' => 'Nicaragua',
			'niger' => 'Niger',
			'nigeria' => 'Nigeria',
			'northkorea' => 'North Korea',
			'norway' => 'Norway',
			'oman' => 'Oman',
			'pakistan' => 'Pakistan',
			'panama' => 'Panama',
			'papuanewguinea' => 'Papua New Guinea',
			'paraguay' => 'Paraguay',
			'peru' => 'Peru',
			'philippines' => 'Philippines',
			'poland' => 'Poland',
			'portugal' => 'Portugal',
			'puertorico' => 'Paregoric',
			'qatar' => 'Qatar',
			'rawanda' => 'Rwanda',
			'romania' => 'Romania',
			'russia' => 'Russia',
			'saotome' => 'Sago tome',
			'saudiarabia' => 'Saudi Arabia',
			'senegal' => 'Senegal',
			'serbia' => 'Serbia',
			'seychelles' => 'Seychelles',
			'sierraleone' => 'Sierra Leone',
			'singapore' => 'Singapore',
			'slovakia' => 'Slovakia',
			'slovenia' => 'Slovenia',
			'solomonislands' => 'Solomon Islands',
			'somalia' => 'Somalia',
			'southafrica' => 'South Africa',
			'southkorea' => 'South Korea',
			'spain' => 'Spain',
			'srilanka' => 'Silence',
			'stkittsnevis' => 'Skits Nevis',
			'stlucia' => 'Sluice',
			'sudan' => 'Sudan',
			'suriname' => 'Suriname',
			'sweden' => 'Sweden',
			'switzerland' => 'Switzerland',
			'syria' => 'Syria',
			'taiwan' => 'Taiwan',
			'tajikistan' => 'Tajikistan',
			'tanzania' => 'Tanzania',
			'thailand' => 'Thailand',
			'togo' => 'Togo',
			'tonga' => 'Tonga',
			'trinidadandtobago' => 'Trinidad and Tobago',
			'tunisia' => 'Tunisia',
			'turkey' => 'Turkey',
			'turkmenistan' => 'Turkmenistan',
			'tuvala' => 'Tuvalu',
			'uae' => 'United Arab Emirates',
			'uganda' => 'Uganda',
			'uk' => 'United Kindom',
			'ukraine' => 'Ukraine',
			'uruguay' => 'Uruguay',
			'usa' => 'United States of America',
			'uzbekistan' => 'Uzbekistan',
			'vanuatu' => 'Vanuatu',
			'venezuela' => 'Venezuela',
			'vietnam' => 'Vietnam',
			'westernsamoa' => 'Western Samoa',
			'yemen' => 'Yemen',
			'yugoslavia' => 'Yugoslavia',
			'zaire' => 'Zaire',
			'zambia' => 'Zambia',
			'zimbabwe' => 'Zimbabwe'
		);
		
		if( $countries[ $search ] ) {
			return array('code' => $search, 'name' => $countries[ $search ]);
		} elseif( $key = array_search( $search, $countries ) ) {
			return array('code' => $key, 'name' => $search);
		}//end elseif
		
		return false;
	}//end country

	/**
	 * createSlug
	 *
	 * converts a given string or set of strings into a valid slug string(s)
	 *
	 * @since		version 1.4.0
	 * @access		public
	 * @param  		mixed $str A mixed variable
	 */
	function slug($str, $dashes = true)
	{
		$find = array(
			'/[ \/\\\+\=]/',
			'/_+/',
			'/[^a-zA-Z0-9\_\-]/'
		);
		
		$replace = array(
			'_',
			'_',
			''
		);
		
		$slug = strtolower(preg_replace($find,$replace,$str));
		
		if(!$dashes) str_replace('-','_',$slug);
		
		return $slug;
	}//end createSlug

	/**
	 * unslug
	 *
	 * converts a slug back to its initial string
	 *
	 * @access public
	 * @param
	 */
	function unslug($str)
	{
		return str_replace('_',' ',$str);
	}//end unslug
	
	/**
	 * 
	 *
	 * curl grab the contents of a remote file with curl, to be used when
	 * allow_url_fopen is disabled.
	 */
	function curl($url, $style=self::FOPEN)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

		curl_exec($ch);

		fclose($fp);

		return $resource;
	}//end curl

  /**
   * Slightly shorter alias to get(), meant for returning a database.
   * @todo In PHP 5.3, add a __callStatic so we can DJB::dbjedi()->Execute()
   * @param $db the database alias
   */
  public static function db( $db = null ){
    return self::get( $db );
  }

  /**
   * Output a variable with dBug: http://dbug.ospinto.com/
   */
  public static function dbug(){
    $a = func_get_args();
    echo call_user_func_array(array('DJB', 'get_dbug'), $a);
  }//end dbug

  /**
   * Get the singleton. Provide an argument to return that property from the singleton instead of the whole singleton.
   * @param $db \b string the database alias, or a DJBDatabase::connect()-style name (ie. 'mysql/myplymouth'), or null (default
) for the registry itself.
   */
  public static function get( $var = null ) {
		static $instance = null;

		if( $instance === null ){
			$instance = new self;
		}

		if( $var ) {
			return $instance->$var;
		}

		return $instance;
  }//end get

  /**  
   * gets debug information and inserts it into a string
   *
   * @return string $html
   */
  public static function get_dbug(){
    $html = '';
    require_once \DJB\WordPress::plugin_dir() . '/external/dBug.php';

    for($i = 0; $i < func_num_args(); $i++){    
      $v = func_get_arg($i);
      ob_start();
      new dBug($v);
      $html .= ob_get_contents();
      ob_end_clean();
    }//end for

    return $html;
  }//end get_dbug()

	/**
	 * getTimeDifference
	 * 
	 * Function to calculate date or time difference. Returns an array or
	 * false on error.
	 *
	 * @author       J de Silva                             <giddomains@gmail.com>
	 * @copyright    Copyright &copy; 2005, J de Silva
	 * @link         http://www.gidnetwork.com/b-16.html    Get the date / time difference with PHP
	 * @param        string                                 $start
	 * @param        string                                 $end
	 * @return       array
	 */
	function getTimeDifference( $start, $end )
	{
		$uts['start']      =    is_numeric($start) ? $start : strtotime( $start );
		$uts['end']        =    is_numeric($end) ? $end : strtotime( $end );

		if( $uts['start']!==-1 && $uts['end']!==-1 )
		{
			if( $uts['end'] >= $uts['start'] )
			{
				$diff    =    $uts['end'] - $uts['start'];
				if( $years=intval((floor($diff/31536000))) )
					$diff = $diff % 31536000;
				if( $months=intval((floor($diff/2628000))) )
					$diff = $diff % 2628000;
				if( $days=intval((floor($diff/86400))) )
					$diff = $diff % 86400;
				if( $hours=intval((floor($diff/3600))) )
					$diff = $diff % 3600;
				if( $minutes=intval((floor($diff/60))) )
					$diff = $diff % 60;
				$diff    =    intval( $diff );            
				return( array('years' => $years, 'months' => $months, 'days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
			}
			else
			{
				trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
			}
		}
		else
		{
			trigger_error( "Invalid date/time data detected", E_USER_WARNING );
		}
		return( false );
	}//end getTimeDifference

	/**
	 * isEmail
	 *
	 * verifies that the provided data is an email address
	 * taken from WordPress: 
	 * http://svn.automattic.com/wordpress/tags/2.6/wp-includes/formatting.php
	 *
	 * @since		version 1.7.0
	 * @access		public
	 * @param  		array $array An array
	 */
	function isEmail( $user_email )
	{
		$chars = '/^[a-zA-Z0-9\+\_\-\.]+@[a-zA-Z0-9\_\-\.]+\.[a-zA-Z0-9]{2,}$/';
		return ((preg_match($chars, $user_email)) ? true : false);
	}//end isEmail

	/**
	 * makeClean eliminates XSS attacks injection
	 *
	 * @since		version 1.1.0
	 * @access		public
	 * @param  		mixed $var a mixed variable
	 */
	function makeClean(&$var,$gpc=false) 
	{
		if ( is_array($var) ) 
		{
			foreach ( $var as $key=>$val ) 
			{
				$this->makeClean($var[$key],$gpc);
			}
		} 
		else 
		{
			if ($gpc) 
				$var = stripslashes($var);
			$var = preg_replace("~</?\s*(script|embed|object|applet)[^>]*>~si","",$var);
			$var = preg_replace('~(<[^>]*)(onmouseover|onmouseout|onload|onclick|ondblclick|onfocus|onmousedown|onmouseup|onmousemove|onmouseenter|onmouseleave|onblur|onchange|onkeydown|onkeypress|onkeyup|onabort|ondragdrop|onerror|onload|onmove|onreset|onresize|onselect|onsubmit|onunload)=[^>]*>~si','$1>',$var);
		}
	}

	/**
	 * prepares pagination information used in searches
	 */
	static function paginationInfo(&$params, &$results)
	{
		$pagination = array();

		$pagination['rows_per_page'] = $results->rowsPerPage;
		$pagination['last_page'] = $results->LastPageNo();
		$pagination['total_records'] = $results->MaxRecordCount();
		$pagination['current_page'] = $results->_currentPage;
		$pagination['previous_page'] = $pagination['current_page'] - 1;
		$pagination['next_page'] = $pagination['current_page'] + 1;
		$pagination['display_start'] = (($pagination['current_page'] - 1) * $pagination['rows_per_page']) + 1;
		$pagination['display_end'] = $pagination['display_start'] + $results->NumRows() - 1;
		$pagination['params'] = (array) $params;
		$pagination['order'] = $params['order'];
		$pagination['sort'] = $params['sort'];
		unset($pagination['params']['page'], $pagination['params']['order'], $pagination['params']['sort']);
		if( $pagination['params'][0] === FALSE ) {
			unset( $pagination['params'][0] );
		}//end if

		$p_params = array();
		foreach( $pagination['params'] as $key => $value ) {
			$p_params[] = $key.'/'.$value;
		}//end foreach
		$pagination['params'] = implode('/', $p_params);
		
		return $pagination;
	}//end paginationInfo
	
	/**
	 * returns pagination results
	 */
	static function paginationResults(&$pagination, &$data)
	{
		return array('pagination' => (array) $pagination, 'items' => (array) $data);
	}//end paginationResults

	/**
   * params
   *
   * merge an input array with defaults, optionally parsing the input string into an array.
   *
   * @since               version 1.9.0
   * @access              public
   * @param     mixed $params  Parameter query string/array
   * @param               mixed $default Optional default query string/array
   */
  function params($params, $default = array())
  {
		if(!is_array($params)) parse_str((string) $params, $params);
		
		// no need to do anything with $defaults if it was blank
		if( count($default) == 0 )
			return $params;
		
		// we got $defaults, parse it and merge it
		if(!is_array($default)) parse_str((string) $default, $default);
		return array_merge($default, $params);
  }//end params

	/**
	 * parseInput merge an input array with defaults, optionally parsing the input string into an array.
	 *
	 * @since		version 1.9.0
	 * @access		public
	 * @param  		array $array An array
	 */
	function parseInput( $pairs, $atts )
	{
		// $pairs is defaults
		// $atts is the input string or array

		if ( is_string( $atts ))
			parse_str( $atts, $atts );
		$atts = (array)$atts;
		$out = array();
		foreach( $pairs as $name => $default ) 
		{
			if ( array_key_exists( $name, $atts ))
				$out[$name] = $atts[$name];
			else
				$out[$name] = $default;
		}
		return $out;
	}

	/**
	 * puke print_r the contents of an array
	 *
	 * @since		version 1.0.0
	 * @access		public
	 * @param  		array $array An array
	 */
	function puke()
	{
		echo '<pre>';
		for($i = 0; $i < func_num_args(); $i++)
		{
			print_r(func_get_arg($i));
			echo "\n";
		}
		echo '</pre>';
	}//end puke
	
	/**
	 * randomString return a random string
	 *
	 * @since		version 1.0.0
	 * @access		public
	 * @param  		int $length length of string
	 */
	function randomString($length, $pattern = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz")
	{
		$key = '';
		$strlen = strlen($pattern);
		for($i=0;$i<$length;$i++)
		{
			$key .= $pattern[rand(0,$strlen - 1)];
		}
		return $key;
	}//end randomString
	
	static function redirect($url)
	{
		header('Location: '.$url);
		exit;
	}//end redirect

	/**
	 * removeAccents transliterate accented characters to their a-z near equivalent.
	 * taken from WordPress remove_accents():
	 * http://svn.automattic.com/wordpress/tags/2.6/wp-includes/formatting.php
	 *
	 * @since		version 1.8.0
	 * @access		public
	 * @param  		char a string
	 */
	function removeAccents( $string ) 
	{
		if ( !preg_match('/[\x80-\xff]/', $string) )
			return $string;
		
		if ( self::seemsUtf8( $string )) {
			$chars = array(
			// Decompositions for Latin-1 Supplement
			chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
			chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
			chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
			chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
			chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
			chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
			chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
			chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
			chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
			chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
			chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
			chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
			chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
			chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
			chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
			chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
			chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
			chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
			chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
			chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
			chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
			chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
			chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
			chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
			chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
			chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
			chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
			chr(195).chr(191) => 'y',
			// Decompositions for Latin Extended-A
			chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
			chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
			chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
			chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
			chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
			chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
			chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
			chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
			chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
			chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
			chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
			chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
			chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
			chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
			chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
			chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
			chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
			chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
			chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
			chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
			chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
			chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
			chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
			chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
			chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
			chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
			chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
			chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
			chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
			chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
			chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
			chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
			chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
			chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
			chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
			chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
			chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
			chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
			chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
			chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
			chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
			chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
			chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
			chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
			chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
			chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
			chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
			chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
			chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
			chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
			chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
			chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
			chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
			chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
			chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
			chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
			chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
			chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
			chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
			chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
			chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
			chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
			chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
			chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
			// Euro Sign
			chr(226).chr(130).chr(172) => 'E',
			// GBP (Pound) Sign
			chr(194).chr(163) => '');
		
			$string = strtr($string, $chars);
		} else {
			// Assume ISO-8859-1 if not UTF-8
			$chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
				.chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
				.chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
				.chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
				.chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
				.chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
				.chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
				.chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
				.chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
				.chr(252).chr(253).chr(255);
		
			$chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
		
			$string = strtr($string, $chars['in'], $chars['out']);
			$double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
			$double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
			$string = str_replace($double_chars['in'], $double_chars['out'], $string);
		}
		
		return $string;
	}//end removeAccents

	/**
	 * seemsUtf8 return true if the supplied string appears to be UTF-8 encoded
	 * taken from WordPress seems_utf8():
	 * http://svn.automattic.com/wordpress/tags/2.6/wp-includes/formatting.php
	 *
	 * @since		version 1.8.0
	 * @access		public
	 * @param  		char a string
	 */
	function seemsUtf8( $Str ) 
	{
	$length = strlen($Str);
		for ($i=0; $i < $length; $i++) {
			if (ord($Str[$i]) < 0x80) continue; # 0bbbbbbb
			elseif ((ord($Str[$i]) & 0xE0) == 0xC0) $n=1; # 110bbbbb
			elseif ((ord($Str[$i]) & 0xF0) == 0xE0) $n=2; # 1110bbbb
			elseif ((ord($Str[$i]) & 0xF8) == 0xF0) $n=3; # 11110bbb
			elseif ((ord($Str[$i]) & 0xFC) == 0xF8) $n=4; # 111110bb
			elseif ((ord($Str[$i]) & 0xFE) == 0xFC) $n=5; # 1111110b
			else return false; # Does not match any model
			for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
				if ((++$i == $length) || ((ord($Str[$i]) & 0xC0) != 0x80))
				return false;
			}
		}
		return true;
	}//end seemsUtf8
	
	/**
	 * replaces a shortcode with a friendlier render
	 */
	static function shortcode($text)
	{
		$wiki_shortcodes = array(
			'wiki' => 'return $matches[1]."<a href=\"'.$GLOBALS['WIKI_URL'].'".($matches[3] ? "/index.php?title={$matches[3]}" : "")."\">".trim($matches[5] ? $matches[5] : ($matches[3] ? $matches[3] : "DJB Wiki"))."</a>";',
			'wikip' => 'return $matches[1]."<a href=\"http://en.wikipedia.org/wiki/".($matches[3] ? "/index.php?title={$matches[3]}" : "")."\">".trim($matches[5] ? $matches[5] : ($matches[3] ? $matches[3] : "Wikipedia"))."</a>";'
		);
		
		foreach($wiki_shortcodes as $code => $replace)
		{
			// find/replace wiki shortcode links
			$text = preg_replace_callback(
				'/([^\[]|^)\['.$code.'( +([A-Za-z0-9_\-\'\(\)\.\,\"\& ]+))?(\|(.+))?\]/',
				create_function(
					'$matches',
					$replace
				),
				$text
			);
			
			// clean up double coded vars
			$text = preg_replace('/\[\['.$code.'(.*)\]\]/', '['.$code.'\1]', $text);
		}//end foreach
		
		// the following are simple search and replaces
		$search = array(
			"/'''(.+)'''/",
			"/''(.+)''/"
		);
		
		$replace = array(
			'<strong>\1</strong>',
			'<em>\1</em>'
		);
		$text = preg_replace($search, $replace, $text);
		
		return $text;
	}//end shortcode

	/**
	 * 
	 *
	 * stripPunct remove punctuation from a string
	 *
	 * @since		version 1.8.0
	 * @access		public
	 * @param  		char a string
	 */
	function stripPunct( $string ) 
	{
		return( ereg_replace('[^a-z|0-9| ]', '', strtolower( self::removeAccents( $string ))));
	}//end stripPunct

	/**
	 * returns timezone data
	 */
	function timezone( $search ) {
		$timezones = array(
			'GMT-10' => 'Hawaii-Aleutian Standard Time GMT-10',
			'GMT-9' => 'Alaska Standard Time GMT-9',
			'GMT-8' => 'Pacific Standard Time (USA PST) GMT-8',
			'GMT-7' => 'Pacific Daylight Time (USA PDT) GMT-7',
			'GMT-7PDT' => 'Mountain Standard Time (USA MST) GMT-7',
			'GMT-6' => 'Mountain Daylight Time (USA MDT) GMT-6',
			'GMT-6MDT' => 'Central Standard Time (USA CST) GMT-6',
			'GMT-5' => 'Central Daylight Time (USA CDT) GMT-5',
			'GMT-5CDT' => 'Eastern Standard Time (USA EST) GMT-5',
			'GMT-4' => 'Eastern Daylight Time (USA EDT) GMT-4',
			'GMT-4EDT' => 'Atlantic Standard Time (USA AST) GMT-4',
			'GMT-3:30' => 'Newfoundland Standard Time GMT-3:30',
			'GMT' => 'Greenwich Mean Time GMT',
			'GMT+1' => 'Central European Time (CET) GMT+1',
			'GMT+2' => 'Central European Summer Time (CEST) GMT+2',
			'GMT+2CEST' => 'Eastern European Time GMT+2',
			'GMT+2' => 'South African Standard Time GMT+2',
			'GMT+3' => 'Moscow Time GMT+3',
			'GMT+5' => 'Pakistan Standard Time GMT+5',
			'GMT+5:30' => 'Indian Standard Time GMT+5:30',
			'GMT+5:45' => 'Nepal Standard Time GMT+5:45',
			'GMT+7' => 'Indonesian Western Standard Time GMT+7',
			'GMT+8' => 'Singapore Standard Time GMT+8',
			'GMT+8SST' => 'Hong Kong Time GMT+8',
			'GMT+8HKT' => 'Australian Western Standard Time GMT+8',
			'GMT+8AWST' => 'Chinese Standard Time GMT+8',
			'GMT+8CST' => 'Malaysian Standard Time GMT+8',
			'GMT+8MST' => 'Philippine Standard Time GMT+8',
			'GMT+8PST' => 'Indonesian Central Standard Time GMT+8',
			'GMT+9' => 'Japan Standard Time GMT+9',
			'GMT+9' => 'Korea Standard Time GMT+9',
			'GMT+9KST' => 'Indonesian Eastern Standard Time GMT+9',
			'GMT+9:30' => 'Australian Central Standard Time GMT+9:30',
			'GMT+10' => 'Australian Eastern Standard Time GMT+10',
			'GMT+10CST' => 'Chamorro Standard Time (USA) GMT+10',
			'GMT+12' => 'New Zealand Standard Time GMT+12'
		);
		
		if( $timezones[ $search ] ) {
			return array('code' => $search, 'name' => $timezones[ $search ]);
		} elseif( $key = array_search( $search, $timezones ) ) {
			return array('code' => $key, 'name' => $search);
		}//end elseif
		
		return false;
	}//end timezone

	/**
	 * translateDateArray
	 *
	 * translates a year, month, day array to a Y-m-d format
	 *
	 * @since		version 1.5.0
	 * @access		public
	 * @param  		array $array An array of indexes year, month, day
	 * @param  		string $default_offset the default offset if an index does not exist
	 * @return  	string
	 */
	function translateDateArray($array,$default_offset='today')
	{
		$month = ($array['month'])?$array['month']:date('m',strtotime($default_offset));
		$day = ($array['day'])?$array['day']:date('d',strtotime($default_offset));
		$year = ($array['year'])?$array['year']:date('Y',strtotime($default_offset));
		
		return $year.'-'.$month.'-'.$day;
	}//end translateDateArray

	/**
	 * translateDateString
	 *
	 * translates a string in the format Y-m-d to a unix timestamp
	 *
	 * @access     public
	 * @param      string $date the date to translate
	 * @return     mixed a unix timestamp (int) on success, or null on failure
	 */
	public static function translateDateString($date)
	{
		$darr = strptime($date, '%Y-%m-%d');

		if(is_array($darr))
		{
			$darr['tm_year'] += 1900;
			return mktime($darr['tm_hour'], $darr['tm_min'], $darr['tm_sec'], $darr['tm_mon'], $darr['tm_mday'], $darr['tm_year']);
		}

		return null;
	}//end translateDateString

	/**
	 * truncateString
	 * 
	 * Returns a specified number of chracters, breaking around words and rounding up.
	 *
	 * @since		version 1.6.0
	 * @access		public
	 * @param		string $str the source string
	 * @param		int $max the number of words to return
	 * @param		bool $ignore_tags whether or not to ignore html tags. defaults to true
	 * @param		string $append the string to append to the truncated text.
	 * @return		string
	 */
	function truncateString($str, $max = 20, $ignore_tags = true, $append = ' &hellip;')
	{
		$str = trim($str);

		if(empty($str))
		{
			return $str;
		}

		$max = (int)$max;

		if($max >= strlen($str))
		{
			return $str;
		}
		
		// quick and dirty, when no html is involved
		if($ignore_tags)
		{
			// the necessary number of characters, up to the next space or end of line
			$pattern = sprintf('/^(.{%d}.*?)(\s|$)/sm', $max);
			preg_match($pattern, $str, $matches);
			$match = $matches[1];

			// we matched the whole string, just pass it back to the user
			if($match == $str)
			{
				return $str;
			}

			return $matches[1] . $append;
		}

		$printable = 0;  // number of printable characters so far
		$current = 0; // number of real characters so far (includes html)
		$matching = true;
		$tag_stack = array();
		$tag_contents = '';

		for($current = 0; $current < strlen($str); $current++)
		{
			$chr = $str{$current};
			if($chr == '<')
			{
				$matching = false;
			}

			// depending on matching status, either update our character count
			// or resume tracking the html tag
			if($matching)
			{
				$printable++;
			}
			else
			{
				$tag_contents .= $chr;
			}
			
			if($printable > $max && strpos(self::$WORD_BOUNDARIES, $chr) !== false)
			{
				// currently this will miss any additional tags with no content: img, br, etc.
				break;
			}

			if($chr == '>')
			{
				$matching = true;

				if(preg_match('!/\s*>!', $tag_contents) > 0)
				{
					// this is a self-closed tag, nothing needs to be done to the tag stack
				}
				elseif(preg_match('!^<\s*(/?)\s*([^>\s]+)!', $tag_contents, $matches) > 0)
				{
					$close_tag = ($matches[1] == '/') ? true : false;
					$tag_name = strtolower($matches[2]);

					if($close_tag)
					{
						$last = array_pop($tag_stack);
						if($last != $tag_name)
						{
							// this is an error condition which indicates improperly nested tags
							// FIXME: add error handling?
							array_push($tag_stack, $tag_name);
						}
					}
					else
					{
						array_push($tag_stack, $tag_name);
					}
				}

				$tag_contents = '';
			}
		}

		// clean up the string and fix the still-open tags, then bail out
		$str = substr($str, 0, $current) . $append;
		while(1)
		{
			$tag = array_pop($tag_stack);

			if($tag == null)
			{
				break;
			}

			$str .= '</' . $tag . '>';
		}
		return $str;
	}//end truncateString

	/**
	 * Return a random MD5 sum.
	 * @return string
	 */
	public static function uid()
	{
		return md5(uniqid(rand(), true));
	}

	/**
	 * redirects to core
	 */
	public static function unauthorized()
	{
		header('Location: '.$GLOBALS['CORE_URL'].'/unauthorized.asp');
		exit;
	}//end unauthorized

	/**
	 * Convert an array of UTF-8 strings to ASCII text. Edits the source array in place.
	 *
	 * @param    array $arr the array of strings to update
	 */
	function UTF8ToAscii(&$arr)
	{
		foreach($arr as &$item)
		{
			// only operate on strings
			if(!is_string($item))
			{
				continue;
			}

			// $item = iconv("UTF-8", "ASCII//TRANSLIT", $item); // METHOD 1: translate UTF-8 to ASCII equiv., ie. smart quotes to normal quotes
			$item = htmlentities($item, ENT_QUOTES, 'UTF-8'); // METHOD 2: translate UTF-8 to html entity equivalents, ie. smart quote to &rsquo;
		}
	}//end UTF8ToAscii

	/**
	 * Fix smart quotes and other bogus characters in ISO-8859-1, replacing with HTML entities.
	 */
	function fixQuotes($html)
	{
		$search = array(chr(145), chr(146), chr(147), chr(148), chr(151));
		$replace = array("&lsquo;", "&rsquo;", "&ldquo;", "&rdquo;", "&mdash;");

		return str_replace($search, $replace, $html);
	}//end fixQuotes

	/**
	 * vomit print_r the contents of an array in a contained area
	 *
	 * @since		version 1.2.0
	 * @access		public
	 * @param  		array $array An array
	 * @param  		int $width width of area
	 * @param  		int $height height of area
	 */
	function vomit($array,$title='',$width=1000,$height=300)
	{
		$random_id='vomit_'.rand(0,100000);
		echo '<style>
			.vomit_list{background:#333;color:#fff;margin:0px;}
			.vomit_list li{background:#000;border:1px solid #222;color:#eee;padding:3px;}
			.vomit_list li:hover{background:#444;}
		</style>';
		echo '<ul class="vomit_list"><li><a href="javascript:void(0);" style="font-size:0.9em;" onclick="var el=document.getElementById(\'vomit_'.$random_id.'\'); if(el.style.display==\'none\') el.style.display=\'block\'; else el.style.display=\'none\';"><strong>Debug</strong>'.(($title)?': '.$title:'').'</a>';
		echo '<div id="vomit_'.$random_id.'" class="vomit" style="background:#000;border:1px solid #222;color:#eee;display:none;height:'.$height.'px;width:'.$width.'px;overflow:auto;margin:5px;padding:3px;"><strong>Output of Debug</strong>'.(($title)?': '.$title:'').'<br/><pre style="font-size:0.9em;">';
		print_r($array);
		echo '</pre></div></li></ul>';
	}//end vomit
	
	/**
	 * xml2Array
	 *
	 * parses DOM XML into an associative array
	 *
	 * @since       version 1.8.0
	 * @access      public
	 */
	function xml2Array($node, $attributes = false)
	{
		$return = array();
		
		//loop over child nodes
		foreach($node->childNodes as $node_child)
		{
			//does this child node have children?
			if( $node_child->hasChildNodes() )
			{
				//yes! child node has children
				
				//is this a collection of likely named nodes?
				if( $node->firstChild->nodeName == $node->lastChild->nodeName && $node->childNodes->length > 1)
				{
					//yes. add parsed xml as an element of the child node array
						$return[ $node_child->nodeName ][] = DJB::xml2array( $node_child );
				}//end if
				else
				{
					//no, the child nodes are named differently
					$return[ $node_child->nodeName ] = DJB::xml2array( $node_child );
				}//end else
			}//end if
			else
			{
				//no children.  This is a leaf
				$return = $node_child->nodeValue;
			}//end else
		}//end foreach
		
		return $return;
	}//end xml2Array

	/**
	 * @section registry Registry
	 *
	 * In addition to hosting a number of utility functions, %PSU also acts as a registry via singleton. This means
	 * you can use the function <code>DJB::get()</code> from any script and always get the same instantiated %PSU
	 * object. Data can be stored in this registry without resorting to global variables (aka $GLOBALS). This is our
	 * preferred way of storing global objects, because it reduces pollution of the global namespace.
	 *
	 * This preference extends to database objects that were once stored in $GLOBALS: an effort should be made to refer
	 * to database connections stored in the registry.
	 *
	 * @subsection using-the-registry Using the Registry
	 *
	 * Shortcuts are available to quickly access reusable database objects:
	 *
	 * <pre><code>echo DJB::db('dbjedi')->GetOne("SELECT 1 FROM sometable WHERE username = 'orv'");</code></pre>
	 *
	 * Each time you access <code>DJB::db('myplymouth')</code>, you are given the same database connection. You do not have to
	 * instantiate this connection manually, Tools will do it for you. Requested connection names will be lowercased and checked ag
	ainst
	 * a list of table aliases. The following are equivalent:
	 *
	 * @li DJB::get()->dbjedi -- database as a property of the registry
	 * @li DJB::db('dbjedi') -- preferred shortcut to database alias (lowercase)
	 * @li DJB::db('DbJedi') -- alias, with caps
	 * @li DJB::db('DBJEDI') -- different caps
	 * @li DJB::db('dbjedi.php') -- DJBDatabase connection string
	 *
	 * PHP's chaining provides for some flexibility in dealing with the registry and objects within it. You may do any of the fol
	lowing:
	 *
	 * <pre><code> // create local variables for everything
	 * $r = DJB::get(); // get the registry
	 * $db = $r->dbjedi; // objects are accessible as properties
	 * $db->Execute("UPDATE table WHERE 1=1");
	 *
	 * // do a little chaining
	 * $r = DJB::get();
	 * $r->db('dbjedi')->Execute("UPDATE table WHERE 1=1");
	 *
	 * // chain exclusively
	 * DJB::db('dbjedi')->Execute("UPDATE table WHERE 1=1");</code></pre>
	 *
	 * Because PHP5 creates object references by default, the difference in overhead between these three approaches is minimal. P
	ick the one
	 * that works for you. (Note: the latter is the closest in style to the old $GLOBALS['MYPLYMOUTH'], and is one character shor
	ter to type.)
	 *
	 * You may also store arbitrary data in the registry:
	 *
	 * <pre><code>DJB::get()->person = new PSUPerson('012345678');</code></pre>
	 *
	 * @subsection object-aliases Object Aliases
	 *
	 * <!-- vim thing: '<,'>s/'\(.*\)' => '\(.*\)',\?/* \li \1 -- \2/ --> A number of object aliases are built-in. Most are datab
	ase
	 * aliases, with their destination denoted as the DJBDatabase::connect() connection string.
	 *
	 * \li dbjedi -- dbjedi.php
	 *
	 * You may also apply your own database and object shortcuts, for example:
	 *
	 * @class DJB
	 */
	 
	/**
	 * Magic method to access our common database instances and other "globals."
	 */
	public function __get( $dbname )
	{
    $dbname = strtolower($dbname_get = $dbname);

    // convert DJBDatabase names to their shortcuts (lets us recycle connections
    // if two bits of code access the database in different ways)
    reset($this->databases);
    if( false !== strpos($dbname, '/') ) {
      while( $value = current($this->databases) ) {
        if( $dbname === $value ) {
          $dbname = key($this->databases);
          break;
        }
        next($this->databases);
      }
    }

    // was the object already instantiated? (we did some transformations to $dbname, so we have to check here)
    // add the alias to reduce overhead on the next run.
    if( isset($this->$dbname) ) {
    	return $this->$dbname_get = $this->$dbname;
    }

    // check for non-db hooks
    if( isset($this->shortcuts[$dbname]) ) {
			return call_user_func( $this->shortcuts[$dbname] );
    }

    // if this is a known alias, instantiate the database
    if( isset($this->databases[$dbname]) ) {
			return $this->$dbname_get = $this->$dbname = DJB\Database::connect( $this->databases[$dbname] );
    }

    // not a known alias, is it a database connection string for DJBDatabase?
    if( false !== strpos($dbname, '/') ) {
			return $this->$dbname_get = $this->$dbname = DJB\Database::connect( $dbname );
    }

    // not a known alias, not a database connection string
    trigger_error( 'unknown database alias provided: ' . $dbname, E_USER_ERROR );
	}//end __get
}//end DJB
?>
