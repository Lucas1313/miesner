<?php

class A_NextGen_Pro_Horizontal_Filmstrip_Form extends A_NextGen_Pro_Slideshow_Form
{
    function get_display_type_name()
	{
		return NEXTGEN_PRO_HORIZONTAL_FILMSTRIP_MODULE_NAME;
	}

    function enqueue_static_resources()
    {
        wp_enqueue_script(
            $this->object->get_display_type_name() . '-js',
            $this->get_static_url('photocrati-nextgen_pro_horizontal_filmstrip#settings.js')
        );
    }

    /**
     * Returns a list of fields to render on the settings page
     */
    function _get_field_names()
    {
		$fields = parent::_get_field_names();
		$fields[] = 'image_override_settings';
		$fields[] = 'thumbnail_override_settings';
        return $fields;
    }
}