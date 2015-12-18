<style>

    .panel-default{
    width:550px;
    margin-left:35px;
    
    }
    .size{
    width:550px;
        
    }



@media screen and (max-width: 1199px) {
 
     .panel-default{
    width:485px;
    margin-left:15px;
    
    }
    .size{
    width:400px;
    }   
       td{
            width:550px;
            }
    
}
    
    @media screen and (max-width: 992px) {
 
     .panel-default{
    width:400px;
    margin-left:10px;
    
    }
    .size{
    width:300px;
    }   
           td{
            width:350px;
            }
    
}
    
        @media screen and (max-width: 750px) {
 
     .panel-default{
    width:350px;
    margin-left:15px;
    
    }
            td{
            width:350px;
            }
    
}
    
            @media screen and (max-width: 699px) {
 
     .panel-default{
    width:270px;
    margin-left:15px;
    
    }
          .size{
    width:220px;
    }   
    
}
    
 @media screen and (max-width: 500px) {

       .panel-default{
    width:370px;
    margin-left:0px;
        margin-top:10px;
    
    }
     
     .size{
     width:375px;
     }
	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
        background-color:red;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		 width:390px;
		position: relative;
		padding-left: 5%; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
}
    
    @media screen and (max-width: 460px) {
 
     .panel-default{
    width:295px;
    margin-left:0px;
    
    }
          .size{
    width:220px;
    }   
    
    td{
    width:315px;
    }
    
}    

    
@media screen and (max-width: 360px) {
 
     .panel-default{
    width:290px;
    margin-left:0px;
    
    }
          .size{
    width:220px;
    }   
    
    td{
    width:280px;
    }
    
}    
    
@media screen and (max-width: 320px) {
 
     .panel-default{
    width:265px;
    margin-left:0px;
    
    }
          .size{
    width:220px;
    }   
    
    td{
    width:280px;
    }
    
}  
    
</style>
<?php
/**
 * Elgg one-column layout
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['content'] Content string
 * @uses $vars['class']   Additional class to apply to layout
 * @uses $vars['nav']     Optional override of the page nav (default: breadcrumbs)
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['header']  Optional override for the header
 * @uses $vars['footer']  Optional footer
 */



$class = 'elgg-layout elgg-layout-one-column clearfix';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

?>
<div class="<?php echo $class; ?>">
<div class="elgg-main" id="wb-cont">
	<?php

		//echo elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
echo $vars['title'];
		//echo elgg_view('page/layouts/elements/header', $vars);
echo '<table><tr><td>';

		echo $vars['content'];
echo '</td><td class="dif" style="padding-left:0;">';

        echo $vars['sidebar'];
echo '</td></tr></table>';

		
		// @deprecated 1.8
		if (isset($vars['area1'])) {
			echo $vars['area1'];
		}

		echo elgg_view('page/layouts/elements/footer', $vars);
	?>
<!--	</div>-->
<!--</div>-->