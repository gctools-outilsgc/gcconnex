<?php
/*
*
*/
//community list
$community_array = array(
    'atip'=> elgg_echo('gctags:community:atip'),
    'communications'=> elgg_echo('gctags:community:communications'),
    'evaluators'=> elgg_echo('gctags:community:evaluators'),
    'financial'=> elgg_echo('gctags:community:financial'),
    'hr'=> elgg_echo('gctags:community:hr'),
    'im'=> elgg_echo('gctags:community:im'),
    'it'=> elgg_echo('gctags:community:it'),
    'auditors'=> elgg_echo('gctags:community:auditors'),
    'matmanagement'=> elgg_echo('gctags:community:matmanagement'),
    'policy'=> elgg_echo('gctags:community:policy'),
    'procurement'=> elgg_echo('gctags:community:procurement'),
    'realproperty'=> elgg_echo('gctags:community:realproperty'),
    'regulators'=> elgg_echo('gctags:community:regulators'),
    'security'=> elgg_echo('gctags:community:security'),
    'service'=> elgg_echo('gctags:community:service'),
    'science'=> elgg_echo('gctags:community:science'),
    'allps' => elgg_echo('gctags:community:allps'),
);

foreach($community_array as $key => $value){
    $com_help_header = elgg_format_element('h3', array('class'=>'h4'),$value);
    $com_help_body = elgg_format_element('p',array(),elgg_echo('gctags:help:info:'.$key));
    $community_help_list .= elgg_format_element('li',array(),$com_help_header . $com_help_body);
}


?>

<div>
    <p>
        <?php echo elgg_echo('gctags:help:help1');?>
    </p>

    <div>
        <h2 class="h4">
        <?php echo elgg_echo('gctags:help:contentmenu'); ?>
        </h2>
        <ul>
            <li>
                Look what you've done!
            </li>
        </ul>
    </div>

    <div>
        <h2>
        <?php echo elgg_echo('gctags:help:community'); ?>
        </h2>
        <div>
            <ul class="list-unstyled">
                <?php echo $community_help_list; ?>
            </ul>
        </div>
    </div>

    <div>
        <h2>
        <?php echo elgg_echo('gctags:help:tags'); ?>
        </h2>
    </div>
</div>