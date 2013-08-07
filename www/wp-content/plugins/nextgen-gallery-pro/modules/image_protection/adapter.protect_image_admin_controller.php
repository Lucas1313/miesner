<?php

class A_Protect_Image_Admin_Controller extends Mixin
{
    function _get_other_options_forms()
    {
    		$others = $this->call_parent('_get_other_options_forms');
    		$others = array_merge($others, array(_('Site Protection') => 'C_Protect_Image_Settings'));

        return $others;
    }
}
