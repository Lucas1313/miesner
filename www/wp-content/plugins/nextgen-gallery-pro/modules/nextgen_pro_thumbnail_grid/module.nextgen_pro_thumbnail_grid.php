<?php

/*
{
	Module: photocrati-nextgen_pro_thumbnail_grid
}
 */

define('NEXTGEN_PRO_THUMBNAIL_GRID_MODULE_NAME', 'photocrati-nextgen_pro_thumbnail_grid');

class M_NextGen_Pro_Thumbnail_Grid extends C_Base_Module
{
	function define($context=FALSE)
	{
		parent::define(
			NEXTGEN_PRO_THUMBNAIL_GRID_MODULE_NAME,
			'NextGen Pro Thumbnail Grid',
			'Provides a thumbnail grid for NextGEN Pro',
			'0.2',
			'http://www.photocrati.com',
			'Photocrati Media',
			'http://www.photocrati.com',
			$context
		);

		include_once('class.nextgen_pro_thumbnail_grid_installer.php');
		C_Photocrati_Installer::add_handler($this->module_id, 'C_NextGen_Pro_Thumbnail_Grid_Installer');
	}

	function get_type_list()
	{
		return array(
			'A_Nextgen_Pro_Thumbnail_Grid_Controller' => 'adapter.nextgen_pro_thumbnail_grid_controller.php',
			'A_Nextgen_Pro_Thumbnail_Grid_Dynamic_Styles' => 'adapter.nextgen_pro_thumbnail_grid_dynamic_styles.php',
			'A_Nextgen_Pro_Thumbnail_Grid_Form' => 'adapter.nextgen_pro_thumbnail_grid_form.php',
			'A_Nextgen_Pro_Thumbnail_Grid_Forms' => 'adapter.nextgen_pro_thumbnail_grid_forms.php',
			'C_NextGen_Pro_Thumbnail_Grid_Installer' => 'class.nextgen_pro_thumbnail_grid_installer.php',
			'A_Nextgen_Pro_Thumbnail_Grid_Mapper' => 'adapter.nextgen_pro_thumbnail_grid_mapper.php',
		);
	}

	function _register_adapters()
	{
		$this->get_registry()->add_adapter(
			'I_Display_Type_Controller',
			'A_NextGen_Pro_Thumbnail_Grid_Controller',
			$this->module_id
		);

		$this->get_registry()->add_adapter(
			'I_Dynamic_Stylesheet',
			'A_NextGen_Pro_Thumbnail_Grid_Dynamic_Styles'
		);

		$this->get_registry()->add_adapter(
			'I_Display_Type_Mapper',
			'A_NextGen_Pro_Thumbnail_Grid_Mapper'
		);

		$this->get_registry()->add_adapter(
			'I_Form',
			'A_NextGen_Pro_Thumbnail_Grid_Form',
			$this->module_id
		);

        $this->get_registry()->add_adapter(
            'I_Form_Manager',
            'A_NextGen_Pro_Thumbnail_Grid_Forms'
        );
	}
}

new M_NextGen_Pro_Thumbnail_Grid;
