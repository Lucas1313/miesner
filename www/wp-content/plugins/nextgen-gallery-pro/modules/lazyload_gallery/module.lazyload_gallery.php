<?php
/*
{
	Module: photocrati-lazyload_gallery
}
 */

class M_LazyLoad_Gallery extends C_Base_Module
{
	function define($context=FALSE)
	{
		parent::define(
			'photocrati-lazyload_gallery',
			'LazyLoad Gallery Engine',
			'Provides an engine for galleries that require lazyload capabilities',
			'0.2',
			'http://www.photocrati.com',
			'Photocrati Media',
			'http://www.photocrati.com',
			$context
		);
	}

	function get_type_list()
	{
		return array(
			'A_Lazyload_Gallery_Controller' => 'adapter.lazyload_gallery_controller.php',
		);
	}

    function _register_hooks()
    {
        add_action('init', array(&$this, 'register_scripts'));
    }

    function register_scripts()
    {
        $router = $this->get_registry()->get_utility('I_Router');
        wp_register_script(
            'jquery.lazyload',
            $router->get_static_url('photocrati-lazyload_gallery#jquery.lazyload.js'),
            array('jquery')
        );
    }
}

new M_LazyLoad_Gallery;
