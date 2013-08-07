<?php

class C_NextGen_Pro_Horizontal_Filmstrip_Installer extends C_Gallery_Display_Installer
{
	function install()
	{
		$this->install_display_type(
			NEXTGEN_PRO_HORIZONTAL_FILMSTRIP_MODULE_NAME, array(
				'title'						=>	'NextGEN Pro Horizontal Filmstrip',
				'entity_types'				=>	array('image'),
				'default_source'			=>	'galleries',
				'preview_image_relpath'		=>	'photocrati-nextgen_pro_horizontal_filmstrip#preview.jpg',
				'view_order' => NEXTGEN_DISPLAY_PRIORITY_BASE + (NEXTGEN_DISPLAY_PRIORITY_STEP * 10) + 20
			)
		);
	}

	function uninstall($hard)
	{
		if ($hard) {
			$mapper = C_Display_Type_Mapper::get_instance();
			if (($entity = $mapper->find_by_name(NEXTGEN_PRO_HORIZONTAL_FILMSTRIP_MODULE_NAME))) {
				$mapper->destroy($entity);
			}
		}
	}
}
