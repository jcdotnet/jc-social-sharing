<?php

if (!defined('JCSS_PLUGIN_DIR')) {
	header('HTTP/1.1 403 Forbidden', true, 403);
	exit;
}

require_once JCSS_PLUGIN_DIR . 'inc/admin-page.php'; 

add_action( 'admin_init', 'jcss_register_options' );
add_action( 'admin_enqueue_scripts', 'jcss_admin_scripts');
add_action( 'admin_menu', 'jcss_add_menu' );


function jcss_admin_scripts() {    
    if ( isset( $_GET['page'] ) && $_GET['page'] === 'social-sharing-buttons-jc') {
	
        wp_enqueue_style('jcss-styles-admin', JCSS_PLUGIN_URL . 'assets/css/jc-social-sharing-admin.css', array(), JCSS_VERSION);
        
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'jquery-touch-punch' );
        
        wp_register_script('jcss-javascript-admin', JCSS_PLUGIN_URL . 'assets/js/jc-social-sharing-admin.js', array('jquery'), JCSS_VERSION, true);	
        wp_enqueue_script('jcss-javascript-admin');
    }	
}


function jcss_register_options() {
    register_setting('jcss_plugin_options', 'jcss_buttons_options', 'jcss_sanitize_buttons');
    register_setting('jcss_plugin_options', 'jcss_advanced_options', 'jcss_sanitize_advanced');
    register_setting('jcss_plugin_options', 'jcss_animation_options', 'jcss_sanitize_animations');
}

function jcss_add_menu() {
    add_options_page( 'JC Social Sharing', 'JC Social Sharing', 'manage_options', 'social-sharing-buttons-jc', 'jcss_admin_page');
}