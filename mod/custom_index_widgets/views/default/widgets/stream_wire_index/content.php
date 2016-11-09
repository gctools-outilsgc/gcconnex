<?php 


$all_link = elgg_view('output/url', array(
	'href' => 'thewire/all',
	'text' => elgg_echo('View The Wire') . $groupCount,
	'is_trusted' => true,
));
echo "<div class='text-right mrgn-tp-sm'>$all_link</div>";

?>
 



<div id='cyutest' class='cyutest' name='cyutest'>
	fdgfdgfd
</div>

<script>
$( document ).ready(function() {
    console.log( "ready!" );
    doAjaxLongpollingCall()
});
function doAjaxLongpollingCall(){

console.log("polling call");
   $.ajax({
   	type: "GET",
   	dataType: "json",
    url: elgg.config.wwwroot+"/services/api/rest/json/?method=get.wire",
     timeout: 300,
     success: function(data){
       //process your data
      
       document.getElementById("cyutest").innerHTML = "";
//document.getElementById("cyutest").innerHTML = JSON.stringify(data) ;
      
 document.getElementById("cyutest").innerHTML += "<ul class='list-unstyled elgg-list elgg-list-entity'> ";
$.each (data['result']['posts'], function (key, value) {
  console.log ("key: "+key+ " // value:"+value['text']);
  document.getElementById("cyutest").innerHTML += "<li class='elgg-item elgg-item-object list-break mrgn-tp-md clearfix noWrap elgg-item-object-thewire clearfix' id='elgg-object-123'>";
  document.getElementById("cyutest").innerHTML += "<div class='col-xs-12 mrgn-tp-sm clearfix mrgn-bttm-sm'> ";
  document.getElementById("cyutest").innerHTML += "<div class='mrgn-tp-sm col-xs-2 clearfix'><img src='"+value['user']['iconURL']+"' class='img-responsive img-circle' /></div>";
  document.getElementById("cyutest").innerHTML += "<div class='mrgn-tp-sm col-xs-10 noWrap'> "+ value['user']['username'] +" <div>";
  document.getElementById("cyutest").innerHTML += "<div> "+ value['text'] +" <div>";
  document.getElementById("cyutest").innerHTML += "</div> ";
  document.getElementById("cyutest").innerHTML += "</li>";
});

       document.getElementById("cyutest").innerHTML += "</ul>";

       console.log("success!!!!");
     },
     complete: function(){
     	console.log("completed!!!!");
       doAjaxLongpollingCall();
    
     }
   });
}

//while (true) {
    


</script>