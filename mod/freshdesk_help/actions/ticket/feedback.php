<?php
elgg_make_sticky_form('ticket-submit');

$type = get_input('type');
$lang = get_input('langauge');

if($type == 'success'){
  system_message(elgg_echo('freshdesk:ticket:submit:confirmed', array(), $lang));
  elgg_clear_sticky_form('ticket-submit');
} else {
  register_error(elgg_echo('freshdesk:ticket:submit:denied'. ' : '.get_input('code'), array(), $lang));
}

if(get_input('direct') == 'embed'){
  forward('help/embed?lang='.$lang);
} else {
  forward('help/knowledgebase');
}
