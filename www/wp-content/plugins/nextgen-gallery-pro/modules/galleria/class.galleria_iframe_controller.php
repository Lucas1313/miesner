<?php

class C_Galleria_iFrame_Controller extends C_MVC_Controller
{
	static $_instances = array();

	function define($context=FALSE)
	{
		parent::define($context);
		$this->add_mixin('Mixin_Galleria_iFrame_Controller');
		$this->implement('I_Galleria_iFrame_Controller');
	}

	/**
	 * Returns an instance of this controller
	 * @param string|array $context
	 * @return C_Galleria_iFrame_Controller
	 */
	static function get_instance($context=FALSE)
	{
		if (!isset(self::$_instances[$context])) {
			$klass = __CLASS__;
			self::$_instances[$context] = new $klass($context);
		}
		return self::$_instances[$context];
	}
}


class Mixin_Galleria_iFrame_Controller extends Mixin
{
	function index_action($return=FALSE)
	{
		$this->object->expires("1 year");
		// IMPORTANT: The Displayed Gallery has already been fetched by the
		// parent frame, and is available on the client side as
		// window.galleries.gallery_[id] and therefore fetching the
		// displayed gallery on the server side is strongly discouraged as it's
		// a redundant database query. Instead, find a way to make use of the
		// client side object
		return $this->object->render_view(
            'photocrati-galleria#galleria_iframe',
            array(
                'id'                   => $this->param('id'),
                'jquery_url'           => includes_url('/js/jquery/jquery.js'),
                'galleria_url'         => $this->get_static_url('photocrati-galleria#galleria-1.2.9.min.js'),
                'galleria_instance_js' => $this->object->galleria_instance_js()
            ),
            $return
        );
	}


	function galleria_instance_js()
	{
		return $this->object->render_partial('photocrati-galleria#galleria_instance_js', array(), TRUE);
	}
}
