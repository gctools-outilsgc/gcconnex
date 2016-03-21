<?php
    $german = array(
        'friend_request' => "Freundschaftsanfrage",
        'friend_request:menu' => "Freundschaftsanfragen",
        'friend_request:title' => "Freundschaftsanfragen für: %s",
   
        'friend_request:new' => "Neue Freundschaftsanfrage",
       
        'friend_request:friend:add:pending' => "Ausstehende Freundschaftsanfragen",
       
        'friend_request:newfriend:subject' => "%s möchte mit dir befreundet sein!",
        'friend_request:newfriend:body' => "%s möchte mit dir befreundet sein und wartet auf deine Bestätigung! Logge dich jetzt ein um die Anfrage zu Bestätigen!

Du kannst ausstehende Freundschaftsanfragen hier (Stelle sicher, dass du eingeloggt bist, bevor du auf den folgenden Link klickst, ansonsten wirst du nur zum Login weitergeleitet.):

%s

(Diese Email kann nicht beantwortet werden.)",
       
        // Actions
        // Anfragen
        'friend_request:add:failure' => "Sorry, aufgrund eines Systemfehlers konnte deine Freundschaftsanfragen nicht abgeschlossen werden. Bitte versuche es erneut.",
        'friend_request:add:successful' => "Du hast %s eine Freundschaftsanfrage gesendet. Die Freundschaftsanfrage muss erst bestätigt werden, bevor sie/er deiner Freundesliste hinzugefügt wird.",
        'friend_request:add:exists' => "Du hast %s bereits eine Freundschaftsanfrage gesendet.",
       
        // Bestätigte Anfragen
        'friend_request:approve' => "Bestätigen",
        'friend_request:approve:successful' => "%s ist nun mit dir befreundet",
        'friend_request:approve:fail' => "Während des anfreundens mit %s ist ein Fehler aufgetreten",
   
        // Abgelehnte Anfragen
        'friend_request:decline' => "Ablehnen",
        'friend_request:decline:subject' => "%s hat deine Freundschaftsanfrage abgelehnt",
        'friend_request:decline:message' => "Liebe/r %s,

%s hat deine Freundschaftsanfrage abgelehnt.",
        'friend_request:decline:success' => "Freundschaftsanfrage abgelehnt",
        'friend_request:decline:fail' => "Während der Ablehnung der Freundschaftsanfrage ist ein Fehler aufgetreten. Bitte versuche es erneut.",
       
        // Widerrufene Anfragen
        'friend_request:revoke' => "Widerrufen",
        'friend_request:revoke:success' => "Die Freundschaftsanfragen wurde widerrufen",
        'friend_request:revoke:fail' => "Während des Widerrufs der Freundschaftsanfrage ist ein Fehler aufgetreten. Bitte versuche es erneut.",
   
        // Views
        // Empfangen
        'friend_request:received:title' => "Empfangene Freundschaftsanfragen",
        'friend_request:received:none' => "Es warten keine ausstehenden Freundschaftsanfragen auf Bestätigung.",
   
        // Gesendet
        'friend_request:sent:title' => "Gesendete Freundschaftsanfragen",
        'friend_request:sent:none' => "Es stehen keine gesendete Freundschaftsanfragen aus",
    );
                   
    add_translation("de", $german);
