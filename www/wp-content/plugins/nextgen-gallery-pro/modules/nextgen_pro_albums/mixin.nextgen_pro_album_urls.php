<?php

class Mixin_NextGen_Pro_Album_Urls extends Mixin
{
	function initialize()
	{
		$this->object->add_post_hook(
			'set_param_for',
			get_class(),
			get_class(),
			'set_param_for_nextgen_pro_albums'
		);
	}

	function set_param_for_nextgen_pro_albums()
	{
		// Get method's return value
		$retval = $this->object->get_method_property(
			'set_param_for',
			ExtensibleObject::METHOD_PROPERTY_RETURN_VALUE
		);

		// Adjust the return value
		$retval = preg_replace("#album--([^/]+)#", '\1', $retval);
		$retval = preg_replace("#gallery--([^/]+)#", '\1', $retval);
		$this->object->set_method_property(
			'set_param_for',
			ExtensibleObject::METHOD_PROPERTY_RETURN_VALUE,
			$retval
		);

		return $retval;
	}
}