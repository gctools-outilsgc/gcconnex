<?php
/**
 * River attachment view for files
 */
$lang = get_current_language();
$object = $vars['item']->getObjectEntity();
$thumbnail = elgg_view_entity_icon($object);

$mime = $object->getMimeType();

if($mime == 'image/jpeg' || $mime == 'image/png'){
  $image_url = $object->getIconURL('large');
  $image_url = elgg_format_url($image_url);
  //$download_url = elgg_get_download_url($object);
  echo <<<HTML
  <div class="d-flex justify-content-center">
    <a href="$download_url" class="elgg-lightbox-photo"><img class="elgg-photo img-responsive" src="$image_url" /></a>
  </div>
HTML;
}else{
  $download_url = '/file/download/' .$object->guid;
  $title = elgg_format_element('a', ['href' => $object->getURL(), 'class' => 'river-file-title'], gc_explode_translation($object->title,$lang));
  $download_link = elgg_format_element('a', ['href' => $download_url], 'Download');
  $body = elgg_format_element('div', [], '<div class="mb-1">' . $title . '</div>' . '<div>' . $download_link . '</div>');
  $holder = elgg_format_element('div' , [
    'class' => 'p-3 d-flex border rounded elgg-river-file-attachment',
  ], $thumbnail . $body);
  
  echo elgg_format_element('div', [], $holder);
}