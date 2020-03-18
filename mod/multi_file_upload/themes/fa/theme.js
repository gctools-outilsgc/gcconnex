/*!
 * bootstrap-fileinput v4.3.6
 * http://plugins.krajee.com/file-input
 *
 * Font Awesome icon theme configuration for bootstrap-fileinput. Requires font awesome assets to be loaded.
 *
 * Author: Kartik Visweswaran
 * Copyright: 2014 - 2016, Kartik Visweswaran, Krajee.com
 *
 * Licensed under the BSD 3-Clause
 * https://github.com/kartik-v/bootstrap-fileinput/blob/master/LICENSE.md
 */
(function ($) {
    "use strict";

    $.fn.fileinputThemes.fa = {
        fileActionSettings: {
            removeIcon: '<span class="fa fa-trash text-danger"></span>',
            uploadIcon: '<span class="fa fa-upload text-info"></span>',
            zoomIcon: '<span class="fa fa-search-plus"></span>',
            dragIcon: '<span class="fa fa-bars"></span>',
            indicatorNew: '<span class="fa fa-hand-o-down text-warning"></span>',
            indicatorSuccess: '<span class="fa fa-check-circle text-success"></span>',
            indicatorError: '<span class="fa fa-exclamation-circle text-danger"></span>',
            indicatorLoading: '<span class="fa fa-hand-o-up text-muted"></span>'
        },
        layoutTemplates: {
            fileIcon: '<span class="fa fa-file kv-caption-icon"></span> '
        },
        previewZoomButtonIcons: {
            prev: '<span class="fa fa-caret-left fa-lg"></span>',
            next: '<span class="fa fa-caret-right fa-lg"></span>',
            toggleheader: '<span class="fa fa-arrows-v"></span>',
            fullscreen: '<span class="fa fa-arrows-alt"></span>',
            borderless: '<span class="fa fa-external-link"></span>',
            close: '<span class="fa fa-remove"></span>'
        },
        previewFileIcon: '<span class="fa fa-file"></span>',
        browseIcon: '<span class="fa fa-folder-open"></span>',
        removeIcon: '<span class="fa fa-trash"></span>',
        cancelIcon: '<span class="fa fa-ban"></span>',
        uploadIcon: '<span class="fa fa-upload"></span>',
        msgValidationErrorIcon: '<span class="fa fa-exclamation-circle"></span> '
    };
})(window.jQuery);
