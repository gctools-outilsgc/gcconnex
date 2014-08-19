<?php
/**
 * Group Operators languages
 *
 * @package ElggGroupOperators
 */

$english = array(

	/**
	 * Titles
	 */
	"group_operators:title" => 'Operators of %s',
	"group_operators:manage" => 'Manage group operators',
	"group_operators:operators" => 'Operators',
	"group_operators:members" => 'Members',
	
	/**
	 * Menus
	 */
	"group_operators:operators:drop" => 'Drop privileges',
	"group_operators:owner" => 'Is the owner',
	"group_operators:owner:make" => 'Make owner',
	
	/**
	 * Form fields
	 */
	"group_operators:new" => 'Add another operator',
	"group_operators:new:button" => 'Make operator',
	"group_operators:selectone" => 'select one...',
	
	/**
	 * System messages
	 */
	"group_operators:added" => '%s successfully added as group operator',
	"group_operatros:add:error" => 'It was impossible to add %s as group operator',
	"group_operators:owner_changed" => '%s is the new owner',
	"group_operators:change_owner:error" => 'Only the group owner can assign a new owner',
	"group_operators:removed" => 'Operator successfully removed',

);

add_translation("en", $english);
