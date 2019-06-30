<?php

$thumbnail = get_the_post_thumbnail_url(null, 'full');

?>

<?php if ($thumbnail) { ?>
<div class="featured-image-wrapper" >
  <div class="featured-image" style="background-image: url('<?php echo $thumbnail; ?>')" ></div>
</div>
<?php } ?>
