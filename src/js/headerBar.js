($ => {
  $(document).ready(() => {
    const bodyContainer = $("body");
    const headerContent = $("header .torque-header-content-wrapper");
    const outsideHeaderBar = $(".torque-header-logo-wrapper, main, footer");

    const headerMenuPreText = $(
      "header .torque-header-burger-menu-wrapper .pre-text"
    );
    const headerBurgerMenu = $("header .torque-burger-menu");
    const headerMenuItemsContainer = $(
      "header .torque-header-menu-items-mobile"
    );

    const menuOverlayHTML = '<div class="menu-overlay"></div>';
    const menuOverlayClass = ".menu-overlay";

    // const headerSearchForm = headerContent.find("form.searchform");
    // const headerSearchFormInput = headerSearchForm.find("input");

    // open/close menu when user clicks on pre-text
    headerMenuPreText.click(function() {
      openCloseMenu();
      addRemoveOverlay();
    });

    // open/close menu when user clicks on pre-text
    headerBurgerMenu.click(function() {
      // open/close of menu is already handled by the parent theme...
      // this is additional functionality in the child theme...
      addRemoveOverlay();
    });

    // When user clicks outside of menu container
    outsideHeaderBar.click(function() {
      // ONLY If the meun is open, close it...
      if (headerContent.hasClass("active")) {
        openCloseMenu();
      }
    });

    //

    /* headerSearchForm.click(function(e) {
        headerContent.toggleClass("searchform-open");
        $(this).toggleClass("closed");
        // If we've opened the search form then forcus on it...
        if ( headerContent.hasClass("searchform-open") ) {
            headerSearchFormInput.focus();
        }
    });

    headerSearchForm.find("input").click(function(e) {
        e.stopPropagation();
    });

    // When user clicks outside of search form
    outsideHeaderBar.click(function(){
        // If the form is open
        if ( headerContent.hasClass("searchform-open") ) {
            // Close it...
            headerContent.toggleClass("searchform-open");
            headerSearchForm.toggleClass("closed");
        }
    }); */

    // Function to open/close the menu
    function openCloseMenu() {
      headerContent.toggleClass("active");
      headerBurgerMenu.toggleClass("active");
      headerMenuItemsContainer.toggleClass("active");
    }

    // Function to add/remove the menu overlay
    function addRemoveOverlay() {
      if (headerContent.hasClass("active")) {
        // Create and show the menu overlay
        bodyContainer.append(menuOverlayHTML);
        $(menuOverlayClass).animate(
          {
            opacity: 1
          },
          150
        );
        // Add event handler for newly created menu overlay element
        $(menuOverlayClass).click(function() {
          openCloseMenu();
          addRemoveOverlay();
        });
      } else {
        // Remove the menu overlay
        $(menuOverlayClass).fadeOut(250, function() {
          $(this).remove();
        });
      }
    }
  });
})(jQuery);
