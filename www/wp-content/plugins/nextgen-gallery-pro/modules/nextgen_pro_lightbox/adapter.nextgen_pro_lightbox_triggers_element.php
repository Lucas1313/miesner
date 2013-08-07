<?php

class A_NextGen_Pro_Lightbox_Triggers_Element extends Mixin
{
    function initialize()
    {
        $this->object->add_post_hook(
            'render_object',
            'Renders trigger buttons for the gallery',
            get_class(),
            'render_trigger_buttons'
        );
    }
    
    function _check_trigger_rendering($displayed_gallery, $template_id, $root_element)
    {
    	$ret = $this->object->_check_addition_rendering($displayed_gallery, $template_id, $root_element, 'layout');
    	
    	switch ($template_id)
    	{
    		case 'photocrati-nextgen_basic_album#compact':
    		case 'photocrati-nextgen_basic_album#extended':
    		case 'photocrati-nextgen_basic_tagcloud#nextgen_basic_tagcloud':
    		{
    			$ret = false;

    			break;
    		}
    	}
    	
    	return $ret;
    }
    
    function render_trigger_template($displayed_gallery, $template_id, $root_element, $params = null)
    {
    	if ($params == null)
    	{
    		$params = array();
    	}
    	
    	$main_class = isset($params['class']) ? $params['class'] : null;
			$triggers = $this->get_registry()->get_utility('I_NextGen_Pro_Lightbox_Trigger_Manager');

			switch ($template_id)
			{
				case 'photocrati-nextgen_basic_gallery#thumbnails/index':
				case 'photocrati-nextgen_basic_singlepic#nextgen_basic_singlepic':
				case 'photocrati-nextgen_pro_thumbnail_grid#nextgen_pro_thumbnail_grid':
				case 'photocrati-nextgen_pro_blog_gallery#nextgen_pro_blog':
				case 'photocrati-nextgen_pro_film#nextgen_pro_film':
				{
					$list = $root_element->find('nextgen_gallery.image', true);
					
					foreach ($list as $image_element)
					{
						$image = $image_element->get_object();
						
						$params = array(
				      'context' => 'image',
				      'context-id' => $image->{$image->id_field},
				      'context-parent' => 'gallery',
				      'context-parent-id' => $displayed_gallery->transient_id,
				      'class' => 'ngg-trigger'
				    );
				    
				    $triggers_out = $triggers->render_trigger_list(null, $params, $this->object);
				    $class = in_array($template_id, array('photocrati-nextgen_pro_blog_gallery#nextgen_pro_blog', 'photocrati-nextgen_basic_singlepic#nextgen_basic_singlepic')) ? 'large' : 'small';
		      
						$image_element->append('<div class="' . $main_class . ' ngg-trigger-' . $class . '">' . $triggers_out . '</div>');
					}
					
					break;
				}
				case 'photocrati-nextgen_basic_gallery#slideshow/index':
                case 'photocrati-nextgen_pro_masonry#index':
				case 'photocrati-galleria#galleria':
				default:
				{
					$params = array(
						'context' => 'gallery', 
						'context-id' => isset($displayed_gallery->transient_id) ? $displayed_gallery->transient_id : FALSE,
			            'class' => 'ngg-trigger'
					);
					
			    $triggers_out = $triggers->render_trigger_list(null, $params, $this->object);
					
					$root_element->append('<div class="' . $main_class . ' ngg-trigger-large">' . $triggers_out . '</div>');
					
					break;
				}
			}
    }
    
    function render_trigger_buttons()
    {
        $root_element = $this->object->get_method_property(
            $this->method_called,
            ExtensibleObject::METHOD_PROPERTY_RETURN_VALUE
        );
        
        $displayed_type = $this->object->get_param('display_type_rendering');
        $displayed_gallery = $this->object->get_param('displayed_gallery');
				$triggers = $this->get_registry()->get_utility('I_NextGen_Pro_Lightbox_Trigger_Manager');
				$current_lightbox_effect = C_NextGen_Settings::get_instance()->thumbEffect;
				if ($displayed_type && $displayed_gallery != null && $triggers != null && $current_lightbox_effect == NEXTGEN_PRO_LIGHTBOX_MODULE_NAME)
				{
					$state = $triggers->get_object_state($this->object);
					
					if (!in_array($state, array('done', 'skip')))
					{
						$template_id = $root_element->get_id();
						$main_class = 'ngg-trigger-buttons';

            if (isset($displayed_gallery->display_settings['ngg_triggers_display'])) 
            {
                switch ($displayed_gallery->display_settings['ngg_triggers_display'])
                {
                    case 'exclude_mobile':
                    {
                        $main_class .= ' mobile-hide';

                        break;
                    }
                    case 'never':
                    {
                        $main_class .= ' hidden';

                        break;
                    }
                }
            }
            
            $params = array();
            $params['class'] = $main_class;
            
            if ($this->object->_check_trigger_rendering($displayed_gallery, $template_id, $root_element))
            {
            	$this->object->render_trigger_template($displayed_gallery, $template_id, $root_element, $params);
            }
					}
				}

        return $root_element;
    }
}
