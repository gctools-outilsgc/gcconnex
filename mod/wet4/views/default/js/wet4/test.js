/*
 * test.js
 *
 * Various javascript functionality. (Datatables, User menu message/notification dropdown preview)
 *
 * @package wet4
 * @author GCTools Team
 */
//For Datatables creation
//now you can just put 'wb-tables' on tables to render datatables
var dtpath = elgg.normalize_url() + '/mod/wet4/views/default/js/wet4/elgg_dataTables';

require.config({
    paths: {
        "jquery":    "//ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.0.min",
        "datatables": dtpath
    }
});

//testing only one-click button elgg-form-groups-edit
$("input[type=submit]").click(function () {

    $(this).click(function () {
      //After this was clicked do not submit again
        return false;
    });
    return true;
});


//User menu mouse over functions

$('.messagesLabel').hover(function(){

  $(this).find('.dropdown-menu').stop(true, true).delay(400).fadeIn(400, function(){ // Do the ajax call on mouseover
      var type = $(this).attr('id'); //the type is on the list id
      //Call the view
      var ajax_path = 'ajax/view/ajax/notif_dd';
      var params = {'type': type};
      elgg.get(ajax_path, {
        data:params,
        dataType:'html',
        success: function(data){
            $('#'+type).html(data);
        }
      });
  });

}, function(){
  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(200);
})

$('.messagesLabel').on('focusin', function(){
//When A user tabs to the the link in the user menu they can click the link or we show them a dd link to open up the messages dd.
  var dd_object = $(this).find('.dropdown-menu');

  $(this).find('.focus_dd_link').show(function()  {
    $(this).on('click', function(){ // Click = Enter
      $(dd_object).attr('aria-hidden', "false"); //Viewable to screen readers
      $(dd_object).stop(true, true).delay(400).fadeIn(400, function(){
          var type = $(this).attr('id');
          //Call the view
          var ajax_path = 'ajax/view/ajax/notif_dd';
          var params = {'type': type};
          elgg.get(ajax_path, {
            data:params,
            dataType:'html',
            success: function(data){
                //Change  the HTML of the dd
                $('#'+type).html(data);
            }
          });
      });
    })
  });
});

//Close the windows when focusin on other objects on the DOM
$('.dd-close').on('focusin', function(){
  $('.close-msg-dd .dropdown-menu').stop(true, true).delay(200).fadeOut(200);
  $('.close-notif-dd .dropdown-menu').stop(true, true).delay(200).fadeOut(200);
});
$('.close-msg-dd').on('focusin', function(){
  $('.close-notif-dd').find('.dropdown-menu').stop(true, true).delay(200).fadeOut(200);
})
$('.close-notif-dd').on('focusin', function(){
  $('.close-msg-dd').find('.dropdown-menu').stop(true, true).delay(200).fadeOut(200);
})
// { "dom": '<"top"ilf>' }
requirejs( ["datatables"], function() {
// $('.wb-tables').dataTable( { "dom": '<"top"ilf>' } );
} );
