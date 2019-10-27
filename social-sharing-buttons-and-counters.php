<?php
/*
Plugin Name: Social Sharing Buttons
Description: A lightweight SEO-friendly plugin that allows you to share your posts and get more traffic
Version:     1.2.4
Author:      JC
Author URI:  https://josecarlosroman.com/
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: social-sharing-buttons-jc
Domain Path: /languages
*/

if ( !defined('ABSPATH') ) {
	header('HTTP/1.1 403 Forbidden', true, 403);
	exit;
}

define( 'JCSS_PLUGIN_DIR', plugin_dir_path(__FILE__) );
define( 'JCSS_PLUGIN_URL', plugin_dir_url(__FILE__) );
define( 'JCSS_VERSION', '1.2.4' );

require_once JCSS_PLUGIN_DIR . 'inc/functions.php';
require_once JCSS_PLUGIN_DIR . 'inc/template-functions.php';
require_once JCSS_PLUGIN_DIR . 'inc/plugin.php';  

if ( is_admin() ) {
    require_once JCSS_PLUGIN_DIR . 'inc/admin.php';
}