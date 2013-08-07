<?php

class C_AutoUpdate_Installer
{
	function install($reset=TRUE)
	{
		$settings = C_NextGen_Global_Settings::get_instance();
		$params = array(
			'autoupdate_api_url' => 'http://members.photocrati.com/api/'
		);

		foreach ($params as $key => $value) {
			if ($reset) $settings->set($key, NULL);
			$settings->set_default_value($key, $value);
		}
	}
}