<?php

class A_NextGen_Pro_Film_Form extends Mixin_Display_Type_Form
{
    function get_display_type_name()
	{
		return NEXTGEN_PRO_FILM_MODULE_NAME;
	}

    function enqueue_static_resources()
    {
        wp_enqueue_script(
            $this->object->get_display_type_name() . '-js',
            $this->get_static_url('photocrati-nextgen_pro_film#settings.js')
        );
    }

    /**
     * Returns a list of fields to render on the settings page
     */
    function _get_field_names()
    {
        return array(
            'thumbnail_override_settings',
            'nextgen_pro_film_images_per_page',
            'nextgen_pro_film_image_spacing',
            'nextgen_pro_film_border_size',
            'nextgen_pro_film_frame_size',
            'nextgen_pro_film_border_color',
            'nextgen_pro_film_frame_color'
        );
    }

    /**
     * Renders the images_per_page settings field
     *
     * @param C_Display_Type $display_type
     * @return string
     */
    function _render_nextgen_pro_film_images_per_page_field($display_type)
    {
        return $this->_render_number_field(
            $display_type,
            'images_per_page',
            'Images per page',
            $display_type->settings['images_per_page'],
            '"0" will display all images at once',
            FALSE,
            '# of images',
            0
        );
    }

    function _render_nextgen_pro_film_border_size_field($display_type)
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

    function _render_nextgen_pro_film_border_color_field($display_type)
    {
        return $this->_render_color_field(
            $display_type,
            'border_color',
            'Border color',
            $display_type->settings['border_color']
        );
    }

    function _render_nextgen_pro_film_frame_size_field($display_type)
    {
        return $this->_render_number_field(
            $display_type,
            'frame_size',
            'Frame size',
            $display_type->settings['frame_size'],
            '',
            FALSE,
            '',
            0
        );
    }

    function _render_nextgen_pro_film_frame_color_field($display_type)
    {
        return $this->_render_color_field(
            $display_type,
            'frame_color',
            'Frame color',
            $display_type->settings['frame_color']
        );
    }

    function _render_nextgen_pro_film_image_spacing_field($display_type)
    {
        return $this->_render_number_field(
            $display_type,
            'image_spacing',
            'Image spacing',
            $display_type->settings['image_spacing'],
            '',
            FALSE,
            '',
            0
        );
    }
}