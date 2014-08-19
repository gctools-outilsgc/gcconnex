<?php
/**
 * Elgg header logo
 */
				
$site_logo = elgg_view('glee_theme_draft_one/output/site_logo');

if (!empty($site_logo)) {
    $content = <<<HTML
    <div class="glee-draft-one-logo">
    	$site_logo
    </div>
HTML;
}
else {				
    $site = elgg_get_site_entity();
    $site_name = $site->name;
    $site_description = $site->description;
    
    $site_url = elgg_get_site_url();
    
    $content = <<<HTML
    <h1>	
        <a class="elgg-heading-site" href="$site_url" style="color:inherit;">
            $site_name
        </a>
    </h1>
    <p>$site_description</p>
HTML;

}
echo $content;



