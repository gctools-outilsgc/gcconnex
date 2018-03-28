<?php

$wgExtensionCredits['parserhook'][] = array(
  'name'=>'NRC - Recommendations',
  'url'=>'http://www.nrc.gc.ca',
  'author'=>'Luc Belliveau',
  'description'=>'Recommendation extension based on engines provided by the National Research Council.',
  'version'=>'0.0.1'
);
$wgHooks['OutputPageBeforeHTML'][] = 'RecommendationsInit';

function RecommendationsInit($article, &$text) {
  global $wgTitle, $wgUser;

  $loggedIn = $wgUser->mId != 0;
  $email = str_replace("'", "\\'", $wgUser->mEmail);
  if (strpos($email, "\n") !== false) return false;

  $articleId = $wgTitle->mArticleID;
  $context_obj1 = '';
  if ($articleId == 1) {
    if ($loggedIn) {
      $context = 'article_c1';
    } else {
      $context = 'article_c2';
    }
  } else {
    $context_obj1 = $articleId;
    if ($loggedIn) {
      $context = 'article_c3';
    } else {
      $context = 'article_c4';
    }
  }

  /**
   * Automatically get the user's GCconnex GUID, solely based on email.
   *
   * TODO: This must be replaced by SSO.
   */
  $login_context = 'false';
  if ($loggedIn && !isset($_SESSION['GCconnex_GUID'])) {
    $cx = stream_context_create([
      'http'=> [
        'proxy'=>'tcp://proxy.paz.nrc.gc.ca:8080',
        'request_fulluri' => true,
      ],
      // 'https'=>['proxy'=>'proxy.paz.nrc.gc.ca:8080'],
    ]);

    $searchUrl = "http://intranet.canada.ca/search-recherche";
    $query = "query-recherche-eng.aspx?a=s&s=3&chk4=on";
    $encodedEmail = urlencode($email);
    $data = file_get_contents("$searchUrl/$query&q=$encodedEmail", False, $cx);
    $re = '/https:\/\/gcconnex.gc.ca\/profile\/(.*?)"/';
    if (preg_match($re, $data, $m) === 1) {
      $gcconnex_username = $m[1];
      $profile_url = "https://gcconnex.gc.ca/profile/$gcconnex_username";
      $profileData = file_get_contents($profile_url, False, $cx);
      $re = '/"guid":(.*?),/';
      if (preg_match($re, $profileData, $pm)) {
        $_SESSION['GCconnex_GUID'] = $pm[1];
        $login_context = 'true';
      }
    }
  }

  if ($loggedIn) {
    $gcconnex_guid = str_replace("'", "\\'", $_SESSION['GCconnex_GUID']);
    if (strpos($gcconnex_guid, "\n") !== false) return false;
  }

  $script = <<<DOC
<style>
  .nrcRecommendationContainer {
    overflow: hidden;
    padding-top: 10px;
  }
  .nrcRecommendationContainer:hover {
    overflow: visible;
  }
  .nrcRecommendationContainer div.fieldset-container {
    border: 1px solid #000;
    background-color: #eee;
    width: 500px;
    z-index: 1;
    position: relative;
  }
</style>
<link rel="stylesheet" type="text/css" href="/extensions/NRC_Recommendations/static/css/main.css">
<script type="text/javascript">
  var NRC_context = {
    context: '$context',
    context_obj1: '$context_obj1',
    email: '$email',
    gcconnex_guid: '$gcconnex_guid',
    login_context: $login_context,
  }
</script>
<script src="/extensions/NRC_Recommendations/gcpedia.js"></script>
DOC;

  $text = $text . "\n\n" .$script;
  return true;
}
