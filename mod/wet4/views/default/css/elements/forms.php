<?php
/**
 * CSS form/input elements
 *
 * @package Elgg.Core
 * @subpackage UI
 */
?>
/* <style> /**/

/* ***************************************
	Form Elements
*************************************** */



[data-toggle="buttons"] > .btn input[type="radio"], [data-toggle="buttons"] > .btn input[type="checkbox"], [data-toggle="buttons"] > .btn-group > .btn input[type="radio"], [data-toggle="buttons"] > .btn-group > .btn input[type="checkbox"] {
  position: absolute;
  clip: rect(0, 0, 0, 0);
  pointer-events: none; }

.input-group {
  position: relative;
  display: table;
  border-collapse: separate; }
  .input-group[class*="col-"] {
    float: none;
    padding-left: 0;
    padding-right: 0; }
  .input-group .form-control {
    position: relative;
    z-index: 2;
    float: left;
    width: 100%;
    margin-bottom: 0; }

.input-group-addon, .input-group-btn, .input-group .form-control {
  display: table-cell; }
  .input-group-addon:not(:first-child):not(:last-child), .input-group-btn:not(:first-child):not(:last-child), .input-group .form-control:not(:first-child):not(:last-child) {
    border-radius: 0; }

.input-group-addon, .input-group-btn {
  width: 1%;
  white-space: nowrap;
  vertical-align: middle; }

.input-group-addon {
  padding: 6px 12px;
  font-size: 16px;
  font-weight: normal;
  line-height: 1;
  color: #555555;
  text-align: center;
  background-color: #eeeeee;
  border: 1px solid #ccc;
  border-radius: 4px; }
  .input-group-addon.input-sm, .input-group-sm > .input-group-addon.form-control, .input-group-sm > .input-group-addon, .input-group-sm > .input-group-btn > .input-group-addon.btn {
    padding: 5px 10px;
    font-size: 14px;
    border-radius: 3px; }
  .input-group-addon.input-lg, .input-group-lg > .input-group-addon.form-control, .input-group-lg > .input-group-addon, .input-group-lg > .input-group-btn > .input-group-addon.btn {
    padding: 10px 16px;
    font-size: 18px;
    border-radius: 6px; }
  .input-group-addon input[type="radio"], .input-group-addon input[type="checkbox"] {
    margin-top: 0; }

.input-group .form-control:first-child, .input-group-addon:first-child, .input-group-btn:first-child > .btn, .input-group-btn:first-child > .btn-group > .btn, .input-group-btn:first-child > .dropdown-toggle, .input-group-btn:last-child > .btn:not(:last-child):not(.dropdown-toggle), .input-group-btn:last-child > .btn-group:not(:last-child) > .btn {
  border-bottom-right-radius: 0;
  border-top-right-radius: 0; }

.input-group-addon:first-child {
  border-right: 0; }

.input-group .form-control:last-child, .input-group-addon:last-child, .input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group > .btn, .input-group-btn:last-child > .dropdown-toggle, .input-group-btn:first-child > .btn:not(:first-child), .input-group-btn:first-child > .btn-group:not(:first-child) > .btn {
  border-bottom-left-radius: 0;
  border-top-left-radius: 0; }

.input-group-addon:last-child {
  border-left: 0; }

.input-group-btn {
  position: relative;
  font-size: 0;
  white-space: nowrap; }
  .input-group-btn > .btn {
    position: relative; }
    .input-group-btn > .btn + .btn {
      margin-left: -1px; }
    .input-group-btn > .btn:hover, .input-group-btn > .btn:focus, .input-group-btn > .btn:active {
      z-index: 2; }
  .input-group-btn:first-child > .btn, .input-group-btn:first-child > .btn-group {
    margin-right: -1px; }
  .input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
    margin-left: -1px; }



  

  /***************

      Dont know how much of this is useful
      Taken from group suggestions

    ****************  */
     .text-unstyled {
        text-decoration:none !important;
        color: #333333;
    }

     .text-unstyled span {
        text-decoration:underline;
        color:#055959;
    }

     .text-unstyled:hover {
        text-decoration:none !important;
        color: #333333;
    }

     .text-unstyled:visited {
        text-decoration:none !important;
        color: #333333;
    }






/* ***************************************
	Form Elements
*************************************** */


input[type=file], input[type=text] {

	border: 1px solid #BDC7D8;
	padding: .5em;
	width: 100%;

	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}







/* ***************************************
	AUTOCOMPLETE
*************************************** */

<?php //autocomplete will expand to fullscreen without max-width ?>


.elgg-autocomplete-item .elgg-body {
	max-width: 800px;
    width: 100%;
}
.ui-autocomplete {
    width: 770px;
	background-color: white;
	border: 1px solid #ddd !important;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.09);
	padding-bottom: 5px;
}
.ui-autocomplete .ui-menu-item {
	padding: 0px 4px;
    width: auto;
}

.ui-menu-item a {
    width: 100%;
}
.ui-autocomplete .ui-menu-item:hover {
	background-color: #eee;
}
.ui-autocomplete a:hover {
	text-decoration: none;
	color: #4690D6;
}
.ui-autocomplete a.ui-state-hover {
	background-color: #eee;
	display: block;
}


/* ***************************************
	USER PICKER
*************************************** */

.user-picker .user-picker-entry {
	clear:both;
	height:25px;
	padding:5px;
	margin-top:5px;
	border-bottom:1px solid #cccccc;
}
.user-picker-entry .elgg-button-delete {
	margin-right:10px;
}
