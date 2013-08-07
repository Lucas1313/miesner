(function($){
    $(document).on('lazy_resources_loaded', function(){

        // Only run this routine once
        var flag = 'nextgen_pro_film';
        if (typeof($(window).data(flag)) == 'undefined')
            $(window).data(flag, true);
        else return;

        // Lazy load the images
        $('.nextgen_pro_film_image').each(function () {
            var jthis = $(this);
            if (jthis.attr('data-alt') != null) {
                jthis.attr('alt', jthis.attr('data-alt'));
            }
            if (jthis.attr('data-title') != null) {
                jthis.attr('title', jthis.attr('data-title'));
            }
        });

        $('.nextgen_pro_film').each(function(){
            var $this = $(this);

            // Show the gallery
            $this.css('opacity', 1.0);
        });

        // Trigger a scroll event to load the first set of lazy loaded images
        $(window).trigger('scroll');
    });
})(jQuery);