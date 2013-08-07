<?php

interface I_NextGen_Pro_Lightbox_Trigger_Manager
{
	function get_trigger_list();

	function get_trigger($trigger_id);

	function render_trigger_list($trigger_list = null, $params = null, $controller = null);
}
