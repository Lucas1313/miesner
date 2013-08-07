<table class="protect_image_fields">
    <tr>
        <th>
            <label for="protect_enable_site">
                <?php echo_h(_('Enable protection on whole site:'))?>
            </label>
        </th>
        <td>
            <input type="checkbox" id="protect_enable_site" name="settings[enable_site]" value="<?php echo $enable_site; ?>" />
        </td>
    </tr>

    <tr>
        <th>
            <label for="protect_enable_image">
                <?php echo_h(_('Enable protection on all site images:'))?>
            </label>
        </th>
        <td>
            <input type="checkbox" id="protect_enable_image" name="settings[enable_image]" value="<?php echo $enable_image; ?>" />
        </td>
    </tr>

    <tr>
        <th>
            <label for="protect_enable_gallery">
                <?php echo_h(_('Enable protection on gallery images:'))?>
            </label>
        </th>
        <td>
            <input type="checkbox" id="protect_enable_gallery" name="settings[enable_gallery]" value="<?php echo $enable_gallery; ?>" />
        </td>
    </tr>

    <tr>
        <th>
            <label for="protect_enable_lightbox">
                <?php echo_h(_('Enable protection on lightbox pop-ups:'))?>
            </label>
        </th>
        <td>
            <input type="checkbox" id="protect_enable_lightbox" name="settings[enable_lightbox]" value="<?php echo $enable_lightbox; ?>" />
        </td>
    </tr>


</table>
