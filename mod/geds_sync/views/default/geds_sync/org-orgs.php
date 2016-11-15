<?php
/*
* org-orgs.php
* This file creates the ajax view of the organizations section of the organizations tab
* view is called from the org-panel view. JSON string of org data is passed via post 
*
*/

//make sure view is ajax
if (elgg_is_xhr()) {
	//get JSON string from org-panel
	$treeString = get_input('orgTreeData');
	// transform JSON to php object
	$tree = json_decode($treeString);

	///////////////////////////////////////////////////////////////////////////////////////////////////
	// GEDS treats organizations above and below the selected org as seperate.
	// The selected org and above can be accessed as $tree->orgStructure->name
	// orgs contained within the selected org are accessed as $tree->desc.
	// in order to illustrate the difference in levels of orgs two loops must be done.
	/////////////////////////////////////////////////////////////////////
	$x = 0;
	//This loop builds the parents tree
	foreach($tree[0]->orgStructure as $org){ 
		?>
		<div style="padding-left:<?php echo 2*$x; ?>px;"><!-- Indents for each iteration -->
			<img  height='10px' width='10px' src='<?php echo elgg_get_site_url(); ?>/mod/geds_sync/vendors/musicplayer14.png' />
			<a href='javascript:void(0)' onclick='browseOrg("<?php echo $org->DN; ?>")'><?php echo $org->name; ?></a></br> <!-- creates the link -->
		</div>
		<?php
		$x+=5;
	}
	//this loop builds the children rett
	foreach($tree as $t){
		//print_r($t);
		?>
		<div style="padding-left:<?php echo 2*$x; ?>px;">
			<img  height='10px' width='10px' src='<?php echo elgg_get_site_url(); ?>/mod/geds_sync/vendors/rightarrow49.png' />
			<a href='javascript:void(0)' onclick='browseOrg("<?php echo $t->dn; ?>")'><?php echo $t->desc; ?></a></br ><!-- creates the link -->
		</div>
		<?php
	}
	
}