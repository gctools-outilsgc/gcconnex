<?php
/**
 * Reply page
 *
 */

elgg_extend_view('input/longtext', 'thewire_tools/ajax_popup');
elgg_extend_view('input/plaintext', 'thewire_tools/ajax_popup');

elgg_gatekeeper();

$post = get_entity(get_input('guid'));

$title = '<h1>' . elgg_echo('reply') . '</h1>';

//elgg_push_breadcrumb(elgg_echo('thewire'), 'thewire/all');
//elgg_push_breadcrumb($title);

$content = elgg_view('thewire/reply', array('post' => $post));
$form_vars = array('class' => 'thewire-form', 'id' => 'wireAjax');
$content .= elgg_view_form('thewire/add', $form_vars, array('post' => $post));
$content .= elgg_view('input/urlshortener');


$body = elgg_view_layout('one_column', array(
	'filter' => false,
	'content' => $content,
	'title' => $title,
));

echo $body;
//echo elgg_view_page($title, $body);

?>

<script>

    var getCursorPosition = function (el) {
        var pos = 0;

        if ('selectionStart' in el) {
            pos = el.selectionStart;
        } else if ('selection' in document) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', -el.value.length);
            pos = Sel.text.length - SelLength;
        }

        return pos;
    };

    var handleResponse = function (json) {
        var userOptions = '';
        $(json).each(function (key, user) {
            userOptions += '<li tabIndex="0" data-username="' + user.desc + '">' + user.icon + user.name + "</li>";
        });

        if (!userOptions) {
            $('#ajax-popup > .panel-body').html('<div class="elgg-ajax-loader"></div>');
            $('#ajax-popup').addClass('hidden');
            return;
        }

        $('#ajax-popup > .panel-body').html('<ul class="mentions-autocomplete list-unstyled mrgn-bttm-0">' + userOptions + "</ul>");
        $('.mentions-autocomplete .elgg-avatar a').attr('tabindex', '-1');
        $('#ajax-popup').removeClass('hidden');

        $('.mentions-autocomplete > li').bind('click', function (e) {
            e.preventDefault();

            var username = $(this).data('username');

            // Remove the partial @username string from the first part
            newBeforeMention = beforeMention.substring(0, position - current.length);

            // Add the complete @username string and the rest of the original
            // content after the first part
            var newContent = newBeforeMention + username + afterMention;

            // Set new content for the textarea
            if (mentionsEditor == 'ckeditor') {
                textarea.setData(newContent, function () {
                    this.checkDirty(); // true
                });

            } else if (mentionsEditor == 'tinymce') {
                tinyMCE.activeEditor.setContent(newContent);
            } else {
                $(textarea).val(newContent);
            }

            // Hide the autocomplete popup
            $('#ajax-popup').addClass('hidden');
        });


        //ability to tab and press enter on the list item

        $('.mentions-autocomplete > li').bind('keypress', function (e) {

            e.preventDefault();
            if (e.keyCode == 13) {
                var username = $(this).data('username');

                // Remove the partial @username string from the first part
                newBeforeMention = beforeMention.substring(0, position - current.length);

                // Add the complete @username string and the rest of the original
                // content after the first part
                var newContent = newBeforeMention + username + afterMention;

                // Set new content for the textarea
                if (mentionsEditor == 'ckeditor') {
                    textarea.setData(newContent, function () {
                        this.checkDirty(); // true
                        this.focus();
                    });

                } else if (mentionsEditor == 'tinymce') {
                    tinyMCE.activeEditor.setContent(newContent).focus();
                } else {
                    $(textarea).val(newContent).focus();
                }

                // Hide the autocomplete popup
                $('#ajax-popup').addClass('hidden');
            }
        });


    };

    var autocomplete = function (content, position) {
        beforeMention = content.substring(0, position);
        afterMention = content.substring(position);
        parts = beforeMention.split(' ');
        current = parts[parts.length - 1];

        precurrent = false;
        if (parts.length > 1) {
            precurrent = parts[parts.length - 2];
            if (!current.match(/@/)) {
                if (precurrent.match(/@/)) {
                    current = precurrent + ' ' + current;
                }
            }
        }

        if (current.match(/@/) && current.length > 1) {
            current = current.replace('@', '');
            $('#ajax-popup').removeClass('hidden');

            var options = { success: handleResponse };

            elgg.get(elgg.config.wwwroot + 'livesearch?q=' + current + '&match_on=users', options);
        } else {
            $('#ajax-popup > .elgg-body').html('<div class="elgg-ajax-loader"></div>');
            $('#ajax-popup').addClass('hidden');
        }
    };
    var autocomplete = function (content, position) {
        beforeMention = content.substring(0, position);
        afterMention = content.substring(position);
        parts = beforeMention.split(' ');
        current = parts[parts.length - 1];

        precurrent = false;
        if (parts.length > 1) {
            precurrent = parts[parts.length - 2];
            if (!current.match(/@/)) {
                if (precurrent.match(/@/)) {
                    current = precurrent + ' ' + current;
                }
            }
        }

        if (current.match(/@/) && current.length > 1) {
            current = current.replace('@', '');
            $('#ajax-popup').removeClass('hidden');

            var options = { success: handleResponse };

            elgg.get(elgg.config.wwwroot + 'livesearch?q=' + current + '&match_on=users', options);
        } else {
            $('#ajax-popup > .elgg-body').html('<div class="elgg-ajax-loader"></div>');
            $('#ajax-popup').addClass('hidden');
        }
    };

    var test = function () {
        $('textarea').bind('keyup', function (e) {

            // Hide on backspace and enter
            if (e.which == 8 || e.which == 13) {
                $('#ajax-popup > .elgg-body').html('<div class="elgg-ajax-loader"></div>');
                $('#ajax-popup').addClass('hidden');
            } else {
                textarea = $(this);
                content = $(this).val();
                position = getCursorPosition(this);
                mentionsEditor = 'textarea';

                autocomplete(content, position);
            }
        });

        setTimeout(function () {
            if (typeof tinyMCE !== 'undefined') {
                for (var i = 0; i < tinymce.editors.length; i++) {
                    tinymce.editors[i].onKeyUp.add(function (ed, e) {

                        mentionsEditor = 'tinymce';

                        // Hide on backspace and enter
                        if (e.keyCode == 8 || e.keyCode == 13) {
                            $('#ajax-popup > .elgg-body').html('<div class="elgg-ajax-loader"></div>');
                            $('#ajax-popup').addClass('hidden');
                        } else {
                            position = ed.selection.getRng(1).startOffset;
                            content = tinyMCE.activeEditor.getContent({ format: 'text' });

                            autocomplete(content, position);
                        }
                    });
                }
            }
        }, 500);
    };
    elgg.register_hook_handler('init', 'system', test, 9999);


</script>
