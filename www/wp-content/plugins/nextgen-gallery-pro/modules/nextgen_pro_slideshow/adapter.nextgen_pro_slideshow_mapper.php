<?php

class A_NextGen_Pro_Slideshow_Mapper extends Mixin
{
	function initialize()
	{
		$this->object->add_post_hook(
			'set_defaults',
			'NextGen Pro Slideshow Defaults',
			get_class(),
			'set_nextgen_pro_slideshow_defaults'
		);
	}

	function set_nextgen_pro_slideshow_defaults($entity)
	{
		if ($entity->name == NEXTGEN_PRO_SLIDESHOW_MODULE_NAME) {
			$router = $this->get_registry()->get_utility('I_Router');
			$entity->settings['theme'] = $router->get_static_url('photocrati-nextgen_pro_slideshow#theme/galleria.nextgen_pro_slideshow.js');
            $this->object->_set_default_value($entity, 'settings', 'image_crop', 0);
            $this->object->_set_default_value($entity, 'settings', 'image_pan', 1);
            $this->object->_set_default_value($entity, 'settings', 'show_playback_controls', 1);
            $this->object->_set_default_value($entity, 'settings', 'show_captions', 0);
            $this->object->_set_default_value($entity, 'settings', 'caption_class', 'caption_overlay_bottom');
            $this->object->_set_default_value($entity, 'settings', 'aspect_ratio', '1.5');
            $this->object->_set_default_value($entity, 'settings', 'width', 100);
            $this->object->_set_default_value($entity, 'settings', 'width_unit', '%');
            $this->object->_set_default_value($entity, 'settings', 'transition', 'fade');
			$this->object->_set_default_value($entity, 'settings', 'transition_speed', 1);
            $this->object->_set_default_value($entity, 'settings', 'slideshow_speed', 5);
			$this->object->_set_default_value($entity, 'settings', 'border_size', 0);
			$this->object->_set_default_value($entity, 'settings', 'border_color', '#ffffff');
		}
	}
}
