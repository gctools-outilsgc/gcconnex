<?php

echo '<p>Enter the usernames of the user accounts you want to merge.</p>';

//old user account
$params = array(
        'name' => 'olduser',
        'id' => 'olduser',
        'class' => 'mrgn-bttm-sm',
        'match_on' => "users"
    );

echo '<div class="basic-profile-field">';
echo '<label for="olduser">Old user account (merge from)</label>';
echo elgg_view("input/autocomplete", $params);
echo '</div>';

//new user account
$params = array(
        'name' => 'newuser',
        'id' => 'newuser',
        'class' => 'mrgn-bttm-sm',
        'match_on' => "users"
    );

echo '<div class="basic-profile-field">';
echo '<label for="newuser">New user account (merge to)</label>';
echo elgg_view("input/autocomplete", $params);
echo '</div>';

echo '<a href="#" id="confirm" class="btn btn-primary btn-lg">'.elgg_echo('confirm').'</a>';

//echo elgg_view('input/submit', array('value' => elgg_echo('submit'), 'class' => 'btn-lg mrgn-tp-md'));

?>

<div id="popup">
  <span class="close"><a href="#">X</a></span>
<header>Are you sure?</header>
<div class="popup-body">
  <div class="display"></div>
</div>
</div>

<script>
  $('#confirm').on('click', function(){

    var oldU = $('#olduser').val();
    var newU = $('#newuser').val();

    elgg.get('ajax/view/merge_users/display?old='+oldU+'&new='+newU, {
        success: function (output) {
          $('.fullscreen-fade').toggle();
          $('#popup').toggle();

          $('#popup .display').html(output);
        }
    });
  });

  $('.close').on('click', function(){
    $('.fullscreen-fade').toggle();
    $('#popup').toggle();
  });
</script>

<style>
.btn {
  display: inline-block;
  margin-bottom: 0;
  font-weight: normal;
  text-align: center;
  vertical-align: middle;
  -ms-touch-action: manipulation;
  touch-action: manipulation;
  cursor: pointer;
  background-image: none;
  border: 1px solid transparent;
  white-space: nowrap;
  padding: 6px 12px;
  font-size: 16px;
  line-height: 1.4375;
  border-radius: 4px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.btn-primary {
    background-color: #055959;
    border-color: #055959;
}

.btn-submit {
    color: white;
    background-color:#c9302c;
    border-color: #ac2925;
    margin:10px 0;
}

.old, .new {
  font-weight: bold;
  font-style: italic;
}

.close {
  float: right;
  font-size:18px;
  padding:10px;
}

.close a {
  color:white;
}

#popup {
  position:fixed;
  top:60px;
  left:0;
  right:0;
  margin:auto;
  -webkit-background-clip: border-box;
  background-clip: border-box;
  background-color: #fff;
  border: 0;
  border-radius: 0;
  -webkit-transform: translateZ(0);
  transform: inherit;
  z-index: 1050;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
  max-width: 900px;
  
  width:100%;
  display:none;
}

#popup header {
  background:black;
  padding:15px;
  font-size: 26px;
  color:white;
}

#popup .popup-body {
  background:white;
  min-height: 50px;
  padding: 0 10px;
}

.popup-body p {
  margin: 10px;
}

.fullscreen-fade {
    display:none;
    z-index: 1040;
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    background: rgba(0,0,0,0.25);
}

.user-display {
  float:left;
  width:48%;
  margin:5px;
  min-height:175px;
  box-shadow: 0 0 0 1px rgba(0,0,0,.1);
}
.display {
  display:block;
}
</style>
