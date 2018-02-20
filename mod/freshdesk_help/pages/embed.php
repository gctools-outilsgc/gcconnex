<?php
$lang = get_input('lang');
if(!$lang){ $lang = 'en'; }

echo elgg_view_page(elgg_echo('freshdesk:page:title', array(), $lang), elgg_view('freshdesk/embed'), 'embeded');
?>
<script>
  //remove cometchat from window
  $(document).ready(function () {
    $('#cometchat').empty();
  });
</script>
