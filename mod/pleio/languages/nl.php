<?php
$nl = array(
    "admin:server:pleio_template:env" => "Omgeving",
    "pleio_template:type" => "Type",
    "pleio_template:send_mail" => "Verstuur mail",
    "admin:users:access_requests" => "Aanvragen voor lidmaatschap",
    "admin:users:import" => "Importeer gebruikers",
    "pleio:site_permission" => "Toegangsniveau voor de site:",
    "pleio:not_configured" => "De Pleio login plugin is niet geconfigureerd.",
    "pleio:registration_disabled" => "Registratie is gedeactiveerd. Maak een account aan op Pleio.",
    "pleio:walled_garden" => "Welkom op %s",
    "pleio:walled_garden_description" => "Toegang tot deze site is gelimiteerd tot geautoriseerde gebruikers. Log in om toegang te krijgen of toegang aan te vragen.",
    "pleio:request_access" => "Toegang aanvragen",
    "pleio:request_access:description" => "Om toegang tot deze site te krijgen dient u toestemming te hebben van de beheerder. Vraag toestemming aan door op de knop hieronder te drukken.",
    "pleio:validate_access" => "Toegang valideren",
    "pleio:validate_access:description" => "Met jouw e-mailadres krijg je direct toegang tot deze website. Controleer je gegevens en vraag toegang aan. Je ontvangt een e-mail waarmee je direct toegang krijgt tot de site.",
    "pleio:validate_access:error" => "Er is iets mis gegaan tijdens het valideren. Probeer het opnieuw.",
    "pleio:change_settings" => "Instellingen aanpassen",
    "pleio:change_settings:description" => "Om instellingen aan te passen, ga naar %s. Wanneer je de instellingen hebt aangepast, log opnieuw in om de wijzigingen door te voeren.",
    "pleio:access_requested" => "Toegang is aangevraagd",
    "pleio:could_not_find" => "Kan het toegangsverzoek niet vinden.",
    "pleio:access_requested:wait_for_approval" => "De toegang is aangevraagd. Je ontvangt een e-mail wanneer de toegang door de beheerder wordt toegewezen.",
    "pleio:access_requested:check_email" => "Controleer je e-mail en volg de link om je account direct te activeren.",
    "pleio:no_requests" => "Er zijn momenteel geen aanvragen.",
    "pleio:approve" => "Goedkeuren",
    "pleio:decline" => "Afwijzen",
    "pleio:settings:notifications_for_access_request" => "Stuur alle beheerders een notificatie wanneer iemand toegang aanvraagt voor de deelsite",
    "pleio:admin:access_request:subject" => "Nieuwe toegangsaanvraag voor %s",
    "pleio:admin:access_request:body" => "Beste %s,
        %s heeft toegang aangevraagd tot %s.
        Ga naar de volgende link om de aanvraag af te handelen:

        %s",
    "pleio:approved:subject" => "Je hebt nu toegang tot: %s",
    "pleio:approved:body" => "Beste %s,

    De beheerder heeft het verzoek tot lidmaatschap goedgekeurd. Je hebt nu toegang tot %s. Volg de onderstaande link om direct naar de site te gaan:

    %s",
    "pleio:declined:subject" => "Lidmaatschapsverzoek afgewezen voor: %s",
    "pleio:declined:body" => "Beste %s,

Helaas heeft de site-beheerder van %s je lidmaatschapsverzoek afgewezen. Indien je denkt dat dit een vergissing is neem dan contact op met de site-beheerder.",
    "pleio:closed" => "Gesloten",
    "pleio:open" => "Open",
    "pleio:settings:email_from" => "Wanneer dit niet ingesteld is, wordt mail verstuurd vanaf %s.",
    "pleio:settings:authorization" => "Autorisatie",
    "pleio:settings:auth" => "Type autorisatie",
    "pleio:settings:oauth" => "OAuth2",
    "pleio:settings:oidc" => "OpenID Connect",
    "pleio:settings:auth_url" => "Autorisatie-uitgever URL",
    "pleio:settings:auth_client" => "Cliënt ID",
    "pleio:settings:auth_secret" => "Cliënt geheim",
    "pleio:settings:idp" => "SAML2 Identity Provider",
    "pleio:settings:idp_id" => "Wanneer SAML2 inloggen gebruikt wordt, vul hier de unieke ID van de SAML2 Identity Provider in",
    "pleio:settings:idp_name" => "Identity Provider weergavenaam",
    "pleio:settings:additional_settings" => "Aanvullende instellingen",
    "pleio:settings:login_through" => "Inloggen via %s",
    "pleio:settings:login_credentials" => "Maak het ook mogelijk om in te loggen met gebruikersnaam en wachtwoord",
    "pleio:settings:walled_garden_description" => "Beschrijving op de loginpagina (bij een gesloten site)",
    "pleio:login_with_credentials" => "Of, log in met Pleio gebruikersnaam en wachtwoord",
    "pleio:is_banned" => "Helaas, je account is geblokkeerd. Neem contact op met de deelsitebeheerder.",
    "pleio:imported" => "%s gebruikers zijn aangemaakt, %s gebruikers zijn vernieuwd. Er was een probleem met het importeren van %s gebruikers.",
    "pleio:users_import:step1:description" => "Met deze functionaliteit kun je gebruikers importeren door middel van een CSV bestand. Kies het CSV bestand in de eerste stap. Het CSV bestand dient een kopregel te bevatten met de veldnamen. Zorg er verder voor dat de velden gescheiden zijn door een puntkomma ;. Het toegangsniveau van de site zal ingesteld worden op het standaard site toegangsniveau. Zorg verder dat het CSV bestand geencodeerd is met het formaat UTF-8.",
    "pleio:users_import:step1:file" => "CSV-bestand",
    "pleio:continue" => "Ga naar de volgende stap",
    "pleio:users_import:step1:success" => "CSV-bestand succesvol ingelezen.",
    "pleio:users_import:step1:error" => "Er is een fout opgetreden tijdens het lezen van het CSV-bestand. Controleer het bestand en probeer het opnieuw.",
    "pleio:users_import:choose_field" => "Kies een veld",
    "pleio:users_import:source_field" => "Bronveld",
    "pleio:users_import:target_field" => "Doelveld",
    "pleio:users_import:step2:description" => "Link nu de bronvelden uit het CSV-bestand aan de doelvelden in dit platform. Wanneer je niet bestaande gebruikers zou willen aanmaken, zorg er dan voor dat er tenminste een voor- en achternaam en emailadres aanwezig is. Wanneer deze velden niet geselecteerd worden, zullen alleen reeds bestaande accounts vernieuwd worden. Het systeem controleert of een gebruiker reeds bestaat door eerst te kijken naar het guid veld, daarna naar de gebruikersnaam en daarna naar het e-mailadres.",
    "pleio:users_import:sample" => "voorbeeld",
    "pleio:users_import:started_in_background" => "De import is op de achtergrond gestart. Je ontvangt een mail bij afronding.",
    "pleio:users_import:email:success:subject" => "Import afgerond",
    "pleio:users_import:email:success:body" => "Beste %s,

    Het importeren van gebruikers is geslaagd. Hier zijn de statistieken:

    %s gebruikers toegevoegd
    %s gebruikers vernieuwd
    %s gebruikers mislukt
    ",
    "pleio:users_import:email:failed:subject" => "Import mislukt",
    "pleio:users_import:email:failed:body" => "Beste %s,

    Het importeren van gebruikers is mislukt. Hier is de foutmelding van de server:

    %s
    ",
    "profile:gender" => "Geslacht",
    "pleio:settings:domain_whitelist" => "Geef deze domeinen direct toegang tot de site",
    "pleio:settings:domain_whitelist:explanation" => "Je kunt hier een komma-gescheiden lijst toevoegen, bijv. voorbeeld.nl, voorbeeld2.nl",
    "pleio:validation_email:subject" => "Valideer je e-mailadres voor %s",
    "pleio:validation_email:body" => "Beste %s,

    Je hebt toegang aangevraagd voor %s. Volg deze link om direct toegang te krijgen:

    %s",
    "pleio:no_token_available" => "Geen token beschikbaar. Log opnieuw in en probeer het nogmaals."
);

add_translation("nl", $nl);