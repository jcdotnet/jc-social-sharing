<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
delete_option('jcss_buttons_options');
delete_option('jcss_advanced_options');
delete_option('jcss_animation_options');