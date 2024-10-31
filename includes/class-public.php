<?php
class SEO_Images_Reloaded_Public {
	private $plugin_name;
	private $version;

	public function __construct($plugin_name, $version) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function seo_images_reloaded($content) {
		return preg_replace_callback('/<img[^>]+/', array('SEO_Images_Reloaded_Functions', 'img_replace_cb'), $content, 20);
	}
}
