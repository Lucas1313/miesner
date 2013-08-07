<?php
/*
 {
	Module: photocrati-nextgen_pro_blog_gallery
 }
 */
define('NEXTGEN_PRO_BLOG_GALLERY_MODULE_NAME', 'photocrati-nextgen_pro_blog_gallery');
class M_NextGen_Pro_Blog_Gallery extends C_Base_Module
{
	function define($context=FALSE)
	{
		parent::define(
			NEXTGEN_PRO_BLOG_GALLERY_MODULE_NAME,
			'NextGEN Pro Blog Gallery',
			"Provides Photocrati's Blog Style gallery type for NextGEN Gallery",
			'0.2',
			'http://www.nextgen-gallery.com',
			'Photocrati Media',
			'http://www.photocrati.com',
			$context
		);

		include_once('class.nextgen_pro_blog_installer.php');
		C_Photocrati_Installer::add_handler($this->module_id, 'C_NextGen_Pro_Blog_Installer');
	}


	function get_type_list()
	{
		return array(
			'A_Nextgen_Pro_Blog_Controller' => 'adapter.nextgen_pro_blog_controller.php',
			'A_Nextgen_Pro_Blog_Dynamic_Styles' => 'adapter.nextgen_pro_blog_dynamic_styles.php',
			'A_Nextgen_Pro_Blog_Form' => 'adapter.nextgen_pro_blog_form.php',
			'A_Nextgen_Pro_Blog_Forms' => 'adapter.nextgen_pro_blog_forms.php',
			'C_NextGen_Pro_Blog_Installer' => 'class.nextgen_pro_blog_installer.php',
			'A_Nextgen_Pro_Blog_Mapper' => 'adapter.nextgen_pro_blog_mapper.php',
		);
	}

	function _register_adapters()
	{
		$this->get_registry()->add_adapter(
			'I_Display_Type_Controller',
			'A_NextGen_Pro_Blog_Controller',
			$this->module_id
		);

		$this->get_registry()->add_adapter(
			'I_Display_Type_Mapper',
			'A_NextGen_Pro_Blog_Mapper'
		);

		$this->get_registry()->add_adapter(
			'I_Dynamic_Stylesheet',
			'A_NextGen_Pro_Blog_Dynamic_Styles'
		);

		$this->get_registry()->add_adapter(
			'I_Form',
			'A_NextGen_Pro_Blog_Form',
			$this->module_id
		);

        $this->get_registry()->add_adapter(
            'I_Form_Manager',
            'A_NextGen_Pro_Blog_Forms'
        );
	}
}

new M_NextGen_Pro_Blog_Gallery;
