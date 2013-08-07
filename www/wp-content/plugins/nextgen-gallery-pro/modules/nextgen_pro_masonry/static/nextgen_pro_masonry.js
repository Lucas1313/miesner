(function($) {
    $(document).ready(function() {
        $('.ngg-pro-masonry').each(function() {
            var $self = $(this);
            $self.masonry({
                itemSelector: '.ngg-pro-masonry-item',
                gutter: '.ngg-pro-masonry-gutter',
                columnWidth: '.ngg-pro-masonry-sizer',
                isFitWidth: true
            });
        });
    });
})(jQuery);
