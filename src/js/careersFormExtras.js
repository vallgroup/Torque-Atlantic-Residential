($ => {
    $(document).ready(() => {

        /**
         * Single Career Page
         */
        const isSingleCareer = window.location.href.indexOf("/career/") > -1;
        if (isSingleCareer) {
            // pre-fill the job field in the form with the page title
            const jobTitle = $('.career-title-wrapper h2').text();
            $('#careers-form input#tq-job').val(jobTitle);
            // on 'apply' click, scroll to form and focus on first field
            $('.career-content-details .apply-now').click(function(){
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#careers-form").offset().top
                });
                $('#careers-form input#tq-name').focus();
            });
        }

        // Copy the Job Title to the corresponding field, when the available position is clicked...
        $('.careers-list-simple-wrapper ul.loop-career li a').click(function(){
            $('#careers-form input#tq-name').focus();
            $('#careers-form input#tq-job').val($(this).text());
        });

        // update filename placeholder when file changes
        $('input[type="file"]#tq-resume').bind('change', function() {
            var fullPath = $(this).val();
            if (fullPath) {
                var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                var filename = fullPath.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                    filename = filename.substring(1);
                }
                $('.file-input-text').html(filename).removeClass('placeholder');
            }
        });

        /**
         * Manage Careers Forms (Stage 1 & 2)
         * When submitted successfully, hide the form...
         */
        // stage 1
        const s1FormSubmitted = window.location.href.indexOf("#careers-form") > -1;
        const s1FormMessageExists = $('.form-message').length > 0;
        const s1FormSuccess = !$('.form-message').hasClass('error');
        if (s1FormSubmitted && s1FormMessageExists && s1FormSuccess) {
            $('form#careers-form-main').addClass('hide-form');
        }
        // stage 2
        const s2FormSubmitted = window.location.href.indexOf("#online-application-form") > -1;
        const s2FormMessageExists = $('.form-message').length > 0;
        const s2FormSuccess = !$('.form-message').hasClass('error');
        if (s2FormSubmitted && s2FormMessageExists && s2FormSuccess) {
            $('form#online-application-form-main').addClass('hide-form');
        }
        
    });
})(jQuery);
  