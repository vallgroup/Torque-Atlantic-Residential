($ => {
    $(document).ready(() => {
        // Copy the Job Title to the corresponding field, when the available position is clicked...
        $('.careers-list-simple-wrapper ul.loop-career li a').click(function(){
            $('#careers-form input#tq-name').focus();
            $('#careers-form input#tq-job').val($(this).text());
        });

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
    });
})(jQuery);
  