<?php

class A_NextGen_Pro_Lightbox_Form extends A_Lightbox_Library_Form
{
    function get_model()
    {
        return $this->object
                    ->get_registry()
                    ->get_utility('I_Lightbox_Library_Mapper')
                    ->find_by_name(NEXTGEN_PRO_LIGHTBOX_MODULE_NAME, TRUE);
    }

    /**
     * Returns a list of fields to render on the settings page
     */
    function _get_field_names()
    {
        return array(
            'nextgen_pro_lightbox_router_slug',
            'nextgen_pro_lightbox_icon_color',
            'nextgen_pro_lightbox_fullscreen_double_tap',
            'nextgen_pro_lightbox_image_pan',
            'nextgen_pro_lightbox_interaction_pause',
            'nextgen_pro_lightbox_transition_effect',
            'nextgen_pro_lightbox_touch_transition_effect',
            'nextgen_pro_lightbox_image_crop'
        );
    }

    /**
     * Renders the 'slug' setting field
     *
     * @param $lightbox
     * @return mixed
     */
    function _render_nextgen_pro_lightbox_router_slug_field($lightbox)
    {
        return $this->_render_text_field(
            $lightbox,
            'router_slug',
            'Router slug',
            $lightbox->display_settings['router_slug'],
            'Used to route JS actions to the URL'
        );
    }

    /**
     * Renders the lightbox 'icon color' setting field
     *
     * @param $lightbox
     * @return mixed
     */
    function _render_nextgen_pro_lightbox_icon_color_field($lightbox)
    {
        return $this->_render_color_field(
            $lightbox,
            'icon_color',
            'Icon color',
            $lightbox->display_settings['icon_color']
        );
    }

    function _render_nextgen_pro_lightbox_fullscreen_double_tap_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'fullscreen_double_tap',
            'Enable fullscreen on double tap',
            $lightbox->display_settings['fullscreen_double_tap'],
            'Enabling this may cause compatibility issues with some devices'
        );
    }

    function _render_nextgen_pro_lightbox_image_pan_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'image_pan',
            'Pan cropped images',
            $lightbox->display_settings['image_pan'],
            'When enabled images can be panned with the mouse'
        );
    }

    function _render_nextgen_pro_lightbox_interaction_pause_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'interaction_pause',
            'Pause on interaction',
            $lightbox->display_settings['interaction_pause'],
            'When enabled image display will be paused if the user presses a thumbnail or any navigational link'
        );
    }

    function get_effect_options()
    {
        return array(
            'fade' => 'Crossfade betweens images',
            'flash' => 'Fades into background color between images',
            'pulse' => 'Quickly removes the image into background color, then fades the next image',
            'slide' => 'Slides the images depending on image position',
            'fadeslide' => 'Fade between images and slide slightly at the same time'
        );
    }

    function _render_nextgen_pro_lightbox_transition_effect_field($lightbox)
    {
        return $this->_render_select_field(
            $lightbox,
            'transition_effect',
            'Transition effect',
            $this->get_effect_options(),
            $lightbox->display_settings['transition_effect']
        );
    }

    function _render_nextgen_pro_lightbox_touch_transition_effect_field($lightbox)
    {
        return $this->_render_select_field(
            $lightbox,
            'touch_transition_effect',
            'Touch transition effect',
            $this->get_effect_options(),
            $lightbox->display_settings['touch_transition_effect'],
            'The transition to use on touch devices if the default transition is too intense'
        );
    }

    function _render_nextgen_pro_lightbox_image_crop_field($lightbox)
    {
        return $this->_render_select_field(
            $lightbox,
            'image_crop',
            'Crop image display',
            array(
                'true' => 'Images will be scaled to fill the display, centered and cropped',
                'false' => 'Images will be scaled down until the entire image fits',
                'height' => 'Images will scale to fill the height of the display',
                'width' => 'Images will scale to fill the width of the display',
                'landscape' => 'Landscape images will fill the display, but scale portraits to fit',
                'portrait' => 'Portrait images will fill the display, but scale landscapes to fit'
            ),
            $lightbox->display_settings['image_crop']
        );
    }

}
