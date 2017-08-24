define(function(require) {
  var $ = require('jquery');

  $(document).on('click', '#pluginLoaderImportBtn', function() {
    if (confirm(elgg.echo('plugin_loader:import_confirm'))) {
      return true;
    }
    return false;
  });

  $(document).on('click', '#pluginLoaderExportBtn', function() {
    if (confirm(elgg.echo('plugin_loader:export_confirm'))) {
      return true;
    }
    return false;
  });

});
