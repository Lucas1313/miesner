<?php

class C_Protect_Settings extends C_Base_Form_Handler
{
    var $form_identifier = __CLASS__;
    
    
    function define()
    {
        parent::define();
        
        $this->del_mixin('Mixin_Form_Handler_Overrides');
    }
    
    
    function get_config()
    {
    }
    
    
    function render_form($return=FALSE)
    {
    	// XXX load settings properly
    	
        return $this->render_partial('protect_settings_form', array(
            'protect_enable_site' => 1,
            'protect_enable_image' => 1,
            'protect_enable_gallery' => 1,
            'protect_enable_lightbox' => 1
        ), $return);
    }
}
