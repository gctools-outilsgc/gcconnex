<?php 
$entity = $vars["entity"];
?>
<ul class="elgg-menu elgg-menu-annotation elgg-menu-hz float-alt elgg-menu-annotation-default">
    <li><?php echo elgg_view("output/url", [
        "href" => "/action/admin/pleio/process_access?result=approve&id={$entity->id}",
        "text" => elgg_echo("pleio:approve"),
        "is_action" => true
    ]); ?></li>
    <li><?php echo elgg_view("output/url", [
        "href" => "/action/admin/pleio/process_access?result=decline&id={$entity->id}",
        "text" => elgg_echo("pleio:decline"),
        "is_action" => true
    ]); ?></li>
</ul>