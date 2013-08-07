<?php

class Mixin_NextGen_Pro_Album_Controller extends Mixin
{
    function initialize()
    {
        $this->object->add_mixin('Mixin_NextGen_Pro_Album_Urls');
    }


    function _render_gallery($display_type, $original_display_type, $return=FALSE)
    {
        // Get the gallery id, which might
        $gallery_id = $this->param('gallery');
        if (!is_numeric($gallery_id)) {
            $mapper = $this->get_registry()->get_utility('I_Gallery_Mapper');
            $result = reset($mapper->select()->where(array('slug = %s', $gallery_id))->limit(1)->run_query());
            $gallery_id = $result->{$result->id_field};
        }

        $renderer = $this->object->get_registry()->get_utility('I_Displayed_Gallery_Renderer');
        return $renderer->display_images(
            array(
                'source'				=> 'galleries',
                'container_ids'			=> array($gallery_id),
                'display_type'			=> $display_type,
                'original_display_type'	=> $original_display_type
            )
        );
    }

    function _render_album($displayed_gallery, $return)
    {
        // The HTML id of the gallery
        $id = 'displayed_gallery_'.$displayed_gallery->id();

        // Generate the named thumbnail size
        $thumbnail_size_name = 'thumb';
        if (isset($displayed_gallery->display_settings['override_thumbnail_settings']) &&
            $displayed_gallery->display_settings['override_thumbnail_settings']) {

            $dynthumbs = $this->object->get_registry()->get_utility('I_Dynamic_Thumbnails_Manager');
            $dyn_params = array(
                'width' => $displayed_gallery->display_settings['thumbnail_width'],
                'height' => $displayed_gallery->display_settings['thumbnail_height'],
            );

            if ($displayed_gallery->display_settings['thumbnail_quality'])
                $dyn_params['quality'] = $displayed_gallery->display_settings['thumbnail_quality'];

            if ($displayed_gallery->display_settings['thumbnail_crop'])
                $dyn_params['crop'] = true;

            if ($displayed_gallery->display_settings['thumbnail_watermark'])
                $dyn_params['watermark'] = true;

            $thumbnail_size_name = $dynthumbs->get_size_name($dyn_params);
        }

        // Get entities
        $entities                       = $this->object->_prepare_entities($displayed_gallery,$thumbnail_size_name);

        // Render view/template
        return $this->render_view('photocrati-nextgen_pro_albums#index', array(
            'entities'				=>	$entities,
            'effect_code'			=>	$this->object->get_effect_code($displayed_gallery),
            'id'					=>	$id,
            'thumbnail_size_name'	=>	$thumbnail_size_name,
            'css_class'             =>  $this->object->_get_css_class()
        ), $return);
    }


    function _prepare_entities($displayed_gallery, $thumbnail_size_name)
    {
        $current_url= $this->object->get_routed_url(TRUE);
        $storage    = $this->get_registry()->get_utility('I_Gallery_Storage');
        $mapper     = $this->get_registry()->get_utility('I_Image_Mapper');
        $entities   = $displayed_gallery->get_included_entities();


        foreach ($entities as &$entity) {
            $entity_type	= intval($entity->is_gallery) ? 'gallery' : 'album';

            // Is the gallery actually a link to a page? Stupid feature...
            if (isset($entity->pageid) && $entity->pageid > 0) {
                $entity->link = get_post_permalink($entity->pageid);
            }

            // If not, we'll link to the actual gallery/sub-album
            else {
                $page_url = $current_url;
                if (intval($entity->is_gallery) && !$this->param('album')) {
                    $page_url = $this->object->set_param_for($page_url, 'album', 'galleries');
                }
                $entity->link = $this->object->set_param_for($page_url, $entity_type, $entity->slug);
            }

            $preview_img        = $mapper->find($entity->previewpic);
            $entity->thumb_size = $storage->get_image_dimensions($preview_img, $thumbnail_size_name);
            $entity->url        = $storage->get_image_url($preview_img, $thumbnail_size_name);
        }

        return $entities;
    }


    function index_action($displayed_gallery, $return=FALSE)
    {
        $retval = '';

        // Determine what to render:

        // 1) A gallery
        if ($this->param('gallery')) {
            $retval = $this->object->_render_gallery(
                $displayed_gallery->display_settings['gallery_display_type'],
                $displayed_gallery->display_type,
                TRUE
            );
        }

        // 2) A sub-album
        else if (($album_id = $this->param('album'))) {
            if (!is_numeric($album_id)) {
                $mapper = $this->get_registry()->get_utility('I_Album_Mapper');
                $result = array_pop($mapper->select()->where(array("slug = %s", $album_id))->limit(1)->run_query());
                $album_id = $result->{$result->id_field};
            }
            $displayed_gallery->container_ids = array($album_id);
            $retval = $this->object->_render_album($displayed_gallery, $return);
        }

        // 3) The current album
        else {
            $retval = $this->object->_render_album($displayed_gallery, $return);
        }

        return $retval;
    }
}