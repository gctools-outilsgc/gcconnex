<?php
/**
 * GEDS english language file.
 *
 */

$english = array(
	'geds:button' => 'Sync with GCdirectory',
	'geds:cancel' => 'Cancel',
	'geds:save' => 'Save',
	'geds:searchfail' => 'No information was found in GCdirectory for ',
	'geds:searchfail2' => 'Check that your GCconnex email is correct. To update your GCdirectory information, see the instructions available on the <a href=\'http://gcdirectory-gcannuaire.ssc-spc.gc.ca/en/GEDS20/?pgid=005#q1\' >GCdirectory website.</a>',
	'geds:personsel:title' => 'Your GCdirectory information',
	'geds:personsel:isthisyou' => 'Is this correct? ',
	'geds:personsel:yes' => 'Yes',
	'geds:personsel:no' => 'No',
	'geds:personsel:name' => 'Name: ',
	'geds:personsel:job' => 'Job Title: ',
	'geds:personsel:department' => 'Department: ',
	'geds:personsel:phone' => 'Telephone: ',
	'geds:sync:title' => 'Select items to sync',
	'geds:sync:table:field' => 'Field',
	'geds:sync:table:current' => 'What you have in GCconnex',
	'geds:sync:table:ingeds' => 'Available from GCdirectory',
	'geds:sync:table:field:display' => 'Name',
	'geds:sync:table:field:job' => 'Job Title',
	'geds:sync:table:field:department' => 'Department',
	'geds:sync:table:field:telephone' => 'Telephone',
	'geds:sync:table:field:mobile' => 'Mobile',
	'geds:success' => 'Congratulations, your GCdirectory information has been synced with your GCconnex profile.',
	///////////////////////////////////////////////////////////////////////////
	'geds:org:orgTab' => 'Organizations',
	'geds:add:friend' => 'Add colleague',
	'geds:invite:friend' => 'Invite to GCconnex',
	'geds:org:orgTitle' => 'Organizations',
	'geds:org:orgPeopleTitle' => 'People',
	'geds:noMatch' => "<p>Your GCdirectory information has not been synced with GCconnex. Ensure your email address is up to date in your GCconnex settings. To update your GCdirectory information, see the instructions available on the <a href='http://gcdirectory-gcannuaire.ssc-spc.gc.ca/en/GEDS20/?pgid=005#q1'>GCdirectory website</a></p>",
	'geds:floor' => "Floor",
	'geds:org:delete' => "Delete",
	'geds:org:edit' => "Edit",
	'geds:org:edit:title' => 'Modify Privacy Settings of my GCdirectory information',
	'geds:org:access:label' => 'Who can see my organization: ',
	'geds:loc:access:label' => 'Who can see my work location: ',
	'geds:save' => 'Save',
	'geds:map:title' => 'Work location',

	'geds:sync:info' => '<p>
	Please note: GCdirectory is only visible to public servants.<br />
The Government of Canada has a separate, public-facing directory: GEDS.gc.ca.<br />
None of the information in your GCconnex profile will appear on the GEDS.gc.ca website, regardless of your privacy settings in GCconnex.
	</p>
	<p>
	When you click save, two things will happen:<br />
1-	GCdirectory will update your office location and department/agency in GCconnex.
This is a one-time update: if your GCdirectory information changes, you will need to sync again to update GCconnex.<br />
2-	Your GCdirectory and GCconnex accounts will be linked and the following information from your GCconnex profile will automatically appear in GCdirectory:<br />

Mandatory: Your Avatar (photo)<br />
Optional: About Me, Education, Work Experience, and Skills
	</p>
	<p>
	Important!<br />
If you do not wish for your GCconnex avatar to appear on GCdirectory, click “Cancel”.
	</p>
	<p>
	For the optional information, you can chose who sees it by changing your privacy settings in GCconnex (i.e., “ Edit,” “Who can see my [description, education…]).
	</p>',

	'geds:org:edit:body' => 'To update information about your organization or your work location in GCdirectory, see the instructions available on the <a href="http://gcdirectory-gcannuaire.ssc-spc.gc.ca/en/GEDS20/?pgid=005#q1">GCdirectory website</a>.',
	'geds:org:edit:success' => 'Privacy settings have been updated.',
	'geds:edit:error' => 'You do not have permission to view this item.',
	'geds_sync:setting:url' => 'GCdirectory API service URL',
	'geds_sync:setting:auth_key' => 'GCdirectory Auth key',
	'geds_sync:setting:map_key' => 'google map key',
	'geds:button:unsync' => 'Unsync from GCdirectory',
	'geds:unSync:message' => 'If you unsync, your GCconnex profile information will no longer be shown on GCdirectory.<br /> Are you sure?',
	'geds:unsync:title' => 'Are you sure?',
);

add_translation('en', $english);
