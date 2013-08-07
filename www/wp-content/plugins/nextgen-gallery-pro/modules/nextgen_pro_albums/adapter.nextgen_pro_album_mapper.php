<?php

class A_NextGen_Pro_Album_Mapper extends Mixin
{
	function initialize()
	{
		$this->object->add_post_hook(
			'set_defaults',
			get_class(),
			get_class(),
			'set_defaults_for_nextgen_pro_albums'
		);
	}

	function set_defaults_for_nextgen_pro_albums($entity)
	{
		if (in_array($entity->name, array(NEXTGEN_PRO_LIST_ALBUM, NEXTGEN_PRO_GRID_ALBUM))) {
			$settings				= C_NextGen_Settings::get_instance();

            // Galleries within the album will be displayed as NextGEN Pro Thumbnails, or
            // if not available, then NextGEN Basic Thumbnails
			$gallery_display_type	= defined('NEXTGEN_PRO_THUMBNAIL_GRID_MODULE_NAME') ?
				NEXTGEN_PRO_THUMBNAIL_GRID_MODULE_NAME : NEXTGEN_GALLERY_BASIC_THUMBNAILS;
			$this->_set_default_value($entity, 'settings', 'gallery_display_type', $gallery_display_type);

            // Basic style settings
			$this->_set_default_value($entity, 'settings', 'caption_color', '#333333');
			$this->_set_default_value($entity, 'settings', 'border_color', '#CCCCCC');
			$this->_set_default_value($entity, 'settings', 'border_size', 1);
			$this->_set_default_value($entity, 'settings', 'background_color', '#FFFFFF');
            $this->_set_default_value($entity, 'settings', 'padding', 20);
            $this->_set_default_value($entity, 'settings', 'spacing', 10);

            // Thumbnail dimensions
			$this->_set_default_value($entity, 'settings', 'override_thumbnail_settings', 0);
			$this->_set_default_value($entity, 'settings', 'thumbnail_width', $settings->thumbwidth);
			$this->_set_default_value($entity, 'settings', 'thumbnail_height', $settings->thumbheight);
			$this->_set_default_value($entity, 'settings', 'thumbnail_quality', $settings->thumbquality);
			$this->_set_default_value($entity, 'settings', 'thumbnail_crop', $settings->thumbfix);
			$this->_set_default_value($entity, 'settings', 'thumbnail_watermark', 0);
		}

        // Grid albums do not share a caption_size
        if ($entity->name == NEXTGEN_PRO_GRID_ALBUM)
        {
            $this->_set_default_value($entity, 'settings', 'caption_size', 13);
        }

        if ($entity->name == NEXTGEN_PRO_LIST_ALBUM)
        {
            $this->_set_default_value($entity, 'settings', 'description_color', '#33333');
            $this->_set_default_value($entity, 'settings', 'description_size', 13);
            $this->_set_default_value($entity, 'settings', 'caption_size', 18);
        }
	}
}