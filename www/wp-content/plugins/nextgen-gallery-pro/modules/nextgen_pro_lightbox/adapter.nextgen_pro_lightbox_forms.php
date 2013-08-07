<?php

class A_NextGen_Pro_Lightbox_Forms extends Mixin
{
    function initialize()
    {
        $this->add_form(NEXTGEN_LIGHTBOX_OPTIONS_SLUG, NEXTGEN_PRO_LIGHTBOX_MODULE_NAME . '_basic');
    }
}