<?php
class SEO_Images_Reloaded_i18n {
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'seo_images_reloaded',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
		);
	}
}
