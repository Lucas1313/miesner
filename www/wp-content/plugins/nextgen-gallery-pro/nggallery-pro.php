<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

/*
 * Plugin Name: NextGEN Pro by Photocrati
 * Description: The "Pro" upgrade  for NextGEN Gallery. Enjoy beautiful new gallery displays and a fullscreen, responsive Pro Lightbox with social sharing and commenting.
 * Version: 1.0
 * Plugin URI: http://www.nextgen-gallery.com
 * Author: Photocrati Media
 * Author URI: http://www.photocrati.com
 * License: GPLv2
 */

class NextGEN_Gallery_Pro
{
    // Initialize the plugin
    function __construct()
    {
        define('NEXTGEN_GALLERY_PRO_PLUGIN_BASENAME', plugin_basename(__FILE__));
				define('NEXTGEN_GALLERY_PRO_MODULE_URL', plugins_url(path_join(basename(dirname(__FILE__)), 'modules')));
				
        add_action('load_nextgen_gallery_modules', array($this, 'load_product'));
        $this->_register_hooks();
    }

    /**
     * Loads the product providing NextGEN Gallery Pro functionality
     * @param C_Component_Registry $registry
     */
    function load_product(C_Component_Registry $registry)
    {
        // Tell the registry where it can find our products/modules
        $dir = dirname(__FILE__);
        $registry->add_module_path($dir, TRUE, TRUE);
    }

    function _register_hooks()
    {
        add_action('deactivate_' . NEXTGEN_GALLERY_PRO_PLUGIN_BASENAME, array(get_class(), 'deactivate'));
        
        // hooks for showing available updates
        add_action('after_plugin_row_' . NEXTGEN_GALLERY_PRO_PLUGIN_BASENAME, array(get_class(), 'after_plugin_row'));
        add_action('admin_notices', array(get_class(), 'admin_notices'));
    }

    static function deactivate()
    {
    	if (class_exists('C_Photocrati_Installer')) {
				C_Photocrati_Installer::uninstall(NEXTGEN_GALLERY_PRO_PLUGIN_BASENAME);
    	}
    }
    
    static function _get_update_admin()
    {
    	if (class_exists('C_Component_Registry') && method_exists('C_Component_Registry', 'get_instance')) {
    		$registry = C_Component_Registry::get_instance();
    		$update_admin = $registry->get_module('photocrati-auto_update-admin');
    		
    		return $update_admin;
    	}
    	
    	return null;
    }

    static function _get_update_message()
    {
			$update_admin = self::_get_update_admin();
			
			if ($update_admin != NULL && method_exists($update_admin, 'get_update_page_url')) {
				$url = $update_admin->get_update_page_url();
	  	
  			return sprintf(__('There are updates available. You can <a href="%s">Update Now</a>.', 'nggallery'), $url);
  		}
  		
  		return null;
    }

    static function has_updates()
    {
  		$update_admin = self::_get_update_admin();
  		
  		if ($update_admin != NULL && method_exists($update_admin, '_get_update_list')) {
  			$list = $update_admin->_get_update_list();
  			
  			if ($list != NULL) {
  				$ngg_pro_count = 0;
  				
  				foreach ($list as $update) {
  					if (isset($update['info']['product-id']) && $update['info']['product-id'] == 'photocrati-nextgen-pro') {
  						$ngg_pro_count++;
  					}
  				}
  				
  				if ($ngg_pro_count > 0) {
  					return true;
  				}
  			}
  		}
    	
    	return false;
    }

    static function after_plugin_row()
    {
    	if (self::has_updates()) {
				$update_message = self::_get_update_message();
				
				if ($update_message != NULL) {
    			echo '<tr style=""><td colspan="5" style="padding: 6px 8px; ">' . $update_message . '</td></tr>';
    		}
    	}
    }
    
    static function admin_notices() 
    {
    	if (class_exists('C_Page_Manager')) {
    		$pages = C_Page_Manager::get_instance();
    		
				if (in_array($_REQUEST['page'], array_keys($pages->get_all())) || preg_match("/^nggallery-/", $_REQUEST['page']) || $_REQUEST['page'] == 'nextgen-gallery') { 
				
					if (self::has_updates()) {
						$update_message = self::_get_update_message();
					
						echo '<div class="updated">
				    <p>' . $update_message . '</p>
				</div>';
					}
				}
    	}
    }
}

new NextGEN_Gallery_Pro;
