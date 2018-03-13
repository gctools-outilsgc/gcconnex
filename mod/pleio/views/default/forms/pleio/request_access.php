<div class="mtl">
    <?php echo elgg_view("profile_manager/register/fields"); ?>
</div>

<?php echo elgg_view("input/submit", [
    "name" => "submit",
    "value" => elgg_echo("pleio:request_access")
]); ?>