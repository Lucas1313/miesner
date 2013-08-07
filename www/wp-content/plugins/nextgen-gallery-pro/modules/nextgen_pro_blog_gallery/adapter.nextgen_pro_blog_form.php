<?php

class A_NextGen_Pro_Blog_Form extends Mixin_Display_Type_Form
{
	function get_display_type_name()
	{
		return NEXTGEN_PRO_BLOG_GALLERY_MODULE_NAME;
	}

    function enqueue_static_resources()
    {
        wp_enqueue_script(
            $this->object->get_display_type_name() . '-js',
            $this->get_static_url('photocrati-nextgen_pro_blog_gallery#settings.js')
        );
    }

    /**
     * Returns a list of fields to render on the settings page
     */
    function _get_field_names()
    {
        return array(
            'image_override_settings',
            'nextgen_pro_blog_gallery_image_display_size',
            'nextgen_pro_blog_gallery_spacing',
            'nextgen_pro_blog_gallery_border_size',
            'nextgen_pro_blog_gallery_border_color'
        );
    }

    function _render_nextgen_pro_blog_gallery_border_size_field($display_type)
    {
        return $this->_render_number_field(
            $display_type,
            'border_size',
            'Border size',
            $display_type->settings['border_size'],
            '',
            FALSE,
            '',
            0
        );
    }

    function _render_nextgen_pro_blog_gallery_border_color_field($display_type)
    {
        return $this->_render_color_field(
            $display_type,
            'border_color',
            'Border color',
            $display_type->settings['border_color']
        );
    }

    function _render_nextgen_pro_blog_gallery_image_display_size_field($display_type)
    {
        return $this->_render_number_field(
            $display_type,
            'image_display_size',
            'Image display size',
            $display_type->settings['image_display_size'],
            'Measured in pixels',
            FALSE,
            'image width',
            0
        );
    }

    function _render_nextgen_pro_blog_gallery_spacing_field($display_type)
    {
        return $this->_render_number_field(
            $display_type,
            'spacing',
            'Image spacing',
            $display_type->settings['spacing'],
            'Measured in pixels',
            FALSE,
            '',
            0
        );
    }

}