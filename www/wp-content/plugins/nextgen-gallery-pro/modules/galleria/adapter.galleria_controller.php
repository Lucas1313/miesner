<?php

class A_Galleria_Controller extends Mixin
{
	function enqueue_frontend_resources($displayed_gallery)
	{
        // Add some properties to the displayed gallery
        $this->object->_compute_aspect_ratio($displayed_gallery);
        $displayed_gallery->iframe_url = $this->object->get_router()->get_url(
            '/nextgen-galleria-gallery/'.$displayed_gallery->id()
        );

        // Include ngg_common.js
        $this->call_parent('enqueue_frontend_resources', $displayed_gallery);

        // Galleria uses an iframe, which is controlled/loaded by the parent
        wp_enqueue_script('galleria_parent', $this->get_static_url('photocrati-galleria#galleria_parent.js'), array('jquery'));
	}
	
	function _compute_aspect_ratio($displayed_gallery, $type = null)
	{
		$storage = $this->get_registry()->get_utility('I_Gallery_Storage');
		$list = $displayed_gallery->get_included_entities();
		
		if ($type == null)
		{
			$type = !empty($displayed_gallery->display_settings['aspect_ratio']) ? $displayed_gallery->display_settings['aspect_ratio'] : 'image_average';
		}
		
		switch ($type)
		{
			case 'first_image':
			{
				if ($list != null)
				{
					$image = $list[0];
					$dims = $storage->get_image_dimensions($image);
					$ratio = round($dims['width'] / $dims['height'], 2);
			
					$displayed_gallery->display_settings['aspect_ratio_computed'] = $ratio;
				}
				
				break;
			}
			case 'image_average':
			{
				if ($list != null)
				{
					$computed_ratio = 0;
				
					foreach ($list as $image)
					{
						$dims = $storage->get_image_dimensions($image);
						$ratio = round($dims['width'] / $dims['height'], 2);
						
						if ($computed_ratio == 0)
						{
							$computed_ratio = $ratio;
						}
						else
						{
							if (abs($computed_ratio - $ratio) > 0.001)
							{
								$computed_ratio = ($computed_ratio + $ratio) / 2;
							}
						}
					}
					
					if ($computed_ratio > 0)
					{
						$displayed_gallery->display_settings['aspect_ratio_computed'] = $computed_ratio;
					}
				}
				
				break;
			}
		}
	}

	function index_action($displayed_gallery, $return=FALSE)
	{
		$storage = $this->get_registry()->get_utility('I_Gallery_Storage');
		$list = $displayed_gallery->get_included_entities();
		$params = array(
			'images'				=> $list,
			'displayed_gallery_id'	=>	$displayed_gallery->id(),
			'storage'				=>	$storage,
			'custom_css_rules'		=>	$this->object->get_custom_css_rules($displayed_gallery)
		);
                
        $params = $this->object->prepare_display_parameters($displayed_gallery, $params);
    
		return $this->object->render_view('photocrati-galleria#galleria', $params, $return);

	}

	function get_custom_css_rules($displayed_gallery)
	{
		return '';
	}
}
