require.config({
    paths: {
        "jquery":    "//ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.0.min",
        "datatables": "//datatables.net/download/build/nightly/jquery.dataTables.js?_=99823af74ba032ba950452c707888b11"
    }
});


requirejs( ["datatables"], function() {
  $('#dataTable').dataTable();
} );