<?php

$this->include_template('photocrati-nextgen_gallery_display#container/before');

?>
<div class="<?php echo esc_attr($css_class) ?>" id="<?php echo_h($id) ?>">
	<?php $this->include_template('photocrati-nextgen_gallery_display#list/before'); ?>

	<?php $i = 0; foreach ($entities as $entity): ?>
        <div class='image_container'>
            <a
                href="<?php echo esc_attr($entity->link)?>"
                title="<?php echo esc_attr($entity->galdesc)?>"
                class="gallery_link">
                <img
                    data-title="<?php echo esc_attr($entity->title)?>"
                    data-alt="<?php echo esc_attr($entity->title)?>"
                    src="<?php echo esc_attr($entity->url); ?>"
                    width="<?php echo esc_attr($entity->thumb_size['width'])?>"
                    height="<?php echo esc_attr($entity->thumb_size['height'])?>"
                    class="gallery_preview"
                />
                <noscript>
                    <img
                        title="<?php echo esc_attr($entity->title)?>"
                        alt="<?php echo esc_attr($entity->title)?>"
                        src="<?php echo esc_attr($entity->url); ?>"
                        width="<?php echo esc_attr($entity->thumb_size['width'])?>"
                        height="<?php echo esc_attr($entity->thumb_size['height'])?>"
                        class="gallery_preview"
                    />
                </noscript>
            </a>
            <a href="<?php echo esc_attr($entity->link)?>"
               title="<?php echo esc_attr($entity->title); ?>"
               class="caption_link" ><?php echo_h($entity->title)?></a>
            <div class="image_description"><?php echo_h($entity->galdesc)?></div>
            <br class="clear"/>
        </div>
	<?php $i++; ?>
	<?php endforeach ?>

    <?php $this->include_template('photocrati-nextgen_gallery_display#list/after'); ?>
</div>

<?php $this->include_template('photocrati-nextgen_gallery_display#container/after'); ?>
