<?php
/*
* Help Page for finding out what communities and tags are. Links to this page are found in the tagging modal (the [?] links)
*
* @author Nick github.com/piet0024
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
//format some lists for the communities
foreach($community_array as $key => $value){
    $com_help_header = elgg_format_element('h4', array('class'=>'h4', 'id'=>'com-type-'.$key,),$value);
    $com_help_body = elgg_format_element('p',array(),elgg_echo('gctags:help:info:'.$key));
    $community_help_list .= elgg_format_element('li',array(),$com_help_header . $com_help_body);
    $com_menu_link = elgg_view('output/url',array(
        'text' => $value,
        'href' => '#com-type-'.$key,
    ));
    $community_menu_links .= elgg_format_element('li',array(),$com_menu_link);
    
}

?>

<div>
    <p>
        <?php echo elgg_echo('gctags:help:intro');?>
    </p>

    <div>
        <h2 class="h4">
        <?php echo elgg_echo('gctags:help:contentmenu'); ?>
        </h2>
        <ul>
            <li>
                <a href="#what-are-communities"><?php echo elgg_echo('gctags:help:community'); ?></a>
                <ul>
                    <li>
                       <a href="#community-types"><?php echo elgg_echo('gctags:help:communitytypes'); ?> </a>
                        <ul>
                            <?php echo $community_menu_links;?>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#what-are-tags"><?php echo elgg_echo('gctags:help:tags'); ?></a>
            </li>
        </ul>
    </div>

    <div>
        <h2 id="what-are-communities">
        <?php echo elgg_echo('gctags:help:community'); ?>
        </h2>
        <div>
            <?php echo elgg_echo('gctags:help:info:community'); ?>
        </div>
        <h3 id="community-types">
           <?php echo elgg_echo('gctags:help:communitytypes'); ?> 
        </h3>
        <div>
            <ul class="list-unstyled">
                <?php echo $community_help_list; ?>
            </ul>
        </div>
    </div>

    <div>
        <h2 id="what-are-tags">
        <?php echo elgg_echo('gctags:help:tags'); ?>
        </h2>
        <div>
            <?php echo elgg_echo('gctags:help:info:tags'); ?>
        </div>
    </div>
</div>