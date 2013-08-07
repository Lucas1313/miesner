<?php

class A_NextGen_Pro_Grid_Album_Controller extends Mixin_NextGen_Pro_Album_Controller
{
    function _get_css_class()
    {
        return 'nextgen_pro_grid_album';
    }

	function enqueue_frontend_resources($displayed_gallery)
	{
        $this->call_parent('enqueue_frontend_resources', $displayed_gallery);

		wp_enqueue_script('jquery.dotdotdot', $this->object->get_static_url('photocrati-nextgen_basic_album#jquery.dotdotdot-1.5.7-packed.js'), array('jquery'));
        wp_enqueue_style('nextgen_pro_grid_album', $this->get_static_url('photocrati-nextgen_pro_albums#nextgen_pro_grid_album.css'));
        wp_enqueue_script('nextgen_pro_albums', $this->get_static_url('photocrati-nextgen_pro_albums#nextgen_pro_album_init.js'));

		// Enqueue the dynamic stylesheet
		$dyn_styles = $this->get_registry()->get_utility('I_Dynamic_Stylesheet');
		$dyn_styles->enqueue($this->object->_get_css_class(), $this->array_merge_assoc(
			$displayed_gallery->display_settings,
			array('id' => 'displayed_gallery_'.$displayed_gallery->id())
		));
	}
}
