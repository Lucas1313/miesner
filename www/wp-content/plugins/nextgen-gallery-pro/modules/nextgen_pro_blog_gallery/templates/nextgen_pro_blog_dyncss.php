#<?php echo $id ?> .image-wrapper {
	margin-bottom: <?php echo $spacing ?>px;
}
#<?php echo $id ?> img {
	<?php if ($border_size): ?>
	border: solid <?php echo $border_size ?>px <?php echo $border_color ?>;
	<?php endif ?>
}
