<?php

class A_Protect_Image_Factory extends Mixin
{
    function protect_image_config($settings=array(), $context=FALSE)
    {
        return new C_Protect_Image_Config($settings, $context);
    }
    
    function protect_image_controller()
    {
        return new C_Protect_Image_View();
    }
}
