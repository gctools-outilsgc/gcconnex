<?php
elgg_register_event_handler('init', 'system', 'merge_users_init');

function merge_users_init() {

    elgg_register_action('users/merge', elgg_get_plugins_path() . "/merge_users/actions/users/merge.php");

    elgg_register_ajax_view("merge_users/display");

    elgg_register_admin_menu_item('administer', 'merge_users', 'users');

}

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
  system_message($filename.' '.$name);
  $nfh->setFilename($prefix . $name);

  $file->open("read");
  $nfh->open("write");

  $nfh->write($file->grabFile());

  // close file
  $file->close();
  $nfh->close();

  $nfh->save();
  //$file->delete();
}
