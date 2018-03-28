<?php
/*
 * Recommendations interface library
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2018
 */
?>
<?php
namespace NRC_RECOMMENDATIONS;

elgg_register_event_handler('init', 'system', 'NRC_RECOMMENDATIONS\init');

function init() {

  elgg_define_js('react', [
    'src' => '/mod/nrc_recommendations/node_modules/react/umd/react.development.js',
  ]);
  elgg_define_js('react-dom', [
    'src' => '/mod/nrc_recommendations/node_modules/react-dom/umd/react-dom.development.js',
  ]);
  elgg_define_js('refimpl', [
    'src' => '/mod/nrc_recommendations/lib/index.js',
    'deps' => array('react', 'react-dom', 'jsrsasign'),
    'exports' => 'refimpl.default',
  ]);

  elgg_register_css('nrc_component', '/mod/nrc_recommendations/lib/static/css/main.756f64b7.css');
  elgg_load_css('nrc_component');

  elgg_require_js('main');
}

?>
