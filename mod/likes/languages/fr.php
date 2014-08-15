<?php
/**
 * Likes French language file
 */

$french = array(
	'likes:this' => "J'aime",
	'likes:deleted' => 'Votre aime a été supprimé',
	'likes:see' => 'Voir qui aime',
	'likes:remove' => "Je n'aime plus",
	'likes:notdeleted' => 'Il y avait un problème de enlevant l\'aime',
	'likes:likes' => 'Vous aimez cet item maintenant',
	'likes:failure' => 'Il y avait un problème aimer cet item',
	'likes:alreadyliked' => 'Vous avez déjà aime item',
	'likes:notfound' => 'L\'item que vous essayez d\'aimer ne peut être trouvé.',
	'likes:likethis' => "J'aime",
	'likes:userlikedthis' => '%s aime',
	'likes:userslikedthis' => '%s aime',
	'likes:river:annotate' => 'aime',
	'likes:delete:confirm' => 'Etes-vous sûr que vous voulez n\'aimez cela?',

	'river:likes' => "J'aime %s %s",

	// notifications. yikes.
	'likes:notifications:subject' => '%s aime votre message "%s"',
	'likes:notifications:body' =>
'Salut %1$s,

%2$s aime votre message "%3$s" sur %4$s

Consultez votre message original ici:

%5$s

ou consultez le profile de %2$s ici:

%6$s

Merci,
%4$s
',
	
);

add_translation('fr', $french);
