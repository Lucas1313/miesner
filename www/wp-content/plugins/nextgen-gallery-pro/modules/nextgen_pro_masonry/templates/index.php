<?php $this->start_element('nextgen_gallery.gallery_container', 'container', $displayed_gallery); ?>
<style type='text/css'>
    #ngg-gallery-<?php echo_h($displayed_gallery_id); ?> .ngg-pro-masonry-item {
        margin-bottom: <?php print $padding; ?>px;
    }
</style>
<div class="ngg-pro-masonry" id="ngg-gallery-<?php echo_h($displayed_gallery_id); ?>">
    <div class='ngg-pro-masonry-gutter' style='width: <?php print $padding; ?>px'></div>
    <div class='ngg-pro-masonry-sizer' style='width: <?php print $size; ?>px'></div>
    <?php $this->start_element('nextgen_gallery.image_list_container', 'container', $images); ?>
    <?php for ($i = 0; $i < count($images); $i++) { ?>
        <?php $image = $images[$i]; ?>
        <?php $thumb_size = $storage->get_image_dimensions($image, $thumbnail_size_name); ?>
        <?php $this->start_element('nextgen_gallery.image_panel', 'item', $image); ?>
            <?php $this->start_element('nextgen_gallery.image', 'item', $image); ?>
            <div class='ngg-pro-masonry-item' style='width: <?php echo $thumb_size['width']; ?>px; height: <?php echo $thumb_size['height']; ?>px;'>
                <a href="<?php echo esc_attr($storage->get_image_url($image)); ?>"
                   title="<?php echo esc_attr($image->description); ?>"
                   data-image-id='<?php echo esc_attr($image->pid); ?>'
                   <?php echo $effect_code ?>>
                    <img title="<?php echo esc_attr($image->alttext); ?>"
                         alt="<?php echo esc_attr($image->alttext); ?>"
                         src="<?php echo esc_attr($storage->get_image_url($image, $thumbnail_size_name)); ?>"
                         width="<?php echo esc_attr($thumb_size['width']); ?>"
                         height="<?php echo esc_attr($thumb_size['height']); ?>"/>
                </a>
            </div>
            <?php $this->end_element(); ?>
        <?php $this->end_element(); ?>
    <?php } ?>
    <?php $this->end_element(); ?>
</div>
<?php $this->end_element(); ?>
