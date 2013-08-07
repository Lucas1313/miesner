<?php

class A_NextGen_Pro_Lightbox_Triggers_Form extends Mixin
{
    function initialize()
    {
        $this->object->add_post_hook(
            '_get_field_names',
            'Renders trigger settings for the gallery',
            get_class(),
            '_get_trigger_fields'
        );
    }
    
    function _get_trigger_fields()
    {
        $ret = $this->object->get_method_property(
            $this->method_called,
            ExtensibleObject::METHOD_PROPERTY_RETURN_VALUE
        );
        
        $display_type = $this->object->get_display_type_name();
        
        // XXX more generic way of handling this?
        switch ($display_type)
        {
        	case 'photocrati-nextgen_basic_thumbnails':
        	case 'photocrati-nextgen_basic_slideshow':
        	case 'photocrati-nextgen_basic_imagebrowser':
        	case 'photocrati-nextgen_basic_singlepic':
        	case 'photocrati-nextgen_pro_slideshow':
        	case 'photocrati-nextgen_pro_horizontal_filmstrip':
        	case 'photocrati-nextgen_pro_thumbnail_grid':
        	case 'photocrati-nextgen_pro_blog_gallery':
        	case 'photocrati-nextgen_pro_film':
            case 'photocrati-nextgen_pro_masonry':
        	{
        		$ret[] = 'nextgen_pro_lightbox_triggers_display';
        		break;
        	}
        }
        
        $ret = $this->object->set_method_property(
            $this->method_called,
            ExtensibleObject::METHOD_PROPERTY_RETURN_VALUE,
            $ret
        );
        
        return $ret;
    }
    
    function _render_nextgen_pro_lightbox_triggers_display_field($display_type)
    {
        return $this->_render_select_field(
            $display_type,
            'ngg_triggers_display',
            'Display Triggers',
            array('always' => __('Always', 'nggallery'), 'exclude_mobile' => __('Exclude Small Screens', 'nggallery'), 'never' => __('Never', 'nggallery')),
            isset($display_type->settings['ngg_triggers_display']) ? $display_type->settings['ngg_triggers_display'] : 'always'
        );
    }
    
    function _render_nextgen_pro_lightbox_triggers_style_field($display_type)
    {
        return $this->_render_select_field(
            $display_type,
            'ngg_triggers_style',
            'Triggers Style',
            array('plain' => __('Plain', 'nggallery'), 'fancy' => __('Fancy', 'nggallery')),
            isset($display_type->settings['ngg_triggers_style']) ? $display_type->settings['ngg_triggers_style'] : 'plain'
        );
    }
}
