<?php

class A_NextGen_Pro_Thumbnail_Grid_Mapper extends Mixin
{
	function initialize()
	{
		$this->object->add_post_hook(
			'set_defaults',
			'NextGEN Pro Thumbnail Grid Default Values',
			get_class(),
			'set_nextgen_pro_thumbnail_grid_defaults'
		);
	}

	function set_nextgen_pro_thumbnail_grid_defaults($entity)
	{
		if ($entity->name == NEXTGEN_PRO_THUMBNAIL_GRID_MODULE_NAME) {
			$settings = C_NextGen_Settings::get_instance();
			$this->_set_default_value($entity, 'settings', 'override_thumbnail_settings', 0);
			$this->_set_default_value($entity, 'settings', 'thumbnail_width', $settings->thumbwidth);
			$this->_set_default_value($entity, 'settings', 'thumbnail_height', $settings->thumbheight);
			$this->_set_default_value($entity, 'settings', 'thumbnail_quality', $settings->thumbquality);
			$this->_set_default_value($entity, 'settings', 'thumbnail_crop', $settings->thumbfix);
			$this->_set_default_value($entity, 'settings', 'thumbnail_watermark', 0);
            $this->_set_default_value($entity, 'settings', 'images_per_page', $settings->galImages);
            $this->_set_default_value($entity, 'settings', 'disable_pagination', 0);
			$this->_set_default_value($entity, 'settings', 'border_color', '#FFFFFF');
			$this->_set_default_value($entity, 'settings', 'border_size', 1);
			$this->_set_default_value($entity, 'settings', 'spacing', 1);
		}
	}
}