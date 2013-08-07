<?php

$this->include_template('photocrati-nextgen_gallery_display#container/before');

?>
<div class="nextgen_pro_thumbnail_grid" id="<?php echo_h($id) ?>">
	<?php

	$this->include_template('photocrati-nextgen_gallery_display#list/before');

	?>
	<?php 
		$i = 0;
		foreach ($images as $image): ?>
	<?php $thumb_size = $storage->get_image_dimensions($image, $thumbnail_size_name); ?>
		<?php
		
		$template_params = array(
				'index' => $i,
				'class' => 'image-wrapper',
				'image' => $image,
			);
		
		$this->include_template('photocrati-nextgen_gallery_display#image/before', $template_params);
		
		?>
		<a href="<?php echo esc_attr($storage->get_image_url($image))?>"
		   title="<?php echo esc_attr($image->description)?>"
		   data-image-id='<?php echo esc_attr($image->pid); ?>'
			<?php echo $effect_code ?>>
			<img
				data-title="<?php echo esc_attr($image->alttext)?>"
				data-alt="<?php echo esc_attr($image->alttext)?>"
				src="<?php echo esc_attr($storage->get_image_url($image, $thumbnail_size_name))?>"
				width="<?php echo esc_attr($thumb_size['width'])?>"
				height="<?php echo esc_attr($thumb_size['height'])?>"
				style="max-width:none"
			/>
			<noscript>
				<img
					title="<?php echo esc_attr($image->alttext)?>"
					alt="<?php echo esc_attr($image->alttext)?>"
					src="<?php echo esc_attr($storage->get_image_url($image, $thumbnail_size_name))?>"
					width="<?php echo esc_attr($thumb_size['width'])?>"
					height="<?php echo esc_attr($thumb_size['height'])?>"
					style="max-width:none"
				/>
			</noscript>
		</a>
		<?php

		$this->include_template('photocrati-nextgen_gallery_display#image/after', $template_params);

		?>
	<?php $i++; ?>
	<?php endforeach ?>

    <?php if ($pagination) { ?>
        <?php echo $pagination ?>
    <?php } else { ?>
        <div class="ngg-clear"></div>
    <?php } ?>
</div>