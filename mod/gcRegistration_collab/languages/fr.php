<?php

$french = array(

	'gcRegister:membertype' => "Type de membre",
	
	'gcRegister:occupation' => "Occupation",
	'gcRegister:occupation:academic' => "Milieu universitaire",
	'gcRegister:occupation:student' => "Étudiant",
	'gcRegister:occupation:federal' => "Gouvernement fédéral",
	'gcRegister:occupation:provincial' => "Gouvernement provincial/territorial",
	'gcRegister:occupation:municipal' => "Administration municipale",
	'gcRegister:occupation:international' => "International / Gouvernement étranger",
	'gcRegister:occupation:ngo' => "Organismes non gouvernementaux",
	'gcRegister:occupation:community' => "Collectivité / Sans but lucratif",
	'gcRegister:occupation:business' => "Entreprise",
	'gcRegister:occupation:media' => "Média",
	'gcRegister:occupation:retired' => "Fonctionnaire à la retraité(e)",
	'gcRegister:occupation:other' => "Autres renseignements",

	'gcRegister:occupation:university' => "Université ou collège",
	'gcRegister:occupation:department' => "Ministères / organismes",
	'gcRegister:occupation:province' => "Province ou territoire",

	'gcRegister:department' => 'Organisation',
	'gcRegister:university' => 'Université',
	'gcRegister:college' => 'Collège',
	'gcRegister:highschool' => 'École secondaire',
	'gcRegister:province' => 'Province / territoire',
	'gcRegister:ministry' => 'Ministère',
	'gcRegister:city' => 'Ville',

	// labels
	'gcRegister:form' => "Formulaire d'inscription",
	'gcRegister:email' => 'Adresse de courriel',
	'gcRegister:email_secondary' => 'Confirmation du courriel',
	'gcRegister:username' => 'Nom d\'utilisateur (généré automatiquement)',
	'gcRegister:password_initial' => 'Mot de passe',
	'gcRegister:password_secondary' => 'Confirmation du mot de passe',
	'gcRegister:display_name' => 'Nom au complet',
	'gcRegister:display_name_notice' => "Veuillez écrire votre prénom et votre nom de famille, tel que l’on vous connaît au travail. Conformément aux Conditions d’utilisation, le nom affiché doit correspondre à votre vrai nom. Il n’est pas permis d’utiliser un pseudonyme.",
	'gcRegister:please_enter_email' => 'Veuillez inscrire votre adresse de courriel',
	'gcRegister:please_enter_name' => 'Veuillez inscrire votre nom à afficher',
	'gcRegister:department_name' => 'Inscrire le nom de votre ministère',
	'gcRegister:register' => 'S\'inscrire',
	'gcRegister:has_invited' => ' vous a invité à joindre GCcollab :',
				
	// error messages on the form			// error messages on the form			
	'gcRegister:failedMySQLconnection' => 'Impossible de se connecter à la base de données',
	'gcRegister:invalid_email' => 'Adresse de courriel non valide',
	'gcRegister:invalid_email_link' => '<a href="#email">Adresse de courriel non valide</a>',
	'gcRegister:empty_field' => 'Champ vide',
	'gcRegister:mismatch' => 'Erreur de correspondance',
	'gcRegister:make_selection' => 'Veuillez faire une sélection',
	'gcRegister:EmptyPassword' => '<a href="#password1">Les champs du mot de passe ne peut pas être vide</a>',
  	'gcRegister:PasswordMismatch' => '<a href="#password1">Les mots de passe doivent être identiques</a>',
  	'gcRegister:FederalNotSelected' => '<a href="#federal">Organisation n\'a pas été sélectionnée</a>',
	'gcRegister:InstitutionNotSelected' => '<a href="#institution">Institution n\'a pas été sélectionnée</a>',
	'gcRegister:UniversityNotSelected' => '<a href="#university">Université n\'a pas été sélectionnée</a>',
	'gcRegister:CollegeNotSelected' => '<a href="#college">Collège n\'a pas été sélectionnée</a>',
	'gcRegister:HighschoolNotSelected' => '<a href="#highschool">École secondaire n\'a pas été indiqué</a>',
	'gcRegister:ProvincialNotSelected' => '<a href="#provincial">Province / territoire n\'a pas été sélectionnée</a>',
	'gcRegister:MinistryNotSelected' => '<a href="#ministry">Ministère n\'a pas été sélectionnée</a>',
	'gcRegister:MunicipalNotSelected' => '<a href="#municipal">Organisation n\'a pas été indiqué</a>',
	'gcRegister:InternationalNotSelected' => '<a href="#international">Organisation n\'a pas été indiqué</a>',
	'gcRegister:NGONotSelected' => '<a href="#ngo">Organisation n\'a pas été indiqué</a>',
	'gcRegister:CommunityNotSelected' => '<a href="#community">Organisation n\'a pas été indiqué</a>',
	'gcRegister:BusinessNotSelected' => '<a href="#business">Organisation n\'a pas été indiqué</a>',
	'gcRegister:MediaNotSelected' => '<a href="#media">Organisation n\'a pas été indiqué</a>',
	'gcRegister:RetiredNotSelected' => '<a href="#retired">Organisation n\'a pas été indiqué</a>',
	'gcRegister:OtherNotSelected' => '<a href="#other">Organisation n\'a pas été indiqué</a>',
				
	// notice			// avis			
	'gcRegister:email_notice' => '<h2 class="h2"></h2>',
				
	'gcRegister:terms_and_conditions' => 'J\'ai lu, j\'ai compris et j\'accepte les <a href="/termes" target="_blank">conditions d\'utilisation</a>.',
	'gcRegister:validation_notice' => '<b>Remarque :</b> Vous ne pourrez pas ouvrir une session sur Gcconnex avant d\'avoir reçu un courriel de validation.',
	'gcRegister:tutorials_notice' => '<a href="http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex">Tutoriels de GCconnex</a>',
				
	// error messages that pop up			// messages d'erreur qui apparaissen
	'gcRegister:toc_error' => '<a href="#toc2">Vous devez accepter les condtions d\'utilisation</a>',
	'gcRegister:email_in_use' => 'Cette adresse de courriel a déjà déjà été enregistrée',
	'gcRegister:password_mismatch' => '<a href="#password">Les mots de passe ne sont pas identiques</a>',
	'gcRegister:password_too_short' => '<a href="#password">Le mot de passe doit avoir au moins 6 caractères</a>',
	'gcRegister:email_mismatch' => '<a href="#email">Les adresses de courriel ne sont pas identitiques</a>',
	'gcRegister:display_name_is_empty' => '<a href="#name">Le champ « Nom à afficher » ne peut pas être laissé vide</a>',

	'gcRegister:welcome_message' => "<p>GCcollab, un site qui est hébergé par le gouvernement du Canada, vient faciliter la collaboration entre les universitaires, les étudiants, les fonctionnaires canadiens, de même que d’autres collectivités importantes.</p>
	<p class='ptm pbm'><strong>Qui peut s'inscrire?</strong></p>
	<ul>
		<li>Les fonctionnaires canadiens (fédéraux, provinciaux, territoriaux et municipaux) peuvent s'inscrire en se servant de leurs adresses courriel gouvernementales.</li>
		<li>Les universitaires et les étudiants de toutes les universités et collèges canadiens peuvent s'inscrire en utilisant les adresses courriel de leur institution.</li>
	</ul>
	<p><strong>Vous ne faites pas partie de ces groupes?</strong> Les Canadiens peuvent se joindre à GCcollab par invitation! Les membres existants de GCcollab peuvent inviter leurs intervenants et partenaires à se joindre à GCcollab, ce qui en fait un environnement véritablement collaboratif.</p>
	<p class='ptm pbm'><strong>Inscrivez-vous et validez votre compte!</strong></p>
	<p>Une fois que vous aurez rempli le formulaire d'inscription, vous recevrez un courriel de validation. Cliquez sur le lien (ou copiez-le dans la barre d'adresse) pour activer votre compte. Si vous ne recevez pas de courriel, veuillez communiquer avec le <a href='" . elgg_get_site_url() . "mod/contactform/'>bureau d’aide de GCcollab</a>.</p>",
	
	'gcRegister:required' => 'requis',
	'gcRegister:organization_notice' => 'Les individus de cette occupation doivent être invités par un membre existant de GCcollab pour s\'inscrire à un compte. Après avoir reçu votre invitation, inscrivez-vous en utilisant la même adresse courriel que celle qui a été utilisée pour vous inviter.',
);
 
add_translation("fr", $french);