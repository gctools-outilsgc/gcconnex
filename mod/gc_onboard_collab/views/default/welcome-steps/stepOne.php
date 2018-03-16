<?php
/*
 * stepOne.php - Welcome
 *
 * First step asks for user's basic information or gives them an option to sync with GCdirectory
 */

$user = elgg_get_logged_in_user_entity();
?>

<div class="panel-heading clearfix">
    <h2 class="pull-left">
        <?php echo elgg_echo('onboard:welcome:one:title'); ?>
    </h2>
    <div class="pull-right">
        <?php echo elgg_view('page/elements/step_counter', array('current_step'=>2, 'total_steps'=>7));?>

    </div>
</div>


<div class="panel-body">
    <p class="mrgn-lft-sm mrgn-bttm-sm">
        <?php echo elgg_echo('onboard:welcome:one:description'); ?>
    </p>
    <div class="clearfix" id="onboard-table">
        <div class="col-sm-12 clearfix">
            <!-- User Types -->
            <div class="form-group">
                <label for="user_type" class="required">
                    <span class="field-name"><?php echo elgg_echo('gcRegister:occupation'); ?></span>
                    <strong class="required">(<?php echo elgg_echo('gcRegister:required'); ?>)</strong>
                </label>
                <?php
                    echo elgg_view('input/select', array(
                        'name' => 'user_type',
                        'id' => 'user_type',
                        'class' => 'form-control',
                        'value' => $user->user_type,
                        'aria-required' => 'true',
                        'required' => true,
                        'options_values' => array(
                            'academic' => elgg_echo('gcRegister:occupation:academic'),
                            'student' => elgg_echo('gcRegister:occupation:student'),
                            'federal' => elgg_echo('gcRegister:occupation:federal'),
                            'provincial' => elgg_echo('gcRegister:occupation:provincial'),
                            'municipal' => elgg_echo('gcRegister:occupation:municipal'),
                            'international' => elgg_echo('gcRegister:occupation:international'),
                            'ngo' => elgg_echo('gcRegister:occupation:ngo'),
                            'community' => elgg_echo('gcRegister:occupation:community'),
                            'business' => elgg_echo('gcRegister:occupation:business'),
                            'media' => elgg_echo('gcRegister:occupation:media'),
                            'retired' => elgg_echo('gcRegister:occupation:retired'),
                            'other' => elgg_echo('gcRegister:occupation:other')
                        )
                    ));
                ?>
            </div>

            <!-- Organizations -->
                <!-- University/College/High School -->
                <div class="form-group occupation-choices" id="institution-wrapper">
                    <label for="institution" class="required">
                        <span class="field-name"><?php echo elgg_echo('Institution'); ?></span>
                    </label>
                    <?php
                        echo elgg_view('input/select', array(
                            'name' => 'institution',
                            'id' => 'institution',
                            'class' => 'form-control',
                            'value' => $user->institution,
                            'options_values' => array(
                                'default_invalid_value' => elgg_echo('gcRegister:make_selection'),
                                'university' => elgg_echo('gcRegister:university'),
                                'college' => elgg_echo('gcRegister:college'),
                                'highschool' => elgg_echo('gcRegister:highschool')
                            )
                        ));
                    ?>
                </div>

                <!-- Universities -->
                <?php
                    $uniObj = elgg_get_entities(array(
                        'type' => 'object',
                        'subtype' => 'universities',
                    ));
                    $unis = get_entity($uniObj[0]->guid);

                    $universities = array();
                    if (get_current_language() == 'en') {
                        $universities = json_decode($unis->universities_en, true);
                    } else {
                        $universities = json_decode($unis->universities_fr, true);
                    }
                    asort($universities);

                ?>

                <div class="form-group occupation-choices student-choices" id="university-wrapper" hidden>
                    <label for="university" class="required">
                        <span class="field-name"><?php echo elgg_echo('gcRegister:university'); ?></span>
                    </label>
                    <?php
                        echo elgg_view('input/select', array(
                            'name' => 'university',
                            'id' => 'university',
                            'class' => 'form-control',
                            'value' => $user->university,
                            // default to invalid value, so it encourages users to select
                            'options_values' => array_merge(
                                array(
                                    'default_invalid_value' => elgg_echo('gcRegister:make_selection')
                                ),
                                $universities
                            ),
                        ));
                    ?>
                </div>

                <!-- Colleges -->
                <?php
                    $colObj = elgg_get_entities(array(
                        'type' => 'object',
                        'subtype' => 'colleges',
                    ));
                    $cols = get_entity($colObj[0]->guid);

                    $colleges = array();
                    if (get_current_language() == 'en') {
                        $colleges = json_decode($cols->colleges_en, true);
                    } else {
                        $colleges = json_decode($cols->colleges_fr, true);
                    }
                    asort($colleges);
                ?>

                <div class="form-group occupation-choices student-choices" id="college-wrapper" hidden>
                    <label for="college" class="required">
                        <span class="field-name"><?php echo elgg_echo('gcRegister:college'); ?></span>
                    </label>
                    <?php
                        echo elgg_view('input/select', array(
                            'name' => 'college',
                            'id' => 'college',
                            'class' => 'form-control',
                            'value' => $user->college,
                            // default to invalid value, so it encourages users to select
                            'options_values' => array_merge(
                                array(
                                    'default_invalid_value' => elgg_echo('gcRegister:make_selection')
                                ),
                                $colleges
                            ),
                        ));
                    ?>
                </div>

                <!-- High Schools -->
                <div class="form-group occupation-choices student-choices" id="highschool-wrapper" hidden>
                    <label for="highschool" class="required">
                        <span class="field-name"><?php echo elgg_echo('gcRegister:highschool'); ?></span>
                    </label>
                    <?php
                        echo elgg_view('input/text', array(
                            'name' => 'highschool',
                            'id' => 'highschool',
                            'class' => 'form-control',
                            'value' => $user->highschool,
                        ));
                    ?>
                </div>

                <!-- Federal Government -->
                <?php
                    $deptObj = elgg_get_entities(array(
                        'type' => 'object',
                        'subtype' => 'federal_departments',
                    ));
                    $depts = get_entity($deptObj[0]->guid);

                    $federal_departments = array();
                    if (get_current_language() == 'en') {
                        $federal_departments = json_decode($depts->federal_departments_en, true);
                    } else {
                        $federal_departments = json_decode($depts->federal_departments_fr, true);
                    }
                    asort($federal_departments);
                ?>

                <div class="form-group occupation-choices" id="federal-wrapper" hidden>
                    <label for="federal" class="required">
                        <span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span>
                    </label>
                    <?php
                        echo elgg_view('input/select', array(
                            'name' => 'federal',
                            'id' => 'federal',
                            'class' => 'form-control',
                            'value' => $user->federal,
                            // default to invalid value, so it encourages users to select
                            'options_values' => array_merge(
                                array(
                                    'default_invalid_value' => elgg_echo('gcRegister:make_selection')
                                ), $federal_departments
                            ),
                        ));
                    ?>
                </div>

                <!-- Provincial/Territorial Government -->
                <?php
                    $provObj = elgg_get_entities(array(
                        'type' => 'object',
                        'subtype' => 'provinces',
                    ));
                    $provs = get_entity($provObj[0]->guid);

                    $provincial_departments = array();
                    if (get_current_language() == 'en') {
                        $provincial_departments = json_decode($provs->provinces_en, true);
                    } else {
                        $provincial_departments = json_decode($provs->provinces_fr, true);
                    }
                    asort($provincial_departments);
                ?>

                <div class="form-group occupation-choices" id="provincial-wrapper" hidden>
                    <label for="provincial" class="required">
                        <span class="field-name"><?php echo elgg_echo('gcRegister:province'); ?></span>
                    </label>
                    <?php
                        echo elgg_view('input/select', array(
                            'name' => 'provincial',
                            'id' => 'provincial',
                            'class' => 'form-control',
                            'value' => $user->provincial,
                            'options_values' => array_merge(
                                array(
                                    'default_invalid_value' => elgg_echo('gcRegister:make_selection')
                                ),
                                    $provincial_departments
                                )
                            )
                        );
                    ?>
                </div>

                <?php
                    $minObj = elgg_get_entities(array(
                        'type' => 'object',
                        'subtype' => 'ministries',
                    ));
                    $mins = get_entity($minObj[0]->guid);

                    $ministries = array();
                    if (get_current_language() == 'en') {
                        $ministries = json_decode($mins->ministries_en, true);
                    } else {
                        $ministries = json_decode($mins->ministries_fr, true);
                    }
                    asort($ministries);

                    if (!empty($provincial_departments)) {
                        foreach ($provincial_departments as $province => $province_name) {
                            asort($ministries[$province]);

                            $prov_id = str_replace(" ", "-", strtolower($province));
                            echo '<div class="form-group occupation-choices provincial-choices" id="' . $prov_id . '-wrapper" hidden><label for="' . $prov_id . '" class="required"><span class="field-name">' . elgg_echo('gcRegister:ministry') . '</span></label>';
                            echo elgg_view('input/select', array(
                                'name' => 'ministry',
                                'id' => $prov_id,
                                'class' => 'form-control',
                                'value' => $user->ministry,
                                'options_values' => array_merge(array('default_invalid_value' => elgg_echo('gcRegister:make_selection')), $ministries[$province]),
                            ));
                            echo '</div>';
                        }
                    }
                ?>

                <!-- Municipal Government -->
                <?php
                    $munObj = elgg_get_entities(array(
                        'type' => 'object',
                        'subtype' => 'municipal',
                    ));
                    $municipals = get_entity($munObj[0]->guid);

                    $municipal_choices = elgg_view('input/text', array(
                        'name' => 'municipal',
                        'id' => 'municipal',
                        'class' => 'form-control',
                        'value' => $user->municipal,
                        'list' => ''
                    ));
                ?>

                <div class="form-group occupation-choices" id="municipal-wrapper" hidden>
                    <label for="municipal" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:city'); ?></span></label>
                    <?php echo $municipal_choices; ?>
                    <?php
                        if( !empty($provincial_departments) ){
                            foreach($provincial_departments as $province => $province_name){
                                $municipal = json_decode($municipals->get($province), true);
                                $prov_id = str_replace(" ", "-", strtolower($province));

                                echo '<datalist id="municipal-'.$prov_id.'-list">';
                                        if( !empty($municipal) ){
                                            asort($municipal);
                                            
                                            foreach($municipal as $municipal_name => $value){
                                                echo '<option value="' . $municipal_name . '">' . $value . '</option>';
                                            }
                                        }
                                echo '</datalist>';
                            }
                        }
                    ?>
                </div>

                <!-- International/Foreign Government -->
                <div class="form-group occupation-choices" id="international-wrapper" hidden>
                    <label for="international" class="required">
                        <span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span>
                    </label>
                    <?php
                        echo elgg_view('input/text', array(
                            'name' => 'international',
                            'id' => 'international',
                            'class' => 'form-control',
                            'value' => $user->international,
                        ));
                    ?>
                </div>

                <!-- Non-Governmental Organization -->
                <div class="form-group occupation-choices" id="ngo-wrapper" hidden>
                    <label for="ngo" class="required">
                        <span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span>
                    </label>
                    <?php
                        echo elgg_view('input/text', array(
                            'name' => 'ngo',
                            'id' => 'ngo',
                            'class' => 'form-control',
                            'value' => $user->ngo,
                        ));
                    ?>
                </div>

                <!-- Community/Non-profit -->
                <div class="form-group occupation-choices" id="community-wrapper" hidden>
                    <label for="community" class="required">
                        <span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span>
                    </label>
                    <?php
                        echo elgg_view('input/text', array(
                            'name' => 'community',
                            'id' => 'community',
                            'class' => 'form-control',
                            'value' => $user->community,
                        ));
                    ?>
                </div>

                <!-- Business -->
                <div class="form-group occupation-choices" id="business-wrapper" hidden>
                    <label for="business" class="required">
                        <span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span>
                    </label>
                    <?php
                        echo elgg_view('input/text', array(
                            'name' => 'business',
                            'id' => 'business',
                            'class' => 'form-control',
                            'value' => $user->business,
                        ));
                    ?>
                </div>

                <!-- Media -->
                <div class="form-group occupation-choices" id="media-wrapper" hidden>
                    <label for="media" class="required">
                        <span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span>
                    </label>
                    <?php
                        echo elgg_view('input/text', array(
                            'name' => 'media',
                            'id' => 'media',
                            'class' => 'form-control',
                            'value' => $user->media,
                        ));
                    ?>
                </div>

                <!-- Retired Public Servant -->
                <div class="form-group occupation-choices" id="retired-wrapper" hidden>
                    <label for="retired" class="required">
                        <span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span>
                    </label>
                    <?php
                        echo elgg_view('input/text', array(
                            'name' => 'retired',
                            'id' => 'retired',
                            'class' => 'form-control',
                            'list' => 'retired-list',
                            'value' => $user->retired,
                        ));
                    ?>
                    <datalist id="retired-list">
                        <?php
                            if (!empty($federal_departments)) {
                                foreach ($federal_departments as $federal_name => $value) {
                                    echo '<option value="' . $value . '"></option>';
                                }
                            }
                        ?>
                    </datalist>
                </div>

                <!-- Other -->
                <div class="form-group occupation-choices" id="other-wrapper" hidden>
                    <label for="other" class="required">
                        <span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span>
                    </label>
                    <?php
                        echo elgg_view('input/text', array(
                            'name' => 'other',
                            'id' => 'other',
                            'class' => 'form-control',
                            'list' => 'other-list',
                            'value' => $user->other,
                        ));
                    ?>
                    <datalist id="other-list">
                        <?php
                            $otherObj = elgg_get_entities(array(
                                'type' => 'object',
                                'subtype' => 'other',
                            ));
                            $others = get_entity($otherObj[0]->guid);

                            $other = array();
                            if (get_current_language() == 'en') {
                                $other = json_decode($others->other_en, true);
                            } else {
                                $other = json_decode($others->other_fr, true);
                            }
                            asort($other);

                            if (!empty($other)) {
                                foreach ($other as $other_name => $value) {
                                    echo '<option value="' . $other_name . '">' . $value . '</option>';
                                }
                            }
                        ?>
                    </datalist>
                </div>

                <div id="organization_notice" class="alert alert-info mrgn-bttm-md" hidden><?php echo elgg_echo('gcRegister:organization_notice'); ?></div>
            <!-- End Organizations -->
        </div>
    </div>

    <div id="stepOneButtons" class="mrgn-bttm-md mrgn-tp-md pull-right">
        <a id="save" class="btn btn-primary" href="#"><?php echo elgg_echo('save'); ?></a>
    </div>
</div>


<script>
$(document).ready(function () {

    var user_type = $("#user_type").val();
    $('.occupation-choices').hide();
    if (user_type == 'federal') {
        $('#federal-wrapper').fadeIn();
    } else if (user_type == 'academic' || user_type == 'student') {
        $('#institution-wrapper').fadeIn();
        var institution = $('#institution').val();
        $('#' + institution + '-wrapper').fadeIn();
    } else if (user_type == 'provincial') {
        $('#provincial-wrapper').fadeIn();
        var province = $('#provincial').val();
        province = province.replace(/\s+/g, '-').toLowerCase();
        $('#' + province + '-wrapper').fadeIn();
    } else if (user_type == 'municipal') {
        $('#provincial-wrapper').fadeIn();
        var province = $('#provincial').val();
        province = province.replace(/\s+/g, '-').toLowerCase();
        $('#municipal').attr('list', 'municipal-'+province+'-list');
        $('#municipal-wrapper').fadeIn();
    } else {
        $('#' + user_type + '-wrapper').fadeIn();
    }

    $("#user_type").change(function() {
        var type = $(this).val();
        $('.occupation-choices').hide();

        if (type == 'federal') {
            $('#federal-wrapper').fadeIn();
        } else if (type == 'academic' || type == 'student') {
            if( type == 'academic' ){
                if( $("#institution").val() == 'highschool' ){ $("#institution").prop('selectedIndex', 0); }
                $("#institution option[value='highschool']").hide();
            } else {
                $("#institution option[value='highschool']").show();
            }
            $('#institution-wrapper').fadeIn();
            var institution = $('#institution').val();
            $('#' + institution + '-wrapper').fadeIn();
        } else if (type == 'provincial') {
            $('#provincial-wrapper').fadeIn();
            var province = $('#provincial').val();
            province = province.replace(/\s+/g, '-').toLowerCase();
            $('#' + province + '-wrapper').fadeIn();
        } else if (type == 'municipal') {
            $('#provincial-wrapper').fadeIn();
            var province = $('#provincial').val();
            province = province.replace(/\s+/g, '-').toLowerCase();
            $('#municipal').attr('list', 'municipal-'+province+'-list');
            $('#municipal-wrapper').fadeIn();
        } else {
            $('#' + type + '-wrapper').fadeIn();
        }
    });

    $("#institution").change(function() {
        var type = $(this).val();
        $('.student-choices').hide();
        $('#' + type + '-wrapper').fadeIn();
    });

    $("#provincial").change(function() {
        var type = $("#user_type").val();
        var province = $(this).val();
        province = province.replace(/\s+/g, '-').toLowerCase();
        if( type == 'provincial' ){
            $('.provincial-choices').hide();
            $('#' + province + '-wrapper').fadeIn();
        } else if( type == 'municipal' ){
            $('.provincial-choices').hide();
            $('#municipal').attr('list', 'municipal-'+province+'-list');
        }
    });

    //Save info and move on
    $('#save').on('click', function () {
        var profile = {};

        profile.user_type = $("#user_type").val();
        profile.federal = $("#federal").is(":visible") ? $("#federal").val() : "";

        profile.institution = $("#institution").is(":visible") ? $("#institution").val() : "";
        profile.university = $("#university").is(":visible") ? $("#university").val() : "";
        profile.college = $("#college").is(":visible") ? $("#college").val() : "";

        profile.provincial = $("#provincial").is(":visible") ? $("#provincial").val() : "";
        profile.ministry = $("#ministry").is(":visible") ? $("#ministry:visible").val() : "";

        profile.municipal = $("#municipal").is(":visible") ? $("#municipal:visible").val() : "";
        profile.international = $("#international").is(":visible") ? $("#international:visible").val() : "";
        profile.ngo = $("#ngo").is(":visible") ? $("#ngo:visible").val() : "";
        profile.community = $("#community").is(":visible") ? $("#community:visible").val() : "";
        profile.business = $("#business").is(":visible") ? $("#business:visible").val() : "";
        profile.media = $("#media").is(":visible") ? $("#media:visible").val() : "";
        profile.retired = $("#retired").is(":visible") ? $("#retired:visible").val() : "";
        profile.other = $("#other").is(":visible") ? $("#other:visible").val() : "";

        elgg.action('b_extended_profile/edit_profile', {
            data: {
                'guid': elgg.get_logged_in_user_guid(),
                'section': "profile",
                'profile': profile
            },
            success: function(data) {
                console.log(data);
                elgg.get('ajax/view/welcome-steps/stepTwo', {
                    success: function (output) {
                        $('#welcome-step').html(output);
                        $('#welcome-step').focus();
                    }
                });
            }
        });
    });
});
</script>
