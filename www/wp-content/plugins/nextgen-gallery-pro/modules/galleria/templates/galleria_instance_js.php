(function($){
	window.Galleria_Instance = {
		gallery_selector: '#galleria',

		create: function(id){
			// Initialize properties
			this.id					= id;
			this.el_id				= "displayed_gallery_"+id;
			this.selector			= '#'+this.el_id;
			this.$gallery			= $(this.gallery_selector);
			this.$frame				= $(window.frameElement);
			this.$parent			= $(parent);
			this.displayed_gallery	= parent.galleries['gallery_'+id];

			// Fetch CSS Overrides
			this.fetch_css_overrides_from_parent();

			// Load Galleria
			this.configure_galleria();
			Galleria.run(this.gallery_selector, {
                responsive: true,
                debug: false
            });
		},

		configure_galleria: function() {
			// Parse numeric and boolean values from strings
			var settings = this.displayed_gallery.display_settings;
			for (var index in settings) {

				// Parse numbers
				var numeric_val = Number(settings[index]);
				if (!isNaN(numeric_val)) settings[index] = numeric_val;

				// Parse booleans
				if (numeric_val == 0 || numeric_val == 1 && !index.match(/width|size|height|dimensions|percent/)) {
					settings[index] = numeric_val ? true : false;
				}
			}
			
			//settings.autoplay = 250;
			settings.transition_speed = settings.transition_speed * 1000;
			settings.slideshow_speed = settings.slideshow_speed * 1000;

            // the lightbox will always occupy as much of the screen as it can
            if (top.nplModalRouted && top.nplModalRouted.is_open()) {
                settings.width = 'auto';

            } else {
            		var calculateHeight = function (settings) {
		              // Calculate stage width
		              var width = this.$frame.width();
	              
			            // Convert common settings
			            if (settings.width_unit == '%' && settings.width != 100) {
		              		width = this.$frame.parent().width();
			                width = Math.round(width * (settings.width / 100));
			                this.$frame.width(width);
			            }

		              // Calculate height using aspect ratio of device/browser
		              var aspect_ratio = this.$parent.width()/this.$parent.height();
		              if (typeof(settings.aspect_ratio) != 'undefined' && settings.aspect_ratio != 0 ) {
		                  aspect_ratio = this.displayed_gallery.display_settings.aspect_ratio;
		                  
		                  if (!parseFloat(aspect_ratio))
		                  {
		                  	if (settings.aspect_ratio_computed && parseFloat(settings.aspect_ratio_computed))
		                  	{
		                  		aspect_ratio = settings.aspect_ratio_computed;
		                  	}
		                  	else
		                  	{
		                  		aspect_ratio = 1.5;
		                  	}
		                  }
		              }
		              var frame_height = ((width - 20)/aspect_ratio);

		              if (typeof(this.displayed_gallery.display_settings.thumbnail_height) != 'undefined')
		              {
		                  frame_height += this.displayed_gallery.display_settings.thumbnail_height;
		              }

		              frame_height += 20;

		              var caption = this.displayed_gallery.display_settings.caption_class;
		              if (caption == 'caption_above_stage' || caption == 'caption_below_stage')
		              {
		                  frame_height += 52;
		              }

		              this.$frame.height(frame_height);
		              this.$frame.css('margin', '0 auto');
            		};
            		
            		var galleria = this;
            		
            		calculateHeight.call(galleria, settings);
				        		
				        $(window).on('resize orientationchange onfullscreenchange onmozfullscreenchange onwebkitfullscreenchange', function (event) {
            			calculateHeight.call(galleria, settings);
				        });
            }

			Galleria.loadTheme(this.displayed_gallery.display_settings.theme);
			Galleria.configure($.extend(settings, {
				dataSource: this.fetch_images_from_parent()
			}));
		},

		fetch_css_overrides_from_parent: function(){
			$(document).find('style').append($(parent.document).find('#css_overrides_' + this.id).text());
		},

		fetch_images_from_parent: function(){
			var data = [];
			$(window.parent.document).find(this.selector+' .galleria-batch .batch-image').each(function(){
				var $this = $(this);
				var html = $this.html();
				var image = $('<p/>').html(html).find('img');
				data.push({
					image:			image.attr('data-src'),
					title:			image.attr('data-alt'),
					description:	image.attr('data-description'),
                    image_id:       image.attr('data-image-id'),
                    thumb:          image.attr('data-thumbnail'),
					original:		image
				});
			});
			return data;
		}
	};

})(jQuery);
