
<?php

$image_2_start_int = intval($image_2_start);

$col_2 = 12 - $image_2_start_int;
$col_1 =  $image_2_start_int;

?>

<div class="row images-wrapper <?php echo $tablet_stack; ?>">
  <img class="gallery-col gallery-col-<?php echo $col_1; ?>" src="<?php echo $image_1; ?>"/>
  <img class="gallery-col gallery-col-<?php echo $col_2; ?>" src="<?php echo $image_2; ?>"/>
</div>
