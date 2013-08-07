<table class="protect_image_fields">
    <tr>
        <th>
            <label for="protect_enable_site">
                <?php echo_h(_('Protect whole site:'))?>
            </label>
        </th>
        <td id="protect_enable_site">
            <label><input type="radio" name="settings[protect_enable_site]" class="protect_enable_site" value="1" <?php echo $protect_enable_site == 1 ? ' checked="checked"' : ''; ?> /> <?php echo_h(_('Yes')) ?></label>
            <label><input type="radio" name="settings[protect_enable_site]" class="protect_enable_site" value="0" <?php echo $protect_enable_site == 0 ? ' checked="checked"' : ''; ?> /> <?php echo_h(_('No')) ?></label>
        </td>
    </tr>

    <tr>
        <th>
            <label for="protect_enable_image">
                <?php echo_h(_('Protect all site images:'))?>
            </label>
        </th>
        <td id="protect_enable_image">
            <label><input type="radio" name="settings[protect_enable_image]" class="protect_enable_image" value="1" <?php echo $protect_enable_image == 1 ? ' checked="checked"' : ''; ?> /> <?php echo_h(_('Yes')) ?></label>
            <label><input type="radio" name="settings[protect_enable_image]" class="protect_enable_image" value="0" <?php echo $protect_enable_image == 0 ? ' checked="checked"' : ''; ?> /> <?php echo_h(_('No')) ?></label>
        </td>
    </tr>

    <tr>
        <th>
            <label for="protect_enable_gallery">
                <?php echo_h(_('Protect gallery images:'))?>
            </label>
        </th>
        <td id="protect_enable_gallery">
            <label><input type="radio" name="settings[protect_enable_gallery]" class="protect_enable_gallery" value="1" <?php echo $protect_enable_gallery == 1 ? ' checked="checked"' : ''; ?> /> <?php echo_h(_('Yes')) ?></label>
            <label><input type="radio" name="settings[protect_enable_gallery]" class="protect_enable_gallery" value="0" <?php echo $protect_enable_gallery == 0 ? ' checked="checked"' : ''; ?> /> <?php echo_h(_('No')) ?></label>
        </td>
    </tr>

    <tr>
        <th>
            <label for="protect_enable_lightbox">
                <?php echo_h(_('Protect lightbox pop-ups:'))?>
            </label>
        </th>
        <td id="protect_enable_lightbox">
            <label><input type="radio" name="settings[protect_enable_lightbox]" class="protect_enable_lightbox" value="1" <?php echo $protect_enable_lightbox == 1 ? ' checked="checked"' : ''; ?> /> <?php echo_h(_('Yes')) ?></label>
            <label><input type="radio" name="settings[protect_enable_lightbox]" class="protect_enable_lightbox" value="0" <?php echo $protect_enable_lightbox == 0 ? ' checked="checked"' : ''; ?> /> <?php echo_h(_('No')) ?></label>
        </td>
    </tr>


</table>
