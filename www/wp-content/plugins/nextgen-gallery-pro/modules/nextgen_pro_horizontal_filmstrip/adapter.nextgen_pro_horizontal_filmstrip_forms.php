<?php

class A_NextGen_Pro_Horizontal_Filmstrip_Forms extends Mixin
{
    function initialize()
    {
        $this->add_form(
            NEXTGEN_DISPLAY_SETTINGS_SLUG, NEXTGEN_PRO_HORIZONTAL_FILMSTRIP_MODULE_NAME
        );
    }
}