($ => {
   $(document).ready(() => {
      // Set initial variables
      const onListingGridPage = $('body').hasClass('page-template-listings'); // Bool check to see if on page with a Listings Grid
      const onBlogGridPage = $('body').hasClass('page-template-blog'); // Bool check to see if on page with a Blog Grid
      const onAuthorPage = $('body').hasClass('author'); // Bool check to see if on page with a Blog Grid
      const listingGridImagesSelector = '.loop-post .featured-image-wrapper'; // Both Listings & Blogs covered here...
      const WidthToHeightRatio = 0.75; // 4:3 landscape ratio
      // Array of element selectors, used to apply the mutationObserve to each
      let observe_these_wrappers = ['posts-wrapper', 'listings-wrapper'];

      if (onListingGridPage || onBlogGridPage || onAuthorPage) {
         // On load ensure image ratio is correct
         resetImageRatio(listingGridImagesSelector, WidthToHeightRatio, 500);

         // On window resize ensure image ratio is correct
         $(window).resize(function () {
            resetImageRatio(listingGridImagesSelector, WidthToHeightRatio, 500);
         });

         // Setup a mutation observer to perform a given action if mutations are detected
         let mutationObserver = new MutationObserver(function (mutations) {
            let resetRequired = false;
            mutations.forEach(function (mutation) {
               if (mutation.addedNodes.length) {
                  // Set flag so we know a reset is required
                  resetRequired = true;
                  // Attempt to exit the loop
                  return false;
               }
            });
            // Wait until all the mutations have occurred, and if we're determined that a reset is required, go for it!
            if (resetRequired) {
               resetImageRatio(listingGridImagesSelector, WidthToHeightRatio, 500);
            }
         });

         
         // Loop through each selector in the array
         for (let a = 0; a < observe_these_wrappers.length; a++ ) {
            // Check how many of each selector/wrapper exists
            let num_wrappers = jQuery('.'+observe_these_wrappers[a]).length;
               // For each, if any, loop through and call the observe method on them
               for (let b = 0; b < num_wrappers; b++ ) {
                  // Call observe method on wrapper instance
                  mutationObserver.observe(
                     document.getElementsByClassName(observe_these_wrappers[a])[b],
                     {
                        childList: true,
                        subtree: true
                     }
                  );
               }
         }

         // Kill the nutationObserve when leaving the page...
         $(window).unload(function () {
            mutationObserver.disconnect();
         });
      }
   });


   /**
    * Attempts to find elements and resize them based on the WidthToHeightRatioTarget. If no elements are 
    * @param {*} elementsToResizeSelector The selector used to find the element(s)
    * @param {*} WidthToHeightRatioTarget A ratio, used to multiple by the width to get the new height
    * @param {*} maxAttemptsToFindElements Maximum number of attempts before aborting mission
    * @param {*} elementSearchInterval Milliseconds to wait between each search for the elements 
    */
   function resetImageRatio(
      elementsToResizeSelector,
      WidthToHeightRatioTarget = 1,
      maxAttemptsToFindElements = 1000,
      elementSearchInterval = 10
   ) {
      // Set initial variables
      let currSearchAttempt = 1;
      // Initialise a poller, to loop through at certain intervals until we find element(s)
      let poller1 = setInterval(function () {
         // Setup jQuery objects for the selector, each interval
         elementsToFind = $(elementsToResizeSelector);

         /**
          * IF: we haven't found the elements, and we haven't reached the maximum number of attempts, try again
          * ELSE IF: we haven't found the elements, BUT we've reached the maximum number of attempts, abort mission
          * ELSE: We must have found the element(s), start resizing them!
          */
         if (elementsToFind.length < 1 && currSearchAttempt <= maxAttemptsToFindElements) {
            // Increment attempts counter
            currSearchAttempt++;
            // Try again...
            return;
         } else if (elementsToFind.length < 1 && currSearchAttempt > maxAttemptsToFindElements) {
            // Clear the interval and exit
            clearInterval(poller1);
         } else {
            // We've found the element(s), so start resizing them!
            elementsToFind.each(function () {
               let newHeight = $(this).width() * WidthToHeightRatioTarget;
               // With each, reset the image ratio
               $(this).css({
                  transition: '0.2s',
                  width: '100%',
                  'max-height': newHeight,
                  'min-height': newHeight,
                  height: newHeight
               });
            });

            // Clear the interval and exit
            clearInterval(poller1);
         }
      }, elementSearchInterval);
   }
})(jQuery);
