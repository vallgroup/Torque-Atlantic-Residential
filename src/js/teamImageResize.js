($ => {
  $(document).ready(() => {
    // Set constant vars
    const single_listing_team_headshot = $(".broker .broker-image-container");
    const team_grid_headshot = $(".staff-member .image-wrapper");
    const single_team_headshot = $(".staff-image-container .featured-image");
    const height_to_width_ratio = 1.15;

    // On load ensure image ratio is correct
    resetImageRatio(single_listing_team_headshot, height_to_width_ratio);
    resetImageRatio(team_grid_headshot, height_to_width_ratio);
    resetImageRatio(single_team_headshot, height_to_width_ratio);

    // On resize ensure image ratio is correct
    $(window).resize(function() {
      resetImageRatio(single_listing_team_headshot, height_to_width_ratio);
      resetImageRatio(team_grid_headshot, height_to_width_ratio);
      resetImageRatio(single_team_headshot, height_to_width_ratio);
    });
  });

  function resetImageRatio($elements, $heightToWidthRatio = 1) {
    // Check if elements exist
    if ($elements.length > 0) {
      $elements.each(function() {
        // With each, reset the image ratio
        let newHeight = $(this).width() * $heightToWidthRatio;
        $(this).css({
          transition: "0.2s",
          width: "100%",
          "max-height": newHeight,
          "min-height": newHeight
        });
      });
    } else {
      return;
    }
  }
})(jQuery);
