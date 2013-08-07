<?php

class C_NextGen_Pro_Masonry_Installer extends C_Gallery_Display_Installer
{
    function install($reset=FALSE)
    {
        $this->install_display_type(
            NEXTGEN_GALLERY_NEXTGEN_PRO_MASONRY, array(
                'title'                 => 'NextGEN Pro Masonry',
                'entity_types'          => array('image'),
                'preview_image_relpath' => 'photocrati-nextgen_pro_masonry#preview.jpg',
                'default_source'        => 'galleries',
                'view_order'            => NEXTGEN_DISPLAY_PRIORITY_BASE + (NEXTGEN_DISPLAY_PRIORITY_STEP * 10) + 50
            )
        );
    }

	function uninstall($hard=FALSE)
	{
		if ($hard) {
			$mapper = C_Display_Type_Mapper::get_instance();
			if (($entity = $mapper->find_by_name(NEXTGEN_GALLERY_NEXTGEN_PRO_MASONRY))) {
				$mapper->destroy($entity);
			}
		}
	}
}
