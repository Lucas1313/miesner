<?php

class A_Galleria_Routes extends Mixin
{
	function initialize()
	{
		$this->object->add_pre_hook(
			'serve_request',
			'Add Galleria Route for iFrame',
			get_class(),
			'add_galleria_routes'
		);
	}

	function add_galleria_routes()
	{
		$app = $this->create_app('/nextgen-galleria-gallery');
		$app->rewrite("/{id}", "/id--{id}");
		$app->route('/', 'I_Galleria_iFrame_Controller#index');
	}
}