<?php

class A_NextGen_Pro_Thumbnail_Grid_Controller extends Mixin
{
    function initialize()
    {
        parent::initialize();
        $this->add_mixin('Mixin_NextGen_Basic_Pagination');
    }

	function enqueue_frontend_resources($displayed_gallery)
	{
        $this->call_parent('enqueue_frontend_resources', $displayed_gallery);
        wp_enqueue_script('nextgen_pro_thumbnail_grid', $this->get_static_url('photocrati-nextgen_pro_thumbnail_grid#nextgen_pro_thumbnail_grid_init.js'));
		wp_enqueue_style('nextgen_pro_thumbnail_grid', $this->get_static_url('photocrati-nextgen_pro_thumbnail_grid#nextgen_pro_thumbnail_grid.css'));
        wp_enqueue_style('nextgen_pagination_style', $this->get_static_url('photocrati-nextgen_pagination#style.css'));

		$id = 'displayed_gallery_' . $displayed_gallery->id();

		// Enqueue dynamic stylesheet
		$dyn_styles = $this->get_registry()->get_utility('I_Dynamic_Stylesheet');
		$dyn_styles->enqueue(
			'nextgen_pro_thumbnail_grid',
			$this->array_merge_assoc(
				$displayed_gallery->display_settings,
				array('id' => $id)
			)
		);
	}

	function index_action($displayed_gallery, $return=FALSE)
	{
		// The HTML id of the gallery
		$id = 'displayed_gallery_' . $displayed_gallery->id();

		// Get named size of thumbnail images
		$thumbnail_size_name = 'thumbnail';
		$display_settings = $displayed_gallery->display_settings;
		if ($display_settings['override_thumbnail_settings'])
        {
			$dynthumbs = $this->object->get_registry()->get_utility('I_Dynamic_Thumbnails_Manager');
			$dyn_params = array(
				'width'  => $display_settings['thumbnail_width'],
				'height' => $display_settings['thumbnail_height']
			);

			if ($display_settings['thumbnail_quality'])
				$dyn_params['quality'] = $display_settings['thumbnail_quality'];

			if ($display_settings['thumbnail_crop'])
				$dyn_params['crop'] = true;

			if ($display_settings['thumbnail_watermark'])
				$dyn_params['watermark'] = true;

			$thumbnail_size_name = $dynthumbs->get_size_name($dyn_params);
		}

        $current_page = (int)$this->param('page', $displayed_gallery->id(), 1);
        $offset = $display_settings['images_per_page'] * ($current_page - 1);
        $total = $displayed_gallery->get_entity_count();
        $images = $displayed_gallery->get_included_entities($display_settings['images_per_page'], $offset);
        if (in_array($displayed_gallery->source, array('random', 'recent')))
            $display_settings['disable_pagination'] = TRUE;
        if ($images)
        {
            if ($display_settings['images_per_page'] && !$display_settings['disable_pagination'])
            {
                $pagination_result = $this->object->create_pagination(
                    $current_page, $total, $display_settings['images_per_page']
                );
            }
        }
        $pagination = !empty($pagination_result['output']) ? $pagination_result['output'] : NULL;

        $params = array(
			'images'                => $images,
			'storage'               => $this->get_registry()->get_utility('I_Gallery_Storage'),
			'thumbnail_size_name'   => $thumbnail_size_name,
			'effect_code'           => $this->object->get_effect_code($displayed_gallery),
			'id'                    => $id,
			'transient_id'          => $displayed_gallery->transient_id,
            'pagination'            => $pagination
		);
                
        $params = $this->object->prepare_display_parameters($displayed_gallery, $params);

		// Render view/template
		return $this->render_view('photocrati-nextgen_pro_thumbnail_grid#nextgen_pro_thumbnail_grid', $params, $return);
	}
}
