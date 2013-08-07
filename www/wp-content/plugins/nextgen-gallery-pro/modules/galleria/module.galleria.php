<?php

/*
{
	Module: photocrati-galleria
}
 */

define('NEXTGEN_GALLERIA_MODULE_NAME', 'photocrati-galleria');

class M_Galleria extends C_Base_Module
{
	function define($context=FALSE)
	{
		parent::define(
			'photocrati-galleria',
			'Galleria',
			'Provides support for displaying galleries using Galleria Themes',
			'0.1',
			'http://www.nextgen-gallery.com',
			'Photocrati Media',
			'http://www.photocrati.com',
			$context
		);
	}

	function get_type_list()
	{
		return array(
			'A_Galleria_Controller' => 'adapter.galleria_controller.php',
			'A_Galleria_Routes' => 'adapter.galleria_routes.php',
			'C_Galleria_Iframe_Controller' => 'class.galleria_iframe_controller.php',
			'I_Galleria_Iframe_Controller' => 'interface.galleria_iframe_controller.php',
		);
	}

	function _register_adapters()
	{
		$this->get_registry()->add_adapter(
			'I_Router',
			'A_Galleria_Routes'
		);

		// Adapt the controller for the Galleria display type
		$this->get_registry()->add_adapter(
			'I_Display_Type_Controller',
			'A_Galleria_Controller',
			$this->module_id
		);
	}

	function _register_utilities()
	{
		$this->get_registry()->add_utility(
			'I_Galleria_iFrame_Controller',
			'C_Galleria_iFrame_Controller'
		);
	}
}

new M_Galleria();
