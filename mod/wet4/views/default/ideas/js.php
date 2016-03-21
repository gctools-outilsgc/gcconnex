
// JS for ideas plugin
elgg.provide('elgg.ideas');

elgg.ideas.init = function() {
    var timeout;

    $("#ideas-textarea").keypress(function(e) {
        if ( $(this).val().length > 140 && e.which != 8 || e.which == 13) return false;
        elgg.ideas.textCounter(this, $("#ideas-characters-remaining span"), 140);
        var search_input = $(this).val();
        var search_container = $('#ideas-search-response');

        if (search_input.length > 3) {
            if (timeout) {
                clearTimeout(timeout);
                timeout = null;
            }

            timeout = setTimeout(function() {
                search_input = $("#ideas-textarea").val();
                if (search_input.length > 3) { // @todo check why need to do it again ?
                    $.ajax({
                        type: "GET",
                        url: elgg.config.wwwroot + 'mod/ideas/views/default/ideas/search.php',
                        data: 'group=' + elgg.get_page_owner_guid() + '&keyword=' + $("#ideas-textarea").val() + '&point=' + $('#votesLeft strong').text(),
                        beforeSend:  function() {
                            $('#ideas-characters-remaining').addClass('loading');
                        },
                        success: function(response) {
                            clearTimeout(timeout);
                            $('.elgg-page .elgg-menu-filter-default, .ideas-list').hide();
                            if ( search_container.is(':hidden') ) {
                                search_container.css('opacity', 0).html(response).fadeTo('slow', 1);
                            } else {
                                search_container.html(response);
                            }
                            $('#ideas-characters-remaining').removeClass("loading");
                            rateButton();
                            $('body').click('click', function() {$('.ideas-vote-popup').fadeOut();});
                        }
                    });
                }
            }, 500);
        } else if ( $('.ideas-list').css('opacity') != '1' || $('.ideas-list').is(":hidden") ) {
            search_container.hide().html('');
            $('.elgg-page .elgg-menu-filter-default, .ideas-list').css('opacity', 0).fadeTo('slow', 1);
        }
    });

/*
 * if($userVote == 1) {
            $vote .= "<div class=''><a href='$url' data-value='1' data-idea='{$idea->guid}'><span class='fa fa-arrow-up fa-lg icon-sel'></span><span class='wb-inv'>Upvote this Idea</span></a></div>";
        } else {
            $vote .= "<div><a href='$url' data-value='1' data-idea='{$idea->guid}'><span class='fa fa-arrow-up fa-lg icon-unsel'></span><span class='wb-inv'>Upvote this Idea</span></a></div>";
        }

        if($userVote == -1) {
            $vote .= "<div><a href='$url' data-value='-1' data-idea='{$idea->guid}'><span class='fa fa-arrow-down fa-lg icon-sel'></span><span class='wb-inv'>Downvote this Idea</span></a></div>";
        } else {
            $vote .= "<div><a href='$url' data-value='-1' data-idea='{$idea->guid}'><span class='fa fa-arrow-down fa-lg icon-unsel'></span><span class='wb-inv'>Downvote this Idea</span></a></div>";
        }
 */
    var getRateButtons = function(vote,elem) {
        // toggle thumbsup/down buttons on vote
        if(vote == 1) {
            elem.find("i").removeClass().addClass("fa fa-arrow-up fa-lg icon-sel");
            elem.next().next().find("i").removeClass().addClass("fa fa-arrow-down fa-lg icon-unsel");
        } else {
            elem.find("i").removeClass().addClass("fa fa-arrow-down fa-lg icon-sel");
            elem.prev().prev().find("i").removeClass().addClass("fa fa-arrow-up fa-lg icon-unsel");
        }
        return;
    }
    
    $('.idea-vote-container a').live('click', function(e) {
        e.preventDefault();
        var clicked = $(this);
        // ds - don't know if this does anything 
        if ($.data(this, 'clicked') || $(this).hasClass('checked')) // Prevent double-click
            return false;
        else {
            // ds - don't know if this does anything
            $.data(this, 'clicked', true);
            
            var thisVote = this,
                thisButton = $(this);
                value = $(this).data('value'),  // +1 or -1 is stored in the data-value attribute on the thumbs up/dn links
                idea = $(this).data('idea'), // stored in the data-idea attribute on the thumbs up/dn links
                ideaURL = $('#elgg-object-' + idea + ' .idea-content h3 a').attr('href'),
                ideaTitle = $('#elgg-object-' + idea + ' .idea-content h3 a').html();
            
            if ( ideaTitle == null ) ideaTitle = $('.elgg-body h2').html();
            
            // replace current idea points with ajax loader
            var old_points = $('#elgg-object-' + idea + ' .ideaPoints').html();
            $('#elgg-object-' + idea + ' .ideaPoints').html('<div class="elgg-ajax-loader"></div>');
            
            // rateurl with tokens are in the href of the vote icon links in object/idea
            var rateurl = $(this).attr("href");
            elgg.action(rateurl, {
                data: {
                    idea: idea,
                    value: value,
                    page_owner: elgg.get_page_owner_guid()
                },
                success: function(json) {
                    // console.log(json);
                    if ( !json.output.errorRate ) {
                        
                        // get current users ideaVoteContainer and sidebar points
                        var ideaVoteContainer = $(this).parent(),
                            sidebarIdea = $('.sidebar-idea-list #elgg-object-' + idea);
                        
                        // set total points on idea points object
                        $('#elgg-object-' + idea + ' .ideaPoints').html(json.output.sum);
                        
                        // update points in sidebar
                        $('#elgg-object-' + idea + ' .sidebar-idea-points').html(json.output.sum);
                        
                        // set likes/dislikes
                        thisButton.closest(".idea-vote-container").find(".idea-likes").html(json.output.likes);
                        thisButton.closest(".idea-vote-container").find(".idea-dislikes").html(json.output.dislikes);
                        
                        // set current users rate buttons
                        ideaVoteContainer.html(getRateButtons(value,clicked));
                        
                        
                        
                        
                        // put the idea into the sidebar if it doesn't exist there already
                        /*
                        if ( !sidebarIdea.length ) {
                            $('.sidebar-idea-list').prepend(
                                $('<li>', {id: 'elgg-object-'+idea, 'class': 'elgg-item elgg-item-idea'}).append(
                                    $('<div>', {'class': 'mrs idea-value-'+value}).html(value),
                                    $('<h3>').append($('<a>', {href: ideaURL}).html(ideaTitle))
                                )
                            );
                        } else {
                            // set the sidebar idea points if it's already there
                            sidebarIdea.children('div').html(value)
                                .attr('class', function(){return $(this)[0].className.replace(/idea-value-.* \b/g, 'idea-value-'+value+' ')});
                        }
                        */
                    } else {
                        // revert to the old points if there's an error
                        $('#elgg-object-' + idea + ' .ideaPoints').html(old_points);
                    }
                    
                    // not sure 
                    $.data(thisVote, 'clicked', false);
                },
                error: function(e, err){
                    // console.log(e);
                    elgg.system_message(elgg.echo('ideas:idea:rate:error:ajax'));
                    $('#elgg-object-' + idea + ' .ideaPoints').html(old_points);
                }
            });
        }

    });

};
elgg.register_hook_handler('init', 'system', elgg.ideas.init);

/**
 * Update the number of characters left with every keystroke
 *
 * @param {Object}  textarea
 * @param {Object}  status
 * @param {integer} limit
 * @return void
 */
elgg.ideas.textCounter = function(textarea, status, limit) {

    var remaining_chars = limit - $(textarea).val().length;
    status.html(remaining_chars);

    if (remaining_chars < 0) {
        status.parent().css("color", "#D40D12");
    } else {
        status.parent().css("color", "");
    }
}


/**
 * Reposition the vote-popup
 */
elgg.ui.votePopup = function(hook, type, params, options) {
    if (params.target.attr('class') == 'elgg-module-popup ideas-vote-popup') {
        options.my = 'left center';
        options.at = 'right center';
        options.offset = '13 0';
        return options;
    }
    return options;
};
elgg.register_hook_handler('getOptions', 'ui.popup', elgg.ui.votePopup);

