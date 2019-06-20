<?php

if (!defined('JCSS_PLUGIN_DIR')) {
	header('HTTP/1.1 403 Forbidden', true, 403);
	exit;
}

define( 'JCSS_VERSION', '1.1.5' );

function jcss_get_default_buttons_options() {
	
	$default_options = array();
    
	try {				
		$default_options = array(
			'social_options' => 'Facebook,Twitter',
            'post_types' => array ( 'post' ),
            'placement' => 'after',
            'display_names' => 1,  
            'display_shares' => 1,
            'twitter_username' => '',                      
            'sharing_text' => '',
            'sharing_text_position' => 'left',
            'sharing_text_weight' => 500
		);
	
	} catch( Exception $e) {				
	}	
	return $default_options;		
}

function jcss_get_buttons_options() {
	$options = array(); 
	
	try {
		$options = get_option('jcss_buttons_options') ? get_option('jcss_buttons_options') : jcss_get_default_buttons_options();
	
	} catch( Exception $e ) {}
	
	return $options;	
}

function jcss_get_advanced_options() {
	$options = array(); 
	try {
		$db_options = get_option('jcss_advanced_options');
        $options = array(  
            'fa4' => isset($db_options['fa4']) ? $db_options['fa4'] : '0'
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
        case 'facebook' : return $fa_classname . ($advanced['fa4'] === 'on' ? 'fa-facebook' : 'fa-facebook-f');
        case 'linkedin' : return $fa_classname . ($advanced['fa4'] === 'on' ? 'fa-linkedin' : 'fa-linkedin-in');
        default: return $fa_classname . "fa-$social";  
    }
}

function jcss_get_sharing_text($options, $element_id) {
    ?>
    <div id="<?php echo $element_id ?>">
        <span
            <?php if (!empty($options['sharing_text_weight'])):?> style="font-weight:<?php echo $options['sharing_text_weight']?>" <?php endif; ?>>
            <?php echo $options['sharing_text'] ?>
        </span>       
    </div>
    <?php        
}

function jcss_get_social_name($options, $name) {
    if (!empty($options['display_names'])) { ?> <span class="jcss-social-name"><?php echo $name; ?></span><?php } 
}

function jcss_get_social_list( $values, $include_values ) {
    $socials = array('Facebook', 'Twitter', 'LinkedIn', 'Buffer', 'WhatsApp');
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
    if( isset( $input['display_shares'] ) ) $options['display_shares'] = sanitize_text_field( $input['display_shares'] );     
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
    return $options;
}

function jcss_sanitize_animations($input) {
    $options = jcss_get_animation_options();
 
    if( isset( $input['play'] ) ) $options['play'] = sanitize_text_field( $input['play'] );
    if( isset( $input['animation'] ) ) $options['animation'] = sanitize_text_field( $input['animation'] );   
    if( isset( $input['duration'] ) )$options['duration'] = sanitize_text_field( $input['duration'] );

    return $options;
}