<?php

class C_Protect_Image_Config extends C_Base_Component_Config
{
		function set_defaults()
    {
        $this->settings = array_merge($this->settings, array(
								'protect_enable_site' => 1,
								'protect_enable_image'=> 1,
								'protect_enable_gallery' => 1,
								'protect_enable_lightbox' => 1
        ));
        
        parent::set_defaults();
    }
    
    
    function validation()
    {
    }    
}
