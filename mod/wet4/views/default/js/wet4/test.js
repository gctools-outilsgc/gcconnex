//For Datatables creation
//now you can just put 'wb-tables' on tables to render datatables
var dtpath = elgg.normalize_url() + '/mod/wet4/js/elgg_dataTables';

require.config({
    paths: {
        "jquery":    "//ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.0.min",
        "datatables": dtpath
    }
});

// { "dom": '<"top"ilf>' }
requirejs( ["datatables"], function() {
  //$('.wb-tables').dataTable( { "dom": '<"top"ilf>' } );
} );