<?php
/*
 * info.php
 *
 * Updates profile strength panel after each step.
 */
$user = elgg_get_logged_in_user_entity();

$noJava = elgg_extract('noJava', $vars);

if($noJava != 1){
?>



<script>
    $( document ).ready(function() {

        //grab percent in circle
        var value = $('text').text();

        //set from to int of percent
        var from = {property: parseInt(value.replace('%', ''))};

        //get target profile strength
        var to = {property:  <?php echo get_my_profile_strength_collab(); ?> };

        //animate the count
        $(from).animate(to, {
            duration: 1000,
            step: function() {
                var red = this.property;
                //add percent in cricle
                $('.timer').text(Math.round(this.property) + '%');

                //calculate % into degrees for circle
                var circlePercent = ((red) / 100) * 360;
                $('.circle').attr('stroke-dasharray', '' + circlePercent + ', 10000');

            }
        });
    });

</script>
<?php
}
    ?>
