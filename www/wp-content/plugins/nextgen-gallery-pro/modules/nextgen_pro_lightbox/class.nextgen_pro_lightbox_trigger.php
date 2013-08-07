<?php

class C_NextGen_Pro_Lightbox_Trigger
{
	var $_id;
	var $_owner;
	var $_list;
	
	function __construct($trigger_id, $trigger_manager)
	{
		$this->_id = $trigger_id;
		$this->_owner = $trigger_manager;
		$this->_list = array();
	}
	
	function get_id()
	{
		return $this->_id;
	}
	
	function get_owner()
	{
		return $this->_owner;
	}
	
	function get_property($property_name)
	{
		if (isset($this->_list[$property_name]))
		{
			return $this->_list[$property_name];
		}
		
		return null;
	}
	
	function set_property($property_name, $property_value)
	{
		$this->_list[$property_name] = $property_value;
	}
	
	function get_list()
	{
		return array_keys($this->_list);
	}
	
	function get_label()
	{
		return $this->get_property('label');
	}
	
	function set_label($label)
	{
		$this->set_property('label', $label);
	}
}
