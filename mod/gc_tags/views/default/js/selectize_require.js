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
    var comm_selectized = $('.audience-select').selectize({
        plugins: ['remove_button', 'clear_button'],
        onFocus: function(){
            $('.community-input-toggle').data('commtoggle','up');
            $('.community-input-toggle').html('<i class="fa fa-caret-up" aria-hidden="true"></i>');
        },
        onBlur: function(){
            $('.community-input-toggle').data('commtoggle','caret');
            $('.community-input-toggle').html('<i class="fa fa-caret-down" aria-hidden="true"></i>');
        },
        theme: 'bootstrap',
        onChange: function(){
            var changeValue = comm_selectized[0].selectize.getValue();
            if(changeValue.includes('allps')){
                comm_selectized[0].selectize.setValue('allps', true);
            }
        }
    });
    
    //button for opening and closing the community dropdown
    $('.community-input-toggle').on('click', function(){
        if($(this).data('commtoggle') == 'caret'){
            $(this).html('<i class="fa fa-caret-up" aria-hidden="true"></i>');
            comm_selectized[0].selectize.focus();
            $(this).data('commtoggle','up');
        }else{
            $(this).html('<i class="fa fa-caret-down" aria-hidden="true"></i>');
            $(this).data('commtoggle','caret');
        }
    });
    
});