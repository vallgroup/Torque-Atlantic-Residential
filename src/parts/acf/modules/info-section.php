<?php

?>

<div class="info-section align-center color-combo-color4">

  <?php if ($heading) { ?>
    <h3><?php echo $heading; ?></h3>
  <?php } ?>

  <?php if ($content) { ?>
    <div class="info-section-intro"><?php echo $content; ?></div>
  <?php } ?>

  <?php if ($left_list || $right_list) { ?>
    <div class="list-wrapper" >
    <?php if ($left_list) { ?>
        <div class="left-list-wrapper" >
            <ul>
            <?php while ( have_rows('left_list') ) : the_row();
            $list_item = get_sub_field('item');
            echo '<li class="list-item">';
            echo $list_item;
            echo '</li>';
            endwhile; ?>
            </ul>
        </div>
    <?php } ?>
    <?php if ($right_list) { ?>
        <div class="right-list-wrapper" >
            <ul>
            <?php while ( have_rows('right_list') ) : the_row();
            $list_item = get_sub_field('item');
            echo '<li class="list-item">';
            echo $list_item;
            echo '</li>';
            endwhile; ?>
            </ul>
        </div>
    <?php } ?>
    </div>
  <?php } ?>

</div>

<?php ?>