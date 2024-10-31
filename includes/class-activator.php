<?php
class SEO_Images_Reloaded_Activator {
	public static function activate() {
		add_option('seo_images_reloaded_options', array(
		'alt' => '%file_name% %post_title%',
		'title' => '%media_title% photo',
		'override_alt' => true,
		'override_title' => false,
		'strip_special' => true,
		'uppercase_first' => true,
		'uppercase_all' => false
	));
	}
}
