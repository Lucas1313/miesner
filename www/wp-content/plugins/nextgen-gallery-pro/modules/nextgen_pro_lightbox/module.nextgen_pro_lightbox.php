<?php
/*
{
	Module: photocrati-nextgen_pro_lightbox,
    Depends: { photocrati-lightbox }
}
 */

define('NEXTGEN_PRO_LIGHTBOX_MODULE_NAME', 'photocrati-nextgen_pro_lightbox');

class M_NextGen_Pro_Lightbox extends C_Base_Module
{
	function define($context=FALSE)
	{
		parent::define(
			NEXTGEN_PRO_LIGHTBOX_MODULE_NAME,
			'NextGEN Pro Lightbox',
			'Provides a lightbox with integrated commenting, social sharing, and e-commerce functionality',
			'0.1',
			'http://www.photocrati.com',
			'Photocrati Media',
			'http://www.photocrati.com',
			$context
		);

		include_once('class.nextgen_pro_lightbox_installer.php');
		C_Photocrati_Installer::add_handler($this->module_id, 'C_NextGen_Pro_Lightbox_Installer');
	}

	function _register_adapters()
	{
        // controllers & their helpers
        $this->get_registry()->add_adapter('I_Display_Type_Controller', 'A_NextGen_Pro_Lightbox_Effect_Code');
        $this->get_registry()->add_adapter('I_Display_Type_Controller', 'A_NextGen_Pro_Lightbox_Resources');
		$this->get_registry()->add_adapter('I_Display_Type_Controller', 'A_NextGen_Pro_Lightbox_Triggers_Resources');
		$this->get_registry()->add_adapter('I_MVC_View', 'A_NextGen_Pro_Lightbox_Triggers_Element');
		$this->get_registry()->add_adapter('I_Display_Type_Form', 'A_NextGen_Pro_Lightbox_Triggers_Form');

        // routes & rewrites
        $this->get_registry()->add_adapter('I_Router', 'A_NextGen_Pro_Lightbox_Routes');

        // settings form
        $this->get_registry()->add_adapter('I_Form', 'A_NextGen_Pro_Lightbox_Form', NEXTGEN_PRO_LIGHTBOX_MODULE_NAME . '_basic');
        $this->get_registry()->add_adapter('I_Form_Manager', 'A_NextGen_Pro_Lightbox_Forms');
	}

    function _register_utilities()
    {
        // The second controller is for handling lightbox display
        $this->get_registry()->add_utility('I_NextGen_Pro_Lightbox_Controller', 'C_NextGen_Pro_Lightbox_Controller');
        $this->get_registry()->add_utility('I_NextGen_Pro_Lightbox_Trigger_Manager', 'C_NextGen_Pro_Lightbox_Trigger_Manager');
        $this->get_registry()->add_utility('I_OpenGraph_Controller', 'C_OpenGraph_Controller');
    }

    function get_type_list()
    {
        return array(
            'A_Nextgen_Pro_Lightbox_Effect_Code' => 'adapter.nextgen_pro_lightbox_effect_code.php',
            'A_Nextgen_Pro_Lightbox_Form' => 'adapter.nextgen_pro_lightbox_form.php',
            'A_Nextgen_Pro_Lightbox_Forms' => 'adapter.nextgen_pro_lightbox_forms.php',
            'C_NextGen_Pro_Lightbox_Installer' => 'class.nextgen_pro_lightbox_installer.php',
            'A_Nextgen_Pro_Lightbox_Triggers_Element' => 'adapter.nextgen_pro_lightbox_triggers_element.php',
            'A_Nextgen_Pro_Lightbox_Triggers_Form' => 'adapter.nextgen_pro_lightbox_triggers_form.php',
            'A_Nextgen_Pro_Lightbox_Resources' => 'adapter.nextgen_pro_lightbox_resources.php',
            'A_Nextgen_Pro_Lightbox_Routes' => 'adapter.nextgen_pro_lightbox_routes.php',
            'A_Nextgen_Pro_Lightbox_Triggers_Resources' => 'adapter.nextgen_pro_lightbox_triggers_resources.php',
            'C_Nextgen_Pro_Lightbox_Controller' => 'class.nextgen_pro_lightbox_controller.php',
            'C_Opengraph_Controller' => 'class.opengraph_controller.php',
            'C_Nextgen_Pro_Lightbox_Trigger' => 'class.nextgen_pro_lightbox_trigger.php',
            'C_Nextgen_Pro_Lightbox_Trigger_Manager' => 'class.nextgen_pro_lightbox_trigger_manager.php',
            'I_Nextgen_Pro_Lightbox_Controller' => 'interface.nextgen_pro_lightbox_controller.php',
            'I_Nextgen_Pro_Lightbox_Trigger_Manager' => 'interface.nextgen_pro_lightbox_trigger_manager.php',
            'I_Opengraph_Controller' => 'interface.opengraph_controller.php',
            'M_Nextgen_Pro_Lightbox' => 'module.nextgen_pro_lightbox.php'
        );
    }
}

new M_NextGen_Pro_Lightbox;
