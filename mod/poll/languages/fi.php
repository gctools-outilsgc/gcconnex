<?php

return array(

	/**
	 * Menu items and titles
	 */
	'poll' => "Kyselyt",
	'poll:add' => "Uusi kysely",
	'poll:group_poll' => "Ryhmän kyselyt",
	'poll:group_poll:listing:title' => "Käyttäjän %s kyselyt",
	'poll:your' => "Omat kyselysi",
	'poll:not_me' => "Käyttäjän %s kyselyt",
	'poll:friends' => "Ystäviesi kyselyt",
	'poll:addpost' => "Luo uusi kysely",
	'poll:editpost' => "Muokkaa kyselyä: %s",
	'poll:edit' => "Muokkaa kyselyä",
	'item:object:poll' => 'Kyselyt',
	'item:object:poll_choice' => "Vaihtoehdot",
	'poll:question' => "Kyselyn nimi",
	'poll:description' => "Kuvaus",
	'poll:responses' => "Vastausvaihtoehdot",
	'poll:note_responses' => "HUOM! Vaihtoehtojen muokkaaminen jälkikäteen poistaa kaikki kyselyyn tulleet vastaukset.",
	'poll:result:label' => "%s (%s)",
	'poll:show_results' => "Näytä tulokset",
	'poll:show_poll' => "Näytä kysely",
	'poll:add_choice' => "Lisää uusi vaihtoehto",
	'poll:delete_choice' => "Poista tämä vaihtoehto",
	'poll:close_date' => "Kyselyn päättymispäivä",
	'poll:voting_ended' => "Äänestys sulkeutui %s.",
	'poll:poll_closing_date' => "(Kyselyn sulkeutumisajankohta: %s)",
	'poll:poll_reset' => "Nollaa vastaukset",
	'poll:poll_reset_description' => "Poista kaikki kyselyyn tulleet vastaukset.",
	'poll:poll_reset_confirmation' => "Haluatko varmasti poistaa kaikki tallennetut vastaukset?",

	'poll:convert:description' => 'VAROITUS: Löydettiin %s kyselyä, jotka eivät ole yhteensopivia nykyisen version kanssa.',
	'poll:convert' => 'Päivitä kyselyt',
	'poll:convert:confirm' => 'Päivitystä ei voi perua. Haluatko varmasti päivittää kyselyt?',

	'poll:settings:notification_on_vote:title' => "Ilmoita kyselyn tekijälle, kun joku vastaa kyselyyn",
	'poll:settings:notification_on_vote:desc' => "Ilmoitusten lähettämiseen käytetään tekijän omia henkilökohtaisia ilmoitusasetuksia.",
	'poll:settings:group:title' => "Salli ryhmien kyselyt",
	'poll:settings:group_poll_default' => "Kyllä",
	'poll:settings:group_poll_not_default' => "Ei",
	'poll:settings:no' => "Ei",
	'poll:settings:group_access:title' => "Kuva voi luoda kyselyitä ryhmiin",
	'poll:settings:group_access:admins' => "Ryhmien omistajat sekä sivuston ylläpitäjät",
	'poll:settings:group_access:members' => "Ryhmän jäsenet",
	'poll:settings:front_page:title' => 'Ota käyttöön mahdollisuus tehdä kyselystä "Päivän kysely"',
	'poll:settings:front_page:desc' => '(Vaatii Widget manager -pluginin.)',
	'poll:settings:allow_close_date:title' => "Ota käyttöön kyselyn sulkeutumispäivä",
	'poll:settings:allow_close_date:desc' => "Äänestäminen estetään, mutta tuloksiin pääsee käsiksi myös jälkikäteen",
	'poll:settings:allow_open_poll:title' => "Ota käyttöön avoimet kyselyt",
	'poll:settings:allow_open_poll:desc' => "Avoimet kyselyt näyttävät, kuka on äänestänyt mitäkin vaihtoehtoa.",
	'poll:settings:allow_poll_reset:title' => "Ota käyttöön vastausten nollaaminen",
	'poll:settings:allow_poll_reset:desc' => "Tämä sallii kyselyn omistajan poistaa kaikki kyselyyn tulleet äänet.",
	'poll:settings:multiple_answer_polls:title' => "Ota käyttöön useiden vaihtoehtojen äänestäminen",
	'poll:settings:multiple_answer_polls:desc' => "Tämä sallii kyselyn tekijän määrittää, montaako eri vaihtoehtoa on mahdollista äänestää.",
	'poll:none' => "Ei kyselyitä",
	'poll:not_found' => "Kyselyä ei löytynyt",
	'poll:permission_error' => "Sinulla ei ole oikeuksia tämän kyselyn muokkaamiseen",
	'poll:vote' => "Vastaa",
	'poll:login' => "Kirjaudu sisään vastataksesi tähän kyselyyn",
	'group:poll:empty' => "Ei kyselyitä",
	'poll:settings:site_access:title' => "Kuka voi luoda sivustonlaajuisia kyselyitä",
	'poll:settings:site_access:admins' => "Vain ylläpitäjät",
	'poll:settings:site_access:all' => "Sisäänkirjautuneet käyttäjät",
	'poll:can_not_create' => "Sinulla ei ole oikeuksia luoda uutta kyselyä",
	'poll:front_page_label' => 'Tee tästä "Päivän kysely"',
	'poll:open_poll_label' => "Näytä tuloksien yhteydessä, kuka on vastannut mihinkin kysymykseen",
	'poll:show_voters' => "Näytä vastaajat",
	'poll:max_votes:label' => "Äänten maksimimäärä",
	'poll:max_votes:desc' => "Määrittää, montaako eri vaihtoehtoa henkilö voi äänestää",
	'poll:max_votes:exceeded' => "Äänten maksimimäärä ei voi ylittää vaihtoehtojen määrää",
	'poll:max_votes:info' => "Voit äänestää %s vaihtoehtoa",
	'poll:max_votes:not_allowed_hint' => "HUOMIO: Sivuston ylläpitäjä on ottanut pois käytöstä mahdollisuuden äänestää useampaa kuin yhtä vastausvaihtoehtoa. Tämä kysely sallii tällä hetkellä %s kpl vastauksia. Jos muokkaat vastausvaihtoehtoja, vastausten maksimimäärän arvoksi nollautuu 1 kpl.",

	/**
	 * Poll widget
	 */
	'poll:latest_widget_title' => "Uusimmat kyselyt",
	'poll:latest_widget_description' => "Näyttää sivuston viimeisimmät kyselyt",
	'poll:latestgroup_widget_title' => "Ryhmän uusimmat kyselyt",
	'poll:latestgroup_widget_description' => "Näyttää ryhmän viimeisimmät kyselyt",
	'poll:my_widget_title' => "Omat kyselyni",
	'poll:my_widget_description' => "Näyttää omat kyselysi",
	'poll:widget:label:displaynum' => "Näytettävien kyselyiden määrä",
	'poll:individual' => "Päivän kysely",
	'poll_individual:widget:description' => "Näyttää päivän kyselyn",
	'poll:widget:no_poll' => "%s ei ole vielä luonut kyselyitä.",
	'poll:widget:nonefound' => "Ei kyselyitä.",
	'poll:widget:think' => "Vastaa käyttäjän %s kyselyihin!",
	'poll:enable_poll' => "Ota käytöön ryhmän kyselyt",
	'poll:noun_response' => "ääni",
	'poll:noun_responses' => "ääntä",
	'poll:settings:yes' => "Kyllä",
	'poll:settings:no' => "Ei",

	'poll:month:01' => 'Tammikuuta',
	'poll:month:02' => 'Helmikuuta',
	'poll:month:03' => 'Maaliskuuta',
	'poll:month:04' => 'Huhtikuuta',
	'poll:month:05' => 'Toukokuuta',
	'poll:month:06' => 'Kesäkuuta',
	'poll:month:07' => 'Heinäkuuta',
	'poll:month:08' => 'Elokuuta',
	'poll:month:09' => 'Syyskuuta',
	'poll:month:10' => 'Lokakuuta',
	'poll:month:11' => 'Marraskuuta',
	'poll:month:12' => 'Joulukuuta',

	/**
	 * Notifications
	 */
	'poll:new' => 'Uusi kysely',
	'poll:notify:summary' => 'Uusi kysely: %s',
	'poll:notify:subject' => 'Uusi kysely: %s',
	'poll:notify:body' => '%s on luonut uuden kyselyn: %s

Vastaa kyselyyn täällä: %s
',
	'poll:notification_on_vote:subject' => "Uusi ääni kyselyssä",
	'poll:notification_on_vote:body' => 'Hei %s

Kyselyssäsi "%s" on uusi ääni.

Pääset käsiksi kyselyn tuloksiin tästä:
%s',

	/**
	 * Poll river
	 */
	'poll:settings:create_in_river:title' => "Näytä uudet kyselyt toimintalistauksessa",
	'poll:settings:vote_in_river:title' => "Näytä yksittäiset äänet toimintalistauksessa",
	'poll:settings:send_notification:title' => "Ota käyttöön ilmoitukset uusista kyselyistä",
	'poll:settings:send_notification:desc' => "Ilmoitusten lähettämiseen käytetään jäsenten henkilökohtaisia ilmoitusasetuksia.",
	'river:create:object:poll' => '%s loi kyselyn %s',
	'river:update:object:poll' => '%s päivitti kyselyn %s',
	'river:vote:object:poll' => '%s vastasi kyselyyn %s',
	'river:comment:object:poll' => '%s kommentoi kyselyä %s',

	/**
	 * Status messages
	 */
	'poll:added' => "Lisättiin uusi kysely",
	'poll:edited' => "Kysely tallennettu",
	'poll:responded' => "Ääni tallennettu. Kiitos vastauksestasi.",
	'poll:deleted' => "Kysely poistettu",
	'poll:totalvotes' => "Vastausten kokonaismäärä: %s",
	'poll:voted' => "Ääni tallennettu. Kiitos vastauksestasi.",
	'poll:poll_reset_success' => "Kysely nollattu",
	'poll:upgrade' => 'Päivitä',
	'poll:upgrade:success' => 'Päivitettiin kysely-liitännäinen',

	/**
	 * Error messages
	 */
	'poll:blank' => "Syötä vähintään nimi sekä yksi vastausvaihtoehto",
	'poll:novote' => "Valitse jokin vastausvaihtoehdoista",
	'poll:alreadyvoted' => "Olet vastannut tähän kyselyyn jo aiemmin",
	'poll:notfound' => "Kyselyä ei löytynyt",
	'poll:notdeleted' => "Kyselyn poistaminen epäonnistui",
	'poll:poll_reset_denied' => "Sinulla ei ole oikeuksia tämän kyselyn nollaamiseen",
);