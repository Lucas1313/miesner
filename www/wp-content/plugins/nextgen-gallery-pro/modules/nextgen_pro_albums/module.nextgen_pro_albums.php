<?php
/*
{
	Module:	photocrati-nextgen_pro_albums
}
 */

define('NEXTGEN_PRO_ALBUMS_MODULE_NAME', 'photocrati-nextgen_pro_albums');
define('NEXTGEN_PRO_LIST_ALBUM',		 'photocrati-nextgen_pro_list_album');
define('NEXTGEN_PRO_GRID_ALBUM',		 'photocrati-nextgen_pro_grid_album');

class M_NextGen_Pro_Albums extends C_Base_Module
{
	function define($context=FALSE)
	{
		parent::define(
			'photocrati-nextgen_pro_albums',
			'NextGEN Pro Albums',
			'Provides Photocrati styled albums for NextGEN Gallery',
			'0.1',
			'http://www.nextgen-gallery.com',
			'Photocrati Media',
			'http://www.photocrati.com',
			$context
		);

		include_once('class.nextgen_pro_album_installer.php');
		C_Photocrati_Installer::add_handler($this->module_id, 'C_NextGen_Pro_Album_Installer');
	}


	function get_type_list()
	{
		return array(
			'C_NextGen_Pro_Album_Installer' => 'class.nextgen_pro_album_installer.php',
			'A_Nextgen_Pro_Album_Mapper' => 'adapter.nextgen_pro_album_mapper.php',
			'A_Nextgen_Pro_Album_Routes' => 'adapter.nextgen_pro_album_routes.php',
			'A_Nextgen_Pro_Album_Form' => 'adapter.nextgen_pro_album_form.php',
			'A_Nextgen_Pro_Album_Forms' => 'adapter.nextgen_pro_album_forms.php',
			'A_Nextgen_Pro_Grid_Album_Controller' => 'adapter.nextgen_pro_grid_album_controller.php',
			'A_Nextgen_Pro_Grid_Album_Dynamic_Styles' => 'adapter.nextgen_pro_grid_album_dynamic_styles.php',
			'A_Nextgen_Pro_Grid_Album_Form' => 'adapter.nextgen_pro_grid_album_form.php',
			'A_Nextgen_Pro_List_Album_Controller' => 'adapter.nextgen_pro_list_album_controller.php',
			'A_Nextgen_Pro_List_Album_Dynamic_Styles' => 'adapter.nextgen_pro_list_album_dynamic_styles.php',
			'A_Nextgen_Pro_List_Album_Form' => 'adapter.nextgen_pro_list_album_form.php',
			'A_Nextgen_Pro_List_Album_Forms' => 'adapter.nextgen_pro_list_album_forms.php',
			'Mixin_Nextgen_Pro_Album_Controller' => 'mixin.nextgen_pro_album_controller.php',
			'Mixin_Nextgen_Pro_Album_Urls' => 'mixin.nextgen_pro_album_urls.php',
		);
	}

	function _register_adapters()
	{
		$this->get_registry()->add_adapter(
			'I_Installer', 'A_NextGen_Pro_Album_Installer'
		);

		$this->get_registry()->add_adapter(
			'I_Display_Type_Mapper', 'A_NextGen_Pro_Album_Mapper'
		);

		$this->get_registry()->add_adapter(
			'I_Display_Type_Controller', 'A_NextGen_Pro_List_Album_Controller',
			NEXTGEN_PRO_LIST_ALBUM
		);

		$this->get_registry()->add_adapter(
			'I_Display_Type_Controller', 'A_NextGen_Pro_Grid_Album_Controller',
			NEXTGEN_PRO_GRID_ALBUM
		);

		$this->get_registry()->add_adapter(
			'I_Dynamic_Stylesheet',
			'A_NextGen_Pro_List_Album_Dynamic_Styles'
		);

		$this->get_registry()->add_adapter(
			'I_Dynamic_Stylesheet',
			'A_NextGen_Pro_Grid_Album_Dynamic_Styles'
		);

		$this->get_registry()->add_adapter(
			'I_Displayed_Gallery_Renderer',
			'A_NextGen_Pro_Album_Routes'
		);

		$this->get_registry()->add_adapter(
			'I_Form',
			'A_NextGen_Pro_List_Album_Form',
			NEXTGEN_PRO_LIST_ALBUM
		);

		$this->get_registry()->add_adapter(
			'I_Form',
			'A_NextGen_Pro_Grid_Album_Form',
			NEXTGEN_PRO_GRID_ALBUM
		);

        $this->get_registry()->add_adapter(
            'I_Form_Manager',
            'A_NextGen_Pro_Album_Forms'
        );
	}
}

new M_NextGen_Pro_Albums;
