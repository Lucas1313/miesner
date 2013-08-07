<?php

/***
	{
		Module: photocrati-protect_image,
		Depends: { photocrati-admin }
	}
***/

define('NEXTGEN_GALLERY_PROTECT_IMAGE_MOD_URL', path_join(NEXTGEN_GALLERY_MODULE_URL, basename(dirname(__FILE__))));
define('NEXTGEN_GALLERY_PROTECT_IMAGE_MOD_STATIC_URL', path_join(NEXTGEN_GALLERY_PROTECT_IMAGE_MOD_URL, 'static'));

class M_Protect_Image extends C_Base_Module
{
    function define()
    {
        parent::define(
           'photocrati-protect_image',
           'Protect Images',
           'Protects images from being stored locally by preventing right clicks and drag & drop of the images',
           '0.1',
           'http://www.photocrati.com',
           'Photocrati Media',
           'http://www.photocrati.com'
        );
    }


    function initialize()
    {
		parent::initialize();
        $factory = $this->get_registry()->get_singleton_utility('I_Component_Factory');
        $this->_controller = $factory->create('protect_image_controller');
    }


    function _register_hooks()
    {
    	if (!is_admin())
    	{
		    wp_register_script(
		        'pc-protect_image',
		        path_join(
		            NEXTGEN_GALLERY_PROTECT_IMAGE_MOD_STATIC_URL,
		            'custom.js'
		        ),
		        array('jquery')
		    );

#		    wp_register_style(
#		        'pc-protect_image',
#		        path_join(
#		            NEXTGEN_GALLERY_PROTECT_IMAGE_MOD_STATIC_URL,
#		            'custom.css'
#		        )
#		    );

		    //wp_dequeue_script('shutter');
		    //wp_enqueue_script('jquery-livequery');
		    wp_enqueue_script('pc-protect_image');
		    //wp_enqueue_style('pc-protect_image');

        $factory = $this->get_registry()->get_singleton_utility('I_Component_Factory');
        $data = $factory->create('protect_image_config')->settings;
        wp_localize_script('pc-protect_image', 'photocrati_protect_image', $data);
    	}
    }


    function _register_adapters()
    {
        $this->get_registry()->add_adapter('I_Component_Factory', 'A_Protect_Image_Factory');

        $this->get_registry()->add_adapter(
            'I_Resource_Loader',
            'A_Protect_Image_Resources'
        );

        $this->get_registry()->add_adapter(
             'I_Admin_Controller',
             'A_Protect_Image_Admin_Controller'
        );
    }
}

new M_Protect_Image();
