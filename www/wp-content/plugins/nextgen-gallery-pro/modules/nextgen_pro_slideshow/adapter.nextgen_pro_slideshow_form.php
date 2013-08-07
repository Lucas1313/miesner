<?php

class A_NextGen_Pro_Slideshow_Form extends Mixin_Display_Type_Form
{
    function get_display_type_name()
	{
		return NEXTGEN_PRO_SLIDESHOW_MODULE_NAME;
	}

    function enqueue_static_resources()
    {
        wp_enqueue_script(
            $this->get_display_type_name() . '-js',
            $this->get_static_url('photocrati-nextgen_pro_slideshow#settings.js')
        );
    }

    /**
     * Returns a list of fields to render on the settings page
     */
    function _get_field_names()
    {
        return array(
            'nextgen_pro_slideshow_image_crop',
            'nextgen_pro_slideshow_image_pan',
            'nextgen_pro_slideshow_show_playback_controls',
            'nextgen_pro_slideshow_show_captions',
            'nextgen_pro_slideshow_caption_class',
            'nextgen_pro_slideshow_aspect_ratio',
            'width_and_unit',
            'nextgen_pro_slideshow_transition',
            'nextgen_pro_slideshow_transition_speed',
            'nextgen_pro_slideshow_slideshow_speed',
            'nextgen_pro_slideshow_border_size',
            'nextgen_pro_slideshow_border_color',
        );
    }

    function _render_nextgen_pro_slideshow_image_crop_field($display_type)
    {
        return $this->_render_radio_field(
            $display_type,
            'image_crop',
            'Crop images',
            $display_type->settings['image_crop']
        );
    }

    function _render_nextgen_pro_slideshow_image_pan_field($display_type)
    {
        return $this->_render_radio_field(
            $display_type,
            'image_pan',
            'Pan images',
            $display_type->settings['image_pan'],
            '',
            empty($display_type->settings['image_crop']) ? TRUE : FALSE
        );
    }

    function _render_nextgen_pro_slideshow_show_captions_field($display_type)
    {
        return $this->_render_radio_field(
            $display_type,
            'show_captions',
            'Show captions',
            $display_type->settings['show_captions']
        );
    }

    function _render_nextgen_pro_slideshow_caption_class_field($display_type)
    {
        return $this->_render_select_field(
            $display_type,
            'caption_class',
            'Caption location',
            array(
                "caption_above_stage" => "Top",
                "caption_below_stage" => "Bottom",
                "caption_overlay_top" => "Top (Overlay)",
                "caption_overlay_bottom" => "Bottom (Overlay)"
            ),
            $display_type->settings['caption_class'],
            '',
            empty($display_type->settings['show_captions']) ? TRUE : FALSE
        );
    }

    function _render_nextgen_pro_slideshow_slideshow_speed_field($display_type)
    {
        return $this->_render_number_field(
            $display_type,
            'slideshow_speed',
            'Slideshow speed',
            $display_type->settings['slideshow_speed'],
            'Measured in seconds',
            FALSE,
            'seconds',
            0
        );
    }

    function _render_nextgen_pro_slideshow_transition_field($display_type)
    {
        return $this->_render_select_field(
            $display_type,
            'transition',
            'Transition effect',
			array(
                'fade'      => 'Crossfade between images',
                'flash'     => 'Fades into background color between images',
                'pulse'     => 'Quickly move the image into the background color, then fade into the next image',
                'slide'     => 'Slide images depending on image position',
                'fadeslide' => 'Fade between images and slide slightly at the same time'
            ),
            $display_type->settings['transition'],
            '',
            FALSE
        );
    }

    function _render_nextgen_pro_slideshow_transition_speed_field($display_type)
    {
        return $this->_render_number_field(
            $display_type,
            'transition_speed',
            'Transition speed',
            $display_type->settings['transition_speed'],
            'Measured in seconds',
            FALSE,
            'seconds',
            0
        );
    }

    function _render_nextgen_pro_slideshow_border_size_field($display_type)
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

    function _render_nextgen_pro_slideshow_border_color_field($display_type)
    {
        return $this->_render_color_field(
            $display_type,
            'border_color',
            'Border color',
            $display_type->settings['border_color']
        );
    }

    function _render_nextgen_pro_slideshow_aspect_ratio_field($display_type)
    {
        return $this->_render_select_field(
            $display_type,
            'aspect_ratio',
            'Stage aspect ratio',
			$this->_get_aspect_ratio_options(),
            $display_type->settings['aspect_ratio'],
            '',
            FALSE
        );
    }

    function _render_nextgen_pro_slideshow_show_playback_controls_field($display_type)
    {
        return $this->_render_radio_field(
            $display_type,
            'show_playback_controls',
            'Show play controls',
            $display_type->settings['show_playback_controls']
        );
    }
}
