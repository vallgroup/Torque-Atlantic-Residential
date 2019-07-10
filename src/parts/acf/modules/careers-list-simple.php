<?php 

$careers_loop = new Torque_Load_More_Loop(
  'careers',
  $number_of_careers,
  array( 'post_type' => Torque_Careers_CPT::$careers_labels['post_type_name'] ),
  'parts/shared/loop-career-simple.php'
);

Torque_Load_More::get_inst()->register_loop( $careers_loop );

?>


<?php if ($careers_loop->has_first_page()) { ?>

<div class="careers-list-simple-wrapper" >
	<h3>Job Opportunities</h3>
    <ul class="loop-career">
        <?php $careers_loop->the_first_page(); ?>
    </ul>
</div>

<?php } ?>