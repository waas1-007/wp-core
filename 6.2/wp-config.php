<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache




//Begin Really Simple SSL Load balancing fix
if ((isset($_ENV["HTTPS"]) && ("on" == $_ENV["HTTPS"]))
|| (isset($_SERVER["HTTP_X_FORWARDED_SSL"]) && (strpos($_SERVER["HTTP_X_FORWARDED_SSL"], "1") !== false))
|| (isset($_SERVER["HTTP_X_FORWARDED_SSL"]) && (strpos($_SERVER["HTTP_X_FORWARDED_SSL"], "on") !== false))
|| (isset($_SERVER["HTTP_CF_VISITOR"]) && (strpos($_SERVER["HTTP_CF_VISITOR"], "https") !== false))
|| (isset($_SERVER["HTTP_CLOUDFRONT_FORWARDED_PROTO"]) && (strpos($_SERVER["HTTP_CLOUDFRONT_FORWARDED_PROTO"], "https") !== false))
|| (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && (strpos($_SERVER["HTTP_X_FORWARDED_PROTO"], "https") !== false))
|| (isset($_SERVER["HTTP_X_PROTO"]) && (strpos($_SERVER["HTTP_X_PROTO"], "SSL") !== false))
) {
$_SERVER["HTTPS"] = "on";
}
//END Really Simple SSL





//start from here
//get the site id from the env file
//first check for the local file and if not found check for the live file

if( isset($_SERVER['X-WAAS1-TENANT']) ){
	$HOSTENVHEADER = $_SERVER['X-WAAS1-TENANT'];
}else{
	$HOSTENVHEADER = $_SERVER['DOCUMENT_ROOT'];
}

$envVarsFilePath = $HOSTENVHEADER.'/env-vars-dynamic-local.ini'; //first level make sure not to give back slash \ as it will work on windows but will not working on linux. forward slash works on both OS 
if( !file_exists($envVarsFilePath) ) {

	$envVarsFilePath = $HOSTENVHEADER.'/env-vars-dynamic.ini'; //if we are here it means maybe we are using a local test env
	if( !file_exists($envVarsFilePath) ) {
		
		//it means we are in cli or something else
		$envVarsFilePath = 'env-vars-dynamic-local.ini';
		if( !file_exists($envVarsFilePath) ) {
			
			$envVarsFilePath = 'env-vars-dynamic.ini';
			if( !file_exists($envVarsFilePath) ) {
				echo getcwd().' Please setup '.$envVarsFilePath;
				die;
			}
			
			
		}
		
		
	}
}
$evnVars = parse_ini_file( $envVarsFilePath, false, INI_SCANNER_TYPED );







//load wp salts if found
if ( file_exists( $HOSTENVHEADER.'/wp-salts.php' ) ) {
	require_once( $HOSTENVHEADER.'/wp-salts.php' );
}


//load main wp config
require_once( '/var/www/landlord/wp-config.php' );


//load additional wp-config file for constants
if ( file_exists( $HOSTENVHEADER.'/wp-content/wp-config.php' ) ) {
	require_once( $HOSTENVHEADER.'/wp-content/wp-config.php' );
}






/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}


/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

