($ => {
  $(document).ready(() => {
    const top_of_page = $("header").offset().top; // Top of page reference
    const show_btn_after = 600; // Number of pixels to scroll before showing the back to top btn
  
    // Prepend the back to top btn
    $("footer").prepend(
      '<div class="back-to-top-container"><div class="back-to-top-btn fa fa-arrow-up"></div></div>'
    );
  
    // Save the jQuery elements for future use
    const back_to_top_container = $(".back-to-top-container");
    const back_to_top_btn = $(".back-to-top-btn");
  
    // When user scrolls past certain point on page, show/hide the back to top btn
    $(document).scroll(function() {
      var scrolled_from_top = $(document).scrollTop();
      if (scrolled_from_top > show_btn_after) {
        // Show btn
        back_to_top_container.addClass("show-btn");
      } else {
        // Hide btn
        back_to_top_container.removeClass("show-btn");
      }
    });
  
    // On click, take user back to top of page
    back_to_top_container.click(function() {
      $("html, body").animate(
        {
          scrollTop: top_of_page
        },
        200
      );
      return false;
    });
  });
})(jQuery);