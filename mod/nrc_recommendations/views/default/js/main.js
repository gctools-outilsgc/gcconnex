/*
 * Recommendations interface library
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2018
 */

define(function(require) {
  var elgg = require("elgg");
  var $ = require('jquery');
  var React = require('react');
  var ReactDOM = require('react-dom');
  var Refimpl = require('refimpl');

  var createUserObj = function createUserObj(user) {
    return {
      gcconnex_guid: user.guid,
      gcconnex_username: user.username
    };
  };

  elgg.register_hook_handler('init', 'system', function initialize() {

    // Detect Login
    var welcome_alert = $('span[role="alert"]>p:contains("Welcome  to GCconnex")');
    if (welcome_alert.length > 0) {
      console.log('%c **** LOGIN DETECTED ****', 'font-size: 3em');
      var user = elgg.get_logged_in_user_entity();
      console.log('%c GUID: ' + user.guid, 'font-size: 1.5em');
      var container = $('<div />');
      welcome_alert.parent().append(container);

      var ref = React.createElement(
        Refimpl, { user: createUserObj(user), context: 'login' }
      );
      ReactDOM.render(ref, container[0]);

    }

    // Detect discussion page
    var re = /.*?discussion\/view\/(.*?)($|\/)/;
    var m = document.location.href.match(re);
    if (m) {
      var panel_text = $('h2.panel-title:contains("Discussion")');
      if (panel_text.length > 0) {
        console.log('%c **** DISCUSSION PAGE DETECTED ****', 'font-size: 3em');
        var guid = m[1];
        console.log('%c GUID: ' + guid, 'font-size: 1.5em');
        var user = elgg.get_logged_in_user_entity();
        var container = $('<div />');
        container.css('margin-top', '30px');
        panel_text.parent().parent().parent().append(container);
        var ref = React.createElement(
          Refimpl, {
            user: createUserObj(user),
            context: 'article_c5',
            context_obj1: guid
          }
        );
        ReactDOM.render(ref, container[0]);
      }
    }
  });
});