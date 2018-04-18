<?php
/**
  * Creates a splash page for GCcollab for users to check language.
  */

$site_url = elgg_get_site_url();
$jsLocation = $site_url . "mod/wet4/views/default/js/wet-boew.js";
$termsLink = $site_url .'terms';
$loginLink = $site_url .'login';
$toggle_lang = $site_url .'mod/toggle_language/action/toggle_language/toggle';
$gccollab_text = elgg_echo('wet:login_welcome');
$register_text_en = elgg_echo('gcRegister:welcome_message', 'en');
$register_text_fr = elgg_echo('gcRegister:welcome_message', 'fr');

if( _elgg_services()->session->get('language') == 'fr'){
    $graphic_lang = 'fr';
} else {
    $graphic_lang = 'en';
}

//Create The body of the splash
//Add the toggle language JS to the page to set lang
//Page forwards to login with users selected language
$body .= <<<__BODY
<div class="splash">
<div id="bg" style="background: url($site_url/mod/gc_splash_page_collab/graphics/Peyto_Lake-Banff_NP-Canada.jpg) no-repeat center center fixed; background-size: cover;">
</div>
<main role="main">
	<script type="text/javascript">
		function form_submit(lang) {
			set_cookie("gccollab_lang", lang);
			parent.location.href = "$loginLink";
		}

		function set_cookie(name, value) {
			var today = new Date();
			today.setTime(today.getTime());
			expires = 1000 * 60 * 60 * 24;
			var expires_date = new Date( today.getTime() + (expires) );
			document.cookie = name + "=" + escape(value) + ";path=/" + ";expires=" + expires_date.toGMTString() + ";domain=.gccollab.ca;";
		}
	</script>

<div class="sp-hb">
<div class="sp-bx col-xs-12">
<h1 property="name" class="wb-inv">$gccollab_text</h1>
<div class="row">
<div class="col-xs-11 col-md-8">
<object type="image/svg+xml" tabindex="-1" role="img" data="$site_url/mod/wet4_collab/graphics/sig-blk-$graphic_lang.svg" width="283" aria-label="Government of Canada / Gouvernement du Canada"></object>
</div>
</div>
<div class="row">
<section class="col-xs-6 text-right">
<h2 class="wb-inv">GCcollab English</h2>
<p><a href="#" onclick="form_submit('en')" class="btn btn-primary">English</a></p>
</section>
<section class="col-xs-6" lang="fr">
<h2 class="wb-inv">GCcollab Français</h2>
<p><a href="#" onclick="form_submit('fr')" class="btn btn-primary">Fran&#231;ais</a></p>
</section>

<form action="$toggle_lang" method="post" id="formtoggle">

		<?php
		// security tokens.
		echo elgg_view('input/securitytoken');
		?>
		</form>
</div>
<div class="row">
<div class="accordion">
	<details class="acc-group">
		<summary class="wb-toggle tgl-tab" data-toggle='{"parent": ".accordion", "group": ".acc-group"}'>Who can register?</summary>
		<div class="tgl-panel">
             <div class='mrgn-lft-md mrgn-tp-md mrgn-bttn-md mrgn-rght-md'>
        		$register_text_en
            </div>
		</div>
	</details>
	<details class="acc-group">
		<summary class="wb-toggle tgl-tab" data-toggle='{"parent": ".accordion", "group": ".acc-group"}'>Qui peut s'inscrire?</summary>
		<div class="tgl-panel">
             <div class='mrgn-lft-md mrgn-tp-md mrgn-bttn-md mrgn-rght-md'>
    			$register_text_fr
            </div>
		</div>
	</details>
</div>
</div>
</div>
<div class="sp-bx-bt col-xs-12">
<div class="row">
<div class="col-xs-7 col-md-8">
<a href="$termsLink " class="sp-lk">Terms & Conditions of Use</a> <span class="glyphicon glyphicon-asterisk"></span> <a href="/termes" class="sp-lk" lang="fr">Conditions d'utilisation</a>
</div>
<div class="col-xs-5 col-md-4 text-right mrgn-bttm-md">
<object type="image/svg+xml" tabindex="-1" role="img" data="$site_url/mod/gccollab_theme/graphics/wmms-blk.svg" width="127" aria-label="Symbol of the Government of Canada / Symbole du gouvernement du Canada"></object>
</div>
</div>
</div>
</div>
    <div class="splash_identifier wb-inv"><span class="bold-gc">GC</span>collab</div>
</main>
<div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="$jsLocation"></script>

</div>
__BODY;

$body .= elgg_view('page/elements/foot');

$head = elgg_view('page/elements/head', array(
    'title' => elgg_get_site_entity()->name,
));

$params = array(
	'head' => $head,
	'body' => $body,
);

//Create Page
echo elgg_view("page/elements/html", $params);
?>
