<?php

class A_NextGen_Pro_Blog_Controller extends Mixin
{
	function enqueue_frontend_resources($displayed_gallery)
	{
        $this->call_parent('enqueue_frontend_resources', $displayed_gallery);
        wp_enqueue_style('nextgen_pro_blog_gallery', $this->get_static_url('photocrati-nextgen_pro_blog_gallery#nextgen_pro_blog_gallery.css'));
        wp_enqueue_script('nextgen_pro_blog_gallery', $this->get_static_url('photocrati-nextgen_pro_blog_gallery#nextgen_pro_blog_init.js'));

		$dyn_styles = $this->get_registry()->get_utility('I_Dynamic_Stylesheet');
		$dyn_styles->enqueue('nextgen_pro_blog', $this->array_merge_assoc(
			$displayed_gallery->display_settings,
			array('id' => 'displayed_gallery_'.$displayed_gallery->id())
		));
	}

	function index_action($displayed_gallery, $return=FALSE)
	{
		// The HTML id of the gallery
		$id = 'displayed_gallery_'.$displayed_gallery->id();

		$image_size_name = 'full';
		$display_settings = $displayed_gallery->display_settings;
		if (isset($display_settings['override_thumbnail_settings']) && $display_settings['override_thumbnail_settings']) {
			$dynthumbs = $this->object->get_registry()->get_utility('I_Dynamic_Thumbnails_Manager');
			$dyn_params = array(
				'width' => $display_settings['thumbnail_width'],
				'height' => $display_settings['thumbnail_height'],
			);

			if ($display_settings['thumbnail_quality'])
				$dyn_params['quality'] = $display_settings['thumbnail_quality'];

			if ($display_settings['thumbnail_crop'])
				$dyn_params['crop'] = true;

			if ($display_settings['thumbnail_watermark'])
				$dyn_params['watermark'] = true;

			$image_size_name = $dynthumbs->get_size_name($dyn_params);
		}
		
		$params = array(
			'images'				=>	$displayed_gallery->get_included_entities(),
			'storage'				=>	$this->get_registry()->get_utility('I_Gallery_Storage'),
			'effect_code'			=>	$this->object->get_effect_code($displayed_gallery),
			'id'					=>	$id,
			'transient_id' 			=>	$displayed_gallery->transient_id,
			'image_size_name'		=>	$image_size_name,
			'image_display_size'	=>	$displayed_gallery->display_settings['image_display_size'],
			'border_size'			=>	$displayed_gallery->display_settings['border_size']
		);
                
    		$params = $this->object->prepare_display_parameters($displayed_gallery, $params);

		// Render view/template
		return $this->render_view('photocrati-nextgen_pro_blog_gallery#nextgen_pro_blog', $params, $return);
	}
}
