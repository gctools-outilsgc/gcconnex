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
            <div class="panel-body">
            <div class="col-xs-3">
                <div class="mrgn-lft-sm mrgn-tp-md">
                    <?php 
                        echo elgg_view('output/img', array(
                            'src' => $badgeSrc,
                            'alt' => $title,
                            'class' => 'img-responsive'
                        )); 
                    ?>
                </div>
            </div>
            
            <div class="col-xs-9">
                
                <div class="badgeInfo clearfix">
                    <div class="col-xs-11">
                        <h3 class="mrgn-tp-md"><?php echo $title; ?></h3>
                        <p><?php echo $description; ?></p>
                    </div>
                    
                    <div class="col-xs-1">
                        <h4 class="pull-right clearfix"><?php echo $count; ?>/<?php echo $goal; ?></h4>
                    </div>
                </div>
                
                <div class="progressBar clearfix">
                    
                    <?php if($level != 'Completed'){ ?>
                    
                    
                    <p><b>Level <?php echo $level; ?></b></p>
                    
                    <div class="progress">
                        <?php $percent = ($count/$goal)*100; //calculate percent for progress bar ?>
                      <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $count; ?>"
                      aria-valuemin="0" aria-valuemax="<?php echo $goal; ?>" style="width:<?php echo $percent; ?>%">
                        <span class="sr-only"><?php echo $percent; ?>% Complete</span>
                      </div>
                    </div>
                    
                    <?php 
                    
                    } else {
                        echo '<div class="alert alert-success">';  
                        echo '<p>' . $level . '</p>';
                        echo '</div>';
                    }?>
                    
                    
                </div>
                
            </div>
        </div>
    </div>