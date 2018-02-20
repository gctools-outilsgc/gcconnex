<?php
/**
 * Created by PhpStorm.
 * User: barndt
 * Date: 30/01/15
 * Time: 2:51 PM
 */

$french = array(
    //accessibility changes
    'profile:content:menu' => "Menu du contenu de l'utilisateur",
    'profile:content:to' => "à",
    'profile:content:for' => "pour",

    'temp:languages:disabled:message' => "<br />Nous sommes en train de re-travailler comment les compétences linguistiques apparaîtront dans les profils GCconnex.<br />Restez à l'écoute pour des mises à jour.",

    //edit profile message
    'profile:notsaved' => 'Not all information could be saved, empty fields are not allowed', /* NEW */
    'profile:title' => "%s's Profile", /* NEW */
    'profile:contactinfo' => 'Contact Info', /* NEW */

    //user Settings Details
    'item:object:MySkill' => 'Compétences inscrites dans le profil',
    'item:object:experience' => 'Expérience de travail inscrite dans le profil',
    'item:object:education' => 'Niveau d\'édudes inscrit dans le profil',

    //profile sidebar
    'gcprofile:nocoll' => '%s n\'a pris contact avec aucun de ses collègues pour l\'instant.',
    'gcprofile:nogroups' => '%s ne s\'est joint à aucun groupe pour l\'instant.',

    //Email Verification
    'gcc_profile:error' => "La modification n'a pas été sauvegardée : ",
    'gcc_profile:missingemail' => "Adresse de courriel manquante",
    'gcc_profile:notaccepted' => "Vous devez donner une adresse de courriel du Gouvernement du Canada",

    //MAIN PROFILE PAGE
    'gcconnex_profile:edit_profile' => 'Modifier',
    'gcconnex_profile:user_content' => 'Contenu personnel',
    'gcconnex_profile:profile:edit_avatar' => 'Modifier mon avatar',

    //MAIN PROFILE TABS
    'gcconnex_profile:profile' => 'Profil',
    'gcconnex_profile:widgets' => 'Widgets',
    'gcconnex_profile:portfolio' =>  'Portfolio',

    //PROFILE
    'gcconnex_profile:about_me' => 'À mon sujet',
    'gcconnex_profile:education' => 'Études',
    'gcconnex_profile:experience' => 'Expérience de travail',
    'gcconnex_profile:gc_skills' => 'Compétences',
    'gcconnex_profile:edit' => 'Modifier',
    'gcconnex_profile:cancel' => 'Annuler',
    'gcconnex_profile:save' => 'Sauvegarder',
    'gcconnex_profile:present' => 'Maintenant',
    'gcconnex_profile:about_me:empty' => 'Ajoutez des précisions à votre sujet en cliquant sur « Modifier » dans le coin supérieur droit de cette section.',
    'gcconnex_profile:about_me:access' => 'Accès aux renseignements à mon sujet ',
    'gcconnex_profile:optin:access' => "Ces informations seront utilisées pour la Plateforme de possibilités et ne seront pas visibles par les utilisateurs qui naviguent sur votre profil.",

    // BASIC PROFILE FORM
    'gcconnex_profile:basic:header' => 'Modifier le profil de base',
    'gcconnex_profile:basic:name' => 'Nom ',
    'gcconnex_profile:basic:job' => 'Titre ',
    'gcconnex_profile:basic:department' => 'Ministère ',
    'gcconnex_profile:basic:location' => 'Adresse ',
    'gcconnex_profile:basic:phone' => 'Téléphone ',
    'gcconnex_profile:basic:mobile' => 'Cellulaire ',
    'gcconnex_profile:basic:email' => 'Courriel ',
    'gcconnex_profile:basic:website' =>  'Site Web ',
    'gcconnex_profile:basic:micro_confirmation' => 'Les micro-affectations sont des affectations de courte durée publiées sur GCconnex et offertes à tous les fonctionnaires, sans égard à leur ministère. Elles sont de courte durée et de portée restreinte.<p>Avant de présenter votre candidature pour participer à des micro-affectations, vous devez d\'abord obtenir l\'autorisation de votre gestionnaire, puis cliquer sur la case à cocher ci-dessous.', //Micro affectation ou micro-mission?
    'gcconnex_profile:basic:micro_checkbox' => 'Je souhaite présenter ma candidature pour les micro-affectations.',
    'gcconnex_profile:basic:save' => 'Sauvegarder',

    // MONTHS
    'gcconnex_profile:month:january' => 'Janvier',
    'gcconnex_profile:month:february' => 'Février',
    'gcconnex_profile:month:march' => 'Mars',
    'gcconnex_profile:month:april' => 'Avril',
    'gcconnex_profile:month:may' => 'Mai',
    'gcconnex_profile:month:june' => 'Juin',
    'gcconnex_profile:month:july' => 'Juillet',
    'gcconnex_profile:month:august' => 'Août',
    'gcconnex_profile:month:september' => 'Septembre',
    'gcconnex_profile:month:october' => 'Octobre',
    'gcconnex_profile:month:november' => 'Novembre',
    'gcconnex_profile:month:december' => 'Décembre',

    // EDUCATION
    'gcconnex_profile:education:school' => 'Nom de l\'établissement ',
    'gcconnex_profile:education:start_month' => 'Mois de début ',
    'gcconnex_profile:education:start_year' => 'Année de début ',
    'gcconnex_profile:education:end_year' => 'Année de fin ',
    'gcconnex_profile:education:end_month' => 'Mois de fin ',
    'gcconnex_profile:education:ongoing' => 'J\'étudie encore dans cet établissement',
    'gcconnex_profile:education:degree' => 'Diplôme obtenu ',
    'gcconnex_profile:education:program' => 'Programme ',
    'gcconnex_profile:education:field' =>  'Domaine d\'études ',
    'gcconnex_profile:education:delete' => 'Supprimer cette entrée',
    'gcconnex_profile:education:add' => 'Ajouter d\'autres renseignements sur mes études',
    'gcconnex_profile:education:access' => 'Accès aux renseignements sur mes études ',
    'gcconnex_profile:education:present' => 'Maintenant',
    'gcconnex_profile:education:empty' => 'Ajoutez les renseignements sur vos études en cliquant sur « Modifier » dans le coin supérieur droit de cette section.',
    'gcconnex_profile:education:start' => 'Début',
    'gcconnex_profile:education:end' =>  'Fin',

    // WORK EXPERIENCE
    'gcconnex_profile:experience:organization' => 'Nom de l’organisation ',
    'gcconnex_profile:experience:title' => 'Titre ',
    'gcconnex_profile:experience:start_month' => 'Mois de début ',
    'gcconnex_profile:experience:year' => 'Année ',
    'gcconnex_profile:experience:end_month' => 'Mois de fin ',
    'gcconnex_profile:experience:ongoing' => 'J\'occupe encore ce poste',
    'gcconnex_profile:experience:responsibilities' => 'Responsabilités',
    'gcconnex_profile:experience:delete' =>  'Supprimer cette entrée',
    'gcconnex_profile:experience:add' => 'Ajouter d\'autres renseignements sur mon expérience de travail',
    'gcconnex_profile:experience:access' =>  'Accès aux renseignements sur mon expérience de travail ',
    'gcconnex_profile:experience:present' => 'Maintenant',
    'gcconnex_profile:experience:colleagues' =>  'Collègues ',
    'gcconnex_profile:experience:empty' => 'Ajoutez les renseignements sur votre expérience de travail en cliquant sur "Modifier" dans le coin supérieur droit de cette section.',
    'gcconnex_profile:experience:colleagues_empty' => 'Vous n\'avez inscrit aucun nom de collègue dans cette section.',
    'gcconnex_profile:experience:colleague_suggest' => 'Pour lier un ou une collègue à cette entrée, cette personne doit faire partie de votre liste de collègues GCconnex',

    // SKILLS
    'gcconnex_profile:gc_skill:add' => 'Ajouter une nouvelle compétence',
    'gcconnex_profile:gc_skill:delete' => 'Supprimer cette compétence',
    'gcconnex_profile:gc_skill:save' => 'Voulez-vous vraiment sauvegarder ces modifications? Toutes les recommandations relatives aux compétences que vous avez supprimées seront effacées de façon permanente.',
    'gcconnex_profile:gc_skill:empty' => 'Ajoutez les renseignements sur vos compétences en cliquant sur "Modifier" dans le coin supérieur droit de cette section.',
    'gcconnex_profile:gc_skill:endorse' => 'Valider',
    'gcconnex_profile:gc_skill:limit' => 'Vous pouvez ajouter un maximum de 15 compétences.',
    'gcconnex_profile:gc_skill:access' => 'Qui peut voir mes compétences',
    'gcconnex_profile:gc_skill:endorsement' => ' approbation',
    'gcconnex_profile:gc_skill:who' => 'Qui a approuvé cette compétence.',
    'gcconnex_profile:gc_skill:allendorse' => 'Voir toutes les mentions légales.',

    // leftover skills
    'gcconnex_profile:gc_skill:leftover' => 'Vous avez précédemment ajouté des compétences à votre profil GCconnex. Veuillez passer en revue les compétences ci-dessous et les verser dans ce nouveau gabarit, au besoin. Lorsque vous ajoutez des compétences à votre profil, assurez-vous qu\'il s\'agit de compétences que vous croyez réellement posséder, qu\'elles sont précises, qu\'ils s\'agit de comptéences professionnelles, et qu’elles permettent aux personnes qui consultent votre profil d’obtenir de l’information claire, utile et pertinente à votre sujet (essayez d’éviter les expressions comme « plein d’choses » et « accomplir plein de tâches »). ',
    'gcconnex_profile:gc_skill:stop_showing' => 'Ne plus afficher ce message',

    // LANGUAGES
    'gcconnex_profile:langs' => 'Langues',
    'gcconnex_profile:fol' => 'Première langue officiel',
    'gcconnex_profile:sle' => 'Évaluation de la langue seconde',
    'gcconnex_profile:languages:access' => 'Qui peut voir mes renseignements sur les langues : ',
    'gcconnex_profile:languages:language' => 'Langue :',
    'gcconnex_profile:languages:add' => 'Ajouter d\'autres langues',
    'gcconnex_profile:languages:delete' => 'Supprimer cette entrée',
    'gcconnex_profile:languages:empty' => 'Ajoutez les renseignements sur les langues en cliquant sur "Modifier" dans le coin supérieur droit de cette section.',
    'gcconnex_profile:languages:writtencomp' => 'Compréhension écrite',
    'gcconnex_profile:languages:writtenexp' => 'Expression écrite',
    'gcconnex_profile:languages:oral' => 'Compétence orale',
    'gcconnex_profile:languages:english' => 'Anglais',
    'gcconnex_profile:languages:ENG' => 'Anglais',
    'gcconnex_profile:languages:french' => 'Français',
    'gcconnex_profile:languages:FRA' => 'Français',
    'gcconnex_profile:languages:expiry' => 'Expiration',
    'gcconnex_profile:languages:level' => 'Level',

    // PORTFOLIO
    'gcconnex_profile:portfolio' => 'Portfolio',
    'gcconnex_profile:portfolio:empty' => 'Ajoutez des éléments à votre portfolio en cliquant sur le bouton « Modifier » dans le coin supérieur droit de cette section pour commencer à .',
    'gcconnex_profile:portfolio:access' => 'Accès aux renseignements de mon portfolio ',
    'gcconnex_profile:portfolio:add' => 'Ajouter une autre entrée au portfolio',
    'gcconnex_profile:portfolio:title' => 'Titre ',
    'gcconnex_profile:portfolio:link' => 'Hyperlien ',
    'gcconnex_profile:portfolio:publication_date' => 'Date de publication ',
    'gcconnex_profile:portfolio:datestamp' => 'Aucune date de publication',
    'gcconnex_profile:portfolio:description' => 'Description ',
    'gcconnex_profile:portfolio:delete' => 'Supprimer cette entrée',

/////////////// Opportunities
        // labels
        "gcconnex_profile:opt:opt-in" => "S'inscrire",
        "gcconnex_profile:opt:set_empty" => "Aucune option ont été sélectionnés.",
        "gcconnex_profile:opt:micro_mission" => "Micro-Mission",
        "gcconnex_profile:opt:job_swap" => "Échange d'emploi",
        "gcconnex_profile:opt:mentored" => "Mentoré",
        "gcconnex_profile:opt:mentoring" => "Mentor",
        "gcconnex_profile:opt:shadowed" => "Observé",
        "gcconnex_profile:opt:shadowing" => "Observateur",
        "gcconnex_profile:opt:peer_coached" => "Pair entraîné",
        "gcconnex_profile:opt:peer_coaching" => "Pair entraineur",
        "gcconnex_profile:opt:opt_in_access" => "Qui peut voir mes choix d'inscription :",
        "gcconnex_profile:opt:yes"=> "Oui",
        "gcconnex_profile:opt:no" => "Non",
        "gcconnex_profile:completed_missions" => "Possibilités complètés grâce à la plateforme de ConneXions carrière",
        "gcconnex_profile:opt:skill_sharing" => "Partage des habiletés",
        "gcconnex_profile:opt:job_sharing" => "Partage d'emploi",

        // opportunity types opt-in
            // at-level
    "gcconnex_profile:opt:atlevel"=>"Mobilité au même niveau",
        "gcconnex_profile:opt:assignment_deployment_seek" => "Détachements / Affectations participant",
        "gcconnex_profile:opt:assignment_deployment_create" => "Détachements / Affectations hôte",
        "gcconnex_profile:opt:deployment_seek" => "Mutation participant",
        "gcconnex_profile:opt:deployment_create" => "Mutation hôte",
        "gcconnex_profile:opt:job_swap" => "Échange d'emploi",
        "gcconnex_profile:opt:job_rotate" => "Rotation d'emploi",

            // Developmental
        "gcconnex_profile:opt:micro_missionseek" => "Micro-Mission participant",
        "gcconnex_profile:opt:micro_mission" => "Micro-Mission hôte",
        "gcconnex_profile:opt:shadowing" => "Observation au poste de travail participant",
        "gcconnex_profile:opt:shadowed" => "Observation au poste de travail hôte",
        "gcconnex_profile:opt:mentored" => "Mentoré",
        "gcconnex_profile:opt:mentoring" => "Mentor",
        'gcconnex_profile:opt:seeking' => 'Recherche',
        'gcconnex_profile:opt:offering' => 'Offre',
        'gcconnex_profile:opt:casual_seek' => 'Emploi occasionnel participant',
        'gcconnex_profile:opt:casual_create' => 'Emploi occasionnel hôte',
        'gcconnex_profile:opt:student_seek' => 'Intégration des étudiants participant',
        'gcconnex_profile:opt:student_create' => 'Intégration des étudiants hôte',    
        "gcconnex_profile:opt:job_sharing" => "Partage d'emploi",
        "gcconnex_profile:opt:peer_coached" => "Pair entraîné",
        "gcconnex_profile:opt:peer_coaching" => "Pair entraineur",
        "gcconnex_profile:opt:skill_sharing" => "Partage des habiletés participant",
        "gcconnex_profile:opt:skill_sharing_create" => "Partage des habiletés hôte",
            "gcconnex_profile:opt:participants"=>"Participant",
        "gcconnex_profile:opt:host"=>"Hôte",
    
    "gcconnex_profile:opt:development"=>"Possibilités de perfectionnement professionnel",
        
        // SEPARATION
        
        "gcconnex_profile:opportunities" => "Opportunités",
        "gcconnex_profile:hide" => "Cacher",
        "gcconnex_profile:confirm:hide" => "Cacher ce Micro-Mission signifie qu'il ne sera plus visible sous 'Possibilités complètés grâce à la plateforme de ConneXions carrière' dans votre profil et cette opération ne peut pas être inversée.",
        "gcconnex_profile:show" => "Montrer"

);

add_translation("fr",$french);
