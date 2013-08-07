<?php

/*
 * See adapter.nextgen_pro_lightbox_controller.php for the settings controller
 */

class C_NextGen_Pro_Lightbox_Controller extends C_MVC_Controller
{
    static $_instances = array();

    function define($context = FALSE)
    {
        parent::define($context);
        $this->add_mixin('Mixin_NextGen_Pro_Lightbox_Controller');
        $this->implement('C_NextGen_Pro_Lightbox_Controller');
    }

    static function get_instance($context = FALSE)
    {
        if (!isset(self::$_instances[$context]))
        {
            $klass = get_class();
            self::$_instances[$context] = new $klass($context);
        }
        return self::$_instances[$context];
    }
}

class Mixin_NextGen_Pro_Lightbox_Controller extends C_MVC_Controller
{
    function index_action()
    {
        wp_enqueue_script('jquery');
        wp_dequeue_script('admin-bar');
        wp_dequeue_style('admin-bar');
		wp_dequeue_script('devicepx');

        // retrieve by transient id
        $transient_id = $this->object->param('id');
        $factory = $this->object->get_registry()->get_utility('I_Component_Factory');
        $mapper = $this->object->get_registry()->get_utility('I_Displayed_Gallery_Mapper');
        $displayed_gallery = $factory->create('displayed_gallery', $mapper);
        $displayed_gallery->apply_transient($transient_id);

        // For performance reasons we try to avoid loading every image in the entire site
        if ($displayed_gallery->source == 'random')
        {
            if (!empty($displayed_gallery->display_settings['images_per_page']))
                $displayed_gallery->maximum_entity_count = $displayed_gallery->display_settings['images_per_page'];
            if (empty($displayed_gallery->display_settings['images_per_page']))
                $displayed_gallery->maximum_entity_count = 1;
        }

        $renderer = $this->get_registry()->get_utility('I_Displayed_Gallery_Renderer');
        $displayed_gallery->display_type = NEXTGEN_GALLERIA_MODULE_NAME;
        $displayed_gallery->display_settings['theme'] = $this->object->get_static_url('photocrati-nextgen_pro_lightbox#theme/galleria.nextgen_pro_lightbox.js');

        // retrieve the lightbox so we can examine its settings
        $mapper = $this->object->get_registry()->get_utility('I_Lightbox_Library_Mapper');
        $library = $mapper->find_by_name(NEXTGEN_PRO_LIGHTBOX_MODULE_NAME, TRUE);

        return $this->render_view(
            'photocrati-nextgen_pro_lightbox#index',
            array(
                'galleria'         => $renderer->render($displayed_gallery, TRUE, 'bare'),
                'display_settings' => $library->display_settings
            )
        );
    }
}
