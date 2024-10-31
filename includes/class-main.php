<?php
$plugin_name = 'SEO_Images_Reloaded';
$plugin_version = '1.0.0';

class SEO_Images_Reloaded {
	protected $loader;
	protected $plugin_name;
	protected $version;

	public function __construct() {
		global $plugin_name, $plugin_version;
		$this->plugin_name = $plugin_name;
		$this->version = $plugin_version;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	private function load_dependencies() {
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-loader.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-i18n.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-admin.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-public.php';

		$this->loader = new SEO_Images_Reloaded_Loader();
	}

	private function set_locale() {
		$plugin_i18n = new SEO_Images_Reloaded_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	private function define_admin_hooks() {
		$plugin_admin = new SEO_Images_Reloaded_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_menu');
		$this->loader->add_action('plugin_action_links_seo-images-reloaded/seo-images-reloaded.php', $plugin_admin, 'add_action_links');
	}

	private function define_public_hooks() {
		$plugin_public = new SEO_Images_Reloaded_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_filter('the_content', $plugin_public, 'seo_images_reloaded', 500);
		$this->loader->add_filter('post_thumbnail_html', $plugin_public, 'seo_images_reloaded', 500);
	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}
}
