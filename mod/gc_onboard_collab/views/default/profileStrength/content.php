<?php
/*
 * content.php
 *
 * Creates profile strength panel on the right of the page.
 */

echo '<script src="'.elgg_get_site_url().'mod/GC_profileStrength/views/default/widgets/profile_completness/js/circliful.min.js"></script>';
echo '<link rel="stylesheet" href="'.elgg_get_site_url().'mod/GC_profileStrength/views/default/widgets/profile_completness/css/circliful.css">';

?>

<script>$(document).ready(function () {
    $('#complete').circliful({
        animation: 1,
        animationStep: 5,
        iconPosition: 'top',
        foregroundBorderWidth: 15,
        backgroundBorderWidth: 15,
        percent: <?php echo get_my_profile_strength_collab();?>,
        fontColor: '#46246A',
        textSize: 28,
        percentageTextSize: 40,
        foregroundColor: "#46246A",
        iconColor: '#46246A',
        targetColor: '#46246A',
    });
});</script>
