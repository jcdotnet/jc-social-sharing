<?php

if (!defined('JCSS_PLUGIN_DIR')) {
	header('HTTP/1.1 403 Forbidden', true, 403);
	exit;
}

function jcss_admin_page() { ?>

    <div class="wrap">     

        <h2> Social Sharing Buttons </h2>

        <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'buttons'; ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=social-sharing-buttons-jc&tab=buttons" class="nav-tab <?php echo $active_tab == 'buttons' ? 'nav-tab-active' : ''; ?>">
                <?php _e('Buttons', 'social-sharing-buttons-jc'); ?>
            </a>
            <a href="?page=social-sharing-buttons-jc&tab=advanced" class="nav-tab <?php echo $active_tab == 'advanced' ? 'nav-tab-active' : ''; ?>">
                <?php _e('Advanced', 'social-sharing-buttons-jc'); ?>
            </a>
            <a href="?page=social-sharing-buttons-jc&tab=animation" class="nav-tab <?php echo $active_tab == 'animation' ? 'nav-tab-active' : ''; ?>"> 
                <?php _e('Animation', 'social-sharing-buttons-jc'); ?>
            </a>
            <a href="?page=social-sharing-buttons-jc&tab=shortcodes" class="nav-tab <?php echo $active_tab == 'shortcodes' ? 'nav-tab-active' : ''; ?>"> 
                Shortcodes
            </a>
        </h2>

        <?php if ( $active_tab === 'buttons' ) { 
            $options = jcss_get_buttons_options();
                    
            ?>         
            <form action="options.php" method="post">  
                <?php       
                    settings_fields( 'jcss_plugin_options' );
                ?>
                <table class="form-table">			
                    <tbody>
                        <tr>
                            <th scope="row"><label for="social_options"><?php _e('Social buttons', 'social-sharing-buttons-jc'); ?></label></th>
                            <td>
                                <div id="social-list"> 
                                    <ul class="sortable connectable">                   
                                        <?php echo jcss_get_social_list( $options['social_options'], false ) ?>
                                    </ul>
                                </div>  

                                <p class="description" id="social_options_description"><?php _e('Drop below the sharing buttons you want to add', 'social-sharing-buttons-jc'); ?> </p>

                                <div id="social-selected" > 
                                    <ul class="sortable connectable">                         
                                        <?php echo jcss_get_social_list( $options['social_options'], true ) ?>
                                    </ul>
                                </div>                    

                                <div id="twitter-username">
                                    <h4><label for="twitter-username"><?php _e('Twitter username', 'social-sharing-buttons-jc')?> </label></h4>
                                        <input id="twitter-username" type="text" name="jcss_buttons_options[twitter_username]" 
                                            placeholder="<?php _e('username without @', 'social-sharing-buttons-jc') ?>" value="<?php echo esc_attr($options['twitter_username']) ?>">
                                        <p class="description"> <?php _e('Enter your username if you wanted it to be appended to the tweets', 'social-sharing-buttons-jc') ?></p>

                                </div>

                                <input type="hidden" id="social-options" name="jcss_buttons_options[social_options]" value="<?php echo $options['social_options'] ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                            <label for="buttons-text"><?php _e('Buttons text ', 'social-sharing-buttons-jc'); ?></label>
                            </th>
                            <td class="jcss-radio">
                                <label><input type="radio" name="jcss_buttons_options[display_names]" value="1" <?php checked($options['display_names'], 1); ?> > <?php _e('Yes', 'social-sharing-buttons-jc'); ?></label>
                                <label><input type="radio" name="jcss_buttons_options[display_names]" value="0" <?php checked($options['display_names'], 0); ?> > <?php _e('No'); ?></label> 
                                <p class="description"> <?php _e('Display social network names? You can hide them if you don\'t have enough room for the buttons', 'social-sharing-buttons-jc') ?></p>                
                            </td>				             
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="buttons-location"><?php _e('Buttons location', 'social-sharing-buttons-jc') ?></label>
                            </th>
                            <td>
                                <select id="buttons-location" name="jcss_buttons_options[placement]">
                                    <option value="before" <?php selected($options['placement'], 'before') ?> ><?php _e('Before content', 'social-sharing-buttons-jc') ?></option>
                                    <option value="after" <?php selected($options['placement'], 'after'); ?> ><?php _e('After content', 'social-sharing-buttons-jc') ?></option>
                                    <option value="both" <?php selected($options['placement'], 'both'); ?> ><?php _e('Both', 'social-sharing-buttons-jc') ?></option>
                                </select>
                            </td>		
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="add-to"><?php _e('Add buttons to', 'social-sharing-buttons-jc') ?></label>
                            </th>
                            <td>
                                <ul>
                                    <?php $post_types = get_post_types(array( 'public' => true ), 'objects'); 
                                        foreach ($post_types as $post_type_id => $post_type): ?>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="jcss_buttons_options[post_types][]" value="<?php echo esc_attr( $post_type_id ); ?>" 
                                                <?php checked( in_array( $post_type_id, $options['post_types'] ), true ) ?>> <?php echo $post_type->labels->name; ?>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>						
                            </td>				
                        </tr>      

                        <tr>
                            <th scope="row">
                                <label for="sharing-text"><?php _e('Sharing text', 'social-sharing-buttons-jc') ?></label>
                            </th>
                            <td>
                                <input id="sharing-text" type="text" name="jcss_buttons_options[sharing_text]" 
                                        placeholder="<?php _e('Share this!', 'social-sharing-buttons-jc') ?>" value="<?php echo esc_attr($options['sharing_text'])?>">
                                <p class="description"> <?php _e("Left the field empty if you don't want to display a text before the sharing buttons", 'social-sharing-buttons-jc') ?></p>

                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="sharing-text-position"><?php _e('Sharing text position', 'social-sharing-buttons-jc') ?></label>
                            </th>
                            <td>
                                <select id="sharing-text-position" name="jcss_buttons_options[sharing_text_position]">
                                    <option value="left" <?php selected($options['sharing_text_position'], 'left') ?> ><?php _e('Left', 'social-sharing-buttons-jc') ?></option>
                                    <option value="above" <?php selected($options['sharing_text_position'], 'above'); ?> ><?php _e('Above', 'social-sharing-buttons-jc') ?></option>
                                </select>
                            </td>
                        </tr> 
                        <tr>
                            <th scope="row">      
                                <label for="sharing-text-weight"><?php _e('Sharing text weight', 'social-sharing-buttons-jc') ?></label>
                            </th>
                            <td>
                                <select id="sharing-text-weight" name="jcss_buttons_options[sharing_text_weight]">
                                    <?php for ($i = 100; $i <= 900; $i+=100) { ?>
                                        <option value="<?php echo $i ?>" <?php selected($options['sharing_text_weight'], $i) ?> > <?php echo $i ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </tbody>  
                </table>
                <?php submit_button(); ?>             
            </form> <?php
        } else if ( $active_tab === 'advanced' ) {
            $options = jcss_get_advanced_options(); ?>
            <form action="options.php" method="post">
                <?php
                    settings_fields( 'jcss_plugin_options' );
                ?>        
                <table class="form-table">			
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="use-fa4"><?php _e('Font Awesome 4 compatibility', 'social-sharing-buttons-jc') ?></label>
                            </th>
                            <td id="use-fa4">        
                                <label>
                                    <input type="checkbox" name="jcss_advanced_options[fa4]" <?php checked( $options['fa4'] === 'on' ) ?>> 
                                    <?php _e("Check ONLY if your theme still uses Font Awesome 4, take into account that some icons might not be rendered.", 'social-sharing-buttons-jc') ?>
                                </label>
                            </td>			
                        </tr>
                    </tbody>
                </table>
                <?php submit_button(); ?>
            </form> <?php 
        } else if ( $active_tab === 'animation' ) { 
            $options = jcss_get_animation_options(); ?>
            <form action="options.php" method="post">         
                <?php
                    settings_fields( 'jcss_plugin_options' );   
                ?>        
                <table class="form-table">			
                    <tbody>
                        <tr>
                            <th scope="row"><label for="play-animations"><?php _e('Play animations?', 'social-sharing-buttons-jc')?> </label></th>
                            <td id="play-animations" class="jcss-radio">
                                <label><input type="radio" name="jcss_animation_options[play]" value="1" <?php checked($options['play'], 1); ?> > <?php _e('Yes', 'social-sharing-buttons-jc'); ?></label>
                                <label><input type="radio" name="jcss_animation_options[play]" value="0" <?php checked($options['play'], 0); ?> > <?php _e('No'); ?></label> 

                                <p class="description" class="widefat"> 
                                <?php _e("Here you can decide whether or not to play animations when hovering over the sharing buttons.", 'social-sharing-buttons-jc') ?></p>                                                                                 
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="animation-style"><?php _e('Animation Style', 'social-sharing-buttons-jc') ?></label>
                            </th>
                            <td>
                                <select id="animation-style" name="jcss_animation_options[animation]">
                                    <option value="fade" <?php selected($options['animation'], 'fade') ?> ><?php _e('Fade', 'social-sharing-buttons-jc') ?></option>
                                    <option value="slide" <?php selected($options['animation'], 'slide'); ?> ><?php _e('Slide', 'social-sharing-buttons-jc') ?></option>
                                    <option value="bounce" <?php selected($options['animation'], 'bounce'); ?> ><?php _e('Bounce', 'social-sharing-buttons-jc') ?></option>
                                    <option value="spin" <?php selected($options['animation'], 'spin'); ?> ><?php _e('Spin', 'social-sharing-buttons-jc') ?></option>
                                </select>
                            </td>		                        	
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="animation-duration"><?php _e('Animation Duration', 'social-sharing-buttons-jc') ?></label>
                            </th>
                            <td>
                                <select id="animation-duration" name="jcss_animation_options[duration]">
                                    <option value="300ms" <?php selected($options['duration'], '300ms') ?> ><?php _e('300 miliseconds', 'social-sharing-buttons-jc') ?></option>
                                    <option value="500ms" <?php selected($options['duration'], '500ms'); ?> ><?php _e('500 miliseconds', 'social-sharing-buttons-jc') ?></option>
                                    <option value="700ms" <?php selected($options['duration'], '700ms'); ?> ><?php _e('700 miliseconds', 'social-sharing-buttons-jc') ?></option>
                                    <option value="1s" <?php selected($options['duration'], '1s'); ?> ><?php _e('1 second', 'social-sharing-buttons-jc') ?></option>
                                    <option value="2s" <?php selected($options['duration'], '2s'); ?> ><?php _e('2 seconds', 'social-sharing-buttons-jc') ?></option>
                                    <option value="3s" <?php selected($options['duration'], '3s'); ?> ><?php _e('3 seconds', 'social-sharing-buttons-jc') ?></option>
                                </select>
                            </td>		                        	
                        </tr>           
                    </tbody>
                </table>
                <?php submit_button(); ?>    
            </form> <?php
        } else { ?>
            <h3>[jc_buttons] </h3>
            <p><?php _e('The shortcode <strong>[jc_buttons]</strong> will render the sharing buttons as you have customised them in this page. Thanks to this shortcode you can place the buttons anywhere!', 'social-sharing-buttons-jc') ?> </p>
            <?php
        } ?>         
    </div> <?php
}