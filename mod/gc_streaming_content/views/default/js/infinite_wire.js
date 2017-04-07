/**
* infinite_wire.js
* Adds Infinite Scrolling to The Wire
*
* @author Adrien Pyke (Hackathon 2017: Team NOP)
**/
(function() {
	'use strict';

	var SCRIPT_NAME = 'infinite_wire';
	var API = 'ajax/view/ajax/wire_posts';
	var PATHNAME = window.location.pathname;
	var ALL_REGEX = /^\/thewire\/all/;
	var FRIENDS_REGEX = /^\/thewire\/friends\/([^\/]+)/;
	var OWNER_REGEX = /^\/thewire\/owner\/([^\/]+)/;
	var SEARCH_REGEX = /^\/thewire\/search\/?([^\/]+)?/;
	var SCROLLING_BUFFER = 200;

	// If they're on one of the wire pages/^\/thewire\/search\/?(.+)?/
	if (PATHNAME.match(ALL_REGEX) ||
		PATHNAME.match(FRIENDS_REGEX) ||
		PATHNAME.match(OWNER_REGEX) ||
		PATHNAME.match(SEARCH_REGEX)) {
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
			},
			getQueryParameter: function(name, url) {
				if (!url) url = window.location.href;
				name = name.replace(/[\[\]]/g, "\\$&");
				var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
					results = regex.exec(url);
				if (!results) return null;
				if (!results[2]) return '';
				return decodeURIComponent(results[2].replace(/\+/g, " "));
			}
		};

		var Posts = {
			postsElement: Util.q('#wb-cont > ul.elgg-list'),
			// extracts the GUID from the id of the posts element
			extractId: function(elem) {
				var regex = /^elgg\-object\-(\d+)$/;
				return parseInt(elem.id.match(regex)[1]);
			},
			// Returns an array of the ids of all loaded posts
			getCurrent: function() {
				return Util.qq('.elgg-item-object-thewire', Posts.postsElement).map(function(elem) {
					return Posts.extractId(elem);
				});
			}
		};

		var runScript = true;

		var friendsOf;
		var username;
		var query;

		var match = PATHNAME.match(FRIENDS_REGEX);
		if (match) {
			friendsOf = match[1];
		}

		match = PATHNAME.match(OWNER_REGEX);
		if (match) {
			username = match[1];
		}

		match = PATHNAME.match(SEARCH_REGEX);
		if (match) {
			query = match[1];
			if (!query) {
				query = Util.getQueryParameter('q');
				if (!query) {
					runScript = false;
				}
			}
		}

		if (runScript) {
			var isLoading = false;
			window.addEventListener('scroll', function(e) {
				if (!isLoading) {
					// when we've scrolled past the bottom of the wire content load the stuff
					if (Posts.postsElement.getBoundingClientRect().bottom <= window.innerHeight + SCROLLING_BUFFER) {
						isLoading = true;

						var params = {
							'limit': 15,
							'offset': Posts.getCurrent().length
						};

						if (friendsOf) {
							params.friends = friendsOf;
						}

						if (username) {
							params.user = username;
						}

						if (query) {
							params.query = query;
						}

						elgg.get(API, {
							data: params,
							dataType: 'html',
							success: function (data) {
								var tempDiv = document.createElement('div');
								tempDiv.innerHTML = data;

								var currentPosts = Posts.getCurrent();
								var oldestPost;
								if (currentPosts.length > 0) {
									oldestPost = Math.min.apply(null, currentPosts);
								}

								var loadedAny = false;

								Util.qq('.elgg-item-object-thewire', tempDiv).filter(function(elem) {
									// Only include posts that are older than the oldest post
									if (oldestPost) {
										var id = Posts.extractId(elem);
										return id < oldestPost;
									}
									return true;
								}).forEach(function(elem) {
									loadedAny = true;
									Posts.postsElement.appendChild(elem);
								});

								if (loadedAny) {
									// if no new results, assume at end and stop loading
									isLoading = false;
								}
							}
						});
					}
				}
			});
		}
	}
})();