($ => {
    $(document).ready(() => {
        
        const searchForm = $('form.searchform');
        const searchFormSubmitBtn = searchForm.find('button[type=submit]');

        searchFormSubmitBtn.click(function(e){
            if (searchForm.hasClass('closed')) {
                // Don't submit the form
                e.stopPropagation();
                e.preventDefault();
                // Remove the class, to expose the input box!
                searchForm.removeClass('closed');
            }
        });
    });
})(jQuery);