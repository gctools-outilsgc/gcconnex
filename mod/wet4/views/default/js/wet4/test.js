//For Datatables creation
//now you can just put 'wb-tables' on tables to render datatables
var dtpath = elgg.normalize_url() + '/mod/wet4/js/elgg_dataTables';

require.config({
    paths: {
        "jquery":    "//ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.0.min",
        "datatables": dtpath
    }
});

//testing only one-click button elgg-form-groups-edit
$("input[type=submit]").click(function () {

    $(this).click(function () {

        return false;
    });
    return true;
});


//User menu mouse over functions

$('.messagesLabel').hover(function(){
  //alert('you hovered me');
  $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(400);

}, function(){
  $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(400);

})

// { "dom": '<"top"ilf>' }
requirejs( ["datatables"], function() {
// $('.wb-tables').dataTable( { "dom": '<"top"ilf>' } );
} );
