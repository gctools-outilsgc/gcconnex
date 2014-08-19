<?php 
/*****************************************************************************
 * Phloor Logo Manager                                                       *
 *                                                                           *
 * Copyright (C) 2011, 2012 Alois Leitner                                    *
 *                                                                           *
 * This program is free software: you can redistribute it and/or modify      *
 * it under the terms of the GNU General Public License as published by      *
 * the Free Software Foundation, either version 2 of the License, or         *
 * (at your option) any later version.                                       *
 *                                                                           *
 * This program is distributed in the hope that it will be useful,           *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of            *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             *
 * GNU General Public License for more details.                              *
 *                                                                           *
 * You should have received a copy of the GNU General Public License         *
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.     *
 *                                                                           *
 * "When code and comments disagree both are probably wrong." (Norm Schryer) *
 *****************************************************************************/ 
?>
<?php
// powered by phloor banner

$enable_powered_by_phloor = elgg_get_plugin_setting('enable_powered_by_phloor', 'phloor_logo_manager');
if(strcmp('true', $enable_powered_by_phloor) == 0) {
    $powered_url = elgg_get_site_url() . "mod/phloor/graphics/powered_by_phloor_badge_bckgnd.gif";
	echo '<div class="mts clearfloat float-alt">';
	echo elgg_view('output/url', array(
		'href' => 'http://phloor.13net.at/',
		'text' => "<img src=\"$powered_url\" alt=\"powered by phloor\" width=\"106\" height=\"15\" />",
		'class' => '',
		'is_trusted' => true,
	));
	echo '</div>';
}
