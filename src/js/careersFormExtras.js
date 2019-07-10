($ => {
    $(document).ready(() => {
        // Copy the Job Title to the corresponding field, when the available position is clicked...
        $('.careers-list-simple-wrapper ul.loop-career li a').click(function(){
            $('#careers-form input#tq-name').focus();
            $('#careers-form input#tq-job').val($(this).text());
        });
    });
})(jQuery);
  