<?php
	
    $body = "";
    $title = "Carpool";
    
/* Write all of the GC Carpool code here */
    $content = "This will be all the content of the web page for GC Carpool";
    

 /* End all of the GC Carpool code here */

    $body = elgg_view_layout('one_sidebar', array(
				'content' => $content,
				'title' => $title,
				'sidebar' => elgg_view('Carpool/sidebar')
				)
    		);
	echo elgg_view_page($title, $body);

?>