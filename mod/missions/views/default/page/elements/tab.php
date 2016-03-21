<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Creates a set of tabs which may be linked or unlinked.
 * The variable 'tab_bar' is a 2D array where the first dimension represents the individual tabs.
 * The second dimension contains the tabs data, [0] = text within the tab and [1] = tab link.
 */
$tabs = '';
if (isset($vars['tab_bar'])) {
    $tabs = $vars['tab_bar'];
}

echo '<table class="missions-tab-bar-table"><tr>';
foreach ($tabs as $value) {
    if ($value[1] != '') {
        echo '<td>' . elgg_view('output/url', array(
            'href' => $value[1],
            'text' => $value[0],
            'class' => '',
            'is_trusted' => true
        )) . '</td>';
    } else {
        echo '<td class="elgg-tabbar-table-element">' . $value[0] . '</td>';
    }
}
echo "</tr></table>";