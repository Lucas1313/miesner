<?php

class Mixin_Protect_Image_View extends Mixin
{
    function index()
    {
    }
    
    
    function enqueue_scripts($attached_gallery)
    {
    	// XXX load settings
    		$settings = array();
    		
        $this->resource_loader->enqueue_script(
            'protect_image_settings_js',
            FALSE,
            $settings
        );
    }
    
    function enqueue_stylesheets($attached_gallery)
    {
    }
}


class C_Protect_Image_View extends C_MVC_Controller
{
    function define()
    {
        parent::define();
        
        $this->add_mixin('Mixin_Protect_Image_View');
    }
}
