<?php
global $CONFIG;
?>
<table class="elgg-table-alt">
    <tbody>
        <tr class="odd">
            <td><?php echo elgg_echo("pleio_template:type"); ?></td>
            <td><?php echo $CONFIG->env; ?></td>
        </tr>
        <tr class="odd">
            <td><?php echo elgg_echo("pleio_template:send_mail"); ?></td>
            <td><?php echo $CONFIG->block_mail ? elgg_echo("option:no") : elgg_echo("option:yes"); ?></td>
        </tr>
    </tbody>
</table>