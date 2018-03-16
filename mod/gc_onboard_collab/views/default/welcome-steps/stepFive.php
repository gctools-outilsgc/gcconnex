<?php
/*
 * stepFour.php - Welcome
 *
 * Fifth step of welcome module. Gives information on Wire Posts.
 */
?>

<div class="panel-heading clearfix">
    <h2 class="pull-left"><?php echo elgg_echo('onboard:featureTitle');?></h2>
    <div class="pull-right">
        <?php echo elgg_view('page/elements/step_counter', array('current_step'=>6, 'total_steps'=>7));?>
    </div>
</div>
<div class="panel-body">
    <div class="additional-feature-holder clearfix">
        <div class="col-sm-6 feature-col">
            <div class="col-sm-12">
                <div class="feature-image">
                    <img src="<?php echo elgg_get_site_url() .'mod/gc_onboard/graphics/wire/w_1.jpg'; ?>" alt="<?php echo elgg_echo('onboard:wireImgAlt1');?>" />
                </div>
            </div>
            <div class="col-sm-12 mrgn-tp-md feature-desc">
                <?php echo elgg_echo('onboard:wire1'); ?>
            </div>
        </div>
        <div class="col-sm-6 feature-col">
            <p><?php echo elgg_echo('onboard:wire4'); ?></p>
            <?php echo elgg_view_form("thewire/add", array('class' => 'thewire-form', 'id' => 'wireAjax')); ?>
            <p class="mtm"><strong id="wire-success" hidden><?php echo elgg_echo('onboard:wire_success'); ?></strong></p>
        </div>
    </div>

    <div class="mrgn-bttm-md mrgn-tp-md pull-right">
        <?php
            echo elgg_view('input/submit', array(
                'value' => elgg_echo('next'),
                'id' => 'next'
            ));
        ?>
    </div>

    <script>
        //skip to next step
        $('#next').on('click', function () {
            $(this).html('<i class="fa fa-spinner fa-pulse fa-lg fa-fw"></i><span class="sr-only">Loading...</span>');
            elgg.get('ajax/view/welcome-steps/stepSix', {
                success: function (output) {
                    $('#welcome-step').html(output);
                    $('#welcome-step').focus();
                }
            });
        });

        //skip to next step
        $('form.elgg-form-thewire-add button[type=submit]').on('click', function (e) {
            e.preventDefault();
            var message = $(".thewire-textarea").val();

            if( message !== "" ){
                $(this).html('<i class="fa fa-spinner fa-pulse fa-lg fa-fw"></i><span class="sr-only">Posting...</span>');
                elgg.action('thewire/add', {
                    data: {
                        'body': message,
                    },
                    success: function(response) {
                        $('form.elgg-form-thewire-add').hide('slow');
                        $('#wire-success').show();
                    }
                });
            } else {
                $(".thewire-textarea").focus();
            }
        });
    </script>
</div>
