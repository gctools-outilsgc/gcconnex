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
  var dd_type = $(this).find('a').attr('data-dd-type');
  $('#'+dd_type).stop(true, true).delay(400).fadeIn(400, function(){ // Do the ajax call on mouseover
      var type = $(this).attr('id');
      //Call the view
      var ajax_path = 'ajax/view/ajax/notif_dd';
      var params = {'type': type};
      elgg.get(ajax_path, {
        data:params,
        dataType:'html',
        success: function(data){
          //alert(data);
            $('#'+type).html(data);

        }
      });
      //If they mouse leave then close the dd
      $(this).on('mouseleave', function(){
        $(this).stop(true, true).delay(400).fadeOut(400);

      })
  });

} )

// { "dom": '<"top"ilf>' }
requirejs( ["datatables"], function() {
// $('.wb-tables').dataTable( { "dom": '<"top"ilf>' } );
} );
