<?php

class A_NextGen_Pro_Lightbox_Triggers_Resources extends Mixin
{
  function initialize()
  {
      $this->object->add_post_hook(
          'enqueue_frontend_resources',
          'Enqueues resources for buttons',
          get_class(),
          'enqueue_trigger_buttons_resources'
      );
  }

	function enqueue_trigger_buttons_resources($displayed_gallery)
	{
		wp_register_style(
            'ngg-trigger-icons',
            $this->object->get_static_url('photocrati-nextgen_pro_lightbox#icons/font-awesome.css'),
            false
        );
		
		wp_register_style(
            'ngg-trigger-buttons',
            $this->object->get_static_url('photocrati-nextgen_pro_lightbox#trigger_buttons.css'),
            false
        );
        
		wp_enqueue_style('ngg-trigger-icons');
		wp_enqueue_style('ngg-trigger-buttons');
	}
}
