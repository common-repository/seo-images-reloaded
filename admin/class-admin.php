<?php
class SEO_Images_Reloaded_Admin {
	private $plugin_name;
	private $version;

	public function __construct($plugin_name, $version) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles() {
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/admin-styles.css', array(), $this->version, 'all');
	}

	public function add_plugin_menu() {
		add_options_page('SEO Images Reloaded Settings', 'SEO Images', 'manage_options', 'seo-images-reloaded', array(&$this, 'seo_images_reloaded_options'));
	}

	public function seo_images_reloaded_options() {
		if (!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}

		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/form.php';
	}

	public function add_action_links($links) {
		$links[] = '<a href="' . admin_url('options-general.php?page=seo-images-reloaded') . '">Settings</a>';
		$links[] = '<a href="https://wordpress.org/support/plugin/seo-images-reloaded/reviews/#new-post">Review</a>';
		return $links;
	}
}
