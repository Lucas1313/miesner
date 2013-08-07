<?php

class A_Protect_Image_Resources extends Mixin
{
    function protect_image_css($args)
    {
    }
    
    
    function protect_image_js($args)
    {
    die(var_dump('BUUUUU'));
#        $this->render_partial('photocrati_slidebox_gallery_css', array(
#            'css_class'             => $css_class
#        ));
    }
}
