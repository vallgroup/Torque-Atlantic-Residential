<?php

$careers_loop = new Torque_Load_More_Loop(
  'careers',
  2,
  array( 'post_type' => Torque_Careers_CPT::$careers_labels['post_type_name'] ),
  'parts/shared/loop-career.php'
);

Torque_Load_More::get_inst()->register_loop( $careers_loop );

?>


<?php if ($careers_loop->has_first_page()) { ?>

<div class="careers-wrapper" >
	<h3>Available Positions</h3>

	<?php $careers_loop->the_first_page(); ?>
</div>

<?php }

get_template_part( 'parts/forms/form', 'careers' );

?>
