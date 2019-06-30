<?php



$terms = [];
$property_type_terms = get_the_terms( get_the_ID(), Interra_Listing_CPT::$LISTING_PROPERTY_TYPE_TAX_SLUG );
$region_terms = get_the_terms( get_the_ID(), Interra_Listing_CPT::$LISTING_REGION_TAX_SLUG );

if ($property_type_terms) {
  $terms += $property_type_terms;
}

if ($region_terms) {
  $terms += $region_terms;
}

foreach ($terms as $term) { ?>

  <div class="term-listing">
    <a href="/listings?<?php echo $term->taxonomy; ?>=<?php echo $term->term_id; ?>" >
      <?php echo $term->name; ?>
    </a>
  </div>

<?php } ?>
