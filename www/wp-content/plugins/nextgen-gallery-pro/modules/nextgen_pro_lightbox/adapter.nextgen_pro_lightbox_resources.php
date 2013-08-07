<?php

class A_Nextgen_Pro_Lightbox_Resources extends Mixin
{

    function initialize()
    {
        if (C_NextGen_Settings::get_instance()->thumbEffect == NEXTGEN_PRO_LIGHTBOX_MODULE_NAME) {
            $this->object->add_post_hook(
                'enqueue_lightbox_resources',
                'Injects pro-lightbox url paths into the page DOM',
                get_class(),
                'enqueue_pro_lightbox_resources'
            );
        }
    }

    function enqueue_pro_lightbox_resources($displayed_gallery)
    {
        $this->object->_add_script_data(
            'ngg_common',
            'galleries.gallery_' . $displayed_gallery->id() . '.wordpress_page_root',
            get_permalink(),
            FALSE
        );

        // retrieve the lightbox so we can examine its settings
        $mapper = $this->object->get_registry()->get_utility('I_Lightbox_Library_Mapper');
        $library = $mapper->find_by_name(NEXTGEN_PRO_LIGHTBOX_MODULE_NAME, TRUE);

        wp_localize_script(
            'photocrati-nextgen_pro_lightbox-0',
            'nplModalSettings',
            array(
                'gallery_url' => $this->object->get_router()->get_url('/nextgen-pro-lightbox-gallery/{gallery_id}/'),
                'is_front_page' => is_front_page() ? 1 : 0,
                'router_slug' => $library->display_settings['router_slug'],
                'iscroll_url' => $this->object->get_router()->get_static_url('photocrati-nextgen_pro_lightbox#iscroll.js'),
                'fontawesome_url' => $this->object->get_router()->get_static_url('photocrati-nextgen_pro_lightbox#icons/font-awesome.css'),
                'share_url' => $this->object->get_router()->get_url('/nextgen-share/{gallery_id}/{image_id}/')
            )
        );
    }

}
