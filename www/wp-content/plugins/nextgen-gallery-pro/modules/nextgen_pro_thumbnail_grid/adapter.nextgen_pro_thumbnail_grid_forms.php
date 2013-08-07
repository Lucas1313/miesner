<?php

class A_NextGen_Pro_Thumbnail_Grid_Forms extends Mixin
{
    function initialize()
    {
        $this->add_form(
            NEXTGEN_DISPLAY_SETTINGS_SLUG, NEXTGEN_PRO_THUMBNAIL_GRID_MODULE_NAME
        );
    }
}