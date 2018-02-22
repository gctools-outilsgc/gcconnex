/**
 * stream_community.js
 *
 * Streaming Community JS - Listens on the community page for new community items. It then loads the new community items to the DOM
 *
 * @author Nick github.com/piet0024
 * @author Ilia github.com/phanoix
 * @author Mark github.com/markwooff
 **/

$(document).ready(function() {
	community_wire_stream_count();
});

// This function counts 2 minutes while a streaming page is loaded
var interval = null;

function community_wire_stream_count() {
	interval = window.setInterval(check_for_community_wire_items(), 10000);
}

// Stop the timer and add a call to action to the DOM
function stop_stream_community_wire_count() {
	window.clearInterval(interval);
	// Animate in a div button
	$('.new-community-wire-holder').prepend('<div class="stream-new-newsfeed" style="display:none;">' + elgg.echo('stream:new_newsfeed') + '</div>');
	$('.stream-new-newsfeed').show('slow');
	$('.stream-new-newsfeed').on('click', function() {
		load_new_community_wire_items();
	});
}

// Checking to see if there are any new community items
function check_for_community_wire_items() {
	//What are the posts currently loaded on the page?
	//Get the guid from the post id
	var firstPostOnPage = $('.community-wire-holder ul li').first().attr('id');

	if (firstPostOnPage) {
		var postID = firstPostOnPage.split("-");
		postID = postID.slice(2);

		// Ping the api to see what the latest community item. This will only grab one post
		elgg.get('ajax/view/ajax/community_wire', {
			data: {
				'url': window.location.pathname.replace('/', ''),
				'limit': 1
			},
			dataType: 'json',
			success: function(response) {
				//Get the latest post and compare that post to the post that is on the page.
				if (response == postID[0]) {
					//True - Keep looking for posts
					setTimeout(community_wire_stream_count, 10000);
				} else {
					//False - there is a new post. We can stop looking now.
					stop_stream_community_wire_count();
				}
			},
			error: function(request, status, error) {
				console.log('error');
			}
		});
	}
}

function load_new_community_wire_items() {
	// Spinner
	$('.stream-new-newsfeed').html('<i class="fa fa-refresh fa-spin fa-1g fa-fw"></i><span class="sr-only">Loading...</span>');

	// Get the guid from the post id
	var firstPostOnPage = $('.community-wire-holder ul li').first().attr('id');
    if (firstPostOnPage) {
		var postID = firstPostOnPage.split("-");
		postID = postID.slice(2);

		// Bring back the latests posts and add them to the page
		elgg.get('ajax/view/ajax/community_wire', {
			data: {
				'url': window.location.pathname.replace('/', ''),
				'latest': postID[0]
			},
			dataType: 'html',
			success: function(data) {
				$('.community-wire-holder ul').first().prepend($(data).html());
				$('.stream-new-newsfeed').remove();
				community_wire_stream_count();
			}
		});
	}
}
