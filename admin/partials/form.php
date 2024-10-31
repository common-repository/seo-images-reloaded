<?php
$options = get_option('seo_images_reloaded_options');

if (isset($_POST['_wpnonce'])) {
	if (!wp_verify_nonce($_POST['_wpnonce'], 'seo-images-reloaded')) {
		die('Security check');
	}

	$options['alt'] = empty($_POST['default_alt']) ? '' : sanitize_text_field($_POST['default_alt']);
	$options['title'] = empty($_POST['default_title']) ? '' : sanitize_text_field($_POST['default_title']);
	$options['override_alt'] = !empty($_POST['default_override_alt']);
	$options['override_title'] = !empty($_POST['default_override_title']);
	$options['strip_special'] = !empty($_POST['strip_special']);
	$options['uppercase_first'] = !empty($_POST['uppercase_first']);
	$options['uppercase_all'] = !empty($_POST['uppercase_all']);

	update_option('seo_images_reloaded_options', $options);
	echo '<div id="message" class="updated fade"><p>' . __('SEO Images Reloaded settings saved.', 'seo-images-reloaded') . '</p></div>';
}
?>
<div class="wrap">
	<h1><?php _e('SEO Images Reloaded Settings', 'seo-images-reloaded') ?></h1>
  <form method="post">
    <input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce('seo-images-reloaded') ?>" />
		<div>
	    <p><?php _e('This plugin works by modifying the &lt;img /&gt; HTML output on the frontend of your site. No changes are made to images in your media library.', 'seo-images-reloaded') ?></p>
	    <p><?php _e('Use the following special tags:', 'seo-images-reloaded'); ?></p>
	    <ul>
	      <li><b>%file_name%</b> - <?php _e('image file name (without extension)', 'seo-images-reloaded'); ?></li>
		    <li><b>%post_title%</b> - <?php _e('post title', 'seo-images-reloaded'); ?></li>
		    <li><b>%author%</b> - <?php _e('post author', 'seo-images-reloaded'); ?></li>
	      <li><b>%category%</b> - <?php _e('first post category', 'seo-images-reloaded'); ?></li>
	      <li><b>%categories%</b> - <?php _e('all post categories', 'seo-images-reloaded'); ?></li>
	      <li><b>%tag%</b> - <?php _e('first post tag', 'seo-images-reloaded'); ?></li>
	      <li><b>%tags%</b> - <?php _e('all post tags', 'seo-images-reloaded'); ?></li>
				<li><b>%media_title%</b> - <?php _e('image title in media library', 'seo-images-reloaded'); ?></li>
				<li><b>%media_caption%</b> - <?php _e('image caption in media library', 'seo-images-reloaded'); ?></li>
		    <li><b>%title_attr%</b> - <?php _e('existing title attribute on &lt;img /&gt; tag', 'seo-images-reloaded'); ?></li>
		    <li><b>%alt_attr%</b> - <?php _e('existing alt attribute on &lt;img /&gt; tag', 'seo-images-reloaded'); ?></li>
	    </ul>
			<p>Want more tags? Submit a request at <a href="https://wordpress.org/support/plugin/seo-image/">https://wordpress.org/support/plugin/seo-image-reloaded/</a></p>
		</div>
    <table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><?php _e('Alt attribute', 'seo-images-reloaded'); ?></th>
					<td>
						<fieldset>
	          	<input class="regular-text" type="text" id="default_alt" name="default_alt" value="<?php echo esc_attr($options['alt']); ?>" />
	          	<p class="description"><?php _e('example: %filename% %title%', 'seo-images-reloaded'); ?></p>
							<label for="default_override_alt"><input type="checkbox" id="default_override_alt" name="default_override_alt" <?php echo $options['override_alt'] ? 'checked' : ''; ?> /><span><?php _e('Override existing &lt;img /&gt; alt attribute', 'seo-images-reloaded'); ?></span></label>
						</fieldset>
					</td>
        </tr>
				<tr>
	        <th scope="row"><?php _e('Title attribute', 'seo-images-reloaded'); ?></th>
					<td>
						<fieldset>
		          <input class="regular-text" type="text" id="default_title" name="default_title" value="<?php echo esc_attr($options['title']); ?>" />
		          <p class="description"><?php _e('example: %filename% photo', 'seo-images-reloaded'); ?></p>
							<label for="default_override_title"><input type="checkbox" id="default_override_title" name="default_override_title" <?php echo $options['override_title'] ? 'checked' : ''; ?> /><span><?php _e('Override existing &lt;img /&gt; title attribute', 'seo-images-reloaded'); ?></span></label>
						</fieldset>
	        </td>
				</tr>
				<tr>
	        <th scope="row"><?php _e('Text styling', 'seo-images-reloaded'); ?></th>
					<td>
						<fieldset>
							<label for="strip_special"><input type="checkbox" id="strip_special" name="strip_special" <?php echo $options['strip_special'] ? 'checked' : ''; ?> /><span><?php _e('Remove special characters', 'seo-images-reloaded'); ?></span></label>
							<br />
							<label for="uppercase_first"><input type="checkbox" id="uppercase_first" name="uppercase_first" <?php echo $options['uppercase_first'] ? 'checked' : ''; ?> /><span><?php _e('Uppercase first letter of first word', 'seo-images-reloaded'); ?></span></label>
							<br />
							<label for="uppercase_all"><input type="checkbox" id="uppercase_all" name="uppercase_all" <?php echo $options['uppercase_all'] ? 'checked' : ''; ?> /><span><?php _e('Uppercase first letters of every word', 'seo-images-reloaded'); ?></span></label>
						</fieldset>
	        </td>
				</tr>
      </tbody>
    </table>
    <div class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update options', 'seo-images-reloaded'); ?>" class="button button-primary" />
    </div>
  </form>
</div>
