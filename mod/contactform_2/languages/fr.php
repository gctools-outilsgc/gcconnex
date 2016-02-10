<?php
	/**
	 * Elgg MyCustomText plugin
	 *
	 * @package ElggMyCustomText
	 * @license http://gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Untamed
	 * @copyright Untamed 2008-2010
	 */

	$french = array(
          //
    //error messages
    //

   'contactform:Errreason'=>"<a href='#reason'><span class='prefix'>Erreur [#] :</span> Vous devez choisir une raison - Ce champ est obligatoire.</a>",
   'contactform:Errsubject'=>"<a href='#subject'><span class='prefix'>Erreur [#] :</span> Subject - Ce champ est obligatoire.</a>",
   'contactform:Errname'=>"<a href='#name'><span class='prefix'>Erreur [#] :</span> Nom - Ce champ est obligatoire.</a>",
    'contactform:Errnamebig'=>"<a href='#name'><span class='prefix'>Erreur [#] :</span> Limite de caractère atteint pour le nom - Veuillez inscrire moin de 75 caractères.</a>",
    'contactform:Erremail'=>"<a href='#email'><span class='prefix'>Erreur [#] :</span> Courriel - Ce champ est obligatoire.</a>",
    'contactform:Erremailbig'=>"<a href='#email'><span class='prefix'>Erreur [#] :</span> Limite de caractère atteint pour le courriel - Veuillez inscrire moin de 100 caractères.</a>",
    'contactform:Erremailvalid'=>"<a href='#email'><span class='prefix'>Erreur [#] :</span> Courriel invalide - Entrez une adresse email valide.</a>",
    'contactform:Errdepart'=>"<a href='#depart'><span class='prefix'>Erreur [#] :</span> Ministère - Ce champ est obligatoire.</a>",
    'contactform:Errdepartbig'=>"<a href='#depart'><span class='prefix'>Erreur [#] :</span> Limite de caractère atteint pour le ministère. - Veuillez inscrire moin de 255 caractères.</a>",
    'contactform:Errmess'=>"<a href='#message'><span class='prefix'>Erreur [#] :</span> Message - Ce champ est obligatoire.</a>",
    'contactform:Errmessbig'=>"<a href='#message'><span class='prefix'>Erreur [#] :</span> Limite de caractère atteint pour le message. - Veuillez inscrire moin de 2048 caractères.</a>",
    'contactform:Errfiletypes'=>"<a href='#photo'><span class='prefix'>Erreur [#] :</span> Type de fichier invalide. - Types de fichiers valides sont : [##]</a>",
    'contactform:Errfilesize'=>"<a href='#photo'><span class='prefix'>Erreur [#] :</span> La taille du fichier dépasse la limite. - La taille du fichier doit être inférieure à [##] MB.</a>",
    'contactform:Errfileup'=>"<a href='#photo'><span class='prefix'>Erreur [#] :</span> Error in file upload.</a>",

    //General entries
	/**
	 * My CustomText
	 */

		'help_menu_item' => "Aide / Contactez-nous",
		'help:message' => "Pour obtenir de l'aide sur GCconnex, s'il vous plaît consultez la page suivante de GCpedia: ",
		'help:url' => "http://gcpedia.gc.ca/wiki/Gouvernement_du_Canada_pilote/GCconnex_utilisateur_aide_et_FAQ_de_r%C3%A9seautage_professionne",
		'help:url-desc' => "Pages d'aide GCPEDIA",
		'help:contact' => "Contactez-nous: ",
		'contactform:body' => " <div class='elgg-output'>

				<h2 style='border-bottom: solid 3px; padding-bottom: 2px;'>Aide</h2>
					<br />
					<h3><u>Pages d'aide de GCconnex</u></h3><br />
						<ul style='list-style-type: disc;'>
						<li> <a href='http://gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0'>Conseils pratiques/Vidéos/Tutoriels</a> </li>
						<li> <a href='http://gcconnex.gc.ca/file/view/6352643/intro-a-gcconnex-savoir-le-%C2%ABcomment%C2%BB-en-6-etapes-faciles-et-commencer-a-utiliser-gcconnex-aujourdhui'>6 étapes pour utiliser GCconnex</a> </li>
						<li> <a href='http://gcconnex.gc.ca/file/view/390515/en-managing-your-email-notifications-on-gcconnexpdf'>Gestion des avis par courriel</a> </li>
						</ul><br />

					<h3><u>Questions fréquemment posées</u></h3><br />
						<ul>
						<li>
						<h4>Mot de passe perdu:</h4>
						Pour récupérer votre <u>Mot de passe pour GCconnex</u>, allez sur la <a href='http://gcconnex.gc.ca/'>page d'accueil de GCconnex</a> ou cliquez dans la fenêtre contextuelle <u>Ouverture de session</u> qui se trouve dans le coin gauche supérieur de chaque page de GCconnex. Cliquez sur le lien <u>Mot de passe perdu</u> et saisissez votre nom d'utilisateur ou vous adresse de courriel, puis cliquez sur <u>Demande</u>. Un lien vous permettant de réinitialiser votre mot de passe sera envoyé à l'adresse de courriel associée à votre compte GCconnex. Suivez ce lien, puis cliquez sur <u>Réinitialiser mon mot de passe</u> pour qu'un nouveau mot de passe généré aléatoirement soit envoyé à votre adresse de courriel.
						<br /><br />
						Une fois que vous aurez ouvert une session avec le nouveau mot de passe, cliquez sur le lien <u>Paramètres</u> qui se trouve dans le coin droit supérieur de chaque page de GCconnex. Dans la section <u>Mot de passe du compte</u>, saisissez votre <u>Mot de passe actuel</u> (le mot de passe généré aléatoirement qui vous a été envoyé par courriel) et <u>Votre nouveau mot de passe</u> (le mot de passe que vous souhaitez utiliser désormais) deux fois, puis cliquez sur <u>Enregistrer</u>.
						</li> <br />

						<li>
						<h4>Nom d'utilisateur perdu :</h4>
						Si vous avez oublié votre <u>Nom d'utilisateur pour GCconnex</u>, ne vous en faites pas; il n'est pas nécessaire de le récupérer. Vous pouvez utiliser l'adresse de courriel associée à votre compte GCconnex pour ouvrir une session, soit sur la <a href='http://gcconnex.gc.ca/'>Page d'accueil de GCconnex</a> ou en allant dans la fenêtre contextuelle d'<u>Ouverture de session</u> dans le coin gauche supérieur de chaque page de GCconnex. 
						<br /><br />
						Toutefois, si vous avez changé d'adresse de courriel depuis que vous avez créé votre compte GCconnex, vous ne pouvez pas utiliser votre nouvelle adresse pour ouvrir une session à moins que vous ayez <a href='http://gcconnex.gc.ca/settings/'>mis à jour votre adresse de courriel dans vos paramètres</a>. Veuillez envoyer un courriel à <a href='mailto:gcconnex@tbs-sct.gc.ca'>gcconnex@tbs-sct.gc.ca</a> et indiquer que vous n'avez plus accès à l'adresse de courriel qui est associée à votre compte GCconnex. Nous vous répondrons dans les deux jours ouvrables qui suivent. 
						</li> <br />

						<li>
						<h4>Créer un compte :</h4>
						Rendez-vous sur <a href='http://gcconnex.gc.ca/'>GCconnex.gc.ca</a> et cliquez sur « Inscription » (sous « Ouvrir une session »). Vous pourrez alors saisir votre adresse de courriel du travail et choisir un mot de passe. Ensuite, lisez et acceptez les Conditions générales et cliquez sur « Inscription ». 
						</li> <br />

						<li>
						<h4>Télécharger une photo de profil :</h4>
						Cliquez sur l'icône de Profil dans le coin supérieur gauche (vous verrez soit votre photo de profil actuel ou une silhouette générique). Vous serez dirigé vers une autre page où vous pourrez « Modifier votre avatar ». Cliquez sur « Parcourir » et sélectionnez la photo que vous souhaitez utiliser, puis cliquez sur « Télécharger ». Vous pourrez ensuite cadrer votre photo (s'il y a lieu) en utilisant la section de prévisionnement.
						</li> <br />

						<li>
						<h4>Et plus encore… </h4>
						</li> <br />

						</ul> <br />

					<h3><u>Groupes GCconnex qui pourraient vous être utiles :</u></h3><br />
						<ul>
						<li> <a href=''>Clics et conseils</a> </li>
						<li> <a href='http://gcconnex.gc.ca/groups/profile/226392/gc20-tools-outils-gc20'>Outils GC2.0</a> </li>
						</ul>

				<h2 style='border-bottom: solid 3px; padding-bottom: 2px;'>Contactez-nous</h2>
					<p style = 'padding: 8px 0 8px'>
					Vous ne trouvez pas la réponse à votre question dans les Questions fréquemment posées ou les ressources d'aide? <br /> <br />
					<b>Communiquez avec le <a href='mailto:gcconnex@tbs-sct.gc.ca'>Soutien technique</a> de GCconnex!</b> Veuillez fournir le plus de détails possible lorsque vous décrirez votre problème ou question, et fournissez également des captures d'écran si possible.
					</p> <br />

						</div>",
        'contactform:reason' => 'Choisir...',
	);

	add_translation("fr",$french);