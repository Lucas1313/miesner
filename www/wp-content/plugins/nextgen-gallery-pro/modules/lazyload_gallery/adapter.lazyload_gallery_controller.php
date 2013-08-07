<?php

class A_LazyLoad_Gallery_Controller extends Mixin
{
	function placeholder_img_url()
	{
		return $this->get_static_url('photocrati-lazyload_gallery#placeholder.png');
	}

	function enqueue_frontend_resources($displayed_gallery)
	{
		wp_register_script('jquery.scrollstop', $this->get_static_url('photocrati-lazyload_gallery#jquery.scrollstop.js'), array('jquery'));
        wp_enqueue_script('jquery.lazyload');
		wp_enqueue_script('jquery.scrollstop');
		wp_register_style('jquery.lazyload', $this->get_static_url('photocrati-lazyload_gallery#jquery.lazyload.css'));
		wp_enqueue_style('jquery.lazyload');
		$this->call_parent('enqueue_frontend_resources', $displayed_gallery);
	}
}