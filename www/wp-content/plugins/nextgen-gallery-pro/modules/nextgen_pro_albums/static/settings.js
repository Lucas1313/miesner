(function($){
    $(document).on('lazy_resources_loaded', function() {
        $('input[name="photocrati-nextgen_pro_list_album[override_thumbnail_settings]"]')
            .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_list_album_thumbnail_dimensions'))
            .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_list_album_thumbnail_quality'))
            .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_list_album_thumbnail_crop'))
            .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_list_album_thumbnail_watermark'));

        $('input[name="photocrati-nextgen_pro_grid_album[override_thumbnail_settings]"]')
            .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_grid_album_thumbnail_dimensions'))
            .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_grid_album_thumbnail_quality'))
            .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_grid_album_thumbnail_crop'))
            .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_grid_album_thumbnail_watermark'));
    });
})(jQuery);