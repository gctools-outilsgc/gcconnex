<?php
/**
 * Elgg friends picker
 * Lists the friends picker
 *
 * @warning Below is the ugliest code in Elgg. It needs to be rewritten or removed
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['entities'] The array of ElggUser objects
 * @uses $vars['name']
 * @uses $vars['value']
 * @uses $vars['highlight']
 * @uses $vars['callback']
 */

//elgg_load_js('elgg.friendspicker');
elgg_load_js('jquery.easing');


$chararray = elgg_echo('friendspicker:chararray');

// Initialise name
if (!isset($vars['name'])) {
	$name = "friend";
} else {
	$name = $vars['name'];
}

// Are we highlighting default or all?
if (empty($vars['highlight'])) {
	$vars['highlight'] = 'default';
}
if ($vars['highlight'] != 'all') {
	$vars['highlight'] = 'default';
}

// Initialise values
if (!isset($vars['value'])) {
	$vars['value'] = array();
} else {
	if (!is_array($vars['value'])) {
		$vars['value'] = (int) $vars['value'];
		$vars['value'] = array($vars['value']);
	}
}

// Initialise whether we're calling back or not
if (isset($vars['callback'])) {
	$callback = $vars['callback'];
} else {
	$callback = false;
}

// We need to count the number of friends pickers on the page.
if (!isset($vars['friendspicker'])) {
	global $friendspicker;
	if (!isset($friendspicker)) {
		$friendspicker = 0;
	}
	$friendspicker++;
} else {
	$friendspicker = $vars['friendspicker'];
}

$users = array();
$activeletters = array();

// Are we displaying form tags and submit buttons?
// (If we've been given a target, then yes! Otherwise, no.)
if (isset($vars['formtarget'])) {
	$formtarget = $vars['formtarget'];
} else {
	$formtarget = false;
}

// Sort users by letter
if (is_array($vars['entities']) && sizeof($vars['entities'])) {
	foreach($vars['entities'] as $user) {
		$letter = elgg_strtoupper(elgg_substr($user->name, 0, 1));

		if (!elgg_substr_count($chararray, $letter)) {
			$letter = "*";
		}
		if (!isset($users[$letter])) {
			$users[$letter] = array();
		}
		$users[$letter][$user->guid] = $user;
	}
}

// sort users in letters alphabetically
foreach ($users as $letter => $letter_users) {
	usort($letter_users, create_function('$a, $b', '
		return strcasecmp($a->name, $b->name);
	'));
	$users[$letter] = $letter_users;
}

if (!$callback) {
	?>

	<div class="friends-picker-main-wrapper">

	<?php

	if (isset($vars['content'])) {
		echo $vars['content'];
	}
	?>

	<div id="friends-picker_placeholder<?php echo $friendspicker; ?>">

	<?php
}

if (!isset($vars['replacement'])) {
	if ($formtarget) {
?>
<?php //@todo JS 1.8: no ?>


<!-- Collection members form -->
<form id="collectionMembersForm<?php echo $friendspicker; ?>" action="<?php echo $formtarget; ?>" method="post"> <!-- action="" method=""> -->

<?php
		echo elgg_view('input/securitytoken');
		echo elgg_view('input/hidden', array(
			'name' => 'collection_id',
			'value' => $vars['collection_id'],
		));
	}
?>

<div class="friends-picker-wrapper">
<div id="friends-picker<?php echo $friendspicker; ?>">
	<div class="friends-picker-container">
        <!-- Trying data tables 
        <table class=" wb-tables table">
        <thead>Testing</thead>
        <tbody>
        -->
<?php

// Initialise letters
	$chararray .= "*";
	$letter = elgg_substr($chararray, 0, 1);
	$letpos = 0;

            
    $collTable = '';
    
	while (1 == 1) {

        unset($collRow);

		if (isset($users[$letter])) {
			ksort($users[$letter]);

			$col = 0;

			foreach($users[$letter] as $friend) {
               
				if ($col == 0) {
					$collRow .= "<div class='col-xs-12'>";
				}

                

				//echo "<p>" . $user->name . "</p>";
				$label = elgg_view_entity_icon($friend, 'small', array('use_hover' => false, 'class' => 'img-responsive'));
				$options[$label] = $friend->getGUID();

				if ($vars['highlight'] == 'all' && !in_array($letter,$activeletters)) {
					$activeletters[] = $letter;
				}


				if (in_array($friend->getGUID(),$vars['value'])) {
					$checked = "checked = \"checked\"";
                    $checkedValues .= '<input type="checkbox"' . $checked . 'name="' . $name . '[]" value="' . $options[$label] . '" />';
					if (!in_array($letter,$activeletters) && $vars['highlight'] == 'default') {
						$activeletters[] = $letter;
					}
				} else {
					$checked = "";
				}


				$collRow .= '<div class="col-xs-1">';

                $collRow .= '<div  class="mrgn-tp-sm"><input type="checkbox"' . $checked . 'name="' . $name . '[]" value="' . $options[$label] . '" /></div>';

				$collRow .= '</div>

				<div class="col-xs-2">

					<div style="">';
				
					$collRow .= $label;
				
				$collRow .=	'</div>
				</div>
				<div class="col-xs-9">';
                $collRow .= $friend->name;
				$collRow .= '</div>';
				
				$col++;
				//if ($col == 3){
					$collRow .= "</div>";
					$col = 0;
				//}

                    if ($col < 3) {
                        $collRow .= "</div>";
                    }

                    //stick items in <td> element
                    $list_items = elgg_format_element('td', ['class' => 'data-table-list-item '], $collRow);
                    //stick <td> elements in <tr>
                    $tR .= elgg_format_element('tr', ['class' => 'testing',], $list_items);

                    $collRow = '';

			}
			

		}

        if(isset($collRow)){

            //$collTable .= '<tr><td>' . $collRow . '</tr></td>';

            //stick items in <td> element
            //$list_items = elgg_format_element('td', ['class' => 'data-table-list-item '], $collRow);
            //stick <td> elements in <tr>
            //$tR .= elgg_format_element('tr', ['class' => 'testing',], $list_items);
        }

			$substr = elgg_substr($chararray, elgg_strlen($chararray) - 1, 1);
			if ($letter == $substr) {
				break;
			}
			//$letter++;
			$letpos++;
			$letter = elgg_substr($chararray, $letpos, 1);

            
		}

    //create table body
    $tBody = elgg_format_element('tbody', ['class' => ''], $tR);

    //create table head
    $tHead = elgg_format_element('thead', ['class' => ''], '<tr> <th class="data-table-head"> ' . elgg_echo('friends') . '</th> </tr>');
    
    echo elgg_format_element('table', ['class' => ' wb-tables table', 'id' => ''], $tHead . $tBody);





if ($formtarget) {

	if (isset($vars['formcontents']))
		echo $vars['formcontents'];

?>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
	<div class="friendspicker-savebuttons">
		<input type="submit" class="mrgn-lft-sm mrgn-bttm-sm btn btn-primary" value="<?php echo elgg_echo('save'); ?>" />
		<input type="button" class="mrgn-bttm-sm btn btn-default" value="<?php echo elgg_echo('cancel'); ?>" onclick="$('a.collectionmembers<?php echo $friendspicker; ?>').click();" />
	<br /></div>
	</form>

        

<?php

}

?>

</div>
</div>

<?php
} else {
	echo $vars['replacement'];
}
if (!$callback) {

?>

<?php

}

if (!isset($vars['replacement'])) {
?>
<?php //@todo JS 1.8: no ?>


<?php

}?>

    <div id="storedArea" class="hidden">
        <?php echo $checkedValues;?>
            <script>
                $(function () {



                    //add guids to move selected link when checked
                    $(':checkbox').change(function () {
                        if ($(this).is(":checked")) {

                            $(this).clone().attr('checked', 'checked').appendTo('#storedArea');

                            return;

                        } else {

                            var checkBoxes = $('#storedArea input').toArray();
                            for (var i = 0; i < checkBoxes.length; i++) {

                                if (checkBoxes[i].getAttribute("value") == $(this).val()) {

                                    checkBoxes[i].parentNode.removeChild(checkBoxes[i]);

                                }
                            }

                        }
                    });



                });

            </script>

        </div>