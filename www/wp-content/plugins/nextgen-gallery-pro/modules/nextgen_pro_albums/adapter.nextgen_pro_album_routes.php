<?php

class A_NextGen_Pro_Album_Routes extends Mixin
{
	function initialize()
	{
		$this->object->add_pre_hook(
			'render',
			get_class(),
			get_class(),
			'rewrite_nextgen_pro_album_urls'
		);
	}

	function rewrite_nextgen_pro_album_urls($displayed_gallery)
	{
		$album_types = array(
			NEXTGEN_PRO_ALBUMS_MODULE_NAME,
			NEXTGEN_PRO_LIST_ALBUM,
			NEXTGEN_PRO_GRID_ALBUM
		);
        $router = $this->get_registry()->get_utility('I_Router');
		$app = $router->get_routed_app();
		$slug = C_NextGen_Global_Settings::get_instance()->router_param_slug;

		// Get the original display type
		$original_display_type = isset($displayed_gallery->display_settings['original_display_type']) ?
			$displayed_gallery->display_settings['original_display_type'] : '';

		if (in_array($displayed_gallery->display_type, $album_types)) {
			$app->rewrite($slug.'/{\w}',					$slug.'/album--{1}');
			$app->rewrite($slug.'/{\w}/{\w}',				$slug.'/album--{1}/gallery--{2}');
			$app->rewrite($slug.'/{\w}/{\w}/{\w}{*}',		$slug.'/album--{1}/gallery--{2}/{3}{4}');
		}
		elseif(in_array($original_display_type, $album_types)) {
			$app->rewrite("{$slug}/album--{\\w}",                    "{$slug}/{1}");
			$app->rewrite("{$slug}/album--{\\w}/gallery--{\\w}",     "{$slug}/{1}/{2}");
			$app->rewrite("{$slug}/album--{\\w}/gallery--{\\w}/{*}", "{$slug}/{1}/{2}/{3}");
		}
		$app->do_rewrites();
	}
}