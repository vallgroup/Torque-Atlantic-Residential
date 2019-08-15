($ => {
    $(document).ready(() => {
        
        const searchForm = $('form.searchform');
        const searchFormSubmitBtn = searchForm.find('button[type=submit]');

        // Style search form on page load
        styleSearchForm();

        searchFormSubmitBtn.click(function(e){
            if (searchForm.hasClass('closed')) {
                // Don't submit the form
                e.stopPropagation();
                e.preventDefault();
                // Remove the class, to expose the input box!
                searchForm.removeClass('closed');
            }
        });

        $(window).resize(function(){
            // Style search form on window resize
            styleSearchForm();
        });

        function styleSearchForm() {
            if ( $(window).width() >= 1023 ) {
                searchForm.addClass('closed');
            } else {
                searchForm.removeClass('closed');
            }
        }
    });
})(jQuery);