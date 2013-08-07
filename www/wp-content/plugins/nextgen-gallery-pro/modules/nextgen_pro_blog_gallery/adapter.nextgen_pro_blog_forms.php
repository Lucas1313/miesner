<?php

class A_NextGen_Pro_Blog_Forms extends Mixin
{
    function initialize()
    {
        $this->add_form(
            NEXTGEN_DISPLAY_SETTINGS_SLUG, NEXTGEN_PRO_BLOG_GALLERY_MODULE_NAME
        );
    }
}