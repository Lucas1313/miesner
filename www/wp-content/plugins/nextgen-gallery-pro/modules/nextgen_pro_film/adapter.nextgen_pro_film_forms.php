<?php

class A_NextGen_Pro_Film_Forms extends Mixin
{
    function initialize()
    {
        $this->add_form(
            NEXTGEN_DISPLAY_SETTINGS_SLUG, NEXTGEN_PRO_FILM_MODULE_NAME
        );
    }
}