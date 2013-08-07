<?php

class C_NextGen_Pro_Slideshow_Installer extends C_Gallery_Display_Installer
{
	function install($reset=FALSE)
	{
		$this->install_display_type(
			NEXTGEN_PRO_SLIDESHOW_MODULE_NAME, array(
				'title'							=>	'NextGEN Pro Slideshow',
				'entity_types'					=>	array('image'),
				'default_source'				=>	'galleries',
				'preview_image_relpath'			=>	'photocrati-nextgen_pro_slideshow#preview.jpg',
				'view_order' => NEXTGEN_DISPLAY_PRIORITY_BASE + (NEXTGEN_DISPLAY_PRIORITY_STEP * 10) + 10
			)
		);
	}

	function uninstall($hard=FALSE)
	{
		if ($hard) {
			$mapper = C_Display_Type_Mapper::get_instance();
			if (($entity = $mapper->find_by_name(NEXTGEN_PRO_SLIDESHOW_MODULE_NAME))) {
				$mapper->destroy($entity);
			}
		}
	}
}
