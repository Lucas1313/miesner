<?php

class Mixin_NextGen_Pro_Lightbox_Trigger_Manager extends Mixin
{
	var $_list = array();
	
	function get_default_trigger_list()
	{
		return array(
			'photocrati.lightbox', 
			'photocrati.social', 
			/*'photocrati.cart',*/
		);
	}

	function get_trigger_list()
	{
		$default_list = $this->object->get_default_trigger_list();
		$list = array_keys($this->_list);
		
		if ($list != null)
		{
			foreach ($list as $item)
			{
				$index = array_search($item, $default_list);
				
				if ($index !== false)
				{
					unset($default_list[$index]);	
				}
			}
		}
		
		$list = array_merge($default_list, $list);
		
		return $list;
	}

	function get_trigger($trigger_id)
	{
		$trigger = null;
		
		if (!isset($this->_list[$trigger_id]))
		{
			$trigger = $this->object->create_default_trigger($trigger_id);
			
			if ($trigger != null)
			{
				$this->object->add_trigger($trigger_id, $trigger);
			}
		}
		
		if (isset($this->_list[$trigger_id]))
		{
			$trigger = $this->_list[$trigger_id];
		}
		
		return $trigger;
	}

	function add_trigger($trigger_id, $trigger)
	{
		if (!isset($this->_list[$trigger_id]))
		{
			$this->_list[$trigger_id] = $trigger;
		}
	}

	function remove_trigger($trigger_id, $trigger)
	{
		if (isset($this->_list[$trigger_id]))
		{
			unset($this->_list[$trigger_id]);
		}
	}
}

class Mixin_NextGen_Pro_Lightbox_Trigger_Render extends Mixin
{
	var $_object_list = array();
	var $_descriptor_list = array();
	
	function _get_descriptor_index($object, $force = false)
	{
		foreach ($this->_object_list as $object_index => $object_object)
		{
			if ($object_object === $object)
			{
				return $object_index;
			}
		}
		
		if ($force)
		{
			$count = count($this->_object_list);
			
			$this->_object_list[$count] = $object;
			$this->_descriptor_list[$count] = array('state' => 'none');
			
			return $count;
		}
		
		return -1;
	}
	
	function get_object_state($object)
	{
		$index = $this->object->_get_descriptor_index($object);
		
		if ($index > -1)
		{
			return $this->_descriptor_list[$index]['state'];
		}
		
		return null;
	}
	
	function set_object_state($object, $state)
	{
		$index = $this->object->_get_descriptor_index($object, true);
		
		if ($index > -1)
		{
			$this->_descriptor_list[$index]['state'] = $state;
		}
	}
	
	function render_trigger_list($trigger_list = null, $params = null, $object = null)
	{
		$out = null;
		
		if ($trigger_list == null)
		{
			$trigger_list = $this->object->get_trigger_list();
		}
		
		$params_list = $params ? array_keys($params) : array();
		$params_trigger = array();
		$trigger_mark = '-trigger-';
		
		foreach ($params_list as $param_name)
		{
			if (strpos($param_name, $trigger_mark) === 0 && is_array($params[$param_name]))
			{
				$trigger_id = substr($param_name, strlen($trigger_mark));
				
				$params_trigger[$trigger_id] = $params[$param_name];
				
				unset($params[$param_name]);
			}
		}
		
		if ($object != null)
		{
			$this->object->set_object_state($object, 'rendering');
		}
		
		foreach ($trigger_list as $trigger_id)
		{
			$params_use = $params;
			
			if (isset($params_trigger[$trigger_id]))
			{
				$params_use = array_merge($params_use, $params_trigger[$trigger_id]);
			}
			
			$out .= $this->object->_render_trigger($trigger_id, $params_use, $object);
		}
		
		if ($object != null)
		{
			$this->object->set_object_state($object, 'done');
		}
		
		return $out;
	}

	function _render_trigger($trigger_id, $params = null, $object = null)
	{
		$trigger = $this->object->get_trigger($trigger_id);
		
		if ($trigger != null)
		{
			$out = null;
			$main_icon_path = isset($params['icon-path']) ? $params['icon-path'] : null;
			$main_icon_uri = isset($params['icon-uri']) ? $params['icon-uri'] : null;
			$main_class = isset($params['class']) ? $params['class'] : null;
			$main_context = isset($params['context']) ? $params['context'] : null;
			$main_context_id = isset($params['context-id']) ? $params['context-id'] : null;
			$main_context_parent = isset($params['context-parent']) ? $params['context-parent'] : null;
			$main_context_parent_id = isset($params['context-parent-id']) ? $params['context-parent-id'] : null;
			$default_class = 'sb'; // dependent on what we use to style buttons
			
			$icon_path = $trigger->get_property('icon-path');
			$icon_uri = $trigger->get_property('icon-uri');
			$icon_name = $trigger->get_property('icon-name');
			$class = $trigger->get_property('class');
			$text = $trigger->get_property('text');
			$markup = $trigger->get_property('markup');
			$action = $trigger->get_property('action');
			$action_target = $trigger->get_property('action-target');
			$script = $trigger->get_property('script');
			$link = $trigger->get_property('link');
			
			if ($text != null || $markup != null)
			{
				$default_class .= ' text';
			}
			
			if ($icon_name != null)
			{
				$default_class .= ' ' . $icon_name;
			}
			
			if ($main_class != null)
			{
				$class = $main_class . ' ' . $class;
			}
			
			if ($default_class != null)
			{
				$class = $default_class . ' ' . $class;
			}
			
			$attributes = array();
			
			switch ($action)
			{
				case 'lightbox':
				case 'script':
				{
					$link = '#';
					
					if ($script != null)
					{
						$attributes['onclick'] = $script;
					}
					else
					{
						if ($action == 'lightbox')
						{
							$class .= ' nextgen_pro_lightbox';
							//$attributes['onclick'] = 'jQuery(this).nplModal(\'open_modal\', {});';
						}
					}
					
					break;
				}
			}
			
			switch ($action_target)
			{
				case 'social':
				{
          $attributes['data-nplmodal-show-comments'] = 1;
          
					break;
				}
			}
			
			switch ($main_context)
			{
				case 'image':
				{
					$attributes['data-image-id'] = $main_context_id;
					
					break;
				}
				case 'gallery':
				{
					$attributes['data-nplmodal-gallery-id'] = $main_context_id;
					
					break;
				}
			}
			
			switch ($main_context_parent)
			{
				case 'gallery':
				{
					$attributes['data-nplmodal-gallery-id'] = $main_context_parent_id;
					
					break;
				}
			}
			
			$attributes['class'] = $class;
			$out .= '<i';
			
			foreach ($attributes as $attribute_name => $attribute_value)
			{
				if (in_array($attribute_name, array('href', 'src')))
				{
					$attribute_value = esc_url($attribute_value);
				}
				else
				{
					$attribute_value = esc_attr($attribute_value);
				}
				
				$out .= ' ' . $attribute_name . '="' . $attribute_value . '"';
			}
			
			$out .= '>';
			
			if ($markup != null)
			{
				$out .= $markup;
			}
			else if ($text != null)
			{
				$out .= esc_html($text);
			}
			
			$out .= '</i>';
			
			return $out;
		}
		
		return null;
	}
}

class Mixin_NextGen_Pro_Lightbox_Trigger_Creator extends Mixin
{
	function get_default_properties($trigger_id)
	{
		$default_properties = array();
		
		$default_properties['label'] = ucwords(str_replace(array('.', '-', '_'), ' ', $trigger_id));
		$default_properties['icon-type'] = 'png';
		
		// set default properties
		switch ($trigger_id)
		{
			case 'photocrati.lightbox':
			{
				$default_properties['icon-name'] = 'icon-share-sign';
				//$default_properties['text'] = 'Share';
				$default_properties['action'] = 'lightbox';
				//$default_properties['class'] = 'trigger-button-social';
			
				break;
			}
			case 'photocrati.social':
			{
				$default_properties['icon-name'] = 'icon-comment';
				//$default_properties['text'] = 'Share';
				$default_properties['action'] = 'lightbox';
				$default_properties['action-target'] = 'social';
				//$default_properties['class'] = 'trigger-button-social';
			
				break;
			}
			case 'photocrati.cart':
			{
				$default_properties['icon-name'] = 'icon-download';
				//$default_properties['text'] = 'Cart';
				$default_properties['action'] = 'lightbox';
				$default_properties['action-target'] = 'cart';
				//$default_properties['class'] = 'trigger-button-social';
			
				break;
			}
		}
		
		$lightbox = $this->get_registry()->get_utility('I_NextGen_Pro_Lightbox_Controller');
		
		if (isset($default_properties['icon-name']) && $lightbox != null)
		{
			$default_properties['icon-uri'] = $lightbox->get_static_url('photocrati-nextgen_pro_lightbox#buttons/' . $default_properties['icon-name'] . '.' . $default_properties['icon-type']);
		}
		
		return $default_properties;
	}
		
	function create_default_trigger($trigger_id, $properties = null)
	{
		$default_list = $this->object->get_default_trigger_list();
		$trigger = null;
	
		if (array_search($trigger_id, $default_list) !== false)
		{
			$default_properties = (array) $this->object->get_default_properties($trigger_id);
		
			if ($properties == null)
			{
				$properties = $default_properties;
			}
			else
			{
				$properties = array_merge($default_properties, (array) $properties);
			}
			
			$trigger = $this->object->create_trigger($trigger_id, $properties);
		}
		
		return $trigger;
	}
	
	function create_trigger($trigger_id, $properties)
	{
		$trigger = new C_NextGen_Pro_Lightbox_Trigger($trigger_id, $this->object);
		
		if ($properties != null)
		{
			foreach ($properties as $property_name => $property_value)
			{
				$trigger->set_property($property_name, $property_value);
			}
		}
		
		return $trigger;
	}
}

class C_NextGen_Pro_Lightbox_Trigger_Manager extends C_Component
{
    static $_instances = array();

    function define($context=FALSE)
    {
			parent::define($context);

			$this->implement('I_NextGen_Pro_Lightbox_Trigger_Manager');
			$this->add_mixin('Mixin_NextGen_Pro_Lightbox_Trigger_Manager');
			$this->add_mixin('Mixin_NextGen_Pro_Lightbox_Trigger_Render');
			$this->add_mixin('Mixin_NextGen_Pro_Lightbox_Trigger_Creator');
    }

    static function get_instance($context = False)
    {
			if (!isset(self::$_instances[$context]))
			{
					self::$_instances[$context] = new C_NextGen_Pro_Lightbox_Trigger_Manager($context);
			}

			return self::$_instances[$context];
    }
}
