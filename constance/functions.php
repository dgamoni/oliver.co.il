<?php

/********** NOVARO DEFINITION *************/
define('CONSTANCE_PARENTMENU_SLUG', 'nvrtheme-settings' );
define('CONSTANCE_SITEURL', site_url() );
define('CONSTANCE_ADMINURL', admin_url() );
define('CONSTANCE_FRAMEWORKPATH', get_template_directory() . '/framework/' );
define('CONSTANCE_FRAMEWORKURI', get_template_directory_uri() . '/framework/' );
define('CONSTANCE_STYLEURI', get_stylesheet_directory_uri() . '/');
define('CONSTANCE_STYLEPATH', get_stylesheet_directory() . '/');
define('CONSTANCE_CSSURI', get_template_directory_uri() . '/css/' );
define('CONSTANCE_JSURI', get_template_directory_uri() . '/js/' );
define('CONSTANCE_ENGINEPATH', get_template_directory() . '/engine/' );
define('CONSTANCE_WIDGETPATH', get_template_directory() . '/widgets/' );
/********** END NOVARO DEFINITION *************/

//Connecting to Novaro Framework
require_once CONSTANCE_FRAMEWORKPATH . 'framework-connector.php';

//Starting the theme setting
require_once CONSTANCE_ENGINEPATH . 'engine-start.php';

//Settings the theme options
require_once CONSTANCE_ENGINEPATH . 'theme-options.php';

//you can add your own function in here
if(file_exists(CONSTANCE_STYLEPATH . 'functions-custom.php')){
	include_once CONSTANCE_STYLEPATH . 'functions-custom.php';
}