<?php
elgg_load_library('c_ext_lib');

if( !empty($_POST['id']) && !empty($_POST['ext']) && !empty($_POST['dept']) ){
	echo editExtension($_POST['id'], $_POST['ext'], $_POST['dept']);
} else {
	echo false;
}
