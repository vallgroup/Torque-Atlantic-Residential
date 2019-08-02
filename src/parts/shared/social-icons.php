<?php

$social_channels = have_rows('social_media', 'options');

?>

<div class="social-icons">

<?php if ($social_channels) { ?>
  <div class="social-media" >
    <ul class="social-icons">
      <?php
      while ( have_rows('social_media', 'option') ) : the_row();
        $socialchannel = get_sub_field('social_channel', 'option');
        $socialurl = get_sub_field('social_url', 'option');
        echo '<li class="social-item">';
        echo '<a class="social-link social-icon-' . $socialchannel . '" rel="nofollow noopener noreferrer" href="' . $socialurl . '" target="_blank">';
        echo '<span class="sr-only hidden">' . ucfirst($socialchannel) . '</span>';
        echo '</a></li>';
      endwhile;
      ?>
    </ul>
  </div>
<?php } ?>

</div>