<?php
/**
 * Tasks languages
 *
 * @package ElggTasks
 */

$english = array(

	/**
	 * Menu items and titles
	 */

	'tasks' => "Tasks",
	'tasks:owner' => "%s's tasks",
	'tasks:friends' => "Friends' tasks",
	'tasks:all' => "All site tasks",
	'tasks:add' => "Add task",

	'tasks:group' => "Group tasks",
	'groups:enabletasks' => 'Enable group tasks',

	'tasks:edit' => "Edit this task",
	'tasks:delete' => "Delete this task",
	'tasks:history' => "History",
	'tasks:view' => "View task",
	'tasks:revision' => "Revision",

	'tasks:navigation' => "Navigation",
	'tasks:via' => "via tasks",
	'item:object:task_top' => 'Top-level tasks',
	'item:object:task' => 'Tasks',
	'tasks:nogroup' => 'This group does not have any tasks yet',
	'tasks:more' => 'More tasks',
	'tasks:none' => 'No tasks created yet',

	/**
	* River
	**/

	'river:create:object:task' => '%s created a task %s',
	'river:create:object:task_top' => '%s created a task %s',
	'river:update:object:task' => '%s updated a task %s',
	'river:update:object:task_top' => '%s updated a task %s',
	'river:comment:object:task' => '%s commented on a task titled %s',
	'river:comment:object:task_top' => '%s commented on a task titled %s',

	/**
	 * Form fields
	 */

	'tasks:title' => 'Task title',
	'tasks:description' => 'Task text',
	'tasks:tags' => 'Tags',
	'tasks:access_id' => 'Read access',
	'tasks:write_access_id' => 'Write access',
	'tasks:transfer:myself' => 'Myself',

	/**
	 * Status and error messages
	 */
	'tasks:noaccess' => 'No access to task',
	'tasks:cantedit' => 'You cannot edit this task',
	'tasks:saved' => 'Task saved',
	'tasks:notsaved' => 'Task could not be saved',
	'tasks:error:no_title' => 'You must specify a title for this task.',
	'tasks:delete:success' => 'The task was successfully deleted.',
	'tasks:delete:failure' => 'The task could not be deleted.',

	/**
	 * Task
	 */
	'tasks:strapline' => 'Last updated %s by %s',

	/**
	 * History
	 */
	'tasks:revision:subtitle' => 'Revision created %s by %s',

	/**
	 * Widget
	 **/

	'tasks:num' => 'Number of tasks to display',
	'tasks:widget:description' => "This is a list of your tasks.",

	/**
	 * Submenu items
	 */
	'tasks:label:view' => "View task",
	'tasks:label:edit' => "Edit task",
	'tasks:label:history' => "Task history",

	/**
	 * Sidebar items
	 */
	'tasks:sidebar:this' => "This task",
	'tasks:sidebar:children' => "Sub-tasks",
	'tasks:sidebar:parent' => "Parent",

	'tasks:newchild' => "Create a sub-task",
	'tasks:backtoparent' => "Back to '%s'",
	
	
	
	'tasks:start_date' => "Start",
	'tasks:end_date' => "End",
	'tasks:percent_done' => " Done",
	'tasks:work_remaining' => "Remain.",


	'tasks:task_type' => 'Type',
	'tasks:status' => 'Status',
	'tasks:assigned_to' => 'Worker',

	'tasks:task_type_'=>"",
	'tasks:task_type_0'=>"",
	'tasks:task_type_1'=>"Analyse",
	'tasks:task_type_2'=>"Specifications",
	'tasks:task_type_3'=>"Developement",
	'tasks:task_type_4'=>"Test",
	'tasks:task_type_5'=>"Mise en production",

	'tasks:task_status_'=>"",
	'tasks:task_status_0'=>"",
	'tasks:task_status_1'=>"Opened",
	'tasks:task_status_2'=>"Assigned",
	'tasks:task_status_3'=>"Charged",
	'tasks:task_status_4'=>"In progress",
	'tasks:task_status_5'=>"Closed",

	'tasks:task_percent_done_'=>"0%",
	'tasks:task_percent_done_0'=>"0%",
	'tasks:task_percent_done_1'=>"20%",
	'tasks:task_percent_done_2'=>"40%",
	'tasks:task_percent_done_3'=>"60%",
	'tasks:task_percent_done_4'=>"80%",
	'tasks:task_percent_done_5'=>"100%",

	'tasks:tasksboard'=>"TasksBoard",
	'tasks:tasksmanage'=>"Manage",
	'tasks:tasksmanageone'=>"Manage a task",
);

add_translation("en", $english);