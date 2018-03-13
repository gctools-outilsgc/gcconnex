<?php
$accessRequests = new ModPleio\AccessRequests();

$limit = (int) get_input("limit", 20);
$offset = (int) get_input("offset", 0);
$count = $accessRequests->count();
?>
<ul class="elgg-list">
    <?php foreach ($accessRequests->fetchAll($limit, $offset) as $entity): ?>
        <li id="<?php echo $accessRequest->id; ?>" class="elgg-item">
            <?php echo elgg_view("entity/access_request", ["entity" => $entity]); ?>
        </li>
    <?php endforeach; ?>
</ul>
<?php if ($count === 0): ?>
    <p><?php echo elgg_echo("pleio:no_requests"); ?></p>
<?php endif; ?>

<?php echo elgg_view("navigation/pagination", array(
    "limit" => $limit,
    "offset" => $offset,
    "count" => $accessRequests->count()
)); ?>
