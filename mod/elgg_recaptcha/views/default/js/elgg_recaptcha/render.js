define(function(require) {
    var $ = require('jquery');
    var elgg = require('elgg');
    var url = 'https://www.google.com/recaptcha/api.js?render=explicit&onload=elgg_recaptcha_render&hl=' + elgg.get_language(); 
    require([url]);
    
    window.elgg_recaptcha_render = function() {
        // move recaptcha divs into position before loading the recaptcha js
        $('div.g-recaptcha[data-form]').each(function(index, item) {
            var selector = $(item).attr('data-form');
            $(item).removeAttr('data-form');
            var $submit = $('form' + selector + ' input[type="submit"]').filter(':last');
            var $elggfoot = $('form'+ selector + ' .elgg-foot').filter(':last');
            var $parent = $(item).parents('.g-recaptcha-wrapper').first();
    
            // stick in the .elgg-foot div if available
            // otherwise just above last submit
            if ($elggfoot.length) {
                $parent.prependTo($elggfoot);
            }
            else {
                $parent.insertBefore($submit);
            }
        });
        
        $('div.g-recaptcha').each(function(index, item) {
            if ($(this).hasClass('g-recaptcha-nojs')) {
                return;
            }
            
            grecaptcha.render(item, {
                sitekey: $(item).attr('data-sitekey'),
                theme: $(item).attr('data-theme'),
                size: $(item).attr('data-size'),
                type: $(item).attr('data-type')
            });
        });
    };
});
