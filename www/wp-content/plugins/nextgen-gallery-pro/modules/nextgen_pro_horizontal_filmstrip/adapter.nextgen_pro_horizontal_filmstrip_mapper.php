<?php

class A_NextGen_Pro_Horizontal_Filmstrip_Mapper extends Mixin
{
	function initialize()
	{
		$this->object->add_post_hook(
			'set_defaults',
			'Set defaults for NextGEN Pro Horizontal Filmstrip galleries',
			get_class(),
			'set_nextgen_pro_horizontal_filmstrip_defaults'
		);
	}

	function set_nextgen_pro_horizontal_filmstrip_defaults($entity)
	{
		if ($entity->name == NEXTGEN_PRO_HORIZONTAL_FILMSTRIP_MODULE_NAME) {
			$settings = C_NextGen_Settings::get_instance();
			$router	  = $this->get_registry()->get_utility('I_Router');
			$entity->settings['theme']	= $router->get_static_url('photocrati-nextgen_pro_horizontal_filmstrip#theme/galleria.nextgen_pro_horizontal_filmstrip.js');

            $this->object->_set_default_value($entity, 'settings', 'override_thumbnail_settings', 0);
            $this->object->_set_default_value($entity, 'settings', 'thumbnail_width', $settings->thumbwidth);
            $this->object->_set_default_value($entity, 'settings', 'thumbnail_height', $settings->thumbheight);
            $this->object->_set_default_value($entity, 'settings', 'thumbnail_quality', $settings->thumbquality);
            $this->object->_set_default_value($entity, 'settings', 'thumbnail_crop', $settings->thumbfix);
            $this->object->_set_default_value($entity, 'settings', 'thumbnail_watermark', 0);

            $this->object->_set_default_value($entity, 'settings', 'override_image_settings', 0);
            $this->object->_set_default_value($entity, 'settings', 'image_quality', '100');
            $this->object->_set_default_value($entity, 'settings', 'image_crop', 0);
            $this->object->_set_default_value($entity, 'settings', 'image_watermark', 0);

            // options inherited from the pro-slideshow module
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
