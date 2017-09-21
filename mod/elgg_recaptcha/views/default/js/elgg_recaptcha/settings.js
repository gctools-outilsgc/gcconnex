// save checkbox values as single comma delimited field
define(['jquery'], function($) {
    $(document).on('change', '.recaptcha-action', function() {

        var val = $(this).val();
        var values = $('.recaptcha-action-values').val();

        if (values) {
            var actions = values.split(',');
        }
        else {
            var actions = [];
        }

        if ($(this).is(':checked')) {
            // add it to the values
            if ($.inArray(val, actions) >= 0) {
                // it's already there
                return;
            }

            actions.push(val);
            actions.sort();
            values = actions.join(',');

            $('.recaptcha-action-values').val(values);

        }
        else {
            // remove it from the values
            if ($.inArray(val, actions) < 0) {
                // already not there
                return;
            }

            actions = $.grep(actions, function(value) {
                return value !== val;
            });

            values = actions.join(',');

            $('.recaptcha-action-values').val(values);
        }
    });
});
