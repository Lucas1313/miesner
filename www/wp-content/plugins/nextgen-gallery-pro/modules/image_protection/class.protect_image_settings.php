<?php

class C_Protect_Image_Settings extends C_Base_Form_Handler
{
    var $form_identifier = __CLASS__;
    var $factory_method  = 'protect_image_config';
    
    function define()
    {
        parent::define();
        
        $this->del_mixin('Mixin_Form_Handler_Overrides');
    }
    
    
    function get_config()
    {
        $factory = $this->get_registry()->get_singleton_utility('I_Component_Factory');
        
        return $this->config = $factory->create(
            $this->factory_method,
            $this->handle_this_form() ? $this->param('settings') : array()
        );
    }
    
    
    function render_form($return=FALSE)
    {
        $config = $this->get_config();
        $settings = $config->settings;
    	
        return $this->render_partial('protect_image_settings_form', $settings, $return);
    }
}
