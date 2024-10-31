<?php
/*
Plugin Name: SEO Images Reloaded
Plugin URI: https://wordpress.org/plugins/seo-image-reloaded/
Description: Automatically adds alt and title attributes to all your images to increase traffic from search engines.
Version: 1.0.0
Author: lerougeliet
Author URI: https://profiles.wordpress.org/lerougeliet/#content-plugins
Text Domain: rss-feed-styles
Domain Path: /languages
*/

if (!defined('WPINC')) {
	die;
}

require_once plugin_dir_path(__FILE__) . 'includes/class-functions.php';

function activate_seo_images_reloaded() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-activator.php';
	SEO_Images_Reloaded_Activator::activate();
}

function deactivate_seo_images_reloaded() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-deactivator.php';
	SEO_Images_Reloaded_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_seo_images_reloaded');
register_deactivation_hook(__FILE__, 'deactivate_seo_images_reloaded');

require plugin_dir_path(__FILE__) . 'includes/class-main.php';

function run_seo_images_reloaded() {
	$plugin = new SEO_Images_Reloaded();
	$plugin->run();
}
run_seo_images_reloaded();
