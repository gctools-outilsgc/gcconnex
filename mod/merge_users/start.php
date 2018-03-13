<?php
elgg_register_event_handler('init', 'system', 'merge_users_init');

function merge_users_init() {

    elgg_register_action('users/merge', elgg_get_plugins_path() . "/merge_users/actions/users/merge.php");

    elgg_register_ajax_view("merge_users/display");

    elgg_register_admin_menu_item('administer', 'merge_users', 'users');

}

//we don't use this but it's good to have it
function transfer_file_to_new_user($object, $NU_guid, $OLD_guid) {

  $prefix = 'file/';

  $file = new FilePluginFile($object->guid);

  $nfh = new ElggFile();
  $nfh->owner_guid = $NU_guid;
  if($file->container_guid != $OLD_guid){
    $nfh->container_guid = $file->container_guid;
  } else {
    $nfh->container_guid = $NU_guid;
  }
  $nfh->subtype = 'file';
  $nfh->title = $file->title;
  $nfh->description = $file->description;
  $nfh->access_id = $file->access_id;
  $nfh->tags = $file->tags;

  $filename = $file->getFilenameOnFilestore();

  $name = end(explode('/', $filename));
  $nfh->setFilename($prefix . $name);

  $file->open("read");
  $nfh->open("write");

  $nfh->write($file->grabFile());

  if($file->simpletype == "image"){
    //lets create some thumbnails
    $thumb = new ElggFile();
  	$thumb->owner_guid = $nfh->owner_guid;

  	$sizes = [
  		'small' => [
  			'w' => 60,
  			'h' => 60,
  			'square' => true,
  			'metadata_name' => 'thumbnail',
  			'filename_prefix' => 'thumb',
  		],
  		'medium' => [
  			'w' => 153,
  			'h' => 153,
  			'square' => true,
  			'metadata_name' => 'smallthumb',
  			'filename_prefix' => 'smallthumb',
  		],
  		'large' => [
  			'w' => 600,
  			'h' => 600,
  			'square' => false,
  			'metadata_name' => 'largethumb',
  			'filename_prefix' => 'largethumb',
  		],
  	];

    foreach ($sizes as $size => $data) {
      $image_bytes = get_resized_image_from_existing_file($nfh->getFilenameOnFilestore(), $data['w'], $data['h'], $data['square']);
      $name = explode('.', $name);
      $filename2 = "{$prefix}{$data['filename_prefix']}{$name[0]}.jpg";
      $thumb->setFilename($filename2);
      $thumb->open("write");
      $thumb->write($image_bytes);
      $thumb->close();
      unset($image_bytes);

      $nfh->{$data['metadata_name']} = $filename2;
    }
  }

  // close file
  $file->close();
  $nfh->close();
}
