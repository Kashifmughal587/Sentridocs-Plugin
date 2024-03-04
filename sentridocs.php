<?php
/*
Plugin Name: Sentridocs
Description: A plugin for integrating Sentridocs API for license validation.
Version: 1.0
Author: Sentridcocs Corp
License: GPL2
*/

if (!defined('ABSPATH')) {
    exit;
}

function sentridocs_scripts() {
	    wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css');
    	wp_enqueue_script('jquery-script', 'http://code.jquery.com/ui/1.10.4/jquery-ui.js');
        wp_register_style('rmccss' , plugin_dir_url(__FILE__). 'css/style.css');
        wp_enqueue_style('rmccss');
        wp_enqueue_script('rmcjs', plugin_dir_url(__FILE__) . 'js/jquery.tooltipster.min.js', array('jquery'), '2.11', true);

        wp_enqueue_script('tooltipster', plugin_dir_url(__FILE__) . 'js/rmc.js', array('jquery'), '2s.13', true);
}
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

require_once(plugin_dir_path(__FILE__) . 'admin/sentridocs-admin.php');
require_once(plugin_dir_path(__FILE__) . 'admin/sentridocs-activation.php');

function sentridocs_is_activated() {
    return get_option('sentridocs_activated', false);
}

function sentridocs_init() {
    register_activation_hook(__FILE__, 'sentridocs_activation');
}
add_action('admin_menu', 'sentridocs_check_activation');
add_action('admin_init', 'sentridocs_init');

function sentridocs_check_activation() {
    if (current_user_can('manage_options')) {
        $license_key = get_option('sentridocs_license_key');
        $secret_key = get_option('sentridocs_secret_key');
        if (!empty($license_key) && !empty($secret_key)) {
            if (check_license($license_key, $secret_key)) {
                add_action('admin_menu', 'sentridocs_admin_menu');
            } else {
                add_action('admin_menu', 'sentridocs_show_license_key_form');
            }
        }
        if (sentridocs_is_activated()) {
            add_action('admin_menu', 'sentridocs_admin_menu');
        } else {
            add_action('admin_menu', 'sentridocs_show_license_key_form');
        }
    }
}
