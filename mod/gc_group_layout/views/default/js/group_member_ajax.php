<?php
/*
Group membership ajax. Used in cases such as changing group owner or adding operators
*/
?>

var textarea;
    var getCursorPosition = function(el) {
        var pos = 0;

        if ('selectionStart' in el) {
            pos = el.selectionStart;
        } else if ('selection' in document) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', - el.value.length);
            pos = Sel.text.length - SelLength;
        }

        return pos;
    };

    var handleResponse_groupmem = function (json) {
        var userOptions = '';
        var userSelectOptions = '';
        $(json).each(function(key, user) {
            userOptions += '<li tabIndex="0" data-username="' + user.desc + '" data-guid="' + user.guid + '">' + user.icon + user.name + "</li>";
            userSelectOptions += '<option value="' + user.guid + '">' + user.desc + " (@" + user.name + ")" + "</option>";
        });

        $('#groups-owner-guid-select').html(userSelectOptions);        // update select options
        $(textarea).parent().find('.self-groups-owner-guid-select').html(userSelectOptions);
        if (!userOptions) {
            $('#groupmems-popup > .panel-body').html('<div class="elgg-ajax-loader"></div>');
            $('#groupmems-popup').addClass('hidden');
             $(textarea).parent().find('.self-groupmems-popup > .panel-body').html('<div class="elgg-ajax-loader"></div>');
            $(textarea).parent().find('.self-groupmems-popup').addClass('hidden');
            return;
        }

        $(textarea).parent().find('.self-groupmems-popup  > .panel-body').html('<ul class="mentions-autocomplete list-unstyled mrgn-bttm-0">' + userOptions + "</ul>");
        $('#groupmems-popup > .panel-body').html('<ul class="mentions-autocomplete list-unstyled mrgn-bttm-0">' + userOptions + "</ul>");
        $('.mentions-autocomplete .elgg-avatar a').attr('tabindex', '-1');
        $('#groupmems-popup').removeClass('hidden');


        $('.mentions-autocomplete > li').bind('click', function(e) {
            e.preventDefault();

            var username = $(this).data('username');
            var guid = $(this).data('guid');

            // Remove the partial @username string from the first part
            //newBeforeMention = beforeMention.substring(0, position - current.length);

            // Add the complete @username string and the rest of the original
            // content after the first part
            var newContent = username;

            // Set new content for the textarea
                $(textarea).val(newContent);
                $('#groups-owner-guid-select').val(guid);
                $(textarea).parent().first('.self-groups-owner-guid-select').val(guid);
            // Hide the autocomplete popup
            $('#groupmems-popup').addClass('hidden');
            $(textarea).parent().find('.self-groupmems-popup').addClass('hidden');
        });


        //ability to tab and press enter on the list item

        $('.mentions-autocomplete > li').bind('keypress', function (e) {

                e.preventDefault();
                if (e.keyCode == 13) {
                var username = $(this).data('username');
                var guid = $(this).data('guid');

                // Remove the partial @username string from the first part
                //newBeforeMention = beforeMention.substring(0, position - current.length);

                // Add the complete @username string and the rest of the original
                // content after the first part
                var newContent = username;

                $(textarea).val(newContent).focus();
                $('#groups-owner-guid-select').val(guid);

                // Hide the autocomplete popup
                $('#groupmems-popup').addClass('hidden');
                    $(textarea).parent().find('.self-groupmems-popup').addClass('hidden');
            }
            });


    };

    var autocomplete_groupmem = function (content, position) {
        var current = content;

        if (current.length > 1) {
            current = current.replace('@', '');
            $('#groupmems-popup').removeClass('hidden');
            $(textarea).parent().find('.self-groupmems-popup').removeClass('hidden');
            var options = {success: handleResponse_groupmem};

            elgg.get(elgg.config.wwwroot + 'livesearch?q=' + current + '&g=' + elgg.get_page_owner_guid() + '&match_on=groupmems', options);
        } else {
            $('#groupmems-popup > .panel-body').html('<div class="elgg-ajax-loader"></div>');
            $('#groupmems-popup').addClass('hidden');
        }
    };

    var init_groupmem = function() {

        var content;
        var position;
//        elgg = require('elgg');

        $('#groups-owner-guid').bind('keyup', function(e) {

            // Hide on backspace and enter
            if (e.which == 8 || e.which == 13) {
                $('#groupmems-popup > .panel-body').html('<div class="elgg-ajax-loader"></div>');
                $('#groupmems-popup').addClass('hidden');
            } else {
                textarea = $(this);
                content = $(this).val();
                position = getCursorPosition(this);
                autocomplete_groupmem(content, position);
            }
        });
        
        $('.self-groups-owner-guid').bind('keyup', function(e){
                        if (e.which == 8 || e.which == 13) {
                $(this).parent().find('.self-groupmems-popup > .panel-body').html('<div class="elgg-ajax-loader"></div>');
                $('.self-groupmems-popup').addClass('hidden');
            } else {
                textarea = $(this);
                content = $(this).val();
                position = getCursorPosition(this);
                autocomplete_groupmem(content, position);
            }
        })
    };

    elgg.register_hook_handler('init', 'system', init_groupmem, 9999);