<?php
/*****************************************************************************
 * Glee                                                                      *
*                                                                           *
* Copyright (C) 2012 Alois Leitner                                          *
*                                                                           *
* This program is free software: you can redistribute it and/or modify      *
* it under the terms of the GNU General Public License as published by      *
* the Free Software Foundation, either version 2 of the License, or         *
* (at your option) any later version.                                       *
*                                                                           *
* This program is distributed in the hope that it will be useful,           *
* but WITHOUT ANY WARRANTY; without even the implied warranty of            *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             *
* GNU General Public License for more details.                              *
*                                                                           *
* You should have received a copy of the GNU General Public License         *
* along with this program.  If not, see <http://www.gnu.org/licenses/>.     *
*                                                                           *
* "When code and comments disagree both are probably wrong." (Norm Schryer) *
*****************************************************************************/

define('GLEE_DEFAULT_LINK_COLOR', '#4690D6');
/**
 * Register a LESS file for inclusion in the HTML head
*
* @param string $name     An identifier for the LESS file
* @param string $url      URL of the LESS file
* @param int    $priority Priority of the LESS file (lower numbers load earlier)
*
* @return bool
*/
function glee_register_less($name, $url, $priority = null) {
    return elgg_register_external_file('less', $name, $url, 'head', $priority);
}

/**
 * Unregister a LESS file
 *
 * @param string $name The identifier for the LESS file
 *
 * @return bool
 * @since 1.8.0
 */
function glee_unregister_less($name) {
    return elgg_unregister_external_file('less', $name);
}

/**
 * Load a LESS file for this page
 *
 */
function glee_load_less($name) {
    elgg_load_external_file('less', $name);
}

/**
 * Get the loaded LESS URLs
 *
 * @return array
 */
function glee_get_loaded_less() {
    return elgg_get_loaded_external_files('less', 'head');
}

/**
 * Serve CSS
 *
 * Serves CSS from the css views directory with headers for caching control
 *
 * @param array $page The page array
 *
 * @return void
 * @elgg_pagehandler css
 * @access private
 */
function glee_less_page_handler($page) {
    if (!isset($page[0])) {
        // default css
        $page[0] = 'elgg';
    }

    return glee_less_cacheable_view_page_handler($page, 'less');
}

/**
 * Serves a JS or CSS view with headers for caching.
 *
 * /<css||js>/name/of/view.<last_cache>.<css||js>
 *
 * @param array  $page The page array
 * @param string $type The type: js or css
 *
 * @return bool
 * @access private
 */
function glee_less_cacheable_view_page_handler($page, $type) {

    switch ($type) {
        case 'less':
        case 'css':
            $content_type = 'text/plain';
            break;

        default:
            return false;
        break;
    }

    if ($page) {
        $page = implode('/', $page);
        $regex = '|(.+?)\.([\d]+\.)?\w+$|';
        preg_match($regex, $page, $matches);
        $view = $matches[1];
        $return = elgg_view("$type/$view");

        header("Content-type: $content_type");
        //header("Content-Encoding: gzip");

        //header('Expires: ' . date('r', time() + 864000));
        //header("Pragma: public");
        //header("Cache-Control: public");
        //header("Content-Length: " . strlen($return));

        echo $return;
        return true;
    }
}

function glee_example_page_handler($page) {
    // get current site entity
    $site = elgg_get_site_entity();

    // set site entity as page owner
    elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

    $dir = elgg_get_plugins_path() . 'glee/pages/glee/example/';

    $page0 = elgg_extract(0, $page, 'default');
    
    // includes the example file
    switch($page0) {
        case "1":
        case "accordion":
            include "$dir/accordion.php";
            break;

        case "2":
        case "carousel":
            include "$dir/carousel.php";
            break;

        case "3":
        case "thumbnails":
            elgg_load_js('lightbox');
            elgg_load_css('lightbox');

            include "$dir/thumbnails.php";
            break;

        case "0":
        default:
            include "$dir/default.php";
    }

    return true;
}

function glee_get_color($name) {    
    $colors = array(
         'blue'     => '#049cdb',
         'blueDark' => '#0064cd',
         'green'    => '#46a546',
         'red'      => '#9d261d',
         'yellow'   => '#ffc40d', 
         'orange'   => '#f89406', 
         'pink'     => '#c3325f', 
         'purple'   => '#7a43b6', 
    );

    if (!isset($colors[$name])) {
        return false;
    }
    
    $link_color  = elgg_get_plugin_setting("color_$name",  'glee');
    // fall back to default is color does not exist 
    if (empty($link_color)) {
        $link_color = elgg_extract($name, $colors, '');
    }
    
    return $link_color;
}


function glee_get_main_color() {
    return glee_get_link_color();
}

function glee_get_link_color() {
    $link_color  = elgg_get_plugin_setting('link_color',  'glee');
    
    if (empty($link_color)) {
        $link_color = GLEE_DEFAULT_LINK_COLOR;
    }

    return $link_color;
}

function glee_get_themes() {
    return elgg_trigger_plugin_hook('glee', 'themes', array(), array());
}



