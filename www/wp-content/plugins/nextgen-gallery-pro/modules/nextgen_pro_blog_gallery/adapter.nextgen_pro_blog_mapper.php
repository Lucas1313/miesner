<?php

class A_NextGen_Pro_Blog_Mapper extends Mixin
{
	function initialize()
	{
		$this->object->add_post_hook(
			'set_defaults',
			get_class(),
			get_class(),
			'set_nextgen_pro_blog_defaults'
		);
	}

	function set_nextgen_pro_blog_defaults($entity)
	{
		if ($entity->name == NEXTGEN_PRO_BLOG_GALLERY_MODULE_NAME)
        {
            $this->object->_set_default_value($entity, 'settings', 'override_image_settings', 0);
            $this->object->_set_default_value($entity, 'settings', 'image_quality', '100');
            $this->object->_set_default_value($entity, 'settings', 'image_crop', 0);
            $this->object->_set_default_value($entity, 'settings', 'image_watermark', 0);
			$this->object->_set_default_value($entity, 'settings', 'image_display_size', 800);
            $this->object->_set_default_value($entity, 'settings', 'spacing', 5);
			$this->object->_set_default_value($entity, 'settings', 'border_size', 0);
			$this->object->_set_default_value($entity, 'settings', 'border_color', '#FFFFFF');
		}
	}
}