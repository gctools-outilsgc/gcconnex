<?php


//Badge Progress tracker layout

/*
Pass it:

current badge img
title
desc
current count
goal



*/

$title = elgg_extract('title', $vars);
$description = elgg_extract('desc', $vars);
$goal = elgg_extract('goal', $vars);
$count = elgg_extract('count', $vars);
$badgeSrc = elgg_extract('src', $vars);
$level = elgg_extract('level', $vars);

?>


<div class="badgeProgressContainer panel panel-custom">
            <div style="padding: 5px;" class="panel-body">
            <div class="col-xs-2">
                <div class="mrgn-lft-sm mrgn-tp-md">
                    <?php 
                        echo elgg_view('output/img', array(
                            'src' => $badgeSrc,
                            'alt' => $title,
                            'class' => 'img-responsive',
                            'style' => 'width:150px;'
                        )); 
                    ?>
                </div>
            </div>
            
            <div class="col-xs-10">
                
                <div class="badgeInfo clearfix">
                    <div class="col-xs-9">
                        <h3 class="mrgn-tp-md"><?php echo $title; ?></h3>
                        <p><?php echo $description; ?></p>
                    </div>
                <div class="col-xs-3">
                    <h4 class="pull-right clearfix mrgn-tp-md">
                        <?php echo elgg_echo('badge:of', array($count, $goal)); ?>
                    </h4>
                </div>
                    
                </div>

            <div class="progressBar clearfix mrgn-tp-sm">

                <?php if($level != 'Completed'){ ?>


                <div class="pull-left">
                    <p class="mrgn-bttm-sm text-left">
                        <b class="mrgn-lft-sm">
                            <?php 
                                $current = $level - 1; 
                                if($current == '0'){ 
                                    echo elgg_echo('badge:start'); 
                                } else {
                                    echo elgg_echo('badge:level', array($current));
                                }
                                
                                ?>
                        </b>

                    </p>
                </div>

                <div class="pull-right">
                    <p class="mrgn-bttm-sm  text-right">
                        <b class="mrgn-rght-sm">
                            <?php echo elgg_echo('badge:level', array($level)); ?>
                        </b>

                    </p>
                </div>
                <div class="col-xs-12 bar">
                    <div class="progress  mrgn-bttm-sm mrgn-tp-sm">
                        <?php $percent = ($count/$goal)*100; //calculate percent for progress bar ?>
                        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $count; ?>"
                            aria-valuemin="0" aria-valuemax="<?php echo $goal; ?>" style="width:<?php echo $percent; ?>%">
                           
                            <span class="sr-only">
                                <?php echo $percent; ?>% Complete
                            </span>
                        </div>
                    </div>
                </div>
                <style>

                    .bar .progress-bar {
                        background-color:#047177;
                    }

                </style>
           
                
                
            </div>

        

            <?php

                  } else {
                      echo '<div class="alert alert-success">';
                      echo '<p>' . elgg_echo('badge:completed') . '</p>';
                      echo '</div></div>';
                  }?>


        </div>
        </div>
    </div>