elgg.provide('elgg.au_subgroups');

elgg.au_subgroups.init = function() {

    // Initialize global variable for ajax requests
    elgg.au_subgroups.ajax_request = false;

    // init groups search
    elgg.au_subgroups.search();

    // init groups selection
    elgg.au_subgroups.select();

};

elgg.au_subgroups.search = function() {
    $('.au-subgroups-search').live('keyup', function() {
        var query = $(this).val();
        var results = $('.au-subgroups-search-results');
        var subgroup_guid = elgg.page_owner.guid;

        if (query.length < 3) {
            return;
        }

        // cancel any existing ajax requests
        // there's a good chance one was initiated
        // for fast typers
        if (elgg.au_subgroups.ajax_request) {
            elgg.au_subgroups.ajax_request.abort();
        }

        results.addClass('au-subgroups-throbber');
        results.html('');

        // get the results
        elgg.au_subgroups.ajax_request = elgg.get('ajax/view/au_subgroups/search_results', {
            timeout: 120000, //2 min
            data: {
                q: query,
                subgroup_guid: subgroup_guid
            },
            success: function(result, success, xhr) { console.log(result);
                results.removeClass('au-subgroups-throbber');
                results.html(result);
            },
            error: function(result, response, xhr) {
                results.removeClass('au-subgroups-throbber');
                if (response == 'timeout') {
                    results.html(elgg.echo('au_subgroups:error:timeout'));
                }
                else {
                    results.html(elgg.echo('au_subgroups:error:generic'));
                }
            }
        });

    });
};


elgg.au_subgroups.select = function() {
    $('.au-subgroups-parentable, .au-subgroups-non-parentable').live('click', function(e) {
        e.preventDefault();

        if ($(this).hasClass('au-subgroups-non-parentable')) {
            elgg.register_error(elgg.echo('au_subgroups:error:permissions'));
            return;
        }

        var subgroup_guid = elgg.page_owner.guid;
        var action = $(this).attr('data-action') + '&subgroup_guid=' + subgroup_guid;

        if (confirm(elgg.echo('au_subgroups:move:confirm'))) {
            window.location.href = action;
        }
    });
};

elgg.register_hook_handler('init', 'system', elgg.au_subgroups.init);