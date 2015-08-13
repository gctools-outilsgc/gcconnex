<?php
// echo "<div>";
//echo elgg_echo("username");
//echo elgg_view("input/text", array("name" => "user", "value" => ''));
//echo "<div class='elgg-subtext'>" . elgg_echo("simplesaml:settings:simplesamlphp_path:description") . "</div>";
//echo "</div>";
//echo "</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>"
?>
<script>
  function myJsFunc(guid){
    //alert(guid);
    elgg.action('saml_link/setting', {
      data: {
        entityID : guid
      },
      success: function(json){
        // do something
      }
    });
  }

	function loadXMLDoc()
	{
		var word = document.getElementById("uname").value;
		window.location.href = "?username=" + word;
	//	elgg.action('my_blog/setting', {
   	//		data: {
      //			username: word
   		//	},
   		//	success: function(json) {
      	//		// do something
   		//	}
		//});

		//alert(word);
		/*var xmlhttp;
		if (window.XMLHttpRequest)
  		{// code for IE7+, Firefox, Chrome, Opera, Safari
  			xmlhttp=new XMLHttpRequest();
  		}
		else
  		{// code for IE6, IE5
  			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  		}
		xmlhttp.onreadystatechange=function()
  		{
  			if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
    			document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    		}
  		}
		xmlhttp.open("GET","ajax_info.txt",true);
		xmlhttp.send();*/
	}
</script>
<div>

  Username: <input type="text" name="uname" id="uname"><br>
  <button type="button" onclick="loadXMLDoc()">Search</button>

</div>
</br></br>
<?php
	$uname = elgg_echo(htmlspecialchars($_GET["username"]));
	//print_r(get_user_by_username($uname));
	$userObj = get_user_by_username($uname);
	
  if($userObj){ 
    echo elgg_echo("User: ".$uname);
	 $list = elgg_get_entities(array(
    	'type' => 'object',
    	'subtype' => 'gcpedia_account',
    	'owner_guid' => $userObj->getGuid()
			));
    echo elgg_echo("<table style='width:100%;'>");
    echo elgg_echo("<tr><th>Delete?</th><th>GUID</th><th>GCpedia Username</th><th>GCpedia Email</th></tr>");
    foreach ($list as $obj ){
      echo elgg_echo("<tr><td><a href='javascript:void(0)'onclick='myJsFunc(".$obj->guid.");'>Delete</a> </td><td>".$obj->guid."</td><td>".$obj->title."</td><td>".$obj->description."</td></tr>");
    }
    echo elgg_echo("</table>");
  }else{
    echo elgg_echo("No user: ".$uname);
  }
?>

</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>
save does not function on this page