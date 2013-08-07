<?php

class C_NextGen_Pro_Lightbox_Installer
{
	function get_registry()
	{
		return C_Component_Registry::get_instance();
	}

    function set_attr(&$obj, $key, $val)
    {
        if (!isset($obj->$key))
            $obj->$key = $val;
    }

	function install($reset=FALSE)
	{
        $router = $this->get_registry()->get_utility('I_Router');

		// Install or update the lightbox library
		$mapper = $this->get_registry()->get_utility('I_Lightbox_Library_Mapper');
		$lightbox = $mapper->find_by_name(NEXTGEN_PRO_LIGHTBOX_MODULE_NAME);
		if (!$lightbox)
            $lightbox = new stdClass;

        // Set properties
        $lightbox->name	= NEXTGEN_PRO_LIGHTBOX_MODULE_NAME;
		$this->set_attr($lightbox, 'title', "NextGEN Pro Lightbox");
		$this->set_attr($lightbox, 'code', "class='nextgen_pro_lightbox' data-nplmodal-gallery-id='%PRO_LIGHTBOX_GALLERY_ID%'");
        $this->set_attr(
            $lightbox,
            'css_stylesheets',
            implode("\n", array(
                $router->get_static_url('photocrati-nextgen_pro_lightbox#style.css'),
                $router->get_static_url('photocrati-nextgen_pro_lightbox#icons/font-awesome.css')
            ))
        );
		$this->set_attr(
            $lightbox,
            'scripts',
            implode("\n", array(
                $router->get_static_url('photocrati-nextgen_pro_lightbox#jquery.mobile_browsers.js'),
                site_url('/wp-includes/js/underscore.min.js'),
                site_url('/wp-includes/js/backbone.min.js'),
                $router->get_static_url("photocrati-nextgen_pro_lightbox#nextgen_pro_lightbox.js")
            ))
        );
        $this->set_attr(
            $lightbox,
            'display_settings',
            array(
                'icon_color'  => '#bebebe',
                'router_slug' => 'gallery',
                'transition_effect' => 'slide',
                'touch_transition_effect' => 'slide',
                'fullscreen_double_tap' => 'false',
                'image_pan' => 'false',
                'interaction_pause' => 'true',
                'image_crop' => 'false'
            )
        );

		$mapper->save($lightbox);
	}

    function uninstall_nextgen_pro_lightbox($hard = FALSE)
    {
        $mapper = $this->get_registry()->get_utility('I_Lightbox_Library_Mapper');
        if (($lightbox = $mapper->find_by_name(NEXTGEN_PRO_LIGHTBOX_MODULE_NAME)))
            $mapper->destroy($lightbox);
    }
}
