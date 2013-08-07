<?php

class C_NextGen_Pro_Thumbnail_Grid_Installer extends C_Gallery_Display_Installer
{
	function install($reset=FALSE)
	{
		$this->install_display_type(
			NEXTGEN_PRO_THUMBNAIL_GRID_MODULE_NAME, array(
				'title'							=>	'NextGEN Pro Thumbnail Grid',
				'entity_types'					=>	array('image'),
				'preview_image_relpath'			=>	'photocrati-nextgen_pro_thumbnail_grid#preview.jpg',
				'default_source'				=>	'galleries',
				'view_order' => NEXTGEN_DISPLAY_PRIORITY_BASE + (NEXTGEN_DISPLAY_PRIORITY_STEP * 10)
			)
		);
	}

	function uninstall($hard=FALSE)
	{
		if ($hard) {
			$mapper = C_Display_Type_Mapper::get_instance();
			if (($entity = $mapper->find_by_name(NEXTGEN_PRO_THUMBNAIL_GRID_MODULE_NAME))) {
				$mapper->destroy($entity);
			}
		}
	}
}
