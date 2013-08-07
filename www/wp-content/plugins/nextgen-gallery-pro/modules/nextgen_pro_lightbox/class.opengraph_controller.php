<?php

class C_OpenGraph_Controller extends C_MVC_Controller
{
    static $_instances = array();

    /**
     * Returns an instance of the controller in a particular context
     * @param bool $context
     * @return mixed
     */
    static function get_instance($context=FALSE)
    {
        if (!isset(self::$_instances[$context])) {
            $klass = get_class();
            self::$_instances[$context] = new $klass($context);
        }
        return self::$_instances[$context];
    }

    // /nextgen-share/{url}/{slug}
    function index_action()
    {
        $img_mapper     = $this->get_registry()->get_utility('I_Image_Mapper');
        $image_id       = $this->param('image_id');
        if (($image     = $img_mapper->find($image_id))) {

            $displayed_gallery_id = $this->param('displayed_gallery_id');

            // Template parameters
            $params = array('img' => $image);

            // Get the url & dimensions
            $storage    = $this->_get_registry()->get_utility('I_Gallery_Storage');
            $dimensions = $storage->get_image_dimensions($image, 'thumb');
            $image->url = $storage->get_image_url($image, 'thumb');
            $image->width   = $dimensions['width'];
            $image->height  = $dimensions['height'];

            // Generate the lightbox url
            $router         = $this->get_router();
            $mapper         = $this->get_registry()->get_utility('I_Lightbox_Library_Mapper');
            $lightbox       = $mapper->find_by_name(NEXTGEN_PRO_LIGHTBOX_MODULE_NAME);
            $uri            = urldecode($this->param('uri'));
            $lightbox_slug  = $lightbox->display_settings['router_slug'];
            $lightbox_url   = $router->get_url($uri, FALSE);
            $qs             = $this->get_querystring();
            if ($qs)
                $lightbox_url .= "?" . $qs;
            else
                $lightbox_url .= '/';
            $params['lightbox_url'] = "{$lightbox_url}#{$lightbox_slug}/{$displayed_gallery_id}/{$image_id}";

            // We need to ensure that the image exists
            wp_remote_request($image->url);

            // Request the original page, which will create the transient, if required. This is a big hackish, as I'm
            // not convinced that transient ids should be required for anything. But, it works, so we'll go with it. ;)
            wp_remote_request($lightbox_url);

            // Add the blog name
            $params['blog_name'] = get_bloginfo('name');

            // Add routed url
            $params['routed_url'] = $router->get_url($_SERVER['REQUEST_URI']);

            // Render the opengraph metadata
            $this->expires('+1 day');
            $this->render_view("photocrati-nextgen_pro_lightbox#opengraph", $params);
        }
        else {
            header("Status: 404 Image not found");
            echo "Image not found";
        }
    }

    /**
     * The querystring contains the URI segment to return to, but possibly other querystring data that should be included
     * in the lightbox url. This function returns the querystring without the return data
     */
    function get_querystring()
    {
        return preg_replace("/uri=[^&]+&?/", '', $this->get_router()->get_querystring());
    }
}
