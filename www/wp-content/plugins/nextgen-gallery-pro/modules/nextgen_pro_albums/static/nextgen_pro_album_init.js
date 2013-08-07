(function($){
    $(document).on('lazy_resources_loaded', function(){

        // Only run this routine once
        var flag = 'nextgen_pro_albums';
        if (typeof($(window).data(flag)) == 'undefined')
            $(window).data(flag, true);
        else return;

        // Lazy load the images
        var imgs = $('.nextgen_pro_list_album img.gallery_preview, .nextgen_pro_grid_album img.gallery_preview');
	
        imgs.each(function () {
            var jthis = $(this);
            if (jthis.attr('data-alt') != null) {
                jthis.attr('alt', jthis.attr('data-alt'));
            }
            if (jthis.attr('data-title') != null) {
                jthis.attr('title', jthis.attr('data-title'));
            }
        });

        // Now that lazy loaded styles are ready, we'll display the galleries
        $('.nextgen_pro_list_album, .nextgen_pro_grid_album').each(function(){
            var $this = $(this);
            var gallery_id = $this.attr('id').match(/^displayed_gallery_(\w+$)/).pop();
            var display_settings = window.galleries['gallery_'+gallery_id].display_settings;

            // List Album
            if ($this.hasClass('nextgen_pro_list_album')) {

                // Ensure that the screen real estate allocated for an image
                // is equal to the maximum width of a thumbnail
                var max_width = display_settings.thumbnail_width;
                $this.find('.gallery_link').each(function(){
                    var $link = $(this);
                    var margin = max_width - $link.width();

                    // The width of the image is smaller than the allocated real estate. We'll increase
                    // the right margin to fix
                    if (margin > 0) {
                        var right_margin = parseFloat($link.css('margin-right'));
                        $link.css('margin-right', margin/2+right_margin);
                        var left_margin = parseFloat($link.css('margin-left'));
                        $link.css('margin-left', margin/2+left_margin);
                    }
                });

                // Ensure that the gallery/album description uses the remaining space
                var container_width = $this.find('.image_container').width();
                var desc_width = container_width-max_width-(display_settings.padding*2);
                $this.find('.image_description').width(desc_width);
            }

            // Grid Album
            else {
                // Find the widest and longest image dimensions
                var widest = 125; // minimum width
                var longest = 0;
                $this.find('img').each(function(){
                    var $image = $(this);
                    if (parseFloat($image.attr('width')) > widest)    widest  = parseFloat($image.attr('width'));
                    if (parseFloat($image.attr('height')) > longest)  longest = parseFloat($image.attr('height'));
                }).each(function(){

                    // Ensure that each image is centered in the space allocated
                    var $image = $(this);
                    var margin = longest-parseFloat($image.attr('height'));
                    if (margin > 0) {
                        $image.parent().css({
                           'margin-top':    margin/2,
                           'margin-bottom': margin/2
                        });
                    }
                });

                // All image containers must be the same size.
                $this.find('.image_container').each(function(){
                   $(this).css({
                      'width': widest,
                      'padding': display_settings.padding
                   });
                });

                // Prevent the title from being too big
                $('div.nextgen_pro_grid_album a.caption_link')
                    .css('display', 'block')
                    .dotdotdot();

                // Find the longest captions
                var longest_caption = 0;
                $this.find('.caption_link').each(function() {
                    if ($(this).outerHeight() > longest_caption) {
                        longest_caption = $(this).outerHeight();
                    }
                });

                // Ensure each container has the same height
                $this.find('.image_container').each(function() {
                   $(this).height(longest + longest_caption);
                });

            }

            // Gallery is ready to display!
            $this.css('opacity', 1.0);
        });
    });

})(jQuery);
