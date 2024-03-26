<?php
/**
 * connecting to all framework files
 */

require_once CONSTANCE_FRAMEWORKPATH . 'nvr-general-functions.php';
require_once CONSTANCE_FRAMEWORKPATH . 'nvr-googlefontjson.php';

/****************Connecting to Classes***********************/ 
require_once CONSTANCE_FRAMEWORKPATH . 'classes/class-tgm-plugin-activation.php';
require_once CONSTANCE_FRAMEWORKPATH . 'classes/class-mega-menu-walker.php';
require_once CONSTANCE_FRAMEWORKPATH . 'classes/class-front-menu-walker.php';
 
/****************Connecting to Sidebar Generator***********************/ 
require_once CONSTANCE_FRAMEWORKPATH . 'sidebargenerator/nvr-form.php';
require_once CONSTANCE_FRAMEWORKPATH . 'sidebargenerator/nvr-sidebar.php';

/****************Connecting to Functions***********************/ 
$func_path = CONSTANCE_FRAMEWORKPATH . 'functions/';
require_once($func_path. "functions.php");