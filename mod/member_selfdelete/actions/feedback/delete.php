<?php

namespace Beck24\MemberSelfDelete;

$id = get_input('id');
$annotation = elgg_get_annotation_from_id($id);

if (!$annotation || $annotation->name != 'selfdeletefeedback') {
	register_error(elgg_echo('member_selfdelete:error:invalid:annotation'));
	forward(REFERER);
}

$annotation->delete();

system_message(elgg_echo('member_selfdelete:feedback:deleted'));
forward(REFERER);