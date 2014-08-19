<?php

/**
 * Order By
 */

echo elgg_echo('au_subgroups:widget:order') . '<br>';
echo elgg_view('input/dropdown', array(
    'name' => 'params[order]',
    'value' => $vars['entity']->order ? $vars['entity']->order : 'default',
    'options_values' => array(
        'default' => elgg_echo('au_subgroups:option:default'),
        'alpha' => elgg_echo('au_subgroups:option:alpha')
    )
));

echo '<br><br>';

/**
 * Number of results
 */
$options_values = array();
for ($i=1; $i<11; $i++) {
  $options_values[$i] = $i;
}

echo elgg_echo('au_subgroups:widget:numdisplay') . '<br>';
echo elgg_view('input/dropdown', array(
    'name' => 'params[numdisplay]',
    'value' => $vars['entity']->numdisplay ? $vars['entity']->numdisplay : 5,
    'options_values' => $options_values
));

echo '<br><br>';