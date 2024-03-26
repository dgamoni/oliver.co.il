<?php

$nvr_func_path = CONSTANCE_FRAMEWORKPATH . 'functions/';
require_once($nvr_func_path. "metaboxes/metaboxes.php");

if ( !function_exists( 'constance_functions_init' ) ) {

	function constance_functions_init() {		
		// Load the required CSS and javscript
		add_action('admin_enqueue_scripts', 'constance_load_scripts');
	}
	add_action('admin_init','constance_functions_init');
}

/* Loads the javascript */
function constance_load_scripts($hook) {
	// Enqueued scripts
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('constance-metaboxes-js', CONSTANCE_FRAMEWORKURI .'functions/metaboxes/metaboxes.js', array('jquery'));
	
	wp_enqueue_style('constance-metaboxes-css', CONSTANCE_FRAMEWORKURI .'functions/metaboxes/metaboxes.css');
}
?>