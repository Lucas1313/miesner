<?php
/*
{
	Module: photocrati-nextgen_pro_horizontal_filmstrip,
    Depends: { photocrati-galleria, photocrati-nextgen_pro_slideshow }
}
 */
define('NEXTGEN_PRO_HORIZONTAL_FILMSTRIP_MODULE_NAME', 'photocrati-nextgen_pro_horizontal_filmstrip');
class M_NextGen_Pro_Horizontal_Filmstrip extends C_Base_Module
{
	function define($context)
	{
		parent::define(
			NEXTGEN_PRO_HORIZONTAL_FILMSTRIP_MODULE_NAME,
			'NextGEN Pro Horizontal Filmstrip',
			"Provides Photocrati's Horizontal Filmstrip for NextGEN Gallery",
			'0.2',
			'http://www.nextgen-gallery.com',
			'Photocrati Media',
			'http://www.photocrati.com',
			$context
		);

		include_once('class.nextgen_pro_horizontal_filmstrip_installer.php');
		C_Photocrati_Installer::add_handler(
			$this->module_id, 'C_NextGen_Pro_Horizontal_Filmstrip_Installer'
		);
	}

	function get_type_list()
	{
		return array(
			'A_Nextgen_Pro_Horizontal_Filmstrip_Controller' => 'adapter.nextgen_pro_horizontal_filmstrip_controller.php',
			'A_Nextgen_Pro_Horizontal_Filmstrip_Form' => 'adapter.nextgen_pro_horizontal_filmstrip_form.php',
			'A_Nextgen_Pro_Horizontal_Filmstrip_Forms' => 'adapter.nextgen_pro_horizontal_filmstrip_forms.php',
			'C_Nextgen_Pro_Horizontal_Filmstrip_Installer' => 'class.nextgen_pro_horizontal_filmstrip_installer.php',
			'A_Nextgen_Pro_Horizontal_Filmstrip_Mapper' => 'adapter.nextgen_pro_horizontal_filmstrip_mapper.php',
		);
	}

	function _register_adapters()
	{
		$this->get_registry()->add_adapter(
			'I_Display_Type_Mapper',
			'A_NextGen_Pro_Horizontal_Filmstrip_Mapper'
		);

		$this->get_registry()->add_adapter(
			'I_Display_Type_Controller',
			'A_NextGen_Pro_Horizontal_Filmstrip_Controller',
			$this->module_id
		);

		$this->get_registry()->add_adapter(
			'I_Form',
			'A_NextGen_Pro_Horizontal_Filmstrip_Form',
			$this->module_id
		);

        $this->get_registry()->add_adapter(
            'I_Form_Manager',
            'A_NextGen_Pro_Horizontal_Filmstrip_Forms'
        );
	}
}
new M_NextGen_Pro_Horizontal_Filmstrip;
