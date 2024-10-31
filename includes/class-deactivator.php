<?php
class SEO_Images_Reloaded_Deactivator {
	public static function deactivate() {
		delete_option('seo_images_reloaded_secret_id');
	}
}
