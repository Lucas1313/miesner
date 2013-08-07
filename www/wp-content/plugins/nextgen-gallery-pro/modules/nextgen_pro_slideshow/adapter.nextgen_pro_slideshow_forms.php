<?php

class A_NextGen_Pro_Slideshow_Forms extends Mixin
{
    function initialize()
    {
        $this->add_form(
			NEXTGEN_DISPLAY_SETTINGS_SLUG, NEXTGEN_PRO_SLIDESHOW_MODULE_NAME
		);
    }
}