<?php
/*
 * This form is meant to be extended by each album type, it provides defaults for common settings
 */
class A_NextGen_Pro_Album_Form extends Mixin_Display_Type_Form
{
    /**
     * Enqueues static resources required by this form
     */
    function enqueue_static_resources()
    {
        wp_enqueue_script(
            'nextgen_pro_albums_settings_script',
            $this->object->get_static_url('photocrati-nextgen_pro_albums#settings.js'),
            array('jquery.nextgen_radio_toggle')
        );
    }

    /**
     * Returns a list of fields to render on the settings page
     */
    function _get_field_names()
    {
        return array(
            'thumbnail_override_settings',
            'nextgen_pro_albums_caption_color',
            'nextgen_pro_albums_caption_size',
            'nextgen_pro_albums_border_color',
            'nextgen_pro_albums_border_size',
            'nextgen_pro_albums_background_color',
            'nextgen_pro_albums_padding',
            'nextgen_pro_albums_spacing'
        );
    }

    function _render_nextgen_pro_albums_caption_color_field($display_type)
    {
        return $this->_render_color_field(
            $display_type,
            'caption_color',
            'Caption color',
            $display_type->settings['caption_color']
        );
    }

    function _render_nextgen_pro_albums_caption_size_field($display_type)
    {
        return $this->_render_number_field(
            $display_type,
            'caption_size',
            'Caption size',
            $display_type->settings['caption_size'],
            '',
            FALSE,
            '',
            0
        );
    }

    function _render_nextgen_pro_albums_border_color_field($display_type)
    {
        return $this->_render_color_field(
            $display_type,
            'border_color',
            'Border color',
            $display_type->settings['border_color']
        );
    }

    function _render_nextgen_pro_albums_border_size_field($display_type)
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

    function _render_nextgen_pro_albums_background_color_field($display_type)
    {
        return $this->_render_color_field(
            $display_type,
            'background_color',
            'Background color',
            $display_type->settings['background_color']
        );
    }

    function _render_nextgen_pro_albums_padding_field($display_type)
    {
        return $this->_render_number_field(
            $display_type,
            'padding',
            'Padding',
            $display_type->settings['padding'],
            '',
            FALSE,
            '',
            0
        );
    }

    function _render_nextgen_pro_albums_spacing_field($display_type)
    {
        return $this->_render_number_field(
            $display_type,
            'spacing',
            'Spacing',
            $display_type->settings['spacing'],
            '',
            FALSE,
            '',
            0
        );
    }
}