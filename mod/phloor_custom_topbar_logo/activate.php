<?php

if (get_subtype_id('object', 'phloor_topbar_logo')) {
	update_subtype('object', 'phloor_topbar_logo', 'PhloorTopbarLogo');
} else {
	add_subtype('object', 'phloor_topbar_logo', 'PhloorTopbarLogo');
}
