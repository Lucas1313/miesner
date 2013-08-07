<?php

/**
 * Adds validation
 */
class A_NextGen_Pro_Masonry extends Mixin
{
    function initialize()
    {
        if ($this->object->name == NEXTGEN_GALLERY_NEXTGEN_PRO_MASONRY)
            $this->object->add_pre_hook('validation', __CLASS__, 'Hook_NextGen_Pro_Masonry_Validation');
    }
}

/**
 * Provides validation
 */
class Hook_NextGen_Pro_Masonry_Validation extends Hook
{
    function validation()
    {
    }
}
