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
				echo getcwd().' Please setup '.$envVarsFilePath.' - Coming from wp-config.php';
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





















///~~~~!!!!//////
///~~~~!!!!//////
///~~~~!!!!//////

//load main wp config
//define all the ENV constants here
define( 'THIS_ENV_IS_LOCAL', 		$evnVars['THIS_ENV_IS_LOCAL'] );
define( 'THIS_SITE_ID', 			$evnVars['THIS_SITE_ID'] );
define( 'THIS_CONTROLLER_TAG', 		$evnVars['THIS_CONTROLLER_TAG'] );


define( 'WAAS1_PLATFORM_DOMAIN', 	$evnVars['WAAS1_PLATFORM_DOMAIN'] );
define( 'WAAS1_SITE_API_KEY', 		$evnVars['WAAS1_SITE_API_KEY'] );
define( 'WAAS1_SITE_API_URL', 		$evnVars['WAAS1_SITE_API_URL'] );


define( 'WAAS1_DB_HOST', 			$evnVars['WAAS1_DB_HOST'] );
define( 'WAAS1_DB_USER', 			$evnVars['WAAS1_DB_USER'] );
define( 'WAAS1_DB_PASSWORD', 		$evnVars['WAAS1_DB_PASSWORD'] );
define( 'WAAS1_DB_NAME', 			$evnVars['WAAS1_DB_NAME'] );



define( 'WAAS1_WP_HOME', 			$evnVars['WAAS1_WP_HOME'] );
define( 'WAAS1_WP_CONTENT_URL', 	$evnVars['WAAS1_WP_CONTENT_URL'] );
define( 'WAAS1_WP_CONTENT_DIR', 	$evnVars['WAAS1_WP_CONTENT_DIR'] );
define( 'WAAS1_WP_DEBUG_LOG', 		$evnVars['WAAS1_WP_DEBUG_LOG'] );


define( 'PLATFORM_BRAND_LOGO_URL', 		$evnVars['PLATFORM_BRAND_LOGO_URL'] );
define( 'PLATFORM_BRAND_SITE_URL', 		$evnVars['PLATFORM_BRAND_SITE_URL'] );
define( 'PLATFORM_BRAND_NAME', 			$evnVars['PLATFORM_BRAND_NAME'] );



if( isset($evnVars['WAAS1_CLIENT_EMAIL']) ){
	define( 'WAAS1_CLIENT_EMAIL',	$evnVars['WAAS1_CLIENT_EMAIL'] );
}else{
	define( 'WAAS1_CLIENT_EMAIL',	'client@email.com' ); //default to fake email
}


//WAAS1_INJECT_DATA
if( isset($evnVars['WAAS1_INJECT_DATA']) ){
	define( 'WAAS1_INJECT_DATA',	$evnVars['WAAS1_INJECT_DATA'] );
}else{
	define( 'WAAS1_INJECT_DATA',	'[]' ); //default to empty json array
}


//WAAS1_RESTRICTION_GROUP_ID
if( isset($evnVars['WAAS1_RESTRICTION_GROUP_ID']) ){
	define( 'WAAS1_RESTRICTION_GROUP_ID',	$evnVars['WAAS1_RESTRICTION_GROUP_ID'] );
}else{
	define( 'WAAS1_RESTRICTION_GROUP_ID',	1 ); //default to 1
}



//allow plugin install
if( isset($evnVars['WAAS1_RESTRICTION_ALLOW_PLUGINS_INSTALL']) ){
	define( 'WAAS1_RESTRICTION_ALLOW_PLUGINS_INSTALL',	$evnVars['WAAS1_RESTRICTION_ALLOW_PLUGINS_INSTALL'] );
}else{
	define( 'WAAS1_RESTRICTION_ALLOW_PLUGINS_INSTALL',	false ); //default not to allow plugins install
}


//allow plugin activation
if( isset($evnVars['WAAS1_RESTRICTION_ALLOW_PLUGINS_ACTIVATE']) ){
	define( 'WAAS1_RESTRICTION_ALLOW_PLUGINS_ACTIVATE',	$evnVars['WAAS1_RESTRICTION_ALLOW_PLUGINS_ACTIVATE'] );
}else{
	define( 'WAAS1_RESTRICTION_ALLOW_PLUGINS_ACTIVATE',	false ); //default not to allow plugins activation
}



//allow site settings panel
if( isset($evnVars['WAAS1_RESTRICTION_ALLOW_SITE_SETTINGS_MU_PLUGIN']) ){
	define( 'WAAS1_RESTRICTION_ALLOW_SITE_SETTINGS_MU_PLUGIN',	$evnVars['WAAS1_RESTRICTION_ALLOW_SITE_SETTINGS_MU_PLUGIN'] );
}else{
	define( 'WAAS1_RESTRICTION_ALLOW_SITE_SETTINGS_MU_PLUGIN',	false ); //default not to allow site settings
}


//allow themes install
if( isset($evnVars['WAAS1_RESTRICTION_ALLOW_THEMES_INSTALL']) ){
	define( 'WAAS1_RESTRICTION_ALLOW_THEMES_INSTALL',	$evnVars['WAAS1_RESTRICTION_ALLOW_THEMES_INSTALL'] );
}else{
	define( 'WAAS1_RESTRICTION_ALLOW_THEMES_INSTALL',	false ); //default not to allow themes install
}


//allow themes switch
if( isset($evnVars['WAAS1_RESTRICTION_ALLOW_THEMES_SWITCH']) ){
	define( 'WAAS1_RESTRICTION_ALLOW_THEMES_SWITCH',	$evnVars['WAAS1_RESTRICTION_ALLOW_THEMES_SWITCH'] );
}else{
	define( 'WAAS1_RESTRICTION_ALLOW_THEMES_SWITCH',	false ); //default not to allow themes switch
}



if( isset($evnVars['WAAS1_TOTAL_DB_SIZE_MB']) ){
	define( 'WAAS1_TOTAL_DB_SIZE_MB',	$evnVars['WAAS1_TOTAL_DB_SIZE_MB'] );
}else{
	define( 'WAAS1_TOTAL_DB_SIZE_MB',	0 );
}

if( isset($evnVars['WAAS1_TOTAL_APP_SIZE_MB']) ){
	define( 'WAAS1_TOTAL_APP_SIZE_MB',	$evnVars['WAAS1_TOTAL_APP_SIZE_MB'] );
}else{
	define( 'WAAS1_TOTAL_APP_SIZE_MB',	0 );
}

if( isset($evnVars['WAAS1_TOTAL_APP_INODES']) ){
	define( 'WAAS1_TOTAL_APP_INODES',	$evnVars['WAAS1_TOTAL_APP_INODES'] );
}else{
	define( 'WAAS1_TOTAL_APP_INODES',	0 );
}

if( isset($evnVars['TOTAL_PAGE_VIEWS']) ){
	define( 'TOTAL_PAGE_VIEWS',	$evnVars['TOTAL_PAGE_VIEWS'] );
}else{
	define( 'TOTAL_PAGE_VIEWS',	0 );
}

if( isset($evnVars['TOTAL_UNIQUE_VISITORS']) ){
	define( 'TOTAL_UNIQUE_VISITORS',	$evnVars['TOTAL_UNIQUE_VISITORS'] );
}else{
	define( 'TOTAL_UNIQUE_VISITORS',	0 );
}

if( isset($evnVars['TOTAL_BANDWIDTH_MB']) ){
	define( 'TOTAL_BANDWIDTH_MB',	$evnVars['TOTAL_BANDWIDTH_MB'] );
}else{
	define( 'TOTAL_BANDWIDTH_MB',	0 );
}

if( isset($evnVars['TOTAL_REQUESTS']) ){
	define( 'TOTAL_REQUESTS',	$evnVars['TOTAL_REQUESTS'] );
}else{
	define( 'TOTAL_REQUESTS',	0 );
}


if( isset($evnVars['ANALYTICS_MONTH']) ){
	define( 'ANALYTICS_MONTH',	$evnVars['ANALYTICS_MONTH'] );
}else{
	define( 'ANALYTICS_MONTH',	false );
}

if( isset($evnVars['ANALYTICS_DATE']) ){
	define( 'ANALYTICS_DATE',	$evnVars['ANALYTICS_DATE'] );
}else{
	define( 'ANALYTICS_DATE',	false );
}








//define keys for plugins
if( isset($evnVars['PLUGIN_FLUENT_SMTP_FLUENTMAIL_SENDINBLUE_API_KEY']) ){
	define( 'FLUENTMAIL_SENDINBLUE_API_KEY',	$evnVars['PLUGIN_FLUENT_SMTP_FLUENTMAIL_SENDINBLUE_API_KEY'] );
}



//setup cloudflare cdn cname
define( 'REGISTERABLE_DOMAIN', 		$evnVars['REGISTERABLE_DOMAIN'] );
define( 'CLOUDFLARE_CDN_CNAME', 	$evnVars['CLOUDFLARE_CDN_CNAME'] );


$cfcdnDomain 			= CLOUDFLARE_CDN_CNAME.'.'.REGISTERABLE_DOMAIN;
define( 'CFCDN_FC_DOMAIN_TLD',	$cfcdnDomain );








define('DB_NAME', 		WAAS1_DB_NAME);
define('DB_USER', 		WAAS1_DB_USER);
define('DB_PASSWORD', 	WAAS1_DB_PASSWORD);
define('DB_HOST', 		WAAS1_DB_HOST);














define( 'WP_HOME', 			WAAS1_WP_HOME );
define( 'WP_CONTENT_URL', 	WAAS1_WP_CONTENT_URL );
define( 'WP_CONTENT_DIR', 	WAAS1_WP_CONTENT_DIR );
define( 'FS_METHOD', 'direct' ); //this seems important












//disable site health email notifications
define( 'WP_DISABLE_FATAL_ERROR_HANDLING', true );


//disable plugin and theme editor
define( 'DISALLOW_FILE_EDIT', true ); 




//disable wordpress cron
define('DISABLE_WP_CRON', 'true');

//disable auto updated
define( 'AUTOMATIC_UPDATER_DISABLED', true );
define( 'WP_AUTO_UPDATE_CORE', false );

//disable post revisions and autosave interval to 300 seconds
define('AUTOSAVE_INTERVAL', 300 ); // seconds
define('WP_POST_REVISIONS', false );






//plugins related settings starts here


//autooptimize plugin settings
define( 'AUTOPTIMIZE_CACHE_URL', '//'.CFCDN_FC_DOMAIN_TLD.'/wp-content/cache/autoptimize/' );
//define( 'AUTOPTIMIZE_CACHE_NOGZIP', true ); //very important without autoptimize will start making php files




//learndash
define( 'LEARNDASH_LMS_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins/sfwd-lms/' );
define( 'LEARNDASH_LMS_PLUGIN_URL', WP_CONTENT_URL . '/plugins/sfwd-lms/' );


//buddyboss
define( 'BP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins/buddyboss-platform/' );
define( 'BP_PLUGIN_URL', WP_CONTENT_URL . '/plugins/buddyboss-platform/' );



//updraftplus 
define('UPDRAFTPLUS_ADMINBAR_DISABLE', true);

//debug
define( 'WP_DEBUG_LOG', false ); //do not allow users to log the errors as we are already doing it in the /logs directory of each site in this file php-error.log
//set debug valuse following constant in wp-config.php and save it in /var/www/site{ID}/wp-content
//define( 'WP_DEBUG', true );
//define( 'WP_DEBUG_DISPLAY', true );


if( isset($evnVars['WAAS1_RESTRICTION_CONCATENATE_SCRIPTS']) ){
	define( 'CONCATENATE_SCRIPTS',	$evnVars['WAAS1_RESTRICTION_CONCATENATE_SCRIPTS'] );
}else{
	define( 'CONCATENATE_SCRIPTS',	false );
}




///~~~~!!!!//////
///~~~~!!!!//////
///~~~~!!!!//////







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

