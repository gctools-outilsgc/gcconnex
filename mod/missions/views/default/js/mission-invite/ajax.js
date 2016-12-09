/**
 * Enable asynchronous invitation to members found in search.
 *
 * Author: Luc Belliveau <luc.belliveau@nrc-cnrc.gc.ca>
 * Copyright (c) 2016 National Research Council Canada
 */
define(function(require) {
  var elgg = require("elgg");
  var $ = require("jquery");

  return function() {
    require(['jquery.form'], function(form) {
      $('.elgg-form-missions-mission-invite-selector').ajaxForm({
        dataType: 'json',
        success: function(response) {
          elgg.register_error(elgg.echo(response.system_messages.error))
          elgg.system_message(elgg.echo(response.system_messages.success));
        }
      });
    });
  };
});