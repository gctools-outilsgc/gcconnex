<?php
/*
 * message.php
 *
 * Reads session variable after using multi_file_upload(drag and drop) to display system messages, then unsets them.
 *
 * @package multi_file_upload
 * @author Ethan Wallace
 */
if(isset($_SESSION['multi_file_upload_success'])){
	system_message($_SESSION['multi_file_upload_success']);
	unset($_SESSION['multi_file_upload_success']);
}
if(isset($_SESSION['multi_file_upload_fail'])){
	register_error($_SESSION['multi_file_upload_fail']);
	unset($_SESSION['multi_file_upload_fail']);
}
 ?>
