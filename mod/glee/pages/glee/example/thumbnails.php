<?php


$image_path = elgg_normalize_url('mod/glee_theme_draft_one/graphics/example/');

// view user as flip wall
$thumbnails = <<<HTML
<ul class="thumbnails">
    <li class="span4">
      <a class="thumbnail phloor-image-lightbox" href="http://placehold.it/360x268">
        <img alt="" src="http://placehold.it/360x268">
      </a>
    </li>
    <li class="span2">
      <a class="thumbnail phloor-image-lightbox" href="http://placehold.it/160x120">
        <img alt="" src="http://placehold.it/160x120">
      </a>
    </li>
    <li class="span2">
      <a class="thumbnail phloor-image-lightbox" href="http://placehold.it/160x120">
        <img alt="" src="http://placehold.it/160x120">
      </a>
    </li>
    <li class="span2">
      <a class="thumbnail phloor-image-lightbox" href="http://placehold.it/160x120">
        <img alt="" src="http://placehold.it/160x120">
      </a>
    </li>
    <li class="span2">
      <a class="thumbnail phloor-image-lightbox" href="http://placehold.it/160x120">
        <img alt="" src="http://placehold.it/160x120">
      </a>
    </li>
    <li class="span2">
      <a class="thumbnail phloor-image-lightbox" href="http://placehold.it/160x120">
        <img alt="" src="http://placehold.it/160x120">
      </a>
    </li>
    <li class="span2">
      <a class="thumbnail phloor-image-lightbox" href="http://placehold.it/160x120">
        <img alt="" src="http://placehold.it/160x120">
      </a>
    </li>
</ul>
HTML;


$thumbnails2 = <<<HTML
<ul class="thumbnails">
<li class="span3">
<div class="thumbnail">
	<a class="thumbnail phloor-image-lightbox" href="http://placehold.it/360x268">
        <img alt="" src="http://placehold.it/360x268">
      </a>
    <div class="caption">
      <h5>Thumbnail label</h5>
      <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
      <p><a class="btn btn-primary" href="#">Action</a> <a class="btn" href="#">Action</a></p>
    </div>
</div>
</li>

<li class="span3">
<div class="thumbnail">
	<a class="thumbnail phloor-image-lightbox" href="http://placehold.it/360x268">
        <img alt="" src="http://placehold.it/360x268">
      </a>
    <div class="caption">
      <h5>Thumbnail label</h5>
      <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
      <p><a class="btn btn-primary" href="#">Action</a> <a class="btn" href="#">Action</a></p>
    </div>
</div>
</li>

<li class="span3">
<div class="thumbnail">
	<a class="thumbnail phloor-image-lightbox" href="http://placehold.it/360x268">
        <img alt="" src="http://placehold.it/360x268">
    </a>
    <div class="caption">
      <h5>Thumbnail label</h5>
      <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
      <p><a class="btn btn-primary" href="#">Action</a> <a class="btn" href="#">Action</a></p>
    </div>
</div>
</li>
HTML;


$content = $thumbnails . $thumbnails2;

// use one_column layout (without sidebar, without filter)
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => "Thumbnails example",
	'sidebar' => '',
));


// display the page
echo elgg_view_page("phloor bootstrap thumbnails example", $body);

