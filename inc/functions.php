<?php

if (!defined('JCSS_PLUGIN_DIR')) {
	header('HTTP/1.1 403 Forbidden', true, 403);
	exit;
}

function jcss_get_buttons_options() {
	$options = array(); 
	
	try {
        $db_options = get_option('jcss_buttons_options');
        $options = array(  
            'social_options'        => isset($db_options['social_options']) ? $db_options['social_options'] : 'Facebook,Twitter',
            'post_types'            => isset($db_options['post_types']) ? $db_options['post_types'] : array ( 'post' ),
            'placement'             => isset($db_options['placement']) ? $db_options['placement'] : 'after',
            'display_names'         => isset($db_options['display_names']) ? $db_options['display_names'] : 1,
            'hide_on_mobile'        => isset($db_options['hide_on_mobile']) ? $db_options['hide_on_mobile'] : '0',
            'twitter_username'      => isset($db_options['twitter_username']) ? $db_options['twitter_username'] : '',
            'sharing_text'          => isset($db_options['sharing_text']) ? $db_options['sharing_text'] : '',
            'sharing_text_position' => isset($db_options['sharing_text_position']) ? $db_options['sharing_text_position'] : 'left',
            'sharing_text_weight'   => isset($db_options['sharing_text_weight']) ? $db_options['sharing_text_weight'] : 500,
		);
	} catch( Exception $e ) {}
	
	return $options;	
}

function jcss_get_advanced_options() {
	$options = array(); 
	try {
		$db_options = get_option('jcss_advanced_options');
        $options = array(  
            'fa4' => isset($db_options['fa4']) ? $db_options['fa4'] : '0',
            'no_fa' => isset($db_options['no_fa']) ? $db_options['no_fa'] : '0'
		);
    } catch( Exception $e ) {}
	return $options;
}

function jcss_get_animation_options() {
	$options = array(); 
	
	try {
		$db_options = get_option('jcss_animation_options');
        $options = array(  
            'play' => isset($db_options['play']) ? $db_options['play'] : 0,
            'animation' => isset($db_options['animation']) ? $db_options['animation'] : 'fade',
            'duration' => isset($db_options['duration']) ? $db_options['duration'] : '700ms'
		);
	} catch( Exception $e ) {}
	return $options;
}

function jcss_get_fa_classnames($advanced, $social) {
    $fa_classname =  $advanced['fa4'] === 'on' ? 'fa ' : 'fab ';
    switch ($social) {
        case 'email' : return $advanced['fa4'] === 'on' ? 'fa fa-envelope' : 'fas fa-envelope';
        case 'facebook' : return $fa_classname . ($advanced['fa4'] === 'on' ? 'fa-facebook' : 'fa-facebook-f');
        case 'linkedin' : return $fa_classname . ($advanced['fa4'] === 'on' ? 'fa-linkedin' : 'fa-linkedin-in'); 
        default: return $fa_classname . "fa-$social";  
    }
}

function jcss_get_sharing_text($options, $element_id) { ?>
    <div id="<?php echo $element_id ?>">
        <span
            <?php if (!empty($options['sharing_text_weight'])):?> style="font-weight:<?php echo $options['sharing_text_weight']?>" <?php endif; ?>>
            <?php echo $options['sharing_text'] ?>
        </span>       
    </div>
    <?php        
}

function jcss_get_social_name($options, $name) {
    if (!empty($options['display_names']))
        return printf('<span class="jcss-social-name%2$s">%1$s</span>', $name, empty($options['hide_on_mobile']) ? '' : ' jcss-hide');  
}

function jcss_get_social_list( $values, $include_values ) {
    $socials = array('Facebook', 'Twitter', 'LinkedIn', 'Buffer', 'Pinterest', 'Reddit', 'Telegram', 'Email', 'WhatsApp');
    $values_array = explode(',', $values);

    $html = '';
    if ($include_values) {
        foreach ($values_array as &$value) {    
            if (in_array($value, $socials))  
                $html .= '<div id="'.$value.'" class="social-list-item"><li><span class="jcss-card">'.$value.'</span></li></div>';       
        }
    }
    else {    
        foreach ($socials as &$social) {
            if (!in_array($social, $values_array) )
                $html .= '<div id="'.$social.'" class="social-list-item"><li><span class="jcss-card">'.$social.'</span></li></div>'; 
        }
    }
    return $html;
}

function jcss_sanitize_buttons($input) {
    $options = jcss_get_buttons_options();
    
    if( isset( $input['social_options'] ) ) $options['social_options'] = sanitize_text_field( $input['social_options'] );     
    if( isset( $input['post_types'] ) ) $options['post_types'] = array_map( function( $val ) { return sanitize_text_field( $val );}, $input['post_types']  );
    else if (isset($input)) $options['post_types'] = array();
    if( isset( $input['placement'] ) ) $options['placement'] = sanitize_text_field( $input['placement'] );     
    if( isset( $input['display_names'] ) ) $options['display_names'] = sanitize_text_field( $input['display_names'] );
    if( isset( $input['hide_on_mobile'] ) ) $options['hide_on_mobile'] = sanitize_text_field( $input['hide_on_mobile'] );
    else $options['hide_on_mobile'] = '0';
    if( isset( $input['twitter_username'] ) ) $options['twitter_username'] = sanitize_text_field( $input['twitter_username'] );
    if( isset( $input['sharing_text'] ) ) $options['sharing_text'] = sanitize_text_field( $input['sharing_text'] );     
    if( isset( $input['sharing_text_position'] ) ) $options['sharing_text_position'] = sanitize_text_field( $input['sharing_text_position'] );
    if( isset( $input['sharing_text_weight'] ) ) $options['sharing_text_weight'] = sanitize_text_field( $input['sharing_text_weight'] );
    
    return $options;
}

function jcss_sanitize_advanced($input) {
    $options = jcss_get_advanced_options();
    if( isset( $input['fa4'] ) ) $options['fa4'] = sanitize_text_field( $input['fa4'] );
    else $options['fa4'] = '0';
    if( isset( $input['no_fa'] ) ) $options['no_fa'] = sanitize_text_field( $input['no_fa'] );
    else $options['no_fa'] = '0';
    return $options;
}

function jcss_sanitize_animations($input) {
    $options = jcss_get_animation_options();
 
    if( isset( $input['play'] ) ) $options['play'] = sanitize_text_field( $input['play'] );
    if( isset( $input['animation'] ) ) $options['animation'] = sanitize_text_field( $input['animation'] );   
    if( isset( $input['duration'] ) )$options['duration'] = sanitize_text_field( $input['duration'] );

    return $options;
}