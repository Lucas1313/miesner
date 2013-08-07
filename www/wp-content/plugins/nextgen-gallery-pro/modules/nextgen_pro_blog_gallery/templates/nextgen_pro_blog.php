<?php

$this->start_element('nextgen_gallery.gallery_container', 'container', $displayed_gallery);

?>
<div class="nextgen_pro_blog_gallery" id="<?php echo_h($id) ?>">
	<?php

	$this->start_element('nextgen_gallery.image_list_container', 'container', $images);

	?>
	<?php 
		$image_display_size = $image_display_size - ($border_size * 2);
		
		$i = 0;
		foreach ($images as $image): 
	$image_size = $storage->get_image_dimensions($image, $image_size_name); 
	
	// We scale each image in such that it's longest side equals the gallery's
	// "Image Display Size" setting/property
	$aspect_ratio = $image_size['width']/$image_size['height'];

	// XXX always assume width
#if (((float)$image_size['width']) > ((float)$image_size['height'])) {
		$image_size['width']	 = $image_display_size;
		$image_size['height']	 = $image_size['width']/$aspect_ratio;
#	}
#	else {
#		$image_size['height']	= $image_display_size;
#		$image_size['width']	= $image_size['height']*$aspect_ratio;
#	}
	
		$style = 'width: ' . $image_size['width'] . 'px';
		
		$this->start_element('nextgen_gallery.image_panel', 'item', $image);
		
		?>
	<div id="<?php echo_h('ngg-image-' . $i) ?>" class="image-wrapper" style="<?php echo esc_attr($style); ?>">
		<?php

		$this->start_element('nextgen_gallery.image', 'item', $image);

		?>
		<a href="<?php echo esc_attr($storage->get_image_url($image))?>"
		   title="<?php echo esc_attr($image->description)?>"
		   data-image-id='<?php echo esc_attr($image->pid); ?>'
		   <?php echo $effect_code ?>>
		   <?php // NOTE: we don't specify height as the "width" property might actually not reflect the final image width, because images are responsive and adapt to container size when needed ?>
			<img
				data-title="<?php echo esc_attr($image->alttext)?>"
				data-alt="<?php echo esc_attr($image->alttext)?>"
                width="<?php echo esc_attr($image_size['width']); ?>"
				src="<?php echo esc_attr($storage->get_image_url($image, $image_size_name))?>"
			/>
			<noscript>
				<img
					title="<?php echo esc_attr($image->alttext)?>"
					alt="<?php echo esc_attr($image->alttext)?>"
					src="<?php echo esc_attr($storage->get_image_url($image, $image_size_name))?>"
          width="<?php echo esc_attr($image_size['width']); ?>"
				/>
			</noscript>
		</a>
		<?php

		$this->end_element(); 

		?>
	</div>
	<?php

	$this->end_element(); 

	?>
	<?php $i++; ?>
	<?php endforeach ?>
	<?php

	$this->end_element(); 

	?>
</div>

<?php

$this->end_element(); 
	
?>
