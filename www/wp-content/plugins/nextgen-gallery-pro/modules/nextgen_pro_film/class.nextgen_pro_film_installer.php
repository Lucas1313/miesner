<?php

class C_NextGen_Pro_Film_Installer extends C_Gallery_Display_Installer
{
	function install()
	{
		$this->install_display_type(
			NEXTGEN_PRO_FILM_MODULE_NAME, array(
				'title'						=>	'NextGEN Pro Film',
				'entity_types'				=>	array('image'),
				'default_source'			=>	'galleries',
				'preview_image_relpath'		=>	'photocrati-nextgen_pro_film#preview.jpg',
				'view_order' => NEXTGEN_DISPLAY_PRIORITY_BASE + (NEXTGEN_DISPLAY_PRIORITY_STEP * 10) + 30
			)
		);
	}

	function uninstall($hard)
	{
		if ($hard) {
			$mapper = C_Display_Type_Mapper::get_instance();
			if (($entity = $mapper->find_by_name(NEXTGEN_PRO_FILM_MODULE_NAME))) {
				$mapper->destroy($entity);
			}
		}
	}
}
