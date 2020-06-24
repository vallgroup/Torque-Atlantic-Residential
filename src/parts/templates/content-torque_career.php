<?php
$content = apply_filters( 'the_content', get_the_content() );
?>

<div class="career-content-wrapper">

  <div class="career-content-details" >

    <?php if ( ! empty( $content ) ) { ?>

      <div class="the-content" >
        <?php echo $content; ?>
        <button class="apply-now">Apply Now</button>
      </div>
    <?php } ?>

  </div>

  <div class="career-form-module-wrapper">
    <?php /* Careers Form Module */ ?>
    <?php get_template_part( 'parts/forms/form', 'careers' ); ?>
  </div>

</div>

