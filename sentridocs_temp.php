<?php
/*
Plugin Name: Sentridocs
Description: Plugin to iframe Mortgage Form on URL
Version: 1.0
Author: Sentridocs 
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue scripts and styles only when needed
function sentridocs_enqueue_scripts() {
    if (shortcode_exists('sentridocs')) {
        // Enqueue any necessary scripts or styles here
    }
}
add_action('wp_enqueue_scripts', 'sentridocs_enqueue_scripts');

// Shortcode function to embed the form
function sentridocs_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(array(
        'url' => 'https://sentridocs.com/refinance.php', // Default URL if not provided
        'height' => '500px', // Default height
        'width' => '100%', // Default width
    ), $atts);

    // Sanitize attributes
    $url = esc_url($atts['url']);
    $height = esc_attr($atts['height']);
    $width = esc_attr($atts['width']);

    // Perform additional security checks
    if ($url && filter_var($url, FILTER_VALIDATE_URL)) {
        // Return the iframe code for embedding the form
        return '<iframe src="' . $url . '" width="' . $width . '" height="' . $height . '" frameborder="0"></iframe>';
    } else {
        return '<p>Error: Invalid URL provided.</p>';
    }
}
add_shortcode('sentridocs', 'sentridocs_shortcode');

// Add menu to the dashboard
function sentridocs_menu() {
    add_menu_page(
        'Sentridocs Settings', // Page title
        'Sentridocs', // Menu title
        'manage_options', // Capability required to access the menu
        'sentridocs-settings', // Menu slug
        'sentridocs_settings_page', // Callback function to render the page
        'dashicons-welcome-widgets-menus', // Icon URL or Dashicons class
        80 // Position in the menu
    );
}
add_action('admin_menu', 'sentridocs_menu');

// Render the settings page
function sentridocs_settings_page() {
    // You can place your settings page HTML and form elements here
    echo '<div class="wrap">';
    echo '<h1>Sentridocs Settings</h1>';
    echo '<p>This is where you can configure Sentridocs plugin settings.</p>';
    // Display the shortcode or its output
    echo do_shortcode('[sentridocs url="https://sentridocs.com/refinance.php" height="500px" width="100%"]');
    echo '</div>';
}
