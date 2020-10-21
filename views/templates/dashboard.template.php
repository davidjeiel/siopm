<?php ob_start(); ?>
<link href='/views/css/dashboard.css' rel='stylesheet'>
<div id='dashboard' class=''>
	<div class='widget-container'><?php require "/views/templates/widgets/$widgets[0].widget.php"; ?></div>
	<div class='widget-container'> 
		<?php 
			require "/views/templates/widgets/$widgets[1].widget.php"; 
			require "/views/templates/widgets/$widgets[2].widget.php"; 
		?>
	</div>
	<div class='widget-container'><?php require "/views/templates/widgets/$widgets[3].widget.php"; ?></div>
</div>
<?php $contents = ob_get_clean(); ?>