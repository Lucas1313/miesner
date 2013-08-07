/**
 * Used as a callback to stop the content menu from 
 * appearing
 */
function photocrati_protect_image_stop_event(e)
{
    if (e) {
        e.stopPropagation();
    }
    return false;
}

if (parseInt(photocrati_protect_image.protect_enable_site) == 1)
{
	document.oncontextmenu = photocrati_protect_image_stop_event;
}

// For JQuery counterparts
jQuery(function($) {

	var handler = function (event) 
	{ 
		try 
		{ 
		  if (event.button == 2 || event.button == 3) 
		  {
      	return photocrati_protect_image_stop_event(event);
		  }
		}  
		catch (e) 
		{
		  if (event.which == 3)
		  {
      	return photocrati_protect_image_stop_event(event);
		  }
		} 
	}

	var modifier = function () {
		$(this)[0].oncontextmenu = photocrati_protect_image_stop_event;
		$(this)[0].ondragstart   = photocrati_protect_image_stop_event;
		$(this)[0].onmousedown   = handler;
	};

	var selector = '';
	
	if (parseInt(photocrati_protect_image.protect_enable_image) == 1)
	{
		if (selector != '') 
			selector += ', ';
			
		selector += 'img';
	}
	
	if (parseInt(photocrati_protect_image.protect_enable_gallery) == 1)
	{
		if (selector != '') 
			selector += ', ';
			
		selector += '.image_container img, .pic img';
	}
	
	if (parseInt(photocrati_protect_image.protect_enable_lightbox) == 1)
	{
		if (selector != '') 
			selector += ', ';
		
		// XXX add all lighbox libraries
		selector += '#shWrap img, #lightbox-container-image, #lightbox-container-image img';
	}
	
	$(this).delegate(selector, 'contextmenu', photocrati_protect_image_stop_event);
	$(this).delegate(selector, 'dragstart', photocrati_protect_image_stop_event);
	$(this).delegate(selector, 'mousedown', handler); 
});

