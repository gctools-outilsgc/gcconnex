/*
* Require js file for selectize scripts
*
* @author Nick github.com/piet0024
*/

var selectizePath = elgg.normalize_url() + '/mod/gc_tags/js/selectize';

require.config({
    paths: {
        "selectize": selectizePath
    }
});

requirejs(["selectize"], function () {
    //tagging input
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
    //multi select audience input
    $('.audience-select').selectize({
        plugins: ['remove_button', 'clear_button'],

    });
    

});