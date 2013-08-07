jQuery(function($) {
    $('input[name="photocrati-nextgen_pro_film[override_thumbnail_settings]"]')
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_film_thumbnail_dimensions'))
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_film_thumbnail_quality'))
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_film_thumbnail_crop'))
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_film_thumbnail_watermark'));
});