<?php

/*
 {
	Module:		photocrati-nextgen_pro_slideshow,
	Depends:	{ photocrati-galleria }
 }
 */

define('NEXTGEN_PRO_SLIDESHOW_MODULE_NAME', 'photocrati-nextgen_pro_slideshow');

class M_NextGen_Pro_Slideshow extends C_Base_Module
{
	function define($context=FALSE)
	{
		parent::define(
			'photocrati-nextgen_pro_slideshow',
			'NextGen Pro Slideshow',
			"Provides Photocrati's Slideshow Gallery Type",
			'0.2',
			'http://www.photocrati.com',
			'Photocrati Media',
			'http://www.photocrati.com',
			$context
		);

		include_once('class.nextgen_pro_slideshow_installer.php');
		C_Photocrati_Installer::add_handler($this->module_id, 'C_NextGen_Pro_Slideshow_Installer');
	}

	function get_type_list()
	{
		return array(
			'A_Nextgen_Pro_Slideshow' => 'adapter.nextgen_pro_slideshow.php',
			'A_Nextgen_Pro_Slideshow_Controller' => 'adapter.nextgen_pro_slideshow_controller.php',
			'A_Nextgen_Pro_Slideshow_Form' => 'adapter.nextgen_pro_slideshow_form.php',
			'A_Nextgen_Pro_Slideshow_Forms' => 'adapter.nextgen_pro_slideshow_forms.php',
			'C_NextGen_Pro_Slideshow_Installer' => 'class.nextgen_pro_slideshow_installer.php',
			'A_Nextgen_Pro_Slideshow_Mapper' => 'adapter.nextgen_pro_slideshow_mapper.php',
		);
	}


	function _register_adapters()
	{
		// Provides settings fields and frontend rendering
		$this->get_registry()->add_adapter(
			'I_Display_Type_Controller',
			'A_NextGen_Pro_Slideshow_Controller',
			$this->module_id
		);

		// Provides default values for the display type
		$this->get_registry()->add_adapter(
			'I_Display_Type_Mapper',
			'A_NextGen_Pro_Slideshow_Mapper'
		);

		// Provides a display settings form
		$this->get_registry()->add_adapter(
			'I_Form',
			'A_NextGen_Pro_Slideshow_Form',
			$this->module_id
		);

        $this->get_registry()->add_adapter(
            'I_Form_Manager',
            'A_NextGen_Pro_Slideshow_Forms'
        );
	}
}

new M_NextGen_Pro_Slideshow;
