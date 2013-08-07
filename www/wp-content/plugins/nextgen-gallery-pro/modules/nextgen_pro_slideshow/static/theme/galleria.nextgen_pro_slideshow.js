(function($) {

// Set defaults
var defaults = $.extend(Galleria.configure.options, {
	carousel:	false,
	thumbnails:	false,
	autoplay:	true,
	showInfo:	false
});

// Set the image margin to the same width as the border size
if (defaults.border_size > 0)	{
	defaults.imageMargin = defaults.border_size;
}

// Show captions if a caption_class has been provided
if (defaults.show_captions && defaults.caption_class.length > 0) {
	defaults.showInfo = true;
}

Galleria.addTheme({
    name: 'nextgen_pro_slideshow',
    author: 'Photocrati Media',
    css: 'galleria.nextgen_pro_slideshow.css',
    defaults: defaults,
    init: function(options) {
        Galleria.requires(1.28, 'This version of Classic theme requires Galleria 1.2.8 or later');

		// Provides a function which sets the width of an image
		this.set_image_width = function($img, width) {
			$img.attr('width', width);
			$img.width(width);
		};

		// Provides a function which sets the height of an image
		this.set_image_height = function($img, height){
			$img.attr('height', height);
			$img.height(height);
		};

		// some stuff for non-touch browsers
		if (! Galleria.TOUCH ) {
				this.addIdleState( this.get('image-nav-left'), { left:-50 });
				this.addIdleState( this.get('image-nav-right'), { right:-50 });
				this.addIdleState( this.get('counter'), { opacity:0 });
		}

		// Add the caption class to the Galleria container
		if (options.showInfo && options.captionClass.length > 0) 
		{
			$(this._target).find('.galleria-info').show();
			$(this._target).addClass(options.captionClass);
			
			var jcap = $(this._target).find('.galleria-info');
			var jcap_par = jcap.parent();
			var jstage = $(this._target).find('.galleria-stage');
			var jthumb = $(this._target).find('.galleria-thumbnails-container');
			var jpar = jstage.parent();
			
			var cap_off = jcap.offset();
			var cap_par_off = jcap_par.offset();
			var stage_off = jstage.offset();
			var par_off = jpar.offset();
			
			var cap_par_bott = cap_par_off.top + jcap_par.outerHeight();
			var stage_top = stage_off.top - par_off.top;
			var stage_bott = stage_off.top + jstage.outerHeight();
			var stage_right = stage_off.left + jstage.outerWidth();
			var par_right = par_off.left + jpar.outerWidth();
			
			switch (options.captionClass)
			{
				case 'caption_above_stage':
				{
					jstage.css({ top: jcap.outerHeight() + 10 });
					
					jcap.css({
						top : 0,
						bottom : 'auto',
						left : stage_off.left,
						right : par_right - stage_right
					});
					
					break;
				}
				case 'caption_below_stage':
				{
					jthumb.css({ bottom: jcap.outerHeight() });
					jstage.css({ bottom: jcap.outerHeight() + jthumb.outerHeight() + 7 });
					
					jcap.css({
						top : 'auto',
						bottom : 0,
						left : stage_off.left,
						right : par_right - stage_right
					});
		
					break;
				}
				case 'caption_overlay_top':
				{
					jcap.css({
						top : stage_top,
						left : stage_off.left,
						right : par_right - stage_right
					});
					
					break;
				}
				case 'caption_overlay_bottom':
				{
					jcap.css({
						bottom : cap_par_bott - stage_bott,
						left : stage_off.left,
						right : par_right - stage_right
					});
					
					break;
				}
			}
			
			if (options.captionClass == 'caption_above_stage' || options.captionClass == 'caption_below_stage')
			{
				var imgs = jstage.find('.galleria-image');
				imgs.each(function () {
					$(this).css({ height : jstage.height() + 'px' });
					$(this).height(jstage.height());
				});
				
				this.bind('loadfinish', this.proxy(function(e){
					var $img = $(e.imageTarget);
					
					$img.parent().height(jstage.height());
					$img.css({
						top : ($img.parent().height() - $img.height()) / 2
					});
				}));
			}
			
			jcap.hover(
				function () {
					var self = jQuery(this);
					var text = self.find('.galleria-info-text');
					var diff = self.outerHeight() - text.outerHeight();

					if (diff < 0)
					{
						self.stop().animate({ scrollTop: -diff }, ((-diff) / 17) * 450);
					}
				},
				function () {
					var self = jQuery(this);
					var text = self.find('.galleria-info-text');
					var diff = self.outerHeight() - text.outerHeight();

					if (diff < 0)
					{
						self.stop().animate({ scrollTop: 0 }, 'fast');
					}
				}
			);
		}

		// set slideshow speed
		if (options.slideshowSpeed) {
			this.setPlaytime(options.slideshowSpeed);
		}

		// add playback controls if we're to do so
		if (options.showPlaybackControls) {

			// Add playback controls
			var playback_button = $('<div/>').addClass('galleria-playback-button');
			if (this._playing) playback_button.removeClass('play').addClass('pause');
			else playback_button.removeClass('pause').addClass('play');
			$(this._dom.stage).append(playback_button);

			// Add clickable button
			var button = $('<a/>').hover(
				function(){ $(this).parent().css('opacity', 0.9); },
				function(){ $(this).parent().css('opacity', 0.7); }
			).click(this.proxy(function(e){
				var controls = $(e.target).parent();
				if (this._playing) {
					this.pause();
					controls.removeClass('pause').addClass('play');
				}
				else {
					this.play().next();
					controls.removeClass('play').addClass('pause');
				}
			}));
			playback_button.append(button);

			// Show the controls on hover
			playback_button.hover(
				function(){ $(this).css('opacity', 0.7); },
				function(){ $(this).animate({opacity: 0.0}); }
			);
		}

		this.bind('loadfinish', this.proxy(function(e){
			var $img = $(e.imageTarget);

			// If a border has been specified, adjust the dimensions of the image
			// to accomodate
			if (this._options.borderSize > 0) {

				// The stage height is accomodated for the height of the
				// counter (10px) and the border width
				var stage_height = $(this._target).height()-(this._options.borderSize*2)-10;
				var aspect_ratio = $img.width()/$img.height();
				var max_width	 = $img.width()-(this._options.borderSize*2);
				this.set_image_width($img, max_width);
				this.set_image_height($img, $img.width()/aspect_ratio);
				if ($img.height() > stage_height) {
					this.set_image_height($img, stage_height);
					this.set_image_width($img, stage_height*aspect_ratio);
				}
			}

			// If the image is clicked, open fullscreen mode
			$img.on('click', this.proxy(function(){
				this.enterFullscreen();
			}));
		}));

        this.bind('loadfinish', this.proxy(function (event) {
            var self = this
            var gallery_id = window.Galleria_Instance.displayed_gallery.ID;
            top.jQuery('#displayed_gallery_' + gallery_id).siblings('div.ngg-trigger-buttons').each(function() {
                top.jQuery('body').trigger('nplmodal.update_image_id', [jQuery(this).find('i'), $(self.getData(self.getIndex()).original).data('image-id')]);
            });
        }));
    }
});

}(jQuery));
