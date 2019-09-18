<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */


// Nick - added additional opportunity types, removed the table, changed layout to match splash page opt in
/*
 * This view displays a form which allows the user to edit their opt-in choices.
 * This view is inside a section wrapper as described in wrapper.php.
 */
if (elgg_is_xhr()) {
	$user_guid = elgg_get_logged_in_user_guid();
	$user = get_user ( $user_guid );

	echo elgg_format_element('div',array('class'=> 'mrgn-bttm-sm mrgn-tp-sm alert alert-info'),elgg_echo('gcconnex_profile:optin:access'));
	
	$opt_in_set = array($user->opt_in_missions, $user->opt_in_swap, $user->opt_in_mentored, $user->opt_in_mentoring, $user->opt_in_shadowed, $user->opt_in_shadowing, $user->opt_in_jobshare, $user->opt_in_pcSeek, $user->opt_in_pcCreate, $user->opt_in_ssSeek, $user->opt_in_ssCreate, $user->opt_in_rotation, $user->opt_in_assignSeek, $user->opt_in_assignCreate, $user->opt_in_deploySeek, $user->opt_in_deployCreate, $user->opt_in_missionCreate, $user->opt_in_casual_seek, $user->opt_in_casual_create, $user->opt_in_student_seek, $user->opt_in_student_create, $user->opt_in_collaboration_seek, $user->opt_in_collaboration_create, $user->opt_in_interchange_seek, $user->opt_in_interchange_create);
    //Nick - Loop through array of selected things and change their value to match the meta data        
	foreach($opt_in_set as $k => $v){
		if($v == 'gcconnex_profile:opt:yes'){
			$opt_in_set[$k]  = true;
		}else{
			$opt_in_set[$k]  = false;   
		}
	}
} else {
	echo 'An error has occurred.';
}

//Nick - modifying the edit form to account for additional opportunity types
?>

<div class="clearfix brdr-bttm mrgn-bttm-sm mm-optin-holder gcconnex-profile-opt-in-options-table mtm">
    <div class="col-sm-6">
        <h3 class="h4 mrgn-tp-0"><?php echo elgg_echo('gcconnex_profile:opt:career'); ?></h3>
        <ul class="list-unstyled">
            <li class="clearfix">
                <?php echo elgg_echo('missions:casual'); ?>
                <ul class="brdr-lft clearfix mrgn-lft-md list-unstyled">
                	<li class="clearfix pull-left mrgn-lft-md">
		                <?php
		                	echo elgg_view("input/checkbox", array(
						        'name' => 'casualseek_check',
						        'checked' => $opt_in_set[17],
						        'id' => 'gcconnex-opt-in-casualseek-check',
			                    'label' => elgg_echo('gcconnex_profile:opt:seeking') 
			               	));
		                ?>
                	</li>
	                <li class="clearfix pull-left mrgn-lft-md">
		                <?php
		                	echo elgg_view("input/checkbox", array(
						        'name' => 'casualcreate_check',
						        'checked' => $opt_in_set[18],
						        'id' => 'gcconnex-opt-in-casualcreate-check',
			                    'label' => elgg_echo('gcconnex_profile:opt:offering')
			            	));
		                ?>
                	</li>
                </ul>
            </li>
            <li class="clearfix">
                <?php echo elgg_echo('missions:student'); ?>
                <ul class="brdr-lft clearfix mrgn-lft-md list-unstyled">
                	<li class="clearfix pull-left mrgn-lft-md">
		                <?php
		                	echo elgg_view("input/checkbox", array(
						        'name' => 'studentseek_check',
						        'checked' => $opt_in_set[19],
						        'id' => 'gcconnex-opt-in-studentseek-check',
			                    'label' => elgg_echo('gcconnex_profile:opt:seeking') 
			               	));
		                ?>
                	</li>
	                <li class="clearfix pull-left mrgn-lft-md">
		                <?php
		                	echo elgg_view("input/checkbox", array(
						        'name' => 'studentcreate_check',
						        'checked' => $opt_in_set[20],
						        'id' => 'gcconnex-opt-in-studentcreate-check',
			                    'label' => elgg_echo('gcconnex_profile:opt:offering')
			            	));
		                ?>
                	</li>
                </ul>
            </li>
            <li class="clearfix">
                <?php echo elgg_echo('missions:interchange'); ?>
                <ul class="brdr-lft clearfix mrgn-lft-md list-unstyled">
                	<li class="clearfix pull-left mrgn-lft-md">
		                <?php
		                	echo elgg_view("input/checkbox", array(
						        'name' => 'interchangeseek_check',
						        'checked' => $opt_in_set[23],
						        'id' => 'gcconnex-opt-in-interchangeseek-check',
			                    'label' => elgg_echo('gcconnex_profile:opt:seeking') 
			               	));
		                ?>
                	</li>
	                <li class="clearfix pull-left mrgn-lft-md">
		                <?php
		                	echo elgg_view("input/checkbox", array(
						        'name' => 'interchangecreate_check',
						        'checked' => $opt_in_set[24],
						        'id' => 'gcconnex-opt-in-interchangecreate-check',
			                    'label' => elgg_echo('gcconnex_profile:opt:offering')
			            	));
		                ?>
                	</li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="col-sm-6">
        <h3 class="h4 mrgn-tp-0"><?php echo elgg_echo('gcconnex_profile:opt:development'); ?></h3>
        <ul class="list-unstyled">
            
            <li class="clearfix">
                <?php echo elgg_echo('missions:mentoring');?>
                
                <ul class="clearfix brdr-lft mrgn-lft-md list-unstyled">
	                <li class="clearfix pull-left mrgn-lft-md">
		                <?php
							echo elgg_view("input/checkbox", array(
								'name' => 'mentored_check',
								'checked' => $opt_in_set[2],
								'id' => 'gcconnex-opt-in-mentored-check',
								'label' => elgg_echo('gcconnex_profile:opt:mentored'),
							));
		                ?>
		            </li>

		            <li class="clearfix pull-left mrgn-lft-md">
		                <?php
							echo elgg_view("input/checkbox", array(
								'name' => 'mentoring_check',
								'checked' => $opt_in_set[3],
								'id' => 'gcconnex-opt-in-mentoring-check',
								'label' => elgg_echo('gcconnex_profile:opt:mentoring'),
							));
		                ?>
		            </li>
                </ul>
            </li>

            <li class="clearfix">
                <?php echo elgg_echo('missions:collaboration');?>
                
                <ul class="clearfix brdr-lft mrgn-lft-md list-unstyled">
	                <li class="clearfix pull-left mrgn-lft-md">
		                <?php
							echo elgg_view("input/checkbox", array(
								'name' => 'collaborationseek_check',
								'checked' => $opt_in_set[21],
								'id' => 'gcconnex-opt-in-collaborationseek-check',
								'label' => elgg_echo('gcconnex_profile:opt:seeking'),
							));
		                ?>
		            </li>

		            <li class="clearfix pull-left mrgn-lft-md">
		                <?php
							echo elgg_view("input/checkbox", array(
								'name' => 'collaborationcreate_check',
								'checked' => $opt_in_set[22],
								'id' => 'gcconnex-opt-in-collaborationcreate-check',
								'label' => elgg_echo('gcconnex_profile:opt:offering'),
							));
		                ?>
		            </li>
                </ul>
            </li>

            <li class="clearfix">
                <?php echo elgg_echo( 'missions:skill_share' ); ?>
                <ul class="brdr-lft clearfix mrgn-lft-md list-unstyled">
	                <li class="clearfix pull-left mrgn-lft-md">
	                <?php
						echo elgg_view("input/checkbox", array(
							'name' => 'skillseeker_check',
							'checked' => $opt_in_set[9],
							'id' => 'gcconnex-opt-in-skillseeker-check',
							'class' => 'pull-left',
							'label' => elgg_echo('gcconnex_profile:opt:participants')
						));
	                ?>
	                </li>
	            
		            <li class="clearfix pull-left mrgn-lft-md">
		                <?php
							echo elgg_view("input/checkbox", array(
								'name' => 'skillcreator_check',
								'checked' => $opt_in_set[10],
								'id' => 'gcconnex-opt-in-skillcreator-check',
								'class' => 'pull-left',
								'label' => elgg_echo('gcconnex_profile:opt:host')
							));
		                ?>
		            </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
