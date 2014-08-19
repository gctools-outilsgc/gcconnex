<?php

if (get_subtype_id('object', 'phloor_favicon')) {
	update_subtype('object', 'phloor_favicon', 'PhloorFavicon');
} else {
	add_subtype('object', 'phloor_favicon', 'PhloorFavicon');
}
