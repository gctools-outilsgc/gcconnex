/**
* infinite_wire.js
* Adds Infinite Scrolling to The Wire
*
* @author Adrien Pyke (Hackathon 2017: Team NOP)
**/
(function() {
	'use strict';

	var SCRIPT_NAME = 'infinite_wire';
	var BASE_SITE = elgg.normalize_url();
	var WIRE_URL = BASE_SITE + 'thewire/all';
	var API = 'ajax/view/ajax/wire_posts';

	if (window.location.href === WIRE_URL) {
		var Util = {
			log: function() {
				var args = [].slice.call(arguments);
				args.unshift('%c' + SCRIPT_NAME + ':', 'font-weight: bold;color: #233c7b;');
				console.log.apply(console, args);
			},
			q: function(query, context) {
				return (context || document).querySelector(query);
			},
			qq: function(query, context) {
				return [].slice.call((context || document).querySelectorAll(query));
			}
		};

		var wireContent = Util.q('#wb-cont > ul.elgg-list');

		var extractId = function(elem) {
			var regex = /^elgg\-object\-(\d+)$/
			return parseInt(elem.id.match(regex)[1])
		}

		// Returns an array of the ids of all loaded posts
		var getCurrentPosts = function() {
			return Util.qq('.elgg-item-object-thewire', wireContent).map(function(elem) {
				return extractId(elem);
			});
		};

		var isLoading = false;
		window.addEventListener('scroll', function(e) {
			if (!isLoading) {
				// when we've scrolled past the bottom of the wire content load the stuff
				if (wireContent.getBoundingClientRect().bottom <= window.innerHeight) {
					isLoading = true;
					elgg.get(API, {
						data: {
							'limit': 15,
							'offset': getCurrentPosts().length
						},
						dataType: 'html',
						success: function (data) {
							var tempDiv = document.createElement('div');
							tempDiv.innerHTML = data;

							var currentPosts = getCurrentPosts();
							var oldestPost;
							if (currentPosts.length > 0) {
								oldestPost = Math.min.apply(null, currentPosts);
							}

							Util.qq('.elgg-item-object-thewire', tempDiv).filter(function(elem) {
								// Only include posts that are older than the oldest post
								if (oldestPost) {
									var id = extractId(elem);
									return id < oldestPost;
								}
								return true;
							}).forEach(function(elem) {
								wireContent.appendChild(elem);
							})

							isLoading = false;
						}
					});
				}
			}
		});
	}
})();