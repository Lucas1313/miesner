jQuery(function($) {
    $('input[name="photocrati-nextgen_pro_horizontal_filmstrip[override_thumbnail_settings]"]')
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_horizontal_filmstrip_thumbnail_dimensions'))
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_horizontal_filmstrip_thumbnail_quality'))
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_horizontal_filmstrip_thumbnail_crop'))
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_horizontal_filmstrip_thumbnail_watermark'));

    $('input[name="photocrati-nextgen_pro_horizontal_filmstrip[override_image_settings]"]')
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_horizontal_filmstrip_image_dimensions'))
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_horizontal_filmstrip_image_quality'))
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_horizontal_filmstrip_image_crop'))
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_horizontal_filmstrip_image_watermark'));

    $('input[name="photocrati-nextgen_pro_horizontal_filmstrip[image_crop]"]')
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_horizontal_filmstrip_image_pan'));

    $('input[name="photocrati-nextgen_pro_horizontal_filmstrip[show_captions]"]')
        .nextgen_radio_toggle_tr('1', $('#tr_photocrati-nextgen_pro_horizontal_filmstrip_caption_class'));
});