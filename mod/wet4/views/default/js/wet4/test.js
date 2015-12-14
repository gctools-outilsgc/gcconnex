//For Datatables creation
//now you can just put 'wb-tables' on tables to render datatables
require.config({
    paths: {
        "jquery":    "//ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.0.min",
        "datatables": "//datatables.net/download/build/nightly/jquery.dataTables.js?_=99823af74ba032ba950452c707888b11"
    }
});

// { "dom": '<"top"ilf>' }
requirejs( ["datatables"], function() {
  $('#dataTable').dataTable( { "dom": '<"top"ilf>' } );
} );