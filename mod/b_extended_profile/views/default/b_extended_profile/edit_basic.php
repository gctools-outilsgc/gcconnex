<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Since you can't call an ajax view on a form, the ajax view is called on this file, and within it we load the following form...
 */

echo elgg_view_form('b_extended_profile/edit_profile', array('target' => '_parent'));
