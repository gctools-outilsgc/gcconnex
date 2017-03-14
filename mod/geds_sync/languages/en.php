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
	//'geds:sync:info' => 'By clicking Save, you will sync the selected GEDS information with your GCconnex profile. Information about your office location and your organization will also be synched with your GCconnex profile.',
	/*'geds:sync:info' => '<p>
By clicking Save, the above information you selected as well as your office and organization information will be imported from GEDS to update your GCconnex profile.  This information is copied the moment you click Save and will not update automatically if your GEDS information change unless you select the sync option again.
</p>
<p>
Additionally, once the accounts are linked, some information in your GCconnex profile will be pulled from GCconnex each time your GEDS profile is loaded. Your GEDS profile page will display the following information from GCconnex when set to a visibility level of “public”: About Me, Education, Work Experience, and Second Language Evaluations.  
</p>
<p>
If you do not wish for a section of your GCconnex profile to appear on GEDS you can set it to a more restrictive option by clicking Edit in the section whose visibility you would like to change.  This will also limit what information other GCconnex members can see in your profile.
</p>
<p> 
Your Avatar and Skills section will always be display in your GEDS profile.
</p>
<p>
The preceding only applies to the internal version of GEDS that is only visible to public servants. None of the information in your GCconnex profile will ever appear on the public-facing GEDS.gc.ca website, regardless of the privacy settings in GCconnex.
</p>
	',*/
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
