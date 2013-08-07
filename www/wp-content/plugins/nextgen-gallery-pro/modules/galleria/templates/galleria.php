<?php

$this->include_template('photocrati-nextgen_gallery_display#container/before');

if (!isset($galleria_class))
{
	$galleria_class = null;
}

$galleria_class = $displayed_gallery->display_type . ' ' . $galleria_class;

?>
<div class="galleria <?php echo esc_attr($galleria_class) ?>" data-id="<?php echo esc_attr($displayed_gallery_id) ?>" id="displayed_gallery_<?php echo esc_attr($displayed_gallery_id) ?>" style="text-align: center;">
	<script type="text/x-galleria-style-template" id="css_overrides_<?php echo esc_attr($displayed_gallery_id) ?>">
		<?php echo $custom_css_rules ?>
	</script>
	<div class="galleria-batch" style="display: none" id="displayed_gallery_batch_<?php echo esc_attr($displayed_gallery_id) ?>">
	<?php

	$this->include_template('photocrati-nextgen_gallery_display#list/before');

	?>
	<?php
	 $i = 0;
	 
	 foreach ($images as $image): ?>
		<?php
		
		$template_params = array(
				'index' => $i,
				'class' => 'batch-image',
				'image' => $image,
			);
		
		$this->include_template('photocrati-nextgen_gallery_display#image/before', $template_params);
		
		?>
         <img
             data-title="<?php echo esc_attr($image->alttext)?>"
             data-alt="<?php echo esc_attr($image->alttext)?>"
             data-src="<?php echo esc_attr($storage->get_image_url($image))?>"
             data-thumbnail="<?php echo esc_attr($storage->get_image_url($image, 'thumb')); ?>"
             width="<?php echo esc_attr($image->meta_data['width'])?>"
             height="<?php echo esc_attr($image->meta_data['height'])?>"
             data-image-id="<?php echo esc_attr($image->{$image->id_field})?>"
             data-description="<?php echo esc_attr(stripslashes($image->description)); ?>"
         />
         <noscript>
             <img
                 title="<?php echo esc_attr($image->alttext)?>"
                 alt="<?php echo esc_attr($image->alttext)?>"
                 src="<?php echo esc_attr($storage->get_image_url($image))?>"
                 width="<?php echo esc_attr($image->meta_data['width'])?>"
                 height="<?php echo esc_attr($image->meta_data['height'])?>"
                 data-image-id="<?php echo esc_attr($image->{$image->id_field})?>"
                 data-description="<?php echo esc_attr(stripslashes($image->description)); ?>"
                 />
         </noscript>
	  <?php
		$this->include_template('photocrati-nextgen_gallery_display#image/after', $template_params);

		?>

		<?php $i++; ?>
	<?php endforeach ?>
	<?php

	$this->include_template('photocrati-nextgen_gallery_display#list/after');

	?>
	</div>
</div>
<?php $this->include_template('photocrati-nextgen_gallery_display#container/after'); ?>
