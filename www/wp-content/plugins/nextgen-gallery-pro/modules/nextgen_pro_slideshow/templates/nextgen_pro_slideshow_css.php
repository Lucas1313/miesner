.galleria-stage .galleria-image img {
	<?php if ($border_size): ?>
	border: solid <?php echo intval($border_size)?>px black;
	<?php endif ?>

	<?php if ($border_color): ?>
	border-color: <?php echo $border_color?>;
	<?php endif ?>
}