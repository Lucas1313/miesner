<?php

// TODO: This should be replaced by a dynamic stylesheet adapter
class A_NextGen_Pro_Slideshow_Controller extends A_Galleria_Controller
{
	function get_custom_css_rules($displayed_gallery)
	{
		return $this->object->render_partial(
			'photocrati-nextgen_pro_slideshow#nextgen_pro_slideshow_css',
			$displayed_gallery->display_settings,
			TRUE
		);
	}
}