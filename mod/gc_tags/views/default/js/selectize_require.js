/*
* Require js file for selectize scripts
*
*/

var selectizePath = elgg.normalize_url() + '/mod/gc_tags/js/selectize.min';

require.config({
    paths: {
        "selectize": selectizePath
    }
});

requirejs(["selectize"], function () {
    $('#blog_status').selectize();
    $('.elgg-input-tags').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        create: function(input) {
            return {
                value: input,
                text: input
            }
        }
    });
    
    $('.audience-select').selectize({
        plugins: ['remove_button']
    });
});