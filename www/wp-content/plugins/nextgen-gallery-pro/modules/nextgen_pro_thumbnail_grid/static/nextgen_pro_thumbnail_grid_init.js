(function($){
    $(document).on('lazy_resources_loaded', function(){

        // Only run this routine once
        var flag = 'nextgen_pro_thumbnail_grid';
        if (typeof($(window).data(flag)) == 'undefined')
            $(window).data(flag, true);
        else return;

        var imgs = $('.nextgen_pro_thumbnail_grid img');

        imgs.each(function () {
            var jthis = $(this);
            if (jthis.attr('data-alt') != null) {
                jthis.attr('alt', jthis.attr('data-alt'));
            }
            if (jthis.attr('data-title') != null) {
                jthis.attr('title', jthis.attr('data-title'));
            }
        });

        imgs.css('display', 'inline');

        // Trigger a scroll event to load the first set of lazy loaded images
        $(window).trigger('scroll');
    })
})(jQuery);
