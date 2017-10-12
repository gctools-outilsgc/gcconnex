<?php
if(elgg_is_logged_in()){
  $user = elgg_get_logged_in_user_entity();
  $user->user_type = 'ngo';
  $user->ngo = "";
}
?>
<!-- User Types -->
<div class="user-type-input">
  <label for="user_type"><span class="field-name"><?php echo elgg_echo('gcRegister:occupation'); ?></span></label>
  <?php
    $departments = array(
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
    );

    echo elgg_view('input/select', array(
      'name' => 'user_type',
      'id' => 'user_type',
      'class' => 'form-control',
      'aria-required' => 'true',
      'required' => true,
      'value' => $user->user_type,
      'options_values' => $departments,
    ));
  ?>
</div>
<!-- End User Types -->

<!-- Organizations -->
  <!-- University/College/High School -->
  <div class="form-group occupation-choices" id="institution-wrapper">
    <label for="institution" class="required"><span class="field-name"><?php echo elgg_echo('Institution'); ?></span></label>
    <?php
      $institutions = array(
        'default_invalid_value' => elgg_echo('gcRegister:make_selection'),
        'university' => elgg_echo('gcRegister:university'),
        'college' => elgg_echo('gcRegister:college'),
        'highschool' => elgg_echo('gcRegister:highschool')
      );

      echo elgg_view('input/select', array(
        'name' => 'institution',
        'id' => 'institution',
        'class' => 'form-control',
        'value' => 'default_invalid_value',
        'options_values' => $institutions
      ));
    ?>
  </div>
  <!-- End University/College/High School -->

  <!-- Universities -->
  <?php
    $uniObj = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'universities',
    ));
    $unis = get_entity($uniObj[0]->guid);

    $universities = array();
    if (get_current_language() == 'en'){
      $universities = json_decode($unis->universities_en, true);
    } else {
      $universities = json_decode($unis->universities_fr, true);
    }
    asort($universities);

    // default to invalid value, so it encourages users to select
    $university_choices = elgg_view('input/select', array(
      'name' => 'university',
      'id' => 'university',
          'class' => 'form-control',
      'options_values' => array_merge(array('default_invalid_value' => elgg_echo('gcRegister:make_selection')), $universities),
    ));
  ?>

  <div class="form-group occupation-choices student-choices" id="university-wrapper" hidden>
    <label for="university" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:university'); ?></span></label>
    <?php echo $university_choices; ?>
  </div>
  <!-- End Universities -->

  <!-- Colleges -->
  <?php
    $colObj = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'colleges',
    ));
    $cols = get_entity($colObj[0]->guid);

    $colleges = array();
    if (get_current_language() == 'en'){
      $colleges = json_decode($cols->colleges_en, true);
    } else {
      $colleges = json_decode($cols->colleges_fr, true);
    }
    asort($colleges);

    // default to invalid value, so it encourages users to select
    $college_choices = elgg_view('input/select', array(
      'name' => 'college',
      'id' => 'college',
          'class' => 'form-control',
      'options_values' => array_merge(array('default_invalid_value' => elgg_echo('gcRegister:make_selection')), $colleges),
    ));
  ?>

  <div class="form-group occupation-choices student-choices" id="college-wrapper" hidden>
    <label for="college" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:college'); ?></span></label>
    <?php echo $college_choices; ?>
  </div>
  <!-- End Colleges -->

  <!-- High Schools -->
  <?php
    $highschool_choices = elgg_view('input/text', array(
      'name' => 'highschool',
      'id' => 'highschool',
          'class' => 'form-control',
    ));
  ?>

  <div class="form-group occupation-choices student-choices" id="highschool-wrapper" hidden>
    <label for="highschool" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:highschool'); ?></span></label>
    <?php echo $highschool_choices; ?>
  </div>
  <!-- End High Schools -->


  <!-- Federal Government -->
  <?php
    $deptObj = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'federal_departments',
    ));
    $depts = get_entity($deptObj[0]->guid);

    $federal_departments = array();
    if (get_current_language() == 'en'){
      $federal_departments = json_decode($depts->federal_departments_en, true);
    } else {
      $federal_departments = json_decode($depts->federal_departments_fr, true);
    }
    asort($federal_departments);

    // default to invalid value, so it encourages users to select
    $federal_choices = elgg_view('input/select', array(
      'name' => 'federal',
      'id' => 'federal',
          'class' => 'form-control',
      'options_values' => array_merge(array('default_invalid_value' => elgg_echo('gcRegister:make_selection')), $federal_departments),
    ));
  ?>

  <div class="form-group occupation-choices" id="federal-wrapper" hidden>
    <label for="federal" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
    <?php echo $federal_choices; ?>
  </div>
  <!-- End Federal Government -->

  <!-- Provincial/Territorial Government -->
  <?php
    $provObj = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'provinces',
    ));
    $provs = get_entity($provObj[0]->guid);

    $provincial_departments = array();
    if (get_current_language() == 'en'){
      $provincial_departments = json_decode($provs->provinces_en, true);
    } else {
      $provincial_departments = json_decode($provs->provinces_fr, true);
    }
    asort($provincial_departments);

    // default to invalid value, so it encourages users to select
    $provincial_choices = elgg_view('input/select', array(
      'name' => 'provincial',
      'id' => 'provincial',
      'class' => 'form-control',
      'options_values' => array_merge(array('default_invalid_value' => elgg_echo('gcRegister:make_selection')), $provincial_departments),
    ));
  ?>

  <div class="form-group occupation-choices" id="provincial-wrapper" hidden>
    <label for="provincial" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:province'); ?></span></label>
    <?php echo $provincial_choices; ?>
  </div>

  <?php
    $minObj = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'ministries',
    ));
    $mins = get_entity($minObj[0]->guid);

    $ministries = array();
    if (get_current_language() == 'en'){
      $ministries = json_decode($mins->ministries_en, true);
    } else {
      $ministries = json_decode($mins->ministries_fr, true);
    }
    asort($ministries);

    if( !empty($provincial_departments) ){
      foreach($provincial_departments as $province => $province_name){
        asort($ministries[$province]);

        $prov_id = str_replace(" ", "-", strtolower($province));
        echo '<div class="form-group occupation-choices provincial-choices" id="' . $prov_id . '-wrapper" hidden><label for="' . $prov_id . '" class="required"><span class="field-name">' . elgg_echo('gcRegister:ministry') . '</span></label>';
        echo elgg_view('input/select', array(
          'name' => 'ministry',
          'id' => $prov_id,
              'class' => 'form-control',
          'options_values' => array_merge(array('default_invalid_value' => elgg_echo('gcRegister:make_selection')), $ministries[$province]),
        ));
        echo '</div>';
      }
    }
  ?>
  <!-- End Provincial/Territorial Government -->

  <!-- Municipal Government -->
  <?php
    $munObj = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'municipal',
    ));
    $municipals = get_entity($munObj[0]->guid);

    $municipal = array();
    if (get_current_language() == 'en'){
      $municipal = json_decode($municipals->municipal_en, true);
    } else {
      $municipal = json_decode($municipals->municipal_fr, true);
    }

    $municipal_choices = elgg_view('input/text', array(
      'name' => 'municipal',
      'id' => 'municipal',
      'class' => 'form-control',
      'list' => 'municipal-list'
    ));
  ?>

  <div class="form-group occupation-choices" id="municipal-wrapper" hidden>
    <label for="municipal" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
    <?php echo $municipal_choices; ?>
    <datalist id="municipal-list">
      <?php
        if( !empty($municipal) ){
          asort($municipal);

          foreach($municipal as $municipal_name => $value){
            echo '<option value="' . $municipal_name . '">' . $value . '</option>';
          }
        }
      ?>
    </datalist>
  </div>
  <!-- End Municipal Government -->

  <!-- International/Foreign Government -->
  <?php
    $international_choices = elgg_view('input/text', array(
      'name' => 'international',
      'id' => 'international',
          'class' => 'form-control',
    ));
  ?>

  <div class="form-group occupation-choices" id="international-wrapper" hidden>
    <label for="international" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
    <?php echo $international_choices; ?>
  </div>
  <!-- End International/Foreign Government -->


  <!-- Non-Governmental Organization -->
  <?php
    $ngo_choices = elgg_view('input/text', array(
      'name' => 'ngo',
      'id' => 'ngo',
          'class' => 'form-control',
    ));
  ?>

  <div class="form-group occupation-choices" id="ngo-wrapper" hidden>
    <label for="ngo" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
    <?php echo $ngo_choices; ?>
  </div>
  <!-- End Non-Governmental Organization -->


  <!-- Community/Non-profit -->
  <?php
    $community_choices = elgg_view('input/text', array(
      'name' => 'community',
      'id' => 'community',
          'class' => 'form-control',
    ));
  ?>

  <div class="form-group occupation-choices" id="community-wrapper" hidden>
    <label for="community" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
    <?php echo $community_choices; ?>
  </div>
  <!-- End Community/Non-profit -->

  <!-- Business -->
  <?php
    $business_choices = elgg_view('input/text', array(
      'name' => 'business',
      'id' => 'business',
          'class' => 'form-control',
    ));
  ?>

  <div class="form-group occupation-choices" id="business-wrapper" hidden>
    <label for="business" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
    <?php echo $business_choices; ?>
  </div>
  <!-- End Business -->

  <!-- Media -->
  <?php
    $media_choices = elgg_view('input/text', array(
      'name' => 'media',
      'id' => 'media',
          'class' => 'form-control',
    ));
  ?>

  <div class="form-group occupation-choices" id="media-wrapper" hidden>
    <label for="media" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
    <?php echo $media_choices; ?>
  </div>
  <!-- End Media -->

  <!-- Retired Public Servant -->
  <?php
    $retired_choices = elgg_view('input/text', array(
      'name' => 'retired',
      'id' => 'retired',
          'class' => 'form-control',
          'list' => 'retired-list'
    ));
  ?>

  <div class="form-group occupation-choices" id="retired-wrapper" hidden>
    <label for="retired" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
    <?php echo $retired_choices; ?>
    <datalist id="retired-list">
      <?php
        if( !empty($federal_departments) ){
          foreach($federal_departments as $federal_name => $value){
            echo '<option value="' . $value . '"></option>';
          }
        }
      ?>
    </datalist>
  </div>
  <!-- End Retired Public Servant -->

  <!-- Other -->
  <?php
    $otherObj = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'other',
    ));
    $others = get_entity($otherObj[0]->guid);

    $other = array();
    if (get_current_language() == 'en'){
      $other = json_decode($others->other_en, true);
    } else {
      $other = json_decode($others->other_fr, true);
    }
    asort($other);

    $other_choices = elgg_view('input/text', array(
      'name' => 'other',
      'id' => 'other',
          'class' => 'form-control',
          'list' => 'other-list'
    ));
  ?>

  <div class="form-group occupation-choices" id="other-wrapper" hidden>
    <label for="other" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
    <?php echo $other_choices; ?>
    <datalist id="other-list">
      <?php
        if( !empty($other) ){
          foreach($other as $other_name => $value){
            echo '<option value="' . $other_name . '">' . $value . '</option>';
          }
        }
      ?>
    </datalist>
  </div>
  <!-- End Other -->

<!-- End Organizations -->

<script>
$(document).ready(function() {
	$("#user_type").change(function() {
		var type = $(this).val();
		$('.occupation-choices').hide();

		if (type == 'academic' || type == 'student') {
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
		var province = $(this).val();
		province = province.replace(/\s+/g, '-').toLowerCase();
		$('.provincial-choices').hide();
		$('#' + province + '-wrapper').fadeIn();
	});

	// Preload form options if page was reloaded
	if(sessionStorage.length > 0){
		$('.occupation-choices').hide();
		$.each(sessionStorage, function(key, value){
			if( $("#" + key).length > 0 ){
				$("#" + key).val(value);
				$("#" + key).closest('.occupation-choices').show();
			}
		});
	}
});
</script>

<style>
.user-type-input {
  width:35%;
  display: inline-block;
}

#institution-wrapper, #other-wrapper, #retired-wrapper, #media-wrapper, #business-wrapper, #ngo-wrapper, #provincial-wrapper, #federal-wrapper, #municipal-wrapper, #international-wrapper, #community-wrapper {
  width:64%;
  display:inline-block;
}

fieldset.user-info {
  border: 1px solid #e5e5e5;
  padding:5px 10px;
  margin-top:10px;
}
.user-info legend {
  position:relative;
  top:0;
  float:none;
  width:auto;
  margin-bottom: 0;
}

</style>
