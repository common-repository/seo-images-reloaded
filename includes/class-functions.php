<?php
class SEO_Images_Reloaded_Functions {
	public function replace_placeholders($str, $attrs, $options) {
		if (strpos($str, '%file_name%') !== false) {
			$filename = '';
			if ($attrs['src']) {
				$filename = strtok(strtok($attrs['src'], '?'), '#');
				$parts = explode('/', $filename);
				$filename = $parts[count($parts) - 1];
				$parts = explode('.', $filename);
				if (count($parts) >= 2) {
					$filename = implode('.', array_slice($parts, 0, count($parts) - 1));
				}
			}

			$str = str_replace('%file_name%', $filename, $str);
		}

		if (strpos($str, '%post_title%') !== false) {
			$str = str_replace('%post_title%', get_the_title(), $str);
		}
		if (strpos($str, '%author%') !== false) {
			$str = str_replace('%author%', get_the_author(), $str);
		}

		if (strpos($str, '%category%') !== false || strpos($str, '%categories%') !== false) {
			$categories = array();
			$postcats = get_the_category();

			if ($postcats) {
				foreach ($postcats as $cat) {
					$categories []= $cat->slug;
				}
			}

			$str = str_replace('%category%', $categories[0], $str);
			$str = str_replace('%categories%', implode(' ', $categories), $str);
		}

		if (strpos($str, '%tag%') !== false || strpos($str, '%tags%') !== false) {
			$tags = array();
			$posttags = get_the_tags();
			if ($posttags) {
				foreach ($posttags as $tag) {
					$tags []= $tag->name;
				}
			}

			$str = str_replace('%tag%', $tags[0], $str);
			$str = str_replace('%tags%', implode(' ', $tags), $str);
		}

		if (strpos($str, '%media_title%') !== false) {
			$id = attachment_url_to_postid($attrs['src']);
			$str = str_replace('%media_title%', get_the_title($id), $str);
		}

		if (strpos($str, '%media_caption%') !== false) {
			$id = attachment_url_to_postid($attrs['src']);
			$str = str_replace('%media_caption%', wp_get_attachment_caption($id), $str);
		}

		$str = str_replace('%title_attr%', $attrs['title'] ? $attrs['title'] : '', $str);
		$str = str_replace('%alt_attr%', $attrs['alt'] ? $attrs['alt'] : '', $str);

		$str = trim($str);
		if ($options['strip_special']) {
			$str = trim(preg_replace('/\\s+/', ' ', preg_replace('/[^a-z0-9]/i', ' ', $str)));
		}

		if ($options['uppercase_all']) {
			$str = ucwords($str);
		} else if ($options['uppercase_first']) {
			$str = ucfirst($str);
		}

		return $str;
	}

	public function img_replace_cb($matches) {
		$str = $matches[0];
		$options = get_option('seo_images_reloaded_options');

		$attrs = array();
		$quote = '';
		$attr_open = false;
		$attr_name = '';
		$attr_value = '';
		for ($i = 4; $i < strlen($str); $i++) {
			$chr = $str[$i];
			if ($attr_open) {
				if ($chr === $quote || (!$quote && in_array($chr, array(' ', "\n", '/', '>')))) {
					$attr_open = false;
					$attrs[$attr_name] = $attr_value;
					$attr_name = '';
				} else {
					$attr_value .= $chr;
				}
			} else if (in_array($chr, array('/', '>'))) {
				break;
			} else if ($chr === '=') {
				if ($str[$i + 1] === '\'' || $str[$i + 1] === '"') {
					$quote = $str[$i + 1];
					$i++;
				}
				$attr_open = true;
				$attr_value = '';
			} else if (in_array($chr, array(' ', "\n"))) {
				$attr_name = '';
			} else if (preg_match('/[a-z_-]/i', $chr)) {
				$attr_name .= $chr;
			} else {
				// Can't parse.
				return $str;
			}
		}
		$end_idx = $i;

		if ($options['override_title'] || !trim($attrs['title'])) {
			$attrs['title'] = self::replace_placeholders($options['title'], $attrs, $options);
		}

		if ($options['override_alt'] || !trim($attrs['alt'])) {
			$attrs['alt'] = self::replace_placeholders($options['alt'], $attrs, $options);
		}

		$ret = '<img ';
		foreach ($attrs as $name => $value) {
			$ret .= $name . '="' . esc_attr($value) . '" ';
		}
		return $ret . substr($str, $end_idx);
	}
}
