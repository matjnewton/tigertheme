<?php

define('WQS_ATLAS_URL', get_stylesheet_directory_uri() . '/inc/atlasx_api');
define('WQS_ATLAS_PATH', get_stylesheet_directory() . '/inc/atlasx_api');

/// Register Script
function wqs_load_scripts_atlas()
{   
    wp_register_script('wqs_functions_atlas', WQS_ATLAS_URL . '/js/functions.js');
    wp_register_script('wqs_functions_for_check_available_atlas', WQS_ATLAS_URL . '/js/functions_for_check_available.js');
 
    wp_enqueue_script('wqs_functions_atlas');
    wp_enqueue_script('wqs_functions_for_check_available_atlas');

    wp_localize_script( 'wqs_functions_atlas', 'js_var_atlas', 
        array( 
            'userid_key' => get_field('field_n1993k2903_xola', 'option'),
            'wqs_api_url' => get_home_url( null, 'wp-json/wqs-api/tour_product_api'),
            )
    );
    wp_localize_script( 'wqs_functions_for_check_available_atlas', 'js_var_atlas', 
        array( 
            'userid_key' => get_field('field_n1993k2903_xola', 'option'),
            'wqs_api_url' => get_home_url( null, 'wp-json/wqs-api/tour_product_api'),
            )
    );

}

add_action('wp_enqueue_scripts', 'wqs_load_scripts_atlas');
