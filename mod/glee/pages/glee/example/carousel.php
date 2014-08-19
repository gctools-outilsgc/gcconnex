<?php

$image_path = elgg_normalize_url('mod/glee_theme_draft_one/graphics/example/');

// view user as flip wall
$carousel_inner = <<<HTML
<div class="carousel-inner">
  <div class="active item">       
   <img alt="" src="{$image_path}2.jpg">
   <div class="carousel-caption">
    <h4>First Thumbnail label</h4>
    <p> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.  </p>
   </div>
  </div>
  <div class="item">
   <img alt="" src="{$image_path}3.jpg">
   <div class="carousel-caption">
    <h4>Second Thumbnail label</h4>
    <p> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.  </p>
   </div>
  </div>
  
  <div class="item">
   <img alt="" src="{$image_path}4.jpg">
   <div class="carousel-caption">
    <h4>Third Thumbnail label</h4>
    <p> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.  </p>
   </div>
  </div>
  
  <div class="item">
   <img alt="" src="{$image_path}5.jpg">
   <div class="carousel-caption">
    <h4>Fourth Thumbnail label</h4>
    <p> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.  </p>
   </div>
  </div>
  
  <div class="item">
   <img alt="" src="{$image_path}6.jpg">
   <div class="carousel-caption">
    <h4>5th Thumbnail label</h4>
    <p> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.  </p>
   </div>
  </div>
  
  <div class="item">
   <img alt="" src="{$image_path}8.jpg">
   <div class="carousel-caption">
    <h4>6th Thumbnail label</h4>
    <p> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.  </p>
   </div>
  </div>
  
</div>
HTML;


$carousel1 = <<<HTML
<div class="span4">     
    <div id="myCarousel" class="carousel">
     <!-- Carousel items -->
     <div class="carousel-inner">
     	$carousel_inner
     </div>
     <!-- Carousel nav -->
     <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
     <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div>
</div>
HTML;


$carousel2 = <<<HTML
<div class="span6">     
    <div id="myCarousel2" class="carousel">
     <!-- Carousel items -->
     <div class="carousel-inner">
$carousel_inner
     </div>
     <!-- Carousel nav -->
     <a class="carousel-control left" href="#myCarousel2" data-slide="prev">&lsaquo;</a>
     <a class="carousel-control right" href="#myCarousel2" data-slide="next">&rsaquo;</a>
    </div>
</div>
HTML;


$carousel3 = <<<HTML
<div class="span10">     
    <div id="myCarousel3" class="carousel">
     <!-- Carousel items -->
     <div class="carousel-inner">
$carousel_inner
     </div>
     <!-- Carousel nav -->
     <a class="carousel-control left" href="#myCarousel3" data-slide="prev">&lsaquo;</a>
     <a class="carousel-control right" href="#myCarousel3" data-slide="next">&rsaquo;</a>
    </div>
</div>
HTML;

$content = $carousel1 . $carousel2 . $carousel3;

// use one_column layout (without sidebar, without filter)
$body = elgg_view_layout('one_column', array(
	'filter' => '',
	'content' => $content,
	'title' => "Carousel example",
	'sidebar' => '',
));


// append javascript
$body .= <<<HTML
<script type="text/javascript">
	elgg.register_hook_handler('init', 'system', function() {
	    $('#myCarousel').carousel({
    		interval: 1000
    	});
	    $('#myCarousel2').carousel({
    		interval: 2000
    	});
	    $('#myCarousel3').carousel({
    		interval: 3000
    	});
	});
</script>
HTML;


// display the page
echo elgg_view_page("phloor bootstrap carousel example", $body);

