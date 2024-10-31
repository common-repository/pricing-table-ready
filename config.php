<?php
    global $wpdb;
    if (WPLANG == '') {
        define('PRT_WPLANG', 'en_GB');
    } else {
        define('PRT_WPLANG', WPLANG);
    }
    if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

	define('PRT_SITE_URL', get_bloginfo('wpurl'). '/');
    define('PRT_PLUG_NAME', basename(dirname(__FILE__)));
    define('PRT_DIR', WP_PLUGIN_DIR. DS. PRT_PLUG_NAME. DS);
	//define('PRT_DIR_S', 'http://'.$_SERVER['SERVER_NAME']. '/wp-content'. '/plugins'. '/'. PRT_PLUG_NAME);
	define('PRT_DIR_S', PRT_SITE_URL. '/wp-content'. '/plugins'. '/'. PRT_PLUG_NAME);
    define('PRT_TPL_DIR', PRT_DIR. 'tpl'. DS);
    define('PRT_CLASSES_DIR', PRT_DIR. 'classes'. DS);
    define('PRT_TABLES_DIR', PRT_CLASSES_DIR. 'tables'. DS);
	define('PRT_HELPERS_DIR', PRT_CLASSES_DIR. 'helpers'. DS);
    define('PRT_LANG_DIR', PRT_DIR. 'lang'. DS);
    define('PRT_IMG_DIR', PRT_DIR. 'img'. DS);
    define('PRT_TEMPLATES_DIR', PRT_DIR. 'templates'. DS);
    define('PRT_MODULES_DIR', PRT_DIR. 'modules'. DS);
    define('PRT_FILES_DIR', PRT_DIR. 'files'. DS);
    define('PRT_ADMIN_DIR', ABSPATH. 'wp-admin'. DS);
	define('PRT_PLUG_IMG_SPEC', plugin_dir_url(__FILE__).'img/');
	define('PRT_TYPE_POST', 'ready-pricing-tables');
	define('S_PRT_WP_PLUGIN_NAME', 'Ready! Pricing Tables');

    define('PRT_JS_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/js/');
    define('PRT_CSS_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/css/');
    define('PRT_IMG_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/img/');
    define('PRT_MODULES_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/modules/');
    define('PRT_TEMPLATES_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/templates/');
    define('S_IMG_POSTS_PATH', PRT_IMG_PATH. 'posts/');
    define('PRT_JS_DIR', PRT_DIR. 'js/');

    define('PRT_URL', PRT_SITE_URL);

    define('PRT_LOADER_IMG', PRT_IMG_PATH. 'loading-cube.gif');
    define('PRT_DATE_DL', '/');
    define('PRT_DATE_FORMAT', 'd/m/Y');
    define('PRT_DATE_FORMAT_HIS', 'd/m/Y (H:i:s)');
    define('PRT_DATE_FORMAT_JS', 'dd/mm/yy');
    define('PRT_DATE_FORMAT_CONVERT', '%d/%m/%Y');
    define('PRT_WPDB_PREF', $wpdb->prefix);
    define('PRT_DB_PREF', 'prt_');    /*BackUP*/
    define('PRT_MAIN_FILE', 'pricing-tables-v2.php');

    define('PRT_DEFAULT', 'default');
    define('PRT_CURRENT', 'current');
    
    
    define('PRT_PLUGIN_INSTALLED', true);
    define('PRT_VERSION', '0.3.6');
	define('PRT_S_VERSION', PRT_VERSION);
    define('PRT_USER', 'user');
    
    
    define('PRT_CLASS_PREFIX', 'prt');        
    define('PRT_FREE_VERSION', false);
    
    define('PRT_API_UPDATE_URL', 'http://somereadyapiupdatedomain.com');
    
    define('PRT_SUCCESS', 'Success');
    define('PRT_FAILED', 'Failed');
	define('PRT_ERRORS', 'prtErrors');
	
	define('PRT_THEME_MODULES', 'theme_modules');
	
	
	define('PRT_ADMIN',	'admin');
	define('PRT_LOGGED','logged');
	define('PRT_GUEST',	'guest');
	
	define('PRT_ALL',		'all');
	
	define('PRT_METHODS',		'methods');
	define('PRT_USERLEVELS',	'userlevels');
	/**
	 * Framework instance code, unused for now
	 */
	define('PRT_CODE', 'prt');
	
?>