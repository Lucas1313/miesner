<?php

class C_NextGen_Pro_Blog_Installer extends C_Gallery_Display_Installer
{
	function install()
	{
		$this->install_display_type(
			NEXTGEN_PRO_BLOG_GALLERY_MODULE_NAME, array(
				'title'							=>	'NextGEN Pro Blog Style',
				'entity_types'					=>	array('image'),
				'default_source'				=>	'galleries',
				'preview_image_relpath'			=>	'photocrati-nextgen_pro_blog_gallery#preview.jpg',
				'view_order' => NEXTGEN_DISPLAY_PRIORITY_BASE + (NEXTGEN_DISPLAY_PRIORITY_STEP * 10) + 40
			)
		);
	}

	function uninstall($hard)
	{
		if ($hard) {
			$mapper = C_Display_Type_Mapper::get_instance();
			if (($entity = $mapper->find_by_name(NEXTGEN_PRO_BLOG_GALLERY_MODULE_NAME))) {
				$mapper->destroy($entity);
			}
		}
	}
}
