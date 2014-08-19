<?php

// view user as flip wall
$content = <<<HTML
  <!-- Main hero unit for a primary marketing message or call to action -->
  <div class="hero-unit">
    <h1>Hello, world!</h1>
    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
    <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
  </div>

  <!-- Example row of columns -->
  <div class="row">
    <div class="span3">
      <h2>Heading</h2>
      <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. </p>
      <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
    <div class="span3">
      <h2>Heading</h2>
      <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
      <p><a class="btn" href="#">View details &raquo;</a></p>
   </div>
    <div class="span3">
      <h2>Heading</h2>
      <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. </p>
      <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
  </div>
HTML;

// use one_column layout (without sidebar, without filter)
$body = elgg_view_layout('one_column', array(
	'filter' => '',
	'content' => $content,
	'title' => false,
	'sidebar' => '',
));

// display the page
echo elgg_view_page("phloor title example 0", $body);
