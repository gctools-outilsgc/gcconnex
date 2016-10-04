<?php

/**
 * This view is a card that will allow quick creation of discussion topics with groups. Similar to "How are you feeling" actions on social media
 *
 *
 *
 * @version 1.0
 * @author Nick
 */


$user = $vars['user'];
$group = $vars['group'];
$access_id = get_entity($group)->group_acl;
 ?>

 <div class="quick-start-discussion">
     <div id="quick-discuss-panel" class="panel panel-default clearfix quick-discuss">
         <div class="clearfix ">
         <div class="col-sm-2">
             <div class="mrgn-tp-md">
             <?php
             echo elgg_view_entity_icon(elgg_get_logged_in_user_entity(), 'medium', array('use_hover' => false, 'class' => ''));
             ?>
             </div>
         </div>

         <div class="col-sm-10">
                <div class="mrgn-tp-sm">
                    <a href="#quick-discuss-panel" class="quick-discuss-action-btn"><?php echo elgg_echo('discussion:add');?></a>
                </div>

                <div id="quick-discuss-form" class="start-discussion-form" tabindex="-1">
                <div>
                    <?php
                        //Nick - echo out the form to create a discussion here
                        //Pass the container_guid so it knows what group you want to add this discussion to
                    echo elgg_view_form('discussion/save', array('class'=>'quick-start-form-tabindex',), array(
                        'container_guid'=>$group,
                        'access_id'=>$access_id,
                        ));
                    ?>

                </div>
             </div>
         </div>

        </div>
        <div class="toggle-quick-discuss text-center quick-start-collapse">
            <i class="fa fa-caret-up fa-lg" aria-hidden="true"></i>

         </div>
     </div>

     <script>

         $('.quick-start-form-tabindex input').attr('tabindex', '-1');

         $('#title').on('focus', function () {
             $('.quick-start-collapse').show('slow', function () {
                 $('.quick-start-form-tabindex input').attr('tabindex', '0');
             });

         })

        $('#title2').on('focus', function () {
             $('.quick-start-collapse').show('slow', function () {
                 $('.quick-start-form-tabindex input').attr('tabindex', '0');
             });

         })
         $('.quick-discuss-action-btn').on('click', function () {
             $('.quick-start-collapse').show('slow', function () {
                 $('#title').focus();
                 $('#title2').focus();
                 $('.quick-start-form-tabindex input').attr('tabindex', '0');
             });
         });

         $('.toggle-quick-discuss').on('click', function () {
             $('.quick-start-collapse').hide('slow', function () {

             })
         })
     </script>
 </div>
