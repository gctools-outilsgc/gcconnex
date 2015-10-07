<?php
/**
 * CSS Aalborg theme
 *
 * @package AalborgTheme
 * @subpackage UI
 */


//This is a test to get images to work

$site_url = elgg_get_site_url();
?>
/* <style> /**/


@charset "utf-8";
/*!
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 * v4.0.12 - 2015-03-23
 *
 */
/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
/*
 * GLYPHICONS Halflings for Twitter Bootstrap by GLYPHICONS.com | Licensed under http://www.apache.org/licenses/LICENSE-2.0
 */
/*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
/*
 * HOW TO USE THIS FILE
 * Use this file to override Bootstrap variables and WET custom variables.
 * If there is a Bootstrap variable not shown here that you want to override, go to "../lib/bootstrap-sass-official/assets/stylesheets/bootstrap/variables" to view the variables that you can override. Simply copy and paste the variable and its applicable section (if applicable) from the Bootstrap file into this override file and override the variables as applicable.
 */
/*! normalize.css v3.0.2 | MIT License | git.io/normalize */
html {
  font-family: sans-serif;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%; }

body {
  margin: 0; }

article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
  display: block; }

audio, canvas, progress, video {
  display: inline-block;
  vertical-align: baseline; }

audio:not([controls]) {
  display: none;
  height: 0; }

[hidden], template {
  display: none; }

a {
  background-color: transparent; }

a:active, a:hover {
  outline: 0; }

abbr[title] {
  border-bottom: 1px dotted; }

b, strong {
  font-weight: bold; }

dfn {
  font-style: italic; }

h1 {
  font-size: 2em;
  margin: 0.67em 0; }

mark {
  background: #ff0;
  color: #000; }

small {
  font-size: 80%; }

sub, sup {
  font-size: 75%;
  line-height: 0;
  position: relative;
  vertical-align: baseline; }

sup {
  top: -0.5em; }

sub {
  bottom: -0.25em; }

img {
  border: 0; }

svg:not(:root) {
  overflow: hidden; }

figure {
  margin: 1em 40px; }

hr {
  -moz-box-sizing: content-box;
  -webkit-box-sizing: content-box;
  box-sizing: content-box;
  height: 0; }

pre {
  overflow: auto; }

code, kbd, pre, samp {
  font-family: monospace, monospace;
  font-size: 1em; }

button, input, optgroup, select, textarea {
  color: inherit;
  font: inherit;
  margin: 0; }

button {
  overflow: visible; }

button, select {
  text-transform: none; }

button, html input[type="button"], input[type="reset"], input[type="submit"] {
  -webkit-appearance: button;
  cursor: pointer; }

button[disabled], html input[disabled] {
  cursor: default; }

button::-moz-focus-inner, input::-moz-focus-inner {
  border: 0;
  padding: 0; }

input {
  line-height: normal; }

input[type="checkbox"], input[type="radio"] {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  padding: 0; }

input[type="number"]::-webkit-inner-spin-button, input[type="number"]::-webkit-outer-spin-button {
  height: auto; }

input[type="search"] {
  -webkit-appearance: textfield;
  -moz-box-sizing: content-box;
  -webkit-box-sizing: content-box;
  box-sizing: content-box; }

input[type="search"]::-webkit-search-cancel-button, input[type="search"]::-webkit-search-decoration {
  -webkit-appearance: none; }

fieldset {
  border: 1px solid #c0c0c0;
  margin: 0 2px;
  padding: 0.35em 0.625em 0.75em; }

legend {
  border: 0;
  padding: 0; }

textarea {
  overflow: auto; }

optgroup {
  font-weight: bold; }

table {
  border-collapse: collapse;
  border-spacing: 0; }

td, th {
  padding: 0; }

/*! Source: https://github.com/h5bp/html5-boilerplate/blob/master/src/css/main.css */
@media print {
  *, *:before, *:after {
    background: transparent !important;
    color: #000 !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    text-shadow: none !important; }
  a, a:visited {
    text-decoration: underline; }
  a[href]:after {
    content: " (" attr(href) ")"; }
  abbr[title]:after {
    content: " (" attr(title) ")"; }
  a[href^="#"]:after, a[href^="javascript:"]:after {
    content: ""; }
  pre, blockquote {
    border: 1px solid #999;
    page-break-inside: avoid; }
  thead {
    display: table-header-group; }
  tr, img {
    page-break-inside: avoid; }
  img {
    max-width: 100% !important; }
  p, h2, h3 {
    orphans: 3;
    widows: 3; }
  h2, h3 {
    page-break-after: avoid; }
  select {
    background: #fff !important; }
  .navbar {
    display: none; }
  .btn > .caret, .dropup > .btn > .caret {
    border-top-color: #000 !important; }
  .label {
    border: 1px solid #000; }
  .table {
    border-collapse: collapse !important; }
    .table td, .table th {
      background-color: #fff !important; }
  .table-bordered th, .table-bordered td {
    border: 1px solid #ddd !important; } }

@font-face {
  font-family: 'Glyphicons Halflings';
  src: url('<?php echo $site_url ?>/mod/wet4/views/default/fonts/glyphicons-halflings-regular.eot');
  src: url('<?php echo $site_url ?>/mod/wet4/views/default/fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'), url('<?php echo $site_url ?>/mod/wet4/views/default/fonts/glyphicons-halflings-regular.woff') format('woff'), url('<?php echo $site_url ?>/mod/wet4/views/default/fonts/glyphicons-halflings-regular.ttf') format('truetype'), url('<?php echo $site_url ?>/mod/wet4/views/default/fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular') format('svg'); }


* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box; }

*:before, *:after {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box; }

html {
  font-size: 10px;
  -webkit-tap-highlight-color: rgba(0, 0, 0, 0); }

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 16px;
  line-height: 1.4375;
  color: #333333;
  background-color: #fff; }

input, button, select, textarea {
  font-family: inherit;
  font-size: inherit;
  line-height: inherit; }

a {
  color: #295376;
  text-decoration: none; }
  a:hover, a:focus {
    color: #0535d2;
    text-decoration: underline; }
  a:focus {
    outline: thin dotted;
    outline: 5px auto -webkit-focus-ring-color;
    outline-offset: -2px; }

figure {
  margin: 0; }

img {
  vertical-align: middle; }

.img-responsive {
  display: block;
  max-width: 100%;
  height: auto; }

.img-rounded {
  border-radius: 6px; }

.img-thumbnail {
  padding: 4px;
  line-height: 1.4375;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 4px;
  -webkit-transition: all 0.2s ease-in-out;
  transition: all 0.2s ease-in-out;
  display: inline-block;
  max-width: 100%;
  height: auto; }

.img-circle {
  border-radius: 50%; }

hr {
  margin-top: 23px;
  margin-bottom: 23px;
  border: 0;
  border-top: 1px solid #eeeeee; }

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0; }

.sr-only-focusable:active, .sr-only-focusable:focus {
  position: static;
  width: auto;
  height: auto;
  margin: 0;
  overflow: visible;
  clip: auto; }

h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
  font-family: inherit;
  font-weight: 500;
  line-height: 1.1;
  color: inherit; }
  h1 small, h1 .small, h2 small, h2 .small, h3 small, h3 .small, h4 small, h4 .small, h5 small, h5 .small, h6 small, h6 .small, .h1 small, .h1 .small, .h2 small, .h2 .small, .h3 small, .h3 .small, .h4 small, .h4 .small, .h5 small, .h5 .small, .h6 small, .h6 .small {
    font-weight: normal;
    line-height: 1;
    color: #767676; }

h1, .h1, h2, .h2, h3, .h3 {
  margin-top: 23px;
  margin-bottom: 11.5px; }
  h1 small, h1 .small, .h1 small, .h1 .small, h2 small, h2 .small, .h2 small, .h2 .small, h3 small, h3 .small, .h3 small, .h3 .small {
    font-size: 65%; }

h4, .h4, h5, .h5, h6, .h6 {
  margin-top: 11.5px;
  margin-bottom: 11.5px; }
  h4 small, h4 .small, .h4 small, .h4 .small, h5 small, h5 .small, .h5 small, .h5 .small, h6 small, h6 .small, .h6 small, .h6 .small {
    font-size: 75%; }

h1, .h1 {
  font-size: 34px; }

h2, .h2 {
  font-size: 26px; }

h3, .h3 {
  font-size: 22px; }

h4, .h4 {
  font-size: 18px; }

h5, .h5 {
  font-size: 16px; }

h6, .h6 {
  font-size: 14px; }

p {
  margin: 0 0 11.5px; }

.lead {
  margin-bottom: 23px;
  font-size: 18px;
  font-weight: 300;
  line-height: 1.4; }
  @media (min-width: 768px) {
    .lead {
      font-size: 24px; } }

small, .small {
  font-size: 87%; }

mark, .mark {
  background-color: #fcf8e3;
  padding: 0.2em; }

.text-left {
  text-align: left; }

.text-right {
  text-align: right; }

.text-center {
  text-align: center; }

.text-justify {
  text-align: justify; }

.text-nowrap {
  white-space: nowrap; }

.text-lowercase {
  text-transform: lowercase; }

.text-uppercase {
  text-transform: uppercase; }

.text-capitalize {
  text-transform: capitalize; }

.text-muted {
  color: #767676; }

.text-primary {
  color: #2572b4; }

a.text-primary:hover {
  color: #1c588a; }

.text-success {
  color: #3c763d; }

a.text-success:hover {
  color: #2b542b; }

.text-info {
  color: #31708f; }

a.text-info:hover {
  color: #245369; }

.text-warning {
  color: #8a6d3b; }

a.text-warning:hover {
  color: #66502c; }

.text-danger {
  color: #a94442; }

a.text-danger:hover {
  color: #843534; }

.bg-primary {
  color: #fff; }

.bg-primary {
  background-color: #2572b4; }

a.bg-primary:hover {
  background-color: #1c588a; }

.bg-success {
  background-color: #dff0d8; }

a.bg-success:hover {
  background-color: #c1e2b3; }

.bg-info {
  background-color: #d9edf7; }

a.bg-info:hover {
  background-color: #afdaee; }

.bg-warning {
  background-color: #fcf8e3; }

a.bg-warning:hover {
  background-color: #f7ecb5; }

.bg-danger {
  background-color: #f2dede; }

a.bg-danger:hover {
  background-color: #e4b9b9; }

.page-header {
  padding-bottom: 10.5px;
  margin: 46px 0 23px;
  border-bottom: 1px solid #eeeeee; }

ul, ol {
  margin-top: 0;
  margin-bottom: 11.5px; }
  ul ul, ul ol, ol ul, ol ol {
    margin-bottom: 0; }

.list-unstyled {
  padding-left: 0;
  list-style: none; }

.list-inline {
  padding-left: 0;
  list-style: none;
  margin-left: -5px; }
  .list-inline > li {
    display: inline-block;
    padding-left: 5px;
    padding-right: 5px; }

dl {
  margin-top: 0;
  margin-bottom: 23px; }

dt, dd {
  line-height: 1.4375; }

dt {
  font-weight: bold; }

dd {
  margin-left: 0; }

.dl-horizontal dd:before, .dl-horizontal dd:after {
  content: " ";
  display: table; }
.dl-horizontal dd:after {
  clear: both; }
@media (min-width: 768px) {
  .dl-horizontal dt {
    float: left;
    width: 160px;
    clear: left;
    text-align: right;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap; }
  .dl-horizontal dd {
    margin-left: 180px; } }

abbr[title], abbr[data-original-title] {
  cursor: help;
  border-bottom: 1px dotted #767676; }

.initialism {
  font-size: 90%;
  text-transform: uppercase; }

blockquote {
  padding: 11.5px 23px;
  margin: 0 0 23px;
  font-size: 20px;
  border-left: 5px solid #eeeeee; }
  blockquote p:last-child, blockquote ul:last-child, blockquote ol:last-child {
    margin-bottom: 0; }
  blockquote footer, blockquote small, blockquote .small {
    display: block;
    font-size: 80%;
    line-height: 1.4375;
    color: #767676; }
    blockquote footer:before, blockquote small:before, blockquote .small:before {
      content: '\2014 \00A0'; }

.blockquote-reverse, blockquote.pull-right {
  padding-right: 15px;
  padding-left: 0;
  border-right: 5px solid #eeeeee;
  border-left: 0;
  text-align: right; }
  .blockquote-reverse footer:before, .blockquote-reverse small:before, .blockquote-reverse .small:before, blockquote.pull-right footer:before, blockquote.pull-right small:before, blockquote.pull-right .small:before {
    content: ''; }
  .blockquote-reverse footer:after, .blockquote-reverse small:after, .blockquote-reverse .small:after, blockquote.pull-right footer:after, blockquote.pull-right small:after, blockquote.pull-right .small:after {
    content: '\00A0 \2014'; }

address {
  margin-bottom: 23px;
  font-style: normal;
  line-height: 1.4375; }

code, kbd, pre, samp {
  font-family: Menlo, Monaco, Consolas, "Courier New", monospace; }

code {
  padding: 2px 4px;
  font-size: 90%;
  color: #c7254e;
  background-color: #f9f2f4;
  border-radius: 4px; }

kbd {
  padding: 2px 4px;
  font-size: 90%;
  color: #fff;
  background-color: #333;
  border-radius: 3px;
  -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.25);
  box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.25); }
  kbd kbd {
    padding: 0;
    font-size: 100%;
    font-weight: bold;
    -webkit-box-shadow: none;
    box-shadow: none; }

pre {
  display: block;
  padding: 11px;
  margin: 0 0 11.5px;
  font-size: 15px;
  line-height: 1.4375;
  word-break: break-all;
  word-wrap: break-word;
  color: #333333;
  background-color: #f5f5f5;
  border: 1px solid #ccc;
  border-radius: 4px; }
  pre code {
    padding: 0;
    font-size: inherit;
    color: inherit;
    white-space: pre-wrap;
    background-color: transparent;
    border-radius: 0; }

.pre-scrollable {
  max-height: 340px;
  overflow-y: scroll; }

.container {
  margin-right: auto;
  margin-left: auto;
  padding-left: 15px;
  padding-right: 15px; }
  .container:before, .container:after {
    content: " ";
    display: table; }
  .container:after {
    clear: both; }
  @media (min-width: 768px) {
    .container {
      width: 750px; } }
  @media (min-width: 992px) {
    .container {
      width: 970px; } }
  @media (min-width: 1200px) {
    .container {
      width: 1170px; } }

.container-fluid {
  margin-right: auto;
  margin-left: auto;
  padding-left: 15px;
  padding-right: 15px; }
  .container-fluid:before, .container-fluid:after {
    content: " ";
    display: table; }
  .container-fluid:after {
    clear: both; }



table {
  background-color: transparent; }

caption {
  padding-top: 8px;
  padding-bottom: 8px;
  color: #767676;
  text-align: left; }

th {
  text-align: left; }

.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 23px; }
  .table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
    padding: 8px;
    line-height: 1.4375;
    vertical-align: top;
    border-top: 1px solid #ddd; }
  .table > thead > tr > th {
    vertical-align: bottom;
    border-bottom: 2px solid #ddd; }
  .table > caption + thead > tr:first-child > th, .table > caption + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > td, .table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td {
    border-top: 0; }
  .table > tbody + tbody {
    border-top: 2px solid #ddd; }
  .table .table {
    background-color: #fff; }

.table-condensed > thead > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > th, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > th, .table-condensed > tfoot > tr > td {
  padding: 5px; }

.table-bordered {
  border: 1px solid #ddd; }
  .table-bordered > thead > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > tfoot > tr > td {
    border: 1px solid #ddd; }
  .table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
    border-bottom-width: 2px; }

.table-striped > tbody > tr:nth-child(odd) {
  background-color: #f5f5f5; }

.table-hover > tbody > tr:hover {
  background-color: #f0f0f0; }

table col[class*="col-"] {
  position: static;
  float: none;
  display: table-column; }

table td[class*="col-"], table th[class*="col-"] {
  position: static;
  float: none;
  display: table-cell; }

.table > thead > tr > td.active, .table > thead > tr > th.active, .table > thead > tr.active > td, .table > thead > tr.active > th, .table > tbody > tr > td.active, .table > tbody > tr > th.active, .table > tbody > tr.active > td, .table > tbody > tr.active > th, .table > tfoot > tr > td.active, .table > tfoot > tr > th.active, .table > tfoot > tr.active > td, .table > tfoot > tr.active > th {
  background-color: #f0f0f0; }

.table-hover > tbody > tr > td.active:hover, .table-hover > tbody > tr > th.active:hover, .table-hover > tbody > tr.active:hover > td, .table-hover > tbody > tr:hover > .active, .table-hover > tbody > tr.active:hover > th {
  background-color: #e3e3e3; }

.table > thead > tr > td.success, .table > thead > tr > th.success, .table > thead > tr.success > td, .table > thead > tr.success > th, .table > tbody > tr > td.success, .table > tbody > tr > th.success, .table > tbody > tr.success > td, .table > tbody > tr.success > th, .table > tfoot > tr > td.success, .table > tfoot > tr > th.success, .table > tfoot > tr.success > td, .table > tfoot > tr.success > th {
  background-color: #dff0d8; }

.table-hover > tbody > tr > td.success:hover, .table-hover > tbody > tr > th.success:hover, .table-hover > tbody > tr.success:hover > td, .table-hover > tbody > tr:hover > .success, .table-hover > tbody > tr.success:hover > th {
  background-color: #d0e9c6; }

.table > thead > tr > td.info, .table > thead > tr > th.info, .table > thead > tr.info > td, .table > thead > tr.info > th, .table > tbody > tr > td.info, .table > tbody > tr > th.info, .table > tbody > tr.info > td, .table > tbody > tr.info > th, .table > tfoot > tr > td.info, .table > tfoot > tr > th.info, .table > tfoot > tr.info > td, .table > tfoot > tr.info > th {
  background-color: #d9edf7; }

.table-hover > tbody > tr > td.info:hover, .table-hover > tbody > tr > th.info:hover, .table-hover > tbody > tr.info:hover > td, .table-hover > tbody > tr:hover > .info, .table-hover > tbody > tr.info:hover > th {
  background-color: #c4e4f3; }

.table > thead > tr > td.warning, .table > thead > tr > th.warning, .table > thead > tr.warning > td, .table > thead > tr.warning > th, .table > tbody > tr > td.warning, .table > tbody > tr > th.warning, .table > tbody > tr.warning > td, .table > tbody > tr.warning > th, .table > tfoot > tr > td.warning, .table > tfoot > tr > th.warning, .table > tfoot > tr.warning > td, .table > tfoot > tr.warning > th {
  background-color: #fcf8e3; }

.table-hover > tbody > tr > td.warning:hover, .table-hover > tbody > tr > th.warning:hover, .table-hover > tbody > tr.warning:hover > td, .table-hover > tbody > tr:hover > .warning, .table-hover > tbody > tr.warning:hover > th {
  background-color: #faf2cc; }

.table > thead > tr > td.danger, .table > thead > tr > th.danger, .table > thead > tr.danger > td, .table > thead > tr.danger > th, .table > tbody > tr > td.danger, .table > tbody > tr > th.danger, .table > tbody > tr.danger > td, .table > tbody > tr.danger > th, .table > tfoot > tr > td.danger, .table > tfoot > tr > th.danger, .table > tfoot > tr.danger > td, .table > tfoot > tr.danger > th {
  background-color: #f2dede; }

.table-hover > tbody > tr > td.danger:hover, .table-hover > tbody > tr > th.danger:hover, .table-hover > tbody > tr.danger:hover > td, .table-hover > tbody > tr:hover > .danger, .table-hover > tbody > tr.danger:hover > th {
  background-color: #ebcccc; }

.table-responsive {
  overflow-x: auto;
  min-height: 0.01%; }
  @media screen and (max-width: 767px) {
    .table-responsive {
      width: 100%;
      margin-bottom: 17.25px;
      overflow-y: hidden;
      -ms-overflow-style: -ms-autohiding-scrollbar;
      border: 1px solid #ddd; }
      .table-responsive > .table {
        margin-bottom: 0; }
        .table-responsive > .table > thead > tr > th, .table-responsive > .table > thead > tr > td, .table-responsive > .table > tbody > tr > th, .table-responsive > .table > tbody > tr > td, .table-responsive > .table > tfoot > tr > th, .table-responsive > .table > tfoot > tr > td {
          white-space: nowrap; }
      .table-responsive > .table-bordered {
        border: 0; }
        .table-responsive > .table-bordered > thead > tr > th:first-child, .table-responsive > .table-bordered > thead > tr > td:first-child, .table-responsive > .table-bordered > tbody > tr > th:first-child, .table-responsive > .table-bordered > tbody > tr > td:first-child, .table-responsive > .table-bordered > tfoot > tr > th:first-child, .table-responsive > .table-bordered > tfoot > tr > td:first-child {
          border-left: 0; }
        .table-responsive > .table-bordered > thead > tr > th:last-child, .table-responsive > .table-bordered > thead > tr > td:last-child, .table-responsive > .table-bordered > tbody > tr > th:last-child, .table-responsive > .table-bordered > tbody > tr > td:last-child, .table-responsive > .table-bordered > tfoot > tr > th:last-child, .table-responsive > .table-bordered > tfoot > tr > td:last-child {
          border-right: 0; }
        .table-responsive > .table-bordered > tbody > tr:last-child > th, .table-responsive > .table-bordered > tbody > tr:last-child > td, .table-responsive > .table-bordered > tfoot > tr:last-child > th, .table-responsive > .table-bordered > tfoot > tr:last-child > td {
          border-bottom: 0; } }

fieldset {
  /*padding: 0;*/
  margin: 0;
  border: 0;
  min-width: 0; }

legend {
  display: block;
  width: 100%;
  padding: 0;
  margin-bottom: 23px;
  font-size: 24px;
  line-height: inherit;
  color: #333333;
  border: 0;
  border-bottom: 1px solid #e5e5e5; }

label {
  display: inline-block;
  max-width: 100%;
  margin-bottom: 5px;
  font-weight: bold; }

input[type="search"] {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box; }

input[type="radio"], input[type="checkbox"] {
  margin: 4px 0 0;
  margin-top: 1px \9;
  line-height: normal; }

input[type="file"] {
  display: block; }

input[type="range"] {
  display: block;
  width: 100%; }

select[multiple], select[size] {
  height: auto; }

input[type="file"]:focus, input[type="radio"]:focus, input[type="checkbox"]:focus {
  outline: thin dotted;
  outline: 5px auto -webkit-focus-ring-color;
  outline-offset: -2px; }

output {
  display: block;
  padding-top: 7px;
  font-size: 16px;
  line-height: 1.4375;
  color: #555555; }

.form-control {
  display: block;
  width: 100%;
  height: 37px;
  padding: 6px 12px;
  font-size: 16px;
  line-height: 1.4375;
  color: #555555;
  background-color: #fff;
  background-image: none;
  border: 1px solid #ccc;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -webkit-transition: border-color ease-in-out 0.15s, -webkit-box-shadow ease-in-out 0.15s;
  transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s; }
  .form-control:focus {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6); }
  .form-control::-moz-placeholder {
    color: #999;
    opacity: 1; }
  .form-control:-ms-input-placeholder {
    color: #999; }
  .form-control::-webkit-input-placeholder {
    color: #999; }
  .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    cursor: not-allowed;
    background-color: #eeeeee;
    opacity: 1; }

textarea.form-control {
  height: auto; }

input[type="search"] {
  -webkit-appearance: none; }

@media screen and (-webkit-min-device-pixel-ratio: 0) {
  input[type="date"], input[type="time"], input[type="datetime-local"], input[type="month"] {
    line-height: 37px; }
  input[type="date"].input-sm, .input-group-sm > input[type="date"].form-control, .input-group-sm > input[type="date"].input-group-addon, .input-group-sm > .input-group-btn > input[type="date"].btn, input[type="time"].input-sm, .input-group-sm > input[type="time"].form-control, .input-group-sm > input[type="time"].input-group-addon, .input-group-sm > .input-group-btn > input[type="time"].btn, input[type="datetime-local"].input-sm, .input-group-sm > input[type="datetime-local"].form-control, .input-group-sm > input[type="datetime-local"].input-group-addon, .input-group-sm > .input-group-btn > input[type="datetime-local"].btn, input[type="month"].input-sm, .input-group-sm > input[type="month"].form-control, .input-group-sm > input[type="month"].input-group-addon, .input-group-sm > .input-group-btn > input[type="month"].btn {
    line-height: 33px; }
  input[type="date"].input-lg, .input-group-lg > input[type="date"].form-control, .input-group-lg > input[type="date"].input-group-addon, .input-group-lg > .input-group-btn > input[type="date"].btn, input[type="time"].input-lg, .input-group-lg > input[type="time"].form-control, .input-group-lg > input[type="time"].input-group-addon, .input-group-lg > .input-group-btn > input[type="time"].btn, input[type="datetime-local"].input-lg, .input-group-lg > input[type="datetime-local"].form-control, .input-group-lg > input[type="datetime-local"].input-group-addon, .input-group-lg > .input-group-btn > input[type="datetime-local"].btn, input[type="month"].input-lg, .input-group-lg > input[type="month"].form-control, .input-group-lg > input[type="month"].input-group-addon, .input-group-lg > .input-group-btn > input[type="month"].btn {
    line-height: 46px; } }

.form-group {
  margin-bottom: 15px; }

.radio, .checkbox {
  position: relative;
  display: block;
  margin-top: 10px;
  margin-bottom: 10px; }
  .radio label, .checkbox label {
    min-height: 23px;
    padding-left: 20px;
    margin-bottom: 0;
    font-weight: normal;
    cursor: pointer; }

.radio input[type="radio"], .radio-inline input[type="radio"], .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"] {
  position: absolute;
  margin-left: -20px;
  margin-top: 4px \9; }

.radio + .radio, .checkbox + .checkbox {
  margin-top: -5px; }

.radio-inline, .checkbox-inline {
  display: inline-block;
  padding-left: 20px;
  margin-bottom: 0;
  vertical-align: middle;
  font-weight: normal;
  cursor: pointer; }

.radio-inline + .radio-inline, .checkbox-inline + .checkbox-inline {
  margin-top: 0;
  margin-left: 10px; }

input[type="radio"][disabled], input[type="radio"].disabled, fieldset[disabled] input[type="radio"], input[type="checkbox"][disabled], input[type="checkbox"].disabled, fieldset[disabled] input[type="checkbox"] {
  cursor: not-allowed; }

.radio-inline.disabled, fieldset[disabled] .radio-inline, .checkbox-inline.disabled, fieldset[disabled] .checkbox-inline {
  cursor: not-allowed; }

.radio.disabled label, fieldset[disabled] .radio label, .checkbox.disabled label, fieldset[disabled] .checkbox label {
  cursor: not-allowed; }

.form-control-static {
  padding-top: 7px;
  padding-bottom: 7px;
  margin-bottom: 0; }
  .form-control-static.input-lg, .input-group-lg > .form-control-static.form-control, .input-group-lg > .form-control-static.input-group-addon, .input-group-lg > .input-group-btn > .form-control-static.btn, .form-control-static.input-sm, .input-group-sm > .form-control-static.form-control, .input-group-sm > .form-control-static.input-group-addon, .input-group-sm > .input-group-btn > .form-control-static.btn {
    padding-left: 0;
    padding-right: 0; }

.input-sm, .input-group-sm > .form-control, .input-group-sm > .input-group-addon, .input-group-sm > .input-group-btn > .btn, .form-group-sm .form-control {
  height: 33px;
  padding: 5px 10px;
  font-size: 14px;
  line-height: 1.5;
  border-radius: 3px; }

select.input-sm, .input-group-sm > select.form-control, .input-group-sm > select.input-group-addon, .input-group-sm > .input-group-btn > select.btn, .form-group-sm .form-control {
  height: 33px;
  line-height: 33px; }

textarea.input-sm, .input-group-sm > textarea.form-control, .input-group-sm > textarea.input-group-addon, .input-group-sm > .input-group-btn > textarea.btn, .form-group-sm .form-control, select[multiple].input-sm, .input-group-sm > select[multiple].form-control, .input-group-sm > select[multiple].input-group-addon, .input-group-sm > .input-group-btn > select[multiple].btn, .form-group-sm .form-control {
  height: auto; }

.input-lg, .input-group-lg > .form-control, .input-group-lg > .input-group-addon, .input-group-lg > .input-group-btn > .btn, .form-group-lg .form-control {
  height: 46px;
  padding: 10px 16px;
  font-size: 18px;
  line-height: 1.33;
  border-radius: 6px; }

select.input-lg, .input-group-lg > select.form-control, .input-group-lg > select.input-group-addon, .input-group-lg > .input-group-btn > select.btn, .form-group-lg .form-control {
  height: 46px;
  line-height: 46px; }

textarea.input-lg, .input-group-lg > textarea.form-control, .input-group-lg > textarea.input-group-addon, .input-group-lg > .input-group-btn > textarea.btn, .form-group-lg .form-control, select[multiple].input-lg, .input-group-lg > select[multiple].form-control, .input-group-lg > select[multiple].input-group-addon, .input-group-lg > .input-group-btn > select[multiple].btn, .form-group-lg .form-control {
  height: auto; }

.has-feedback {
  position: relative; }
  .has-feedback .form-control {
    padding-right: 46.25px; }

.form-control-feedback {
  position: absolute;
  top: 0;
  right: 0;
  z-index: 2;
  display: block;
  width: 37px;
  height: 37px;
  line-height: 37px;
  text-align: center;
  pointer-events: none; }

.input-lg + .form-control-feedback, .input-lg + .input-group-lg > .form-control, .input-group-lg > .input-lg + .form-control, .input-lg + .input-group-lg > .input-group-addon, .input-group-lg > .input-lg + .input-group-addon, .input-lg + .input-group-lg > .input-group-btn > .btn, .input-group-lg > .input-group-btn > .input-lg + .btn {
  width: 46px;
  height: 46px;
  line-height: 46px; }

.input-sm + .form-control-feedback, .input-sm + .input-group-sm > .form-control, .input-group-sm > .input-sm + .form-control, .input-sm + .input-group-sm > .input-group-addon, .input-group-sm > .input-sm + .input-group-addon, .input-sm + .input-group-sm > .input-group-btn > .btn, .input-group-sm > .input-group-btn > .input-sm + .btn {
  width: 33px;
  height: 33px;
  line-height: 33px; }

.has-success .help-block, .has-success .control-label, .has-success .radio, .has-success .checkbox, .has-success .radio-inline, .has-success .checkbox-inline, .has-success.radio label, .has-success.checkbox label, .has-success.radio-inline label, .has-success.checkbox-inline label {
  color: #3c763d; }
.has-success .form-control {
  border-color: #3c763d;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075); }
  .has-success .form-control:focus {
    border-color: #2b542b;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #67b168;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #67b168; }
.has-success .input-group-addon {
  color: #3c763d;
  border-color: #3c763d;
  background-color: #dff0d8; }
.has-success .form-control-feedback {
  color: #3c763d; }

.has-warning .help-block, .has-warning .control-label, .has-warning .radio, .has-warning .checkbox, .has-warning .radio-inline, .has-warning .checkbox-inline, .has-warning.radio label, .has-warning.checkbox label, .has-warning.radio-inline label, .has-warning.checkbox-inline label {
  color: #8a6d3b; }
.has-warning .form-control {
  border-color: #8a6d3b;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075); }
  .has-warning .form-control:focus {
    border-color: #66502c;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #c09f6b;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #c09f6b; }
.has-warning .input-group-addon {
  color: #8a6d3b;
  border-color: #8a6d3b;
  background-color: #fcf8e3; }
.has-warning .form-control-feedback {
  color: #8a6d3b; }

.has-error .help-block, .has-error .control-label, .has-error .radio, .has-error .checkbox, .has-error .radio-inline, .has-error .checkbox-inline, .has-error.radio label, .has-error.checkbox label, .has-error.radio-inline label, .has-error.checkbox-inline label {
  color: #a94442; }
.has-error .form-control {
  border-color: #a94442;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075); }
  .has-error .form-control:focus {
    border-color: #843534;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #ce8483;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #ce8483; }
.has-error .input-group-addon {
  color: #a94442;
  border-color: #a94442;
  background-color: #f2dede; }
.has-error .form-control-feedback {
  color: #a94442; }

.has-feedback label ~ .form-control-feedback {
  top: 28px; }
.has-feedback label.sr-only ~ .form-control-feedback {
  top: 0; }

.help-block {
  display: block;
  margin-top: 5px;
  margin-bottom: 10px;
  color: #737373; }

@media (min-width: 768px) {
  .form-inline .form-group {
    display: inline-block;
    margin-bottom: 0;
    vertical-align: middle; }
  .form-inline .form-control {
    display: inline-block;
    width: auto;
    vertical-align: middle; }
  .form-inline .form-control-static {
    display: inline-block; }
  .form-inline .input-group {
    display: inline-table;
    vertical-align: middle; }
    .form-inline .input-group .input-group-addon, .form-inline .input-group .input-group-btn, .form-inline .input-group .form-control {
      width: auto; }
  .form-inline .input-group > .form-control {
    width: 100%; }
  .form-inline .control-label {
    margin-bottom: 0;
    vertical-align: middle; }
  .form-inline .radio, .form-inline .checkbox {
    display: inline-block;
    margin-top: 0;
    margin-bottom: 0;
    vertical-align: middle; }
    .form-inline .radio label, .form-inline .checkbox label {
      padding-left: 0; }
  .form-inline .radio input[type="radio"], .form-inline .checkbox input[type="checkbox"] {
    position: relative;
    margin-left: 0; }
  .form-inline .has-feedback .form-control-feedback {
    top: 0; } }

.form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline {
  margin-top: 0;
  margin-bottom: 0;
  padding-top: 7px; }
.form-horizontal .radio, .form-horizontal .checkbox {
  min-height: 30px; }
.form-horizontal .form-group {
  margin-left: -15px;
  margin-right: -15px; }
  .form-horizontal .form-group:before, .form-horizontal .form-group:after {
    content: " ";
    display: table; }
  .form-horizontal .form-group:after {
    clear: both; }
@media (min-width: 768px) {
  .form-horizontal .control-label {
    text-align: right;
    margin-bottom: 0;
    padding-top: 7px; } }
.form-horizontal .has-feedback .form-control-feedback {
  right: 15px; }
@media (min-width: 768px) {
  .form-horizontal .form-group-lg .control-label {
    padding-top: 14.3px; } }
@media (min-width: 768px) {
  .form-horizontal .form-group-sm .control-label {
    padding-top: 6px; } }



.fade {
  opacity: 0;
  -webkit-transition: opacity 0.15s linear;
  transition: opacity 0.15s linear; }
  .fade.in {
    opacity: 1; }

.collapse {
  display: none;
  visibility: hidden; }
  .collapse.in {
    display: block;
    visibility: visible; }

tr.collapse.in {
  display: table-row; }

tbody.collapse.in {
  display: table-row-group; }

.collapsing {
  position: relative;
  height: 0;
  overflow: hidden;
  -webkit-transition-property: height, visibility;
  transition-property: height, visibility;
  -webkit-transition-duration: 0.35s;
  transition-duration: 0.35s;
  -webkit-transition-timing-function: ease;
  transition-timing-function: ease; }

.caret {
  display: inline-block;
  width: 0;
  height: 0;
  margin-left: 2px;
  vertical-align: middle;
  border-top: 4px solid;
  border-right: 4px solid transparent;
  border-left: 4px solid transparent; }

.dropdown {
  position: relative; }

.dropdown-toggle:focus {
  outline: 0; }

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  display: none;
  float: left;
  min-width: 160px;
  padding: 5px 0;
  margin: 2px 0 0;
  list-style: none;
  font-size: 16px;
  text-align: left;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.15);
  border-radius: 4px;
  -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  -webkit-background-clip: padding-box;
  background-clip: padding-box; }
  .dropdown-menu.pull-right {
    right: 0;
    left: auto; }
  .dropdown-menu .divider {
    height: 1px;
    margin: 10.5px 0;
    overflow: hidden;
    background-color: #e5e5e5; }
  .dropdown-menu > li > a {
    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: normal;
    line-height: 1.4375;
    color: #333333;
    white-space: nowrap; }

.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
  text-decoration: none;
  color: #262626;
  background-color: #f5f5f5; }

.dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus {
  color: #fff;
  text-decoration: none;
  outline: 0;
  background-color: #2572b4; }

.dropdown-menu > .disabled > a, .dropdown-menu > .disabled > a:hover, .dropdown-menu > .disabled > a:focus {
  color: #767676; }
.dropdown-menu > .disabled > a:hover, .dropdown-menu > .disabled > a:focus {
  text-decoration: none;
  background-color: transparent;
  background-image: none;
  filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
  cursor: not-allowed; }

.open > .dropdown-menu {
  display: block; }
.open > a {
  outline: 0; }

.dropdown-menu-right {
  left: auto;
  right: 0; }

.dropdown-menu-left {
  left: 0;
  right: auto; }

.dropdown-header {
  display: block;
  padding: 3px 20px;
  font-size: 14px;
  line-height: 1.4375;
  color: #767676;
  white-space: nowrap; }

.dropdown-backdrop {
  position: fixed;
  left: 0;
  right: 0;
  bottom: 0;
  top: 0;
  z-index: 990; }

.pull-right > .dropdown-menu {
  right: 0;
  left: auto; }

.dropup .caret, .navbar-fixed-bottom .dropdown .caret {
  border-top: 0;
  border-bottom: 4px solid;
  content: ""; }
.dropup .dropdown-menu, .navbar-fixed-bottom .dropdown .dropdown-menu {
  top: auto;
  bottom: 100%;
  margin-bottom: 1px; }

@media (min-width: 768px) {
  .navbar-right .dropdown-menu {
    right: 0;
    left: auto; }
  .navbar-right .dropdown-menu-left {
    left: 0;
    right: auto; } }




.nav {
  margin-bottom: 0;
  padding-left: 0;
  list-style: none; }
  .nav:before, .nav:after {
    content: " ";
    display: table; }
  .nav:after {
    clear: both; }
  .nav > li {
    position: relative;
    display: block; }
    .nav > li > a {
      position: relative;
      display: block;
      padding: 10px 15px; }
      .nav > li > a:hover, .nav > li > a:focus {
        text-decoration: none;
        background-color: #eeeeee; }
    .nav > li.disabled > a {
      color: #767676; }
      .nav > li.disabled > a:hover, .nav > li.disabled > a:focus {
        color: #767676;
        text-decoration: none;
        background-color: transparent;
        cursor: not-allowed; }
  .nav .open > a, .nav .open > a:hover, .nav .open > a:focus {
    background-color: #eeeeee;
    border-color: #295376; }
  .nav .nav-divider {
    height: 1px;
    margin: 10.5px 0;
    overflow: hidden;
    background-color: #e5e5e5; }
  .nav > li > a > img {
    max-width: none; }

.nav-tabs {
  border-bottom: 1px solid #ddd; }
  .nav-tabs > li {
    float: left;
    margin-bottom: -1px; }
    .nav-tabs > li > a {
      margin-right: 2px;
      line-height: 1.4375;
      border: 1px solid transparent;
      border-radius: 4px 4px 0 0; }
      .nav-tabs > li > a:hover {
        border-color: #eeeeee #eeeeee #ddd; }
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
      color: #555555;
      background-color: #fff;
      border: 1px solid #ddd;
      border-bottom-color: transparent;
      cursor: default; }

.nav-pills > li {
  float: left; }
  .nav-pills > li > a {
    border-radius: 4px; }
  .nav-pills > li + li {
    margin-left: 2px; }
  .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
    color: #fff;
    background-color: #2572b4; }

.nav-stacked > li {
  float: none; }
  .nav-stacked > li + li {
    margin-top: 2px;
    margin-left: 0; }

.nav-justified, .nav-tabs.nav-justified {
  width: 100%; }
  .nav-justified > li, .nav-justified > .nav-tabs.nav-justified {
    float: none; }
    .nav-justified > li > a, .nav-justified > li > .nav-tabs.nav-justified {
      text-align: center;
      margin-bottom: 5px; }
  .nav-justified > .dropdown .dropdown-menu, .nav-justified > .dropdown .nav-tabs.nav-justified {
    top: auto;
    left: auto; }
  @media (min-width: 768px) {
    .nav-justified > li, .nav-justified > .nav-tabs.nav-justified {
      display: table-cell;
      width: 1%; }
      .nav-justified > li > a, .nav-justified > li > .nav-tabs.nav-justified {
        margin-bottom: 0; } }

.nav-tabs-justified, .nav-tabs.nav-justified, .nav-tabs.nav-justified {
  border-bottom: 0; }
  .nav-tabs-justified > li > a, .nav-tabs-justified > li > .nav-tabs.nav-justified, .nav-tabs-justified > li > .nav-tabs.nav-justified {
    margin-right: 0;
    border-radius: 4px; }
  .nav-tabs-justified > .active > a, .nav-tabs-justified > .active > .nav-tabs.nav-justified, .nav-tabs-justified > .active > .nav-tabs.nav-justified, .nav-tabs-justified > .active > a:hover, .nav-tabs-justified > .active > .nav-tabs.nav-justified, .nav-tabs-justified > .active > .nav-tabs.nav-justified, .nav-tabs-justified > .active > a:focus, .nav-tabs-justified > .active > .nav-tabs.nav-justified, .nav-tabs-justified > .active > .nav-tabs.nav-justified {
    border: 1px solid #ddd; }
  @media (min-width: 768px) {
    .nav-tabs-justified > li > a, .nav-tabs-justified > li > .nav-tabs.nav-justified, .nav-tabs-justified > li > .nav-tabs.nav-justified {
      border-bottom: 1px solid #ddd;
      border-radius: 4px 4px 0 0; }
    .nav-tabs-justified > .active > a, .nav-tabs-justified > .active > .nav-tabs.nav-justified, .nav-tabs-justified > .active > .nav-tabs.nav-justified, .nav-tabs-justified > .active > a:hover, .nav-tabs-justified > .active > .nav-tabs.nav-justified, .nav-tabs-justified > .active > .nav-tabs.nav-justified, .nav-tabs-justified > .active > a:focus, .nav-tabs-justified > .active > .nav-tabs.nav-justified, .nav-tabs-justified > .active > .nav-tabs.nav-justified {
      border-bottom-color: #fff; } }

.tab-content > .tab-pane {
  display: none;
  visibility: hidden; }
.tab-content > .active {
  display: block;
  visibility: visible; }

.nav-tabs .dropdown-menu {
  margin-top: -1px;
  border-top-right-radius: 0;
  border-top-left-radius: 0; }

.navbar {
  position: relative;
  min-height: 50px;
  margin-bottom: 23px;
  border: 1px solid transparent; }
  .navbar:before, .navbar:after {
    content: " ";
    display: table; }
  .navbar:after {
    clear: both; }
  @media (min-width: 768px) {
    .navbar {
      border-radius: 4px; } }

.navbar-header:before, .navbar-header:after {
  content: " ";
  display: table; }
.navbar-header:after {
  clear: both; }
@media (min-width: 768px) {
  .navbar-header {
    float: left; } }

.navbar-collapse {
  overflow-x: visible;
  padding-right: 15px;
  padding-left: 15px;
  border-top: 1px solid transparent;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
  -webkit-overflow-scrolling: touch; }
  .navbar-collapse:before, .navbar-collapse:after {
    content: " ";
    display: table; }
  .navbar-collapse:after {
    clear: both; }
  .navbar-collapse.in {
    overflow-y: auto; }
  @media (min-width: 768px) {
    .navbar-collapse {
      width: auto;
      border-top: 0;
      -webkit-box-shadow: none;
      box-shadow: none; }
      .navbar-collapse.collapse {
        display: block !important;
        visibility: visible !important;
        height: auto !important;
        padding-bottom: 0;
        overflow: visible !important; }
      .navbar-collapse.in {
        overflow-y: visible; }
      .navbar-fixed-top .navbar-collapse, .navbar-static-top .navbar-collapse, .navbar-fixed-bottom .navbar-collapse {
        padding-left: 0;
        padding-right: 0; } }

.navbar-fixed-top .navbar-collapse, .navbar-fixed-bottom .navbar-collapse {
  max-height: 340px; }
  @media (max-device-width: 480px) and (orientation: landscape) {
    .navbar-fixed-top .navbar-collapse, .navbar-fixed-bottom .navbar-collapse {
      max-height: 200px; } }

.container > .navbar-header, .container > .navbar-collapse, .container-fluid > .navbar-header, .container-fluid > .navbar-collapse {
  margin-right: -15px;
  margin-left: -15px; }
  @media (min-width: 768px) {
    .container > .navbar-header, .container > .navbar-collapse, .container-fluid > .navbar-header, .container-fluid > .navbar-collapse {
      margin-right: 0;
      margin-left: 0; } }

.navbar-static-top {
  z-index: 1000;
  border-width: 0 0 1px; }
  @media (min-width: 768px) {
    .navbar-static-top {
      border-radius: 0; } }

.navbar-fixed-top, .navbar-fixed-bottom {
  position: fixed;
  right: 0;
  left: 0;
  z-index: 1030; }
  @media (min-width: 768px) {
    .navbar-fixed-top, .navbar-fixed-bottom {
      border-radius: 0; } }

.navbar-fixed-top {
  top: 0;
  border-width: 0 0 1px; }

.navbar-fixed-bottom {
  bottom: 0;
  margin-bottom: 0;
  border-width: 1px 0 0; }

.navbar-brand {
  float: left;
  padding: 13.5px 15px;
  font-size: 18px;
  line-height: 23px;
  height: 50px; }
  .navbar-brand:hover, .navbar-brand:focus {
    text-decoration: none; }
  .navbar-brand > img {
    display: block; }
  @media (min-width: 768px) {
    .navbar > .container .navbar-brand, .navbar > .container-fluid .navbar-brand {
      margin-left: -15px; } }

.navbar-toggle {
  position: relative;
  float: right;
  margin-right: 15px;
  padding: 9px 10px;
  margin-top: 8px;
  margin-bottom: 8px;
  background-color: transparent;
  background-image: none;
  border: 1px solid transparent;
  border-radius: 4px; }
  .navbar-toggle:focus {
    outline: 0; }
  .navbar-toggle .icon-bar {
    display: block;
    width: 22px;
    height: 2px;
    border-radius: 1px; }
  .navbar-toggle .icon-bar + .icon-bar {
    margin-top: 4px; }
  @media (min-width: 768px) {
    .navbar-toggle {
      display: none; } }

.navbar-nav {
  margin: 6.75px -15px; }
  .navbar-nav > li > a {
    padding-top: 10px;
    padding-bottom: 10px;
    line-height: 23px; }
  @media (max-width: 767px) {
    .navbar-nav .open .dropdown-menu {
      position: static;
      float: none;
      width: auto;
      margin-top: 0;
      background-color: transparent;
      border: 0;
      -webkit-box-shadow: none;
      box-shadow: none; }
      .navbar-nav .open .dropdown-menu > li > a, .navbar-nav .open .dropdown-menu .dropdown-header {
        padding: 5px 15px 5px 25px; }
      .navbar-nav .open .dropdown-menu > li > a {
        line-height: 23px; }
        .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-nav .open .dropdown-menu > li > a:focus {
          background-image: none; } }
  @media (min-width: 768px) {
    .navbar-nav {
      float: left;
      margin: 0; }
      .navbar-nav > li {
        float: left; }
        .navbar-nav > li > a {
          padding-top: 13.5px;
          padding-bottom: 13.5px; } }

.navbar-form {
  margin-left: -15px;
  margin-right: -15px;
  padding: 10px 15px;
  border-top: 1px solid transparent;
  border-bottom: 1px solid transparent;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(255, 255, 255, 0.1);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(255, 255, 255, 0.1);
  margin-top: 6.5px;
  margin-bottom: 6.5px; }
  @media (min-width: 768px) {
    .navbar-form .form-group {
      display: inline-block;
      margin-bottom: 0;
      vertical-align: middle; }
    .navbar-form .form-control {
      display: inline-block;
      width: auto;
      vertical-align: middle; }
    .navbar-form .form-control-static {
      display: inline-block; }
    .navbar-form .input-group {
      display: inline-table;
      vertical-align: middle; }
      .navbar-form .input-group .input-group-addon, .navbar-form .input-group .input-group-btn, .navbar-form .input-group .form-control {
        width: auto; }
    .navbar-form .input-group > .form-control {
      width: 100%; }
    .navbar-form .control-label {
      margin-bottom: 0;
      vertical-align: middle; }
    .navbar-form .radio, .navbar-form .checkbox {
      display: inline-block;
      margin-top: 0;
      margin-bottom: 0;
      vertical-align: middle; }
      .navbar-form .radio label, .navbar-form .checkbox label {
        padding-left: 0; }
    .navbar-form .radio input[type="radio"], .navbar-form .checkbox input[type="checkbox"] {
      position: relative;
      margin-left: 0; }
    .navbar-form .has-feedback .form-control-feedback {
      top: 0; } }
  @media (max-width: 767px) {
    .navbar-form .form-group {
      margin-bottom: 5px; }
      .navbar-form .form-group:last-child {
        margin-bottom: 0; } }
  @media (min-width: 768px) {
    .navbar-form {
      width: auto;
      border: 0;
      margin-left: 0;
      margin-right: 0;
      padding-top: 0;
      padding-bottom: 0;
      -webkit-box-shadow: none;
      box-shadow: none; } }

.navbar-nav > li > .dropdown-menu {
  margin-top: 0;
  border-top-right-radius: 0;
  border-top-left-radius: 0; }

.navbar-fixed-bottom .navbar-nav > li > .dropdown-menu {
  border-top-right-radius: 4px;
  border-top-left-radius: 4px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0; }

.navbar-btn {
  margin-top: 6.5px;
  margin-bottom: 6.5px; }
  .navbar-btn.btn-sm, .btn-group-sm > .navbar-btn.btn {
    margin-top: 8.5px;
    margin-bottom: 8.5px; }
  .navbar-btn.btn-xs, .btn-group-xs > .navbar-btn.btn {
    margin-top: 14px;
    margin-bottom: 14px; }

.navbar-text {
  margin-top: 13.5px;
  margin-bottom: 13.5px; }
  @media (min-width: 768px) {
    .navbar-text {
      float: left;
      margin-left: 15px;
      margin-right: 15px; } }

@media (min-width: 768px) {
  .navbar-left {
    float: left !important; }
  .navbar-right {
    float: right !important;
    margin-right: -15px; }
    .navbar-right ~ .navbar-right {
      margin-right: 0; } }

.navbar-default {
  background-color: #f8f8f8;
  border-color: #e7e7e7; }
  .navbar-default .navbar-brand {
    color: #777; }
    .navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
      color: #5e5e5e;
      background-color: transparent; }
  .navbar-default .navbar-text {
    color: #777; }
  .navbar-default .navbar-nav > li > a {
    color: #777; }
    .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
      color: #333;
      background-color: transparent; }
  .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
    color: #555;
    background-color: #e7e7e7; }
  .navbar-default .navbar-nav > .disabled > a, .navbar-default .navbar-nav > .disabled > a:hover, .navbar-default .navbar-nav > .disabled > a:focus {
    color: #ccc;
    background-color: transparent; }
  .navbar-default .navbar-toggle {
    border-color: #ddd; }
    .navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
      background-color: #ddd; }
    .navbar-default .navbar-toggle .icon-bar {
      background-color: #888; }
  .navbar-default .navbar-collapse, .navbar-default .navbar-form {
    border-color: #e7e7e7; }
  .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
    background-color: #e7e7e7;
    color: #555; }
  @media (max-width: 767px) {
    .navbar-default .navbar-nav .open .dropdown-menu > li > a {
      color: #777; }
      .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
        color: #333;
        background-color: transparent; }
    .navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
      color: #555;
      background-color: #e7e7e7; }
    .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a, .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:focus {
      color: #ccc;
      background-color: transparent; } }
  .navbar-default .navbar-link {
    color: #777; }
    .navbar-default .navbar-link:hover {
      color: #333; }
  .navbar-default .btn-link {
    color: #777; }
    .navbar-default .btn-link:hover, .navbar-default .btn-link:focus {
      color: #333; }
    .navbar-default .btn-link[disabled]:hover, .navbar-default .btn-link[disabled]:focus, fieldset[disabled] .navbar-default .btn-link:hover, fieldset[disabled] .navbar-default .btn-link:focus {
      color: #ccc; }

.navbar-inverse {
  background-color: #222;
  border-color: #090909; }
  .navbar-inverse .navbar-brand {
    color: #9c9c9c; }
    .navbar-inverse .navbar-brand:hover, .navbar-inverse .navbar-brand:focus {
      color: #fff;
      background-color: transparent; }
  .navbar-inverse .navbar-text {
    color: #9c9c9c; }
  .navbar-inverse .navbar-nav > li > a {
    color: #9c9c9c; }
    .navbar-inverse .navbar-nav > li > a:hover, .navbar-inverse .navbar-nav > li > a:focus {
      color: #fff;
      background-color: transparent; }
  .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus {
    color: #fff;
    background-color: #090909; }
  .navbar-inverse .navbar-nav > .disabled > a, .navbar-inverse .navbar-nav > .disabled > a:hover, .navbar-inverse .navbar-nav > .disabled > a:focus {
    color: #444;
    background-color: transparent; }
  .navbar-inverse .navbar-toggle {
    border-color: #333; }
    .navbar-inverse .navbar-toggle:hover, .navbar-inverse .navbar-toggle:focus {
      background-color: #333; }
    .navbar-inverse .navbar-toggle .icon-bar {
      background-color: #fff; }
  .navbar-inverse .navbar-collapse, .navbar-inverse .navbar-form {
    border-color: #101010; }
  .navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .open > a:hover, .navbar-inverse .navbar-nav > .open > a:focus {
    background-color: #090909;
    color: #fff; }
  @media (max-width: 767px) {
    .navbar-inverse .navbar-nav .open .dropdown-menu > .dropdown-header {
      border-color: #090909; }
    .navbar-inverse .navbar-nav .open .dropdown-menu .divider {
      background-color: #090909; }
    .navbar-inverse .navbar-nav .open .dropdown-menu > li > a {
      color: #9c9c9c; }
      .navbar-inverse .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-inverse .navbar-nav .open .dropdown-menu > li > a:focus {
        color: #fff;
        background-color: transparent; }
    .navbar-inverse .navbar-nav .open .dropdown-menu > .active > a, .navbar-inverse .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-inverse .navbar-nav .open .dropdown-menu > .active > a:focus {
      color: #fff;
      background-color: #090909; }
    .navbar-inverse .navbar-nav .open .dropdown-menu > .disabled > a, .navbar-inverse .navbar-nav .open .dropdown-menu > .disabled > a:hover, .navbar-inverse .navbar-nav .open .dropdown-menu > .disabled > a:focus {
      color: #444;
      background-color: transparent; } }
  .navbar-inverse .navbar-link {
    color: #9c9c9c; }
    .navbar-inverse .navbar-link:hover {
      color: #fff; }
  .navbar-inverse .btn-link {
    color: #9c9c9c; }
    .navbar-inverse .btn-link:hover, .navbar-inverse .btn-link:focus {
      color: #fff; }
    .navbar-inverse .btn-link[disabled]:hover, .navbar-inverse .btn-link[disabled]:focus, fieldset[disabled] .navbar-inverse .btn-link:hover, fieldset[disabled] .navbar-inverse .btn-link:focus {
      color: #444; }

.breadcrumb {
  padding: 8px 15px;
  margin-bottom: 23px;
  list-style: none;
  background-color: #f5f5f5;
  border-radius: 4px; }
  .breadcrumb > li {
    display: inline-block; }
    .breadcrumb > li + li:before {
      content: "/\00a0";
      padding: 0 5px;
      color: #ccc; }
  .breadcrumb > .active {
    color: #767676; }

.pagination {
  display: inline-block;
  padding-left: 0;
  margin: 23px 0;
  border-radius: 4px; }
  .pagination > li {
    display: inline; }
    .pagination > li > a, .pagination > li > span {
      position: relative;
      float: left;
      padding: 6px 12px;
      line-height: 1.4375;
      text-decoration: none;
      color: #335075;
      background-color: #eaebed;
      border: 1px solid #dcdee1;
      margin-left: -1px; }
    .pagination > li:first-child > a, .pagination > li:first-child > span {
      margin-left: 0;
      border-bottom-left-radius: 4px;
      border-top-left-radius: 4px; }
    .pagination > li:last-child > a, .pagination > li:last-child > span {
      border-bottom-right-radius: 4px;
      border-top-right-radius: 4px; }
  .pagination > li > a:hover, .pagination > li > a:focus, .pagination > li > span:hover, .pagination > li > span:focus {
    color: #335075;
    background-color: #d4d6da;
    border-color: #bbbfc5; }
  .pagination > .active > a, .pagination > .active > a:hover, .pagination > .active > a:focus, .pagination > .active > span, .pagination > .active > span:hover, .pagination > .active > span:focus {
    z-index: 2;
    color: #fff;
    background-color: #2572b4;
    border-color: #2572b4;
    cursor: default; }
  .pagination > .disabled > span, .pagination > .disabled > span:hover, .pagination > .disabled > span:focus, .pagination > .disabled > a, .pagination > .disabled > a:hover, .pagination > .disabled > a:focus {
    color: #767676;
    background-color: #fff;
    border-color: #ddd;
    cursor: not-allowed; }

.pagination-lg > li > a, .pagination-lg > li > span {
  padding: 10px 16px;
  font-size: 18px; }
.pagination-lg > li:first-child > a, .pagination-lg > li:first-child > span {
  border-bottom-left-radius: 6px;
  border-top-left-radius: 6px; }
.pagination-lg > li:last-child > a, .pagination-lg > li:last-child > span {
  border-bottom-right-radius: 6px;
  border-top-right-radius: 6px; }

.pagination-sm > li > a, .pagination-sm > li > span {
  padding: 5px 10px;
  font-size: 14px; }
.pagination-sm > li:first-child > a, .pagination-sm > li:first-child > span {
  border-bottom-left-radius: 3px;
  border-top-left-radius: 3px; }
.pagination-sm > li:last-child > a, .pagination-sm > li:last-child > span {
  border-bottom-right-radius: 3px;
  border-top-right-radius: 3px; }

.pager {
  padding-left: 0;
  margin: 23px 0;
  list-style: none;
  text-align: center; }
  .pager:before, .pager:after {
    content: " ";
    display: table; }
  .pager:after {
    clear: both; }
  .pager li {
    display: inline; }
    .pager li > a, .pager li > span {
      display: inline-block;
      padding: 5px 14px;
      background-color: #eaebed;
      border: 1px solid #dcdee1;
      border-radius: 4px; }
    .pager li > a:hover, .pager li > a:focus {
      text-decoration: none;
      background-color: #d4d6da; }
  .pager .next > a, .pager .next > span {
    float: right; }
  .pager .previous > a, .pager .previous > span {
    float: left; }
  .pager .disabled > a, .pager .disabled > a:hover, .pager .disabled > a:focus, .pager .disabled > span {
    color: #767676;
    background-color: #eaebed;
    cursor: not-allowed; }

.label {
  display: inline;
  padding: 0.2em 0.6em 0.3em;
  font-size: 75%;
  font-weight: bold;
  line-height: 1;
  color: #fff;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: 0.25em; }
  .label:empty {
    display: none; }
  .btn .label {
    position: relative;
    top: -1px; }

a.label:hover, a.label:focus {
  color: #fff;
  text-decoration: none;
  cursor: pointer; }

.label-default {
  background-color: #767676; }
  .label-default[href]:hover, .label-default[href]:focus {
    background-color: #5d5d5d; }

.label-primary {
  background-color: #2572b4; }
  .label-primary[href]:hover, .label-primary[href]:focus {
    background-color: #1c588a; }

.label-success {
  background-color: #1b6c1c; }
  .label-success[href]:hover, .label-success[href]:focus {
    background-color: #114311; }

.label-info {
  background-color: #4d4d4d; }
  .label-info[href]:hover, .label-info[href]:focus {
    background-color: #343434; }

.label-warning {
  background-color: #f2d40d; }
  .label-warning[href]:hover, .label-warning[href]:focus {
    background-color: #c2a90a; }

.label-danger {
  background-color: #bc3331; }
  .label-danger[href]:hover, .label-danger[href]:focus {
    background-color: #942626; }

.badge {
  display: inline-block;
  min-width: 10px;
  padding: 3px 7px;
  font-size: 14px;
  font-weight: bold;
  color: #fff;
  line-height: 1;
  vertical-align: baseline;
  white-space: nowrap;
  text-align: center;
  background-color: #767676;
  border-radius: 10px; }
  .badge:empty {
    display: none; }
  .btn .badge {
    position: relative;
    top: -1px; }
  .btn-xs .badge, .btn-xs .btn-group-xs > .btn, .btn-group-xs > .btn-xs .btn {
    top: 0;
    padding: 1px 5px; }
  .list-group-item.active > .badge, .nav-pills > .active > a > .badge {
    color: #295376;
    background-color: #fff; }
  .list-group-item > .badge {
    float: right; }
  .list-group-item > .badge + .badge {
    margin-right: 5px; }
  .nav-pills > li > a > .badge {
    margin-left: 3px; }

a.badge:hover, a.badge:focus {
  color: #fff;
  text-decoration: none;
  cursor: pointer; }

.jumbotron {
  padding: 30px 15px;
  margin-bottom: 30px;
  color: inherit;
  background-color: #eeeeee; }
  .jumbotron h1, .jumbotron .h1 {
    color: inherit; }
  .jumbotron p {
    margin-bottom: 15px;
    font-size: 24px;
    font-weight: 200; }
  .jumbotron > hr {
    border-top-color: #d5d5d5; }
  .container .jumbotron, .container-fluid .jumbotron {
    border-radius: 6px; }
  .jumbotron .container {
    max-width: 100%; }
  @media screen and (min-width: 768px) {
    .jumbotron {
      padding: 48px 0; }
      .container .jumbotron, .container-fluid .jumbotron {
        padding-left: 60px;
        padding-right: 60px; }
      .jumbotron h1, .jumbotron .h1 {
        font-size: 72px; } }

.thumbnail {
  display: block;
  padding: 4px;
  margin-bottom: 23px;
  line-height: 1.4375;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 4px;
  -webkit-transition: border 0.2s ease-in-out;
  transition: border 0.2s ease-in-out; }
  .thumbnail > img, .thumbnail a > img {
    display: block;
    max-width: 100%;
    height: auto;
    margin-left: auto;
    margin-right: auto; }
  .thumbnail .caption {
    padding: 9px;
    color: #333333; }

a.thumbnail:hover, a.thumbnail:focus, a.thumbnail.active {
  border-color: #295376; }

.alert {
  padding: 15px;
  /*margin-bottom: 23px;*/
  border: 1px solid transparent;
  border-radius: 4px; }
  .alert h4 {
    margin-top: 0;
    color: inherit; }
  .alert .alert-link {
    font-weight: bold; }
  .alert > p, .alert > ul {
    margin-bottom: 0; }
  .alert > p + p {
    margin-top: 5px; }

.alert-dismissable, .alert-dismissible {
  padding-right: 35px; }
  .alert-dismissable .close, .alert-dismissible .close {
    position: relative;
    top: -2px;
    right: -21px;
    color: inherit; }

.alert-success {
  background-color: #dff0d8;
  border-color: #d7e9c6;
  color: #3c763d; }
  .alert-success hr {
    border-top-color: #cae2b3; }
  .alert-success .alert-link {
    color: #2b542b; }

.alert-info {
  background-color: #d9edf7;
  border-color: #bce9f1;
  color: #31708f; }
  .alert-info hr {
    border-top-color: #a6e2ec; }
  .alert-info .alert-link {
    color: #245369; }

.alert-warning {
  background-color: #fcf8e3;
  border-color: #faeacc;
  color: #8a6d3b; }
  .alert-warning hr {
    border-top-color: #f7e0b5; }
  .alert-warning .alert-link {
    color: #66502c; }

.alert-error {
  background-color: #f2dede;
  border-color: #ebccd1;
  color: #a94442; }
  .alert-danger hr {
    border-top-color: #e4b9c0; }
  .alert-danger .alert-link {
    color: #843534; }

@-webkit-keyframes progress-bar-stripes {
  from {
    background-position: 40px 0; }

  to {
    background-position: 0 0; } }

@keyframes progress-bar-stripes {
  from {
    background-position: 40px 0; }

  to {
    background-position: 0 0; } }

.progress {
  overflow: hidden;
  height: 23px;
  margin-bottom: 23px;
  background-color: #f5f5f5;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); }

.progress-bar {
  float: left;
  width: 0%;
  height: 100%;
  font-size: 14px;
  line-height: 23px;
  color: #fff;
  text-align: center;
  background-color: #2572b4;
  -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15);
  box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15);
  -webkit-transition: width 0.6s ease;
  transition: width 0.6s ease; }

.progress-striped .progress-bar, .progress-bar-striped {
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  -webkit-background-size: 40px 40px;
  background-size: 40px 40px; }

.progress.active .progress-bar, .progress-bar.active {
  -webkit-animation: progress-bar-stripes 2s linear infinite;
  animation: progress-bar-stripes 2s linear infinite; }

.progress-bar-success {
  background-color: #1b6c1c; }
  .progress-striped .progress-bar-success {
    background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); }

.progress-bar-info {
  background-color: #4d4d4d; }
  .progress-striped .progress-bar-info {
    background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); }

.progress-bar-warning {
  background-color: #f2d40d; }
  .progress-striped .progress-bar-warning {
    background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); }

.progress-bar-danger {
  background-color: #bc3331; }
  .progress-striped .progress-bar-danger {
    background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); }

.media {
  margin-top: 15px; }
  .media:first-child {
    margin-top: 0; }

.media-right, .media > .pull-right {
  padding-left: 10px; }

.media-left, .media > .pull-left {
  padding-right: 10px; }

.media-left, .media-right, .media-body {
  display: table-cell;
  vertical-align: top; }

.media-middle {
  vertical-align: middle; }

.media-bottom {
  vertical-align: bottom; }

.media-heading {
  margin-top: 0;
  margin-bottom: 5px; }

.media-list {
  padding-left: 0;
  list-style: none; }

.list-group {
  margin-bottom: 20px;
  padding-left: 0; }

.list-group-item {
  position: relative;
  display: block;
  padding: 10px 15px;
  margin-bottom: -1px;
  background-color: #fff;
  border: 1px solid #ddd; }
  .list-group-item:first-child {
    border-top-right-radius: 4px;
    border-top-left-radius: 4px; }
  .list-group-item:last-child {
    margin-bottom: 0;
    border-bottom-right-radius: 4px;
    border-bottom-left-radius: 4px; }

a.list-group-item {
  color: #555; }
  a.list-group-item .list-group-item-heading {
    color: #333; }
  a.list-group-item:hover, a.list-group-item:focus {
    text-decoration: none;
    color: #555;
    background-color: #f5f5f5; }

.list-group-item.disabled, .list-group-item.disabled:hover, .list-group-item.disabled:focus {
  background-color: #eeeeee;
  color: #767676;
  cursor: not-allowed; }
  .list-group-item.disabled .list-group-item-heading, .list-group-item.disabled:hover .list-group-item-heading, .list-group-item.disabled:focus .list-group-item-heading {
    color: inherit; }
  .list-group-item.disabled .list-group-item-text, .list-group-item.disabled:hover .list-group-item-text, .list-group-item.disabled:focus .list-group-item-text {
    color: #767676; }
.list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
  z-index: 2;
  color: #fff;
  background-color: #2572b4;
  border-color: #2572b4; }
  .list-group-item.active .list-group-item-heading, .list-group-item.active .list-group-item-heading > small, .list-group-item.active .list-group-item-heading > .small, .list-group-item.active:hover .list-group-item-heading, .list-group-item.active:hover .list-group-item-heading > small, .list-group-item.active:hover .list-group-item-heading > .small, .list-group-item.active:focus .list-group-item-heading, .list-group-item.active:focus .list-group-item-heading > small, .list-group-item.active:focus .list-group-item-heading > .small {
    color: inherit; }
  .list-group-item.active .list-group-item-text, .list-group-item.active:hover .list-group-item-text, .list-group-item.active:focus .list-group-item-text {
    color: #b5d5f0; }

.list-group-item-success {
  color: #3c763d;
  background-color: #dff0d8; }

a.list-group-item-success {
  color: #3c763d; }
  a.list-group-item-success .list-group-item-heading {
    color: inherit; }
  a.list-group-item-success:hover, a.list-group-item-success:focus {
    color: #3c763d;
    background-color: #d0e9c6; }
  a.list-group-item-success.active, a.list-group-item-success.active:hover, a.list-group-item-success.active:focus {
    color: #fff;
    background-color: #3c763d;
    border-color: #3c763d; }

.list-group-item-info {
  color: #31708f;
  background-color: #d9edf7; }

a.list-group-item-info {
  color: #31708f; }
  a.list-group-item-info .list-group-item-heading {
    color: inherit; }
  a.list-group-item-info:hover, a.list-group-item-info:focus {
    color: #31708f;
    background-color: #c4e4f3; }
  a.list-group-item-info.active, a.list-group-item-info.active:hover, a.list-group-item-info.active:focus {
    color: #fff;
    background-color: #31708f;
    border-color: #31708f; }

.list-group-item-warning {
  color: #8a6d3b;
  background-color: #fcf8e3; }

a.list-group-item-warning {
  color: #8a6d3b; }
  a.list-group-item-warning .list-group-item-heading {
    color: inherit; }
  a.list-group-item-warning:hover, a.list-group-item-warning:focus {
    color: #8a6d3b;
    background-color: #faf2cc; }
  a.list-group-item-warning.active, a.list-group-item-warning.active:hover, a.list-group-item-warning.active:focus {
    color: #fff;
    background-color: #8a6d3b;
    border-color: #8a6d3b; }

.list-group-item-danger {
  color: #a94442;
  background-color: #f2dede; }

a.list-group-item-danger {
  color: #a94442; }
  a.list-group-item-danger .list-group-item-heading {
    color: inherit; }
  a.list-group-item-danger:hover, a.list-group-item-danger:focus {
    color: #a94442;
    background-color: #ebcccc; }
  a.list-group-item-danger.active, a.list-group-item-danger.active:hover, a.list-group-item-danger.active:focus {
    color: #fff;
    background-color: #a94442;
    border-color: #a94442; }

.list-group-item-heading {
  margin-top: 0;
  margin-bottom: 5px; }

.list-group-item-text {
  margin-bottom: 0;
  line-height: 1.3; }

.panel {
  margin-bottom: 23px;
  background-color: #fff;
  border: 1px solid transparent;
  border-radius: 4px;
  -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05); }

.panel-body {
  padding: 15px; }
  .panel-body:before, .panel-body:after {
    content: " ";
    display: table; }
  .panel-body:after {
    clear: both; }

.panel-heading {
  padding: 10px 15px;
  border-bottom: 1px solid transparent;
  border-top-right-radius: 3px;
  border-top-left-radius: 3px; }
  .panel-heading > .dropdown .dropdown-toggle {
    color: inherit; }

.panel-title {
  margin-top: 0;
  margin-bottom: 0;
  font-size: 18px;
  color: inherit; }
  .panel-title > a {
    color: inherit; }

.panel-footer {
  padding: 10px 15px;
  background-color: #f5f5f5;
  border-top: 1px solid #ddd;
  border-bottom-right-radius: 3px;
  border-bottom-left-radius: 3px; }

.panel > .list-group, .panel > .panel-collapse > .list-group {
  margin-bottom: 0; }
  .panel > .list-group .list-group-item, .panel > .panel-collapse > .list-group .list-group-item {
    border-width: 1px 0;
    border-radius: 0; }
  .panel > .list-group:first-child .list-group-item:first-child, .panel > .panel-collapse > .list-group:first-child .list-group-item:first-child {
    border-top: 0;
    border-top-right-radius: 3px;
    border-top-left-radius: 3px; }
  .panel > .list-group:last-child .list-group-item:last-child, .panel > .panel-collapse > .list-group:last-child .list-group-item:last-child {
    border-bottom: 0;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px; }

.panel-heading + .list-group .list-group-item:first-child {
  border-top-width: 0; }

.list-group + .panel-footer {
  border-top-width: 0; }

.panel > .table, .panel > .table-responsive > .table, .panel > .panel-collapse > .table {
  margin-bottom: 0; }
  .panel > .table caption, .panel > .table-responsive > .table caption, .panel > .panel-collapse > .table caption {
    padding-left: 15px;
    padding-right: 15px; }
.panel > .table:first-child, .panel > .table-responsive:first-child > .table:first-child {
  border-top-right-radius: 3px;
  border-top-left-radius: 3px; }
  .panel > .table:first-child > thead:first-child > tr:first-child, .panel > .table:first-child > tbody:first-child > tr:first-child, .panel > .table-responsive:first-child > .table:first-child > thead:first-child > tr:first-child, .panel > .table-responsive:first-child > .table:first-child > tbody:first-child > tr:first-child {
    border-top-left-radius: 3px;
    border-top-right-radius: 3px; }
    .panel > .table:first-child > thead:first-child > tr:first-child td:first-child, .panel > .table:first-child > thead:first-child > tr:first-child th:first-child, .panel > .table:first-child > tbody:first-child > tr:first-child td:first-child, .panel > .table:first-child > tbody:first-child > tr:first-child th:first-child, .panel > .table-responsive:first-child > .table:first-child > thead:first-child > tr:first-child td:first-child, .panel > .table-responsive:first-child > .table:first-child > thead:first-child > tr:first-child th:first-child, .panel > .table-responsive:first-child > .table:first-child > tbody:first-child > tr:first-child td:first-child, .panel > .table-responsive:first-child > .table:first-child > tbody:first-child > tr:first-child th:first-child {
      border-top-left-radius: 3px; }
    .panel > .table:first-child > thead:first-child > tr:first-child td:last-child, .panel > .table:first-child > thead:first-child > tr:first-child th:last-child, .panel > .table:first-child > tbody:first-child > tr:first-child td:last-child, .panel > .table:first-child > tbody:first-child > tr:first-child th:last-child, .panel > .table-responsive:first-child > .table:first-child > thead:first-child > tr:first-child td:last-child, .panel > .table-responsive:first-child > .table:first-child > thead:first-child > tr:first-child th:last-child, .panel > .table-responsive:first-child > .table:first-child > tbody:first-child > tr:first-child td:last-child, .panel > .table-responsive:first-child > .table:first-child > tbody:first-child > tr:first-child th:last-child {
      border-top-right-radius: 3px; }
.panel > .table:last-child, .panel > .table-responsive:last-child > .table:last-child {
  border-bottom-right-radius: 3px;
  border-bottom-left-radius: 3px; }
  .panel > .table:last-child > tbody:last-child > tr:last-child, .panel > .table:last-child > tfoot:last-child > tr:last-child, .panel > .table-responsive:last-child > .table:last-child > tbody:last-child > tr:last-child, .panel > .table-responsive:last-child > .table:last-child > tfoot:last-child > tr:last-child {
    border-bottom-left-radius: 3px;
    border-bottom-right-radius: 3px; }
    .panel > .table:last-child > tbody:last-child > tr:last-child td:first-child, .panel > .table:last-child > tbody:last-child > tr:last-child th:first-child, .panel > .table:last-child > tfoot:last-child > tr:last-child td:first-child, .panel > .table:last-child > tfoot:last-child > tr:last-child th:first-child, .panel > .table-responsive:last-child > .table:last-child > tbody:last-child > tr:last-child td:first-child, .panel > .table-responsive:last-child > .table:last-child > tbody:last-child > tr:last-child th:first-child, .panel > .table-responsive:last-child > .table:last-child > tfoot:last-child > tr:last-child td:first-child, .panel > .table-responsive:last-child > .table:last-child > tfoot:last-child > tr:last-child th:first-child {
      border-bottom-left-radius: 3px; }
    .panel > .table:last-child > tbody:last-child > tr:last-child td:last-child, .panel > .table:last-child > tbody:last-child > tr:last-child th:last-child, .panel > .table:last-child > tfoot:last-child > tr:last-child td:last-child, .panel > .table:last-child > tfoot:last-child > tr:last-child th:last-child, .panel > .table-responsive:last-child > .table:last-child > tbody:last-child > tr:last-child td:last-child, .panel > .table-responsive:last-child > .table:last-child > tbody:last-child > tr:last-child th:last-child, .panel > .table-responsive:last-child > .table:last-child > tfoot:last-child > tr:last-child td:last-child, .panel > .table-responsive:last-child > .table:last-child > tfoot:last-child > tr:last-child th:last-child {
      border-bottom-right-radius: 3px; }
.panel > .panel-body + .table, .panel > .panel-body + .table-responsive, .panel > .table + .panel-body, .panel > .table-responsive + .panel-body {
  border-top: 1px solid #ddd; }
.panel > .table > tbody:first-child > tr:first-child th, .panel > .table > tbody:first-child > tr:first-child td {
  border-top: 0; }
.panel > .table-bordered, .panel > .table-responsive > .table-bordered {
  border: 0; }
  .panel > .table-bordered > thead > tr > th:first-child, .panel > .table-bordered > thead > tr > td:first-child, .panel > .table-bordered > tbody > tr > th:first-child, .panel > .table-bordered > tbody > tr > td:first-child, .panel > .table-bordered > tfoot > tr > th:first-child, .panel > .table-bordered > tfoot > tr > td:first-child, .panel > .table-responsive > .table-bordered > thead > tr > th:first-child, .panel > .table-responsive > .table-bordered > thead > tr > td:first-child, .panel > .table-responsive > .table-bordered > tbody > tr > th:first-child, .panel > .table-responsive > .table-bordered > tbody > tr > td:first-child, .panel > .table-responsive > .table-bordered > tfoot > tr > th:first-child, .panel > .table-responsive > .table-bordered > tfoot > tr > td:first-child {
    border-left: 0; }
  .panel > .table-bordered > thead > tr > th:last-child, .panel > .table-bordered > thead > tr > td:last-child, .panel > .table-bordered > tbody > tr > th:last-child, .panel > .table-bordered > tbody > tr > td:last-child, .panel > .table-bordered > tfoot > tr > th:last-child, .panel > .table-bordered > tfoot > tr > td:last-child, .panel > .table-responsive > .table-bordered > thead > tr > th:last-child, .panel > .table-responsive > .table-bordered > thead > tr > td:last-child, .panel > .table-responsive > .table-bordered > tbody > tr > th:last-child, .panel > .table-responsive > .table-bordered > tbody > tr > td:last-child, .panel > .table-responsive > .table-bordered > tfoot > tr > th:last-child, .panel > .table-responsive > .table-bordered > tfoot > tr > td:last-child {
    border-right: 0; }
  .panel > .table-bordered > thead > tr:first-child > td, .panel > .table-bordered > thead > tr:first-child > th, .panel > .table-bordered > tbody > tr:first-child > td, .panel > .table-bordered > tbody > tr:first-child > th, .panel > .table-responsive > .table-bordered > thead > tr:first-child > td, .panel > .table-responsive > .table-bordered > thead > tr:first-child > th, .panel > .table-responsive > .table-bordered > tbody > tr:first-child > td, .panel > .table-responsive > .table-bordered > tbody > tr:first-child > th {
    border-bottom: 0; }
  .panel > .table-bordered > tbody > tr:last-child > td, .panel > .table-bordered > tbody > tr:last-child > th, .panel > .table-bordered > tfoot > tr:last-child > td, .panel > .table-bordered > tfoot > tr:last-child > th, .panel > .table-responsive > .table-bordered > tbody > tr:last-child > td, .panel > .table-responsive > .table-bordered > tbody > tr:last-child > th, .panel > .table-responsive > .table-bordered > tfoot > tr:last-child > td, .panel > .table-responsive > .table-bordered > tfoot > tr:last-child > th {
    border-bottom: 0; }
.panel > .table-responsive {
  border: 0;
  margin-bottom: 0; }

.panel-group {
  margin-bottom: 23px; }
  .panel-group .panel {
    margin-bottom: 0;
    border-radius: 4px; }
    .panel-group .panel + .panel {
      margin-top: 5px; }
  .panel-group .panel-heading {
    border-bottom: 0; }
    .panel-group .panel-heading + .panel-collapse > .panel-body, .panel-group .panel-heading + .panel-collapse > .list-group {
      border-top: 1px solid #ddd; }
  .panel-group .panel-footer {
    border-top: 0; }
    .panel-group .panel-footer + .panel-collapse .panel-body {
      border-bottom: 1px solid #ddd; }

.panel-default {
  border-color: #ddd; }
  .panel-default > .panel-heading {
    color: #333333;
    background-color: #f5f5f5;
    border-color: #ddd; }
    .panel-default > .panel-heading + .panel-collapse > .panel-body {
      border-top-color: #ddd; }
    .panel-default > .panel-heading .badge {
      color: #f5f5f5;
      background-color: #333333; }
  .panel-default > .panel-footer + .panel-collapse > .panel-body {
    border-bottom-color: #ddd; }

.panel-primary {
  border-color: #2572b4; }
  .panel-primary > .panel-heading {
    color: #fff;
    background-color: #2572b4;
    border-color: #2572b4; }
    .panel-primary > .panel-heading + .panel-collapse > .panel-body {
      border-top-color: #2572b4; }
    .panel-primary > .panel-heading .badge {
      color: #2572b4;
      background-color: #fff; }
  .panel-primary > .panel-footer + .panel-collapse > .panel-body {
    border-bottom-color: #2572b4; }

.panel-success {
  border-color: #d7e9c6; }
  .panel-success > .panel-heading {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d7e9c6; }
    .panel-success > .panel-heading + .panel-collapse > .panel-body {
      border-top-color: #d7e9c6; }
    .panel-success > .panel-heading .badge {
      color: #dff0d8;
      background-color: #3c763d; }
  .panel-success > .panel-footer + .panel-collapse > .panel-body {
    border-bottom-color: #d7e9c6; }

.panel-info {
  border-color: #bce9f1; }
  .panel-info > .panel-heading {
    color: #31708f;
    background-color: #d9edf7;
    border-color: #bce9f1; }
    .panel-info > .panel-heading + .panel-collapse > .panel-body {
      border-top-color: #bce9f1; }
    .panel-info > .panel-heading .badge {
      color: #d9edf7;
      background-color: #31708f; }
  .panel-info > .panel-footer + .panel-collapse > .panel-body {
    border-bottom-color: #bce9f1; }

.panel-warning {
  border-color: #faeacc; }
  .panel-warning > .panel-heading {
    color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faeacc; }
    .panel-warning > .panel-heading + .panel-collapse > .panel-body {
      border-top-color: #faeacc; }
    .panel-warning > .panel-heading .badge {
      color: #fcf8e3;
      background-color: #8a6d3b; }
  .panel-warning > .panel-footer + .panel-collapse > .panel-body {
    border-bottom-color: #faeacc; }

.panel-danger {
  border-color: #ebccd1; }
  .panel-danger > .panel-heading {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1; }
    .panel-danger > .panel-heading + .panel-collapse > .panel-body {
      border-top-color: #ebccd1; }
    .panel-danger > .panel-heading .badge {
      color: #f2dede;
      background-color: #a94442; }
  .panel-danger > .panel-footer + .panel-collapse > .panel-body {
    border-bottom-color: #ebccd1; }

.embed-responsive {
  position: relative;
  display: block;
  height: 0;
  padding: 0;
  overflow: hidden; }
  .embed-responsive .embed-responsive-item, .embed-responsive iframe, .embed-responsive embed, .embed-responsive object, .embed-responsive video {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    height: 100%;
    width: 100%;
    border: 0; }
  .embed-responsive.embed-responsive-16by9 {
    padding-bottom: 56.25%; }
  .embed-responsive.embed-responsive-4by3 {
    padding-bottom: 75%; }

.well {
  min-height: 20px;
  padding: 19px;
  margin-bottom: 20px;
  background-color: #f5f5f5;
  border: 1px solid #e3e3e3;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); }
  .well blockquote {
    border-color: #ddd;
    border-color: rgba(0, 0, 0, 0.15); }

.well-lg {
  padding: 24px;
  border-radius: 6px; }

.well-sm {
  padding: 9px;
  border-radius: 3px; }

.close {
  float: right;
  font-size: 24px;
  font-weight: bold;
  line-height: 1;
  color: #000;
  text-shadow: 0 1px 0 #fff;
  opacity: 0.2;
  filter: alpha(opacity=20); }
  .close:hover, .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    opacity: 0.5;
    filter: alpha(opacity=50); }

button.close {
  padding: 0;
  cursor: pointer;
  background: transparent;
  border: 0;
  -webkit-appearance: none; }

.modal-open {
  overflow: hidden; }

.modal {
  display: none;
  overflow: hidden;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1040;
  -webkit-overflow-scrolling: touch;
  outline: 0; }
  .modal.fade .modal-dialog {
    -webkit-transform: translate(0, -25%);
    -ms-transform: translate(0, -25%);
    transform: translate(0, -25%);
    -webkit-transition: -webkit-transform 0.3s ease-out;
    transition: transform 0.3s ease-out; }
  .modal.in .modal-dialog {
    -webkit-transform: translate(0, 0);
    -ms-transform: translate(0, 0);
    transform: translate(0, 0); }

.modal-open .modal {
  overflow-x: hidden;
  overflow-y: auto; }

.modal-dialog {
  position: relative;
  width: auto;
  margin: 10px; }

.modal-content {
  position: relative;
  background-color: #fff;
  border: 1px solid #999;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 6px;
  -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
  box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
  -webkit-background-clip: padding-box;
  background-clip: padding-box;
  outline: 0; }

.modal-backdrop {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  background-color: #000; }
  .modal-backdrop.fade {
    opacity: 0;
    filter: alpha(opacity=0); }
  .modal-backdrop.in {
    opacity: 0.5;
    filter: alpha(opacity=50); }

.modal-header {
  padding: 15px;
  border-bottom: 1px solid #e5e5e5;
  min-height: 16.4375px; }

.modal-header .close {
  margin-top: -2px; }

.modal-title {
  margin: 0;
  line-height: 1.4375; }

.modal-body {
  position: relative;
  padding: 15px; }

.modal-footer {
  padding: 15px;
  text-align: right;
  border-top: 1px solid #e5e5e5; }
  .modal-footer:before, .modal-footer:after {
    content: " ";
    display: table; }
  .modal-footer:after {
    clear: both; }
  .modal-footer .btn + .btn {
    margin-left: 5px;
    margin-bottom: 0; }
  .modal-footer .btn-group .btn + .btn {
    margin-left: -1px; }
  .modal-footer .btn-block + .btn-block {
    margin-left: 0; }

.modal-scrollbar-measure {
  position: absolute;
  top: -9999px;
  width: 50px;
  height: 50px;
  overflow: scroll; }

@media (min-width: 768px) {
  .modal-dialog {
    width: 600px;
    margin: 30px auto; }
  .modal-content {
    -webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5); }
  .modal-sm {
    width: 300px; } }

@media (min-width: 992px) {
  .modal-lg {
    width: 900px; } }

.tooltip {
  position: absolute;
  z-index: 1070;
  display: block;
  visibility: visible;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 14px;
  font-weight: normal;
  line-height: 1.4;
  opacity: 0;
  filter: alpha(opacity=0); }
  .tooltip.in {
    opacity: 0.9;
    filter: alpha(opacity=90); }
  .tooltip.top {
    margin-top: -3px;
    padding: 5px 0; }
  .tooltip.right {
    margin-left: 3px;
    padding: 0 5px; }
  .tooltip.bottom {
    margin-top: 3px;
    padding: 5px 0; }
  .tooltip.left {
    margin-left: -3px;
    padding: 0 5px; }

.tooltip-inner {
  max-width: 200px;
  padding: 3px 8px;
  color: #fff;
  text-align: center;
  text-decoration: none;
  background-color: #000;
  border-radius: 4px; }

.tooltip-arrow {
  position: absolute;
  width: 0;
  height: 0;
  border-color: transparent;
  border-style: solid; }

.tooltip.top .tooltip-arrow {
  bottom: 0;
  left: 50%;
  margin-left: -5px;
  border-width: 5px 5px 0;
  border-top-color: #000; }
.tooltip.top-left .tooltip-arrow {
  bottom: 0;
  right: 5px;
  margin-bottom: -5px;
  border-width: 5px 5px 0;
  border-top-color: #000; }
.tooltip.top-right .tooltip-arrow {
  bottom: 0;
  left: 5px;
  margin-bottom: -5px;
  border-width: 5px 5px 0;
  border-top-color: #000; }
.tooltip.right .tooltip-arrow {
  top: 50%;
  left: 0;
  margin-top: -5px;
  border-width: 5px 5px 5px 0;
  border-right-color: #000; }
.tooltip.left .tooltip-arrow {
  top: 50%;
  right: 0;
  margin-top: -5px;
  border-width: 5px 0 5px 5px;
  border-left-color: #000; }
.tooltip.bottom .tooltip-arrow {
  top: 0;
  left: 50%;
  margin-left: -5px;
  border-width: 0 5px 5px;
  border-bottom-color: #000; }
.tooltip.bottom-left .tooltip-arrow {
  top: 0;
  right: 5px;
  margin-top: -5px;
  border-width: 0 5px 5px;
  border-bottom-color: #000; }
.tooltip.bottom-right .tooltip-arrow {
  top: 0;
  left: 5px;
  margin-top: -5px;
  border-width: 0 5px 5px;
  border-bottom-color: #000; }

.popover {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1060;
  display: none;
  max-width: 276px;
  padding: 1px;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 16px;
  font-weight: normal;
  line-height: 1.4375;
  text-align: left;
  background-color: #fff;
  -webkit-background-clip: padding-box;
  background-clip: padding-box;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  white-space: normal; }
  .popover.top {
    margin-top: -10px; }
  .popover.right {
    margin-left: 10px; }
  .popover.bottom {
    margin-top: 10px; }
  .popover.left {
    margin-left: -10px; }

.popover-title {
  margin: 0;
  padding: 8px 14px;
  font-size: 16px;
  background-color: #f7f7f7;
  border-bottom: 1px solid #ebebeb;
  border-radius: 5px 5px 0 0; }

.popover-content {
  padding: 9px 14px; }

.popover > .arrow, .popover > .arrow:after {
  position: absolute;
  display: block;
  width: 0;
  height: 0;
  border-color: transparent;
  border-style: solid; }

.popover > .arrow {
  border-width: 11px; }

.popover > .arrow:after {
  border-width: 10px;
  content: ""; }

.popover.top > .arrow {
  left: 50%;
  margin-left: -11px;
  border-bottom-width: 0;
  border-top-color: #999999;
  border-top-color: rgba(0, 0, 0, 0.25);
  bottom: -11px; }
  .popover.top > .arrow:after {
    content: " ";
    bottom: 1px;
    margin-left: -10px;
    border-bottom-width: 0;
    border-top-color: #fff; }
.popover.right > .arrow {
  top: 50%;
  left: -11px;
  margin-top: -11px;
  border-left-width: 0;
  border-right-color: #999999;
  border-right-color: rgba(0, 0, 0, 0.25); }
  .popover.right > .arrow:after {
    content: " ";
    left: 1px;
    bottom: -10px;
    border-left-width: 0;
    border-right-color: #fff; }
.popover.bottom > .arrow {
  left: 50%;
  margin-left: -11px;
  border-top-width: 0;
  border-bottom-color: #999999;
  border-bottom-color: rgba(0, 0, 0, 0.25);
  top: -11px; }
  .popover.bottom > .arrow:after {
    content: " ";
    top: 1px;
    margin-left: -10px;
    border-top-width: 0;
    border-bottom-color: #fff; }
.popover.left > .arrow {
  top: 50%;
  right: -11px;
  margin-top: -11px;
  border-right-width: 0;
  border-left-color: #999999;
  border-left-color: rgba(0, 0, 0, 0.25); }
  .popover.left > .arrow:after {
    content: " ";
    right: 1px;
    border-right-width: 0;
    border-left-color: #fff;
    bottom: -10px; }

.carousel {
  position: relative; }

.carousel-inner {
  position: relative;
  overflow: hidden;
  width: 100%; }
  .carousel-inner > .item {
    display: none;
    position: relative;
    -webkit-transition: 0.6s ease-in-out left;
    transition: 0.6s ease-in-out left; }
    .carousel-inner > .item > img, .carousel-inner > .item > a > img {
      display: block;
      max-width: 100%;
      height: auto;
      line-height: 1; }
    @media all and (transform-3d), (-webkit-transform-3d) {
      .carousel-inner > .item {
        -webkit-transition: -webkit-transform 0.6s ease-in-out;
        transition: transform 0.6s ease-in-out;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-perspective: 1000;
        perspective: 1000; }
        .carousel-inner > .item.next, .carousel-inner > .item.active.right {
          -webkit-transform: translate3d(100%, 0, 0);
          transform: translate3d(100%, 0, 0);
          left: 0; }
        .carousel-inner > .item.prev, .carousel-inner > .item.active.left {
          -webkit-transform: translate3d(-100%, 0, 0);
          transform: translate3d(-100%, 0, 0);
          left: 0; }
        .carousel-inner > .item.next.left, .carousel-inner > .item.prev.right, .carousel-inner > .item.active {
          -webkit-transform: translate3d(0, 0, 0);
          transform: translate3d(0, 0, 0);
          left: 0; } }
  .carousel-inner > .active, .carousel-inner > .next, .carousel-inner > .prev {
    display: block; }
  .carousel-inner > .active {
    left: 0; }
  .carousel-inner > .next, .carousel-inner > .prev {
    position: absolute;
    top: 0;
    width: 100%; }
  .carousel-inner > .next {
    left: 100%; }
  .carousel-inner > .prev {
    left: -100%; }
  .carousel-inner > .next.left, .carousel-inner > .prev.right {
    left: 0; }
  .carousel-inner > .active.left {
    left: -100%; }
  .carousel-inner > .active.right {
    left: 100%; }

.carousel-control {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  width: 15%;
  opacity: 0.5;
  filter: alpha(opacity=50);
  font-size: 20px;
  color: #fff;
  text-align: center;
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6); }
  .carousel-control.left {
    background-image: -webkit-linear-gradient(left, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.0001) 100%);
    background-image: -webkit-gradient(linear, left top, right top, from(rgba(0, 0, 0, 0.5)), to(rgba(0, 0, 0, 0.0001)));
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.0001) 100%);
    background-repeat: repeat-x;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#80000000', endColorstr='#00000000', GradientType=1); }
  .carousel-control.right {
    left: auto;
    right: 0;
    background-image: -webkit-linear-gradient(left, rgba(0, 0, 0, 0.0001) 0%, rgba(0, 0, 0, 0.5) 100%);
    background-image: -webkit-gradient(linear, left top, right top, from(rgba(0, 0, 0, 0.0001)), to(rgba(0, 0, 0, 0.5)));
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0.0001) 0%, rgba(0, 0, 0, 0.5) 100%);
    background-repeat: repeat-x;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#80000000', GradientType=1); }
  .carousel-control:hover, .carousel-control:focus {
    outline: 0;
    color: #fff;
    text-decoration: none;
    opacity: 0.9;
    filter: alpha(opacity=90); }
  .carousel-control .icon-prev, .carousel-control .icon-next, .carousel-control .glyphicon-chevron-left, .carousel-control .glyphicon-chevron-right {
    position: absolute;
    top: 50%;
    z-index: 5;
    display: inline-block; }
  .carousel-control .icon-prev, .carousel-control .glyphicon-chevron-left {
    left: 50%;
    margin-left: -10px; }
  .carousel-control .icon-next, .carousel-control .glyphicon-chevron-right {
    right: 50%;
    margin-right: -10px; }
  .carousel-control .icon-prev, .carousel-control .icon-next {
    width: 20px;
    height: 20px;
    margin-top: -10px;
    font-family: serif; }
  .carousel-control .icon-prev:before {
    content: '\2039'; }
  .carousel-control .icon-next:before {
    content: '\203a'; }

.carousel-indicators {
  position: absolute;
  bottom: 10px;
  left: 50%;
  z-index: 15;
  width: 60%;
  margin-left: -30%;
  padding-left: 0;
  list-style: none;
  text-align: center; }
  .carousel-indicators li {
    display: inline-block;
    width: 10px;
    height: 10px;
    margin: 1px;
    text-indent: -999px;
    border: 1px solid #fff;
    border-radius: 10px;
    cursor: pointer;
    background-color: #000 \9;
    background-color: rgba(0, 0, 0, 0); }
  .carousel-indicators .active {
    margin: 0;
    width: 12px;
    height: 12px;
    background-color: #fff; }

.carousel-caption {
  position: absolute;
  left: 15%;
  right: 15%;
  bottom: 20px;
  z-index: 10;
  padding-top: 20px;
  padding-bottom: 20px;
  color: #fff;
  text-align: center;
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6); }
  .carousel-caption .btn {
    text-shadow: none; }

@media screen and (min-width: 768px) {
  .carousel-control .glyphicon-chevron-left, .carousel-control .glyphicon-chevron-right, .carousel-control .icon-prev, .carousel-control .icon-next {
    width: 30px;
    height: 30px;
    margin-top: -15px;
    font-size: 30px; }
  .carousel-control .glyphicon-chevron-left, .carousel-control .icon-prev {
    margin-left: -15px; }
  .carousel-control .glyphicon-chevron-right, .carousel-control .icon-next {
    margin-right: -15px; }
  .carousel-caption {
    left: 20%;
    right: 20%;
    padding-bottom: 30px; }
  .carousel-indicators {
    bottom: 20px; } }

.clearfix:before, .clearfix:after {
  content: " ";
  display: table; }
.clearfix:after {
  clear: both; }

.center-block {
  display: block;
  margin-left: auto;
  margin-right: auto; }

.pull-right {
  float: right !important; }

.pull-left {
  float: left !important; }

.hide {
  display: none !important; }

.show {
  display: block !important; }

.invisible {
  visibility: hidden; }

.text-hide {
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0; }

.hidden {
  display: none !important;
  visibility: hidden !important; }

.affix {
  position: fixed; }

@-ms-viewport {
  width: device-width; }

.visible-xs, .visible-sm, .visible-md, .visible-lg {
  display: none !important; }

.visible-xs-block, .visible-xs-inline, .visible-xs-inline-block, .visible-sm-block, .visible-sm-inline, .visible-sm-inline-block, .visible-md-block, .visible-md-inline, .visible-md-inline-block, .visible-lg-block, .visible-lg-inline, .visible-lg-inline-block {
  display: none !important; }

@media (max-width: 767px) {
  .visible-xs {
    display: block !important; }
  table.visible-xs {
    display: table; }
  tr.visible-xs {
    display: table-row !important; }
  th.visible-xs, td.visible-xs {
    display: table-cell !important; } }

@media (max-width: 767px) {
  .visible-xs-block {
    display: block !important; } }

@media (max-width: 767px) {
  .visible-xs-inline {
    display: inline !important; } }

@media (max-width: 767px) {
  .visible-xs-inline-block {
    display: inline-block !important; } }

@media (min-width: 768px) and (max-width: 991px) {
  .visible-sm {
    display: block !important; }
  table.visible-sm {
    display: table; }
  tr.visible-sm {
    display: table-row !important; }
  th.visible-sm, td.visible-sm {
    display: table-cell !important; } }

@media (min-width: 768px) and (max-width: 991px) {
  .visible-sm-block {
    display: block !important; } }

@media (min-width: 768px) and (max-width: 991px) {
  .visible-sm-inline {
    display: inline !important; } }

@media (min-width: 768px) and (max-width: 991px) {
  .visible-sm-inline-block {
    display: inline-block !important; } }

@media (min-width: 992px) and (max-width: 1199px) {
  .visible-md {
    display: block !important; }
  table.visible-md {
    display: table; }
  tr.visible-md {
    display: table-row !important; }
  th.visible-md, td.visible-md {
    display: table-cell !important; } }

@media (min-width: 992px) and (max-width: 1199px) {
  .visible-md-block {
    display: block !important; } }

@media (min-width: 992px) and (max-width: 1199px) {
  .visible-md-inline {
    display: inline !important; } }

@media (min-width: 992px) and (max-width: 1199px) {
  .visible-md-inline-block {
    display: inline-block !important; } }

@media (min-width: 1200px) {
  .visible-lg {
    display: block !important; }
  table.visible-lg {
    display: table; }
  tr.visible-lg {
    display: table-row !important; }
  th.visible-lg, td.visible-lg {
    display: table-cell !important; } }

@media (min-width: 1200px) {
  .visible-lg-block {
    display: block !important; } }

@media (min-width: 1200px) {
  .visible-lg-inline {
    display: inline !important; } }

@media (min-width: 1200px) {
  .visible-lg-inline-block {
    display: inline-block !important; } }

@media (max-width: 767px) {
  .hidden-xs {
    display: none !important; } }

@media (min-width: 768px) and (max-width: 991px) {
  .hidden-sm {
    display: none !important; } }

@media (min-width: 992px) and (max-width: 1199px) {
  .hidden-md {
    display: none !important; } }

@media (min-width: 1200px) {
  .hidden-lg {
    display: none !important; } }

.visible-print {
  display: none !important; }

@media print {
  .visible-print {
    display: block !important; }
  table.visible-print {
    display: table; }
  tr.visible-print {
    display: table-row !important; }
  th.visible-print, td.visible-print {
    display: table-cell !important; } }

.visible-print-block {
  display: none !important; }
  @media print {
    .visible-print-block {
      display: block !important; } }

.visible-print-inline {
  display: none !important; }
  @media print {
    .visible-print-inline {
      display: inline !important; } }

.visible-print-inline-block {
  display: none !important; }
  @media print {
    .visible-print-inline-block {
      display: inline-block !important; } }

@media print {
  .hidden-print {
    display: none !important; } }

/*
  WET-BOEW
  @title: Bootstrap overrides for WET-BOEW
 */
/*
 *	Link colour and decoration
 */
a {
  text-decoration: underline; }
  a.btn {
    text-decoration: none; }
  a:visited {
    color: #7834bc; }

.btn-default:visited {
  color: #335075; }

.btn-primary:visited {
  color: #fff; }

.btn-success:visited {
  color: #fff; }

.btn-info:visited {
  color: #fff; }

.btn-warning:visited {
  color: #000; }

.btn-danger:visited {
  color: #fff; }

.dl-horizontal dt {
  white-space: normal; }

.dropdown-menu > li > a:visited {
  color: #333333; }

.nav > li > a:visited {
  color: #295376; }

.nav-pills > li.active > a:visited {
  color: #fff; }

.navbar-default .navbar-nav > li > a:visited {
  color: #777; }
@media (max-width: 767px) {
  .navbar-default .open .dropdown-menu > li > a {
    color: #777; } }
.navbar-default .navbar-link:visited {
  color: #777; }

.navbar-inverse .navbar-nav > li > a:visited {
  color: #9c9c9c; }
@media (max-width: 767px) {
  .navbar-inverse .open .dropdown-menu > li > a:visited {
    color: #9c9c9c; } }
.navbar-inverse .navbar-link:visited {
  color: #9c9c9c; }

/*
 *	Override the design of alerts and labels
 */
.alert, .label {
  border-radius: 0;
  border-style: solid;
  border-width: 0 0 0 4px; }

.alert > :first-child {
  margin-left: 1.2em;
  margin-top: auto; }
  .alert > :first-child:before {
    display: inline-block;
    font-family: "Glyphicons Halflings";
    margin-left: -1.3em;
    position: absolute; }
.alert > strong:first-child, .alert > em:first-child, .alert > span:first-child {
  display: inline-block; }

.label-default, .label-default[href]:hover, .label-default[href]:focus, .label-default[href]:active, .label-primary, .label-primary[href]:hover, .label-primary[href]:focus, .label-primary[href]:active, .label-success, .label-success[href]:hover, .label-success[href]:focus, .label-success[href]:active, .alert-success, .label-info, .label-info[href]:hover, .label-info[href]:focus, .label-info[href]:active, .alert-info, .label-warning, .label-warning[href]:hover, .label-warning[href]:focus, .label-warning[href]:active, .alert-warning, .label-danger, .label-danger[href]:hover, .label-danger[href]:focus, .label-danger[href]:active, .alert-danger {
  color: #000; }

.label-default[href]:hover, .label-default[href]:focus, .label-default[href]:active, .label-primary[href]:hover, .label-primary[href]:focus, .label-primary[href]:active, .label-success[href]:hover, .label-success[href]:focus, .label-success[href]:active, .label-info[href]:hover, .label-info[href]:focus, .label-info[href]:active, .label-warning[href]:hover, .label-warning[href]:focus, .label-warning[href]:active, .label-danger[href]:hover, .label-danger[href]:focus, .label-danger[href]:active {
  text-decoration: underline; }

.label-default, .label-default[href]:hover, .label-default[href]:focus, .label-default[href]:active {
  background: #eee;
  border-color: #acacac; }

.label-primary, .label-primary[href]:hover, .label-primary[href]:focus, .label-primary[href]:active {
  background: #e8f2f4;
  border-color: #083c6c; }

.label-success, .label-success[href]:hover, .label-success[href]:focus, .label-success[href]:active, .alert-success, details.alert-success {
  background: #d8eeca;
  border-color: #278400; }

.alert-success > :first-child:before {
  color: #278400;
  content: "\e084"; }

.label-info, .label-info[href]:hover, .label-info[href]:focus, .label-info[href]:active, .alert-info, details.alert-info {
  background: #d7faff;
  border-color: #269abc; }

.alert-info > :first-child:before {
  color: #269abc;
  content: "\e086"; }

.label-warning, .label-warning[href]:hover, .label-warning[href]:focus, .label-warning[href]:active, .alert-warning, details.alert-warning {
  background: #f9f4d4;
  border-color: #f90; }

.alert-warning > :first-child:before {
  color: #f90;
  content: "\e107"; }

.label-danger, .label-danger[href]:hover, .label-danger[href]:focus, .label-danger[href]:active, .alert-danger, details.alert-danger {
  background: #f3e9e8;
  border-color: #d3080c; }

.alert-danger > :first-child:before {
  color: #d3080c;
  content: "\e101"; }

details.alert {
  padding-left: 45px; }
  details.alert:before {
    display: inline-block;
    font-family: "Glyphicons Halflings";
    font-size: 24px;
    margin-left: -1.3em;
    margin-top: -3px;
    position: absolute; }
  details.alert > * {
    margin-left: 0.7em; }
  details.alert > :first-child {
    margin-left: 0.4em; }
    details.alert > :first-child:before {
      color: #000;
      content: "";
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; }
details.alert-success:before {
  color: #278400;
  content: "\e084"; }
details.alert-info:before {
  color: #269abc;
  content: "\e086"; }
details.alert-warning:before {
  color: #f90;
  content: "\e107"; }
details.alert-danger:before {
  color: #d3080c;
  content: "\e101"; }

/*
 *	Heading top margins
 */
h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6 {
  font-weight: 700; }

h1, .h1, h2, .h2 {
  margin-top: 38px; }

h3, .h3 {
  margin-top: 32px; }

h4, .h4 {
  margin-top: 26px; }

h5, .h5 {
  margin-top: 23px; }

h6, .h6 {
  margin-top: 21px; }

/*
 * Code
 */
code {
  white-space: normal; }

/*
 * Adding space for definition list items
 */
dt {
  margin-bottom: 3px; }

dd {
  margin-bottom: 15px; }

/*
 *	Firefox-safe line height on input[type="reset|button|submit"]
 */
input[type="reset"], input[type="button"], input[type="submit"] {
  height: 37px; }
  input[type="reset"].btn-lg, .btn-group-lg > input[type="reset"].btn, input[type="reset"].input-lg, .input-group-lg > input[type="reset"].form-control, .input-group-lg > input[type="reset"].input-group-addon, .input-group-lg > .input-group-btn > input[type="reset"].btn, input[type="button"].btn-lg, .btn-group-lg > input[type="button"].btn, input[type="button"].input-lg, .input-group-lg > input[type="button"].form-control, .input-group-lg > input[type="button"].input-group-addon, .input-group-lg > .input-group-btn > input[type="button"].btn, input[type="submit"].btn-lg, .btn-group-lg > input[type="submit"].btn, input[type="submit"].input-lg, .input-group-lg > input[type="submit"].form-control, .input-group-lg > input[type="submit"].input-group-addon, .input-group-lg > .input-group-btn > input[type="submit"].btn {
    height: 46px; }
  input[type="reset"].btn-sm, .btn-group-sm > input[type="reset"].btn, input[type="reset"].input-sm, .input-group-sm > input[type="reset"].form-control, .input-group-sm > input[type="reset"].input-group-addon, .input-group-sm > .input-group-btn > input[type="reset"].btn, input[type="button"].btn-sm, .btn-group-sm > input[type="button"].btn, input[type="button"].input-sm, .input-group-sm > input[type="button"].form-control, .input-group-sm > input[type="button"].input-group-addon, .input-group-sm > .input-group-btn > input[type="button"].btn, input[type="submit"].btn-sm, .btn-group-sm > input[type="submit"].btn, input[type="submit"].input-sm, .input-group-sm > input[type="submit"].form-control, .input-group-sm > input[type="submit"].input-group-addon, .input-group-sm > .input-group-btn > input[type="submit"].btn {
    height: 33px; }
  input[type="reset"].btn-xs, .btn-group-xs > input[type="reset"].btn, input[type="button"].btn-xs, .btn-group-xs > input[type="button"].btn, input[type="submit"].btn-xs, .btn-group-xs > input[type="submit"].btn {
    height: 25px; }

/**
 *	Disable pull-right/left on grid columns that do not match the current
 *	breakpoint
 */
@media (max-width: 767px) {
  .pull-left[class*=col-sm], .pull-left[class*=col-md], .pull-left[class*=col-lg], .pull-right[class*=col-sm], .pull-right[class*=col-md], .pull-right[class*=col-lg] {
    float: none !important; } }

@media (min-width: 768px) and (max-width: 991px) {
  .pull-left[class*=col-md], .pull-left[class*=col-lg], .pull-right[class*=col-md], .pull-right[class*=col-lg] {
    float: none !important; } }

@media (min-width: 992px) and (max-width: 1199px) {
  .pull-left[class*=col-lg], .pull-right[class*=col-lg] {
    float: none !important; } }

/*
 *	Blockquote font size
 */
blockquote {
  font-size: 16px; }

/*
 *	Form control width
 *
 *	Default should be representative of the expected length of input.
 *	Full width should be only for cases when the expected length of input is
 *	greater than the available width.
 */
.form-control {
  max-width: 100%;
  width: auto; }

/*
 *	Fieldset legend border position
 *
 *	Bootstrap puts the border below the legend which creates a visual
 *	separation between the legend and the fields to which it relates. Putting
 *	the border above eliminates that visual separation.
 */
legend {
  border-bottom: 0;
  border-top: 1px solid #e5e5e5; }

/*
 *	Pagination
 *	  * Add left/right arrows to previous/next buttons
 *	  * Increase size of the pagination buttons
 */
.pagination > li:first-child [rel="prev"]:before, .pager > li:first-child [rel="prev"]:before, [dir=rtl] .pagination [rel="next"]:before, [dir=rtl] .pager [rel="next"]:before, .dataTables_wrapper .dataTables_paginate .paginate_button.previous:before, [dir=rtl] .dataTables_wrapper .dataTables_paginate .paginate_button.next:before, .pagination > li:last-child [rel="next"]:after, .pager > li:last-child [rel="next"]:after, [dir=rtl] .pagination [rel="prev"]:after, [dir=rtl] .pager [rel="prev"]:after, .dataTables_wrapper .dataTables_paginate .paginate_button.next:after, [dir=rtl] .dataTables_wrapper .dataTables_paginate .paginate_button.previous:after, table.dataTable thead .sorting-icons:before, table.dataTable thead .sorting-icons:after {
  content: " ";
  font-family: "Glyphicons Halflings";
  font-weight: 400;
  line-height: 1em;
  position: relative;
  top: 0.1em; }

.pagination > li:first-child [rel="prev"]:before, .pager > li:first-child [rel="prev"]:before, [dir=rtl] .pagination [rel="next"]:before, [dir=rtl] .pager [rel="next"]:before, .dataTables_wrapper .dataTables_paginate .paginate_button.previous:before, [dir=rtl] .dataTables_wrapper .dataTables_paginate .paginate_button.next:before {
  content: "\e091";
  margin-right: 0.5em; }

.pagination > li:last-child [rel="next"]:after, .pager > li:last-child [rel="next"]:after, [dir=rtl] .pagination [rel="prev"]:after, [dir=rtl] .pager [rel="prev"]:after, .dataTables_wrapper .dataTables_paginate .paginate_button.next:after, [dir=rtl] .dataTables_wrapper .dataTables_paginate .paginate_button.previous:after {
  content: "\e092";
  margin-left: 0.5em; }

.pagination > li > a, .pager > li > a {
  cursor: pointer;
  display: inline-block;
  margin-bottom: 0.5em;
  padding: 10px 16px; }
.pagination > li.active > a, .pager > li.active > a {
  cursor: default; }
.pagination > li.disabled + li > a, .pager > li.disabled + li > a {
  border-bottom-left-radius: 4px;
  border-top-left-radius: 4px; }

.pager > li > a {
  text-decoration: none; }
.pager > li > a:hover, .pager > li > a:focus, .pager > li > span:hover, .pager > li > span:focus {
  border-color: #bbbfc5;
  color: #335075; }

/*
 *	Use button border style 'outset' to give buttons depth, except when disabled
 */
.btn {
  border-style: outset;
  /*
	 * These two property overrides should be recommended upstream to
	 * Bootstrap as a fix for button wrapping (see wet-boew/wet-boew#4454)
	 */
  height: auto;
  white-space: normal; }
  .btn.disabled, .btn[disabled], fieldset[disabled] .btn {
    border-style: solid; }

/*
 *  Right-to-left support
 */
[dir=rtl] .alert > :first-child {
  margin-left: auto;
  margin-right: 1.2em; }
  [dir=rtl] .alert > :first-child:before {
    margin-left: auto;
    margin-right: -1.3em; }
[dir=rtl] details.alert {
  padding-right: 45px; }
  [dir=rtl] details.alert:before {
    margin-right: -1.3em; }
  [dir=rtl] details.alert > * {
    margin-right: 0.7em; }
  [dir=rtl] details.alert > :first-child {
    margin-right: 0.4em; }
[dir=rtl] .list-unstyled {
  padding-right: 0; }
[dir=rtl] .pagination [rel="prev"], [dir=rtl] .pager [rel="prev"] {
  border-bottom-left-radius: 0;
  border-top-left-radius: 0;
  border-bottom-right-radius: 4px;
  border-top-right-radius: 4px; }
[dir=rtl] .pagination [rel="next"], [dir=rtl] .pager [rel="next"] {
  border-bottom-left-radius: 4px;
  border-top-left-radius: 4px;
  border-bottom-right-radius: 0;
  border-top-right-radius: 0; }
[dir=rtl] .pagination > li, [dir=rtl] .pager > li {
  float: right; }
  [dir=rtl] .pagination > li.disabled + li > a, [dir=rtl] .pager > li.disabled + li > a {
    border-bottom-left-radius: 0;
    border-top-left-radius: 0;
    border-bottom-right-radius: 4px;
    border-top-right-radius: 4px; }

caption {
  color: #333;
  font-size: 1.1em;
  font-weight: bold;
  text-align: center; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
/*
 * GLYPHICONS Halflings for Twitter Bootstrap by GLYPHICONS.com | Licensed under http://www.apache.org/licenses/LICENSE-2.0
 */
/*
 Global placeholders
 */
.wb-invisible, .wb-inv, .wb-show-onfocus, .wb-sl, #wb-lng h2, #wb-glb-mn h2, #wb-srch h2, #wb-srch label, #wb-sm h2, #wb-bc h2, #wb-sec h2, #wb-info h2, #mb-pnl h3, #wb-lng h2, .cal-days td ul, .wb-fnote dt, #mb-pnl .srch-pnl label {
  clip: rect(1px, 1px, 1px, 1px);
  height: 1px;
  margin: 0;
  overflow: hidden;
  position: absolute;
  width: 1px; }

.wb-show-onfocus:focus, .wb-sl:focus, .wb-disable .wb-slc .wb-sl {
  clip: rect(auto, auto, auto, auto);
  height: inherit;
  margin: inherit;
  overflow: inherit;
  position: static;
  width: inherit; }

.pagination.disabled, .pager.disabled, .pagination > li.disabled, .pager > li.disabled, [dir=rtl] .pagination [rel="prev"]:before, [dir=rtl] .pager [rel="prev"]:before, [dir=rtl] .pagination [rel="next"]:after, [dir=rtl] .pager [rel="next"]:after, #mb-pnl .modal-body h2, table.dataTable thead .sorting_disabled .sorting-cnt, table.dataTable thead .sorting_asc_disabled .sorting-icons:before, table.dataTable thead .sorting_desc_disabled .sorting-icons:after, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled, [dir=rtl] .dataTables_wrapper .dataTables_paginate .paginate_button.previous:before, [dir=rtl] .dataTables_wrapper .dataTables_paginate .paginate_button.next:after, [dir=rtl] .dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .wb-tabs.carousel-s1 [role="tablist"] li, .wb-tabs.carousel-s2 [role="tablist"] li {
  display: none; }

.wb-menu .sm.open li, .wb-disable .wb-tabs > details, .wb-disable .wb-tabs > .tabpanels > details {
  display: block; }

.wb-disable .wb-tabs > details[open] > summary, .wb-disable .wb-tabs > .tabpanels > details[open] > summary {
  display: block !important; }

.wb-menu .menu > li a, .wb-menu .menu > li a:hover, .wb-menu .menu > li a:focus, .wb-menu .active > a {
  text-decoration: none; }

.wb-mltmd.waiting .display:after, .wb-enable .wb-twitter .twitter-timeline:after, .wb-mltmd .display:after, .wb-mltmd.waiting .display:before, .wb-enable .wb-twitter .twitter-timeline:before, .wb-mltmd .display:before {
  bottom: 0;
  content: " ";
  height: 100px;
  left: 0;
  margin: auto;
  position: absolute;
  right: 0;
  top: 0;
  width: 100px; }

.wb-mltmd.waiting .display:before, .wb-enable .wb-twitter .twitter-timeline:before, .wb-mltmd .display:before {
  background: rgba(0, 0, 0, 0.7);
  border-radius: 10px;
  z-index: 1; }

@-webkit-keyframes spin {
  from {
    -webkit-transform: rotate(0);
    transform: rotate(0); }

  to {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg); } }

@keyframes spin {
  from {
    -webkit-transform: rotate(0);
    transform: rotate(0); }

  to {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg); } }

.wb-mltmd.waiting .display:after, .wb-enable .wb-twitter .twitter-timeline:after {
  -webkit-animation-duration: 1000ms;
  animation-duration: 1000ms;
  -webkit-animation-iteration-count: infinite;
  animation-iteration-count: infinite;
  -webkit-animation-name: spin;
  animation-name: spin;
  -webkit-animation-timing-function: linear;
  animation-timing-function: linear;
  background: url("../assets/loading.png") center center no-repeat;
  z-index: 2; }

/*! WET-BOEW Core and Plugins */
/*
  WET-BOEW
  @title: Accessibility Additions to WET-BOEW
 */
#wb-tphp {
  list-style-type: none;
  margin-bottom: 0; }

.wb-slc {
  left: 0;
  position: absolute;
  text-align: center;
  top: 10px;
  width: 100%;
  z-index: 3; }

.wb-sl {
  padding: 5px;
  z-index: 501; }

.wb-disable #wb-tphp {
  background: #fff; }
.wb-disable .wb-slc {
  position: static; }
  .wb-disable .wb-slc .wb-sl {
    background: none;
    color: #295376;
    display: block !important;
    font-weight: 400; }
    .wb-disable .wb-slc .wb-sl:hover, .wb-disable .wb-slc .wb-sl:focus {
      color: #0535d2; }
.wb-disable #wb-dtmd {
  float: none !important; }

q:before, q:after {
  content: ""; }

/*
  WET-BOEW
  @title: Language selector
 */
.wb-lng-lnks-rtl:after {
  clear: both;
  content: "";
  display: table; }

.wb-lng-lnks-horiz .wb-lng-lnk {
  display: inline-block; }

.wb-lng-lnks-vert .wb-lng-lnk {
  display: block; }

.wb-lng-lnks-rtl .wb-lng-lnk {
  float: right; }

/*
* Based upon jQuery Mobile Transitions (http://jquerymobile.com)
*
* Copyright 2010, 2013 jQuery Foundation, Inc. and other contributors
* Released under the MIT license.
* http://jquery.org/license
*
*/
.pop.in, .fade.in {
  opacity: 1;
  visibility: visible; }

.pop.out, .fade.out {
  opacity: 0;
  visibility: hidden; }

.out {
  display: none !important; }

.csstransitions .out {
  display: block !important; }

.pop {
  -webkit-transform-origin: 50% 50%;
  -ms-transform-origin: 50% 50%;
  transform-origin: 50% 50%; }
  .pop.in {
    -webkit-animation-duration: 350ms;
    animation-duration: 350ms;
    -webkit-animation-name: popin;
    animation-name: popin;
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
    visibility: visible; }
  .pop.out {
    -webkit-animation-duration: 100ms;
    animation-duration: 100ms;
    -webkit-animation-name: fadeout;
    animation-name: fadeout;
    visibility: hidden; }
  .pop.reverse.in {
    -webkit-animation-name: fadein;
    animation-name: fadein; }
  .pop.reverse.out {
    -webkit-animation-name: popout;
    animation-name: popout;
    -webkit-transform: scale(0.8);
    -ms-transform: scale(0.8);
    transform: scale(0.8); }

@-webkit-keyframes popin {
  0% {
    opacity: 1;
    visibility: visible;
    -webkit-transform: scale(0.8);
    transform: scale(0.8); }

  100% {
    opacity: 0;
    visibility: hidden;
    -webkit-transform: scale(1);
    transform: scale(1); } }

@keyframes popin {
  0% {
    opacity: 1;
    visibility: visible;
    -webkit-transform: scale(0.8);
    transform: scale(0.8); }

  100% {
    opacity: 0;
    visibility: hidden;
    -webkit-transform: scale(1);
    transform: scale(1); } }

@-webkit-keyframes popout {
  0% {
    opacity: 1;
    visibility: visible;
    -webkit-transform: scale(1);
    transform: scale(1); }

  100% {
    opacity: 0;
    visibility: hidden;
    -webkit-transform: scale(0.8);
    transform: scale(0.8); } }

@keyframes popout {
  0% {
    opacity: 1;
    visibility: visible;
    -webkit-transform: scale(1);
    transform: scale(1); }

  100% {
    opacity: 0;
    visibility: hidden;
    -webkit-transform: scale(0.8);
    transform: scale(0.8); } }

.fade {
  -webkit-transition: all 0 ease 0;
  transition: all 0 ease 0; }
  .fade.in {
    -webkit-animation-duration: 225ms;
    animation-duration: 225ms;
    -webkit-animation-name: fadein;
    animation-name: fadein; }
  .fade.out {
    -webkit-animation-duration: 125ms;
    animation-duration: 125ms;
    -webkit-animation-name: fadeout;
    animation-name: fadeout;
    z-index: -1; }

@-webkit-keyframes fadein {
  0% {
    opacity: 0;
    visibility: hidden; }

  100% {
    opacity: 1;
    visibility: visible; } }

@keyframes fadein {
  0% {
    opacity: 0;
    visibility: hidden; }

  100% {
    opacity: 1;
    visibility: visible; } }

@-webkit-keyframes fadeout {
  0% {
    opacity: 1;
    visibility: visible; }

  100% {
    opacity: 0;
    visibility: hidden; } }

@keyframes fadeout {
  0% {
    opacity: 1;
    visibility: visible; }

  100% {
    opacity: 0;
    visibility: hidden; } }

.slide.out, .slide.in {
  -webkit-animation-duration: 350ms;
  animation-duration: 350ms;
  -webkit-animation-timing-function: ease-out;
  animation-timing-function: ease-out; }
.slide.out {
  -webkit-animation-name: slideouttoleft;
  animation-name: slideouttoleft;
  -webkit-transform: translateX(-100%);
  -ms-transform: translateX(-100%);
  transform: translateX(-100%);
  visibility: hidden; }
.slide.in {
  -webkit-animation-name: slideinfromright;
  animation-name: slideinfromright;
  -webkit-transform: translateX(0);
  -ms-transform: translateX(0);
  transform: translateX(0);
  visibility: visible; }
.slide.reverse.out {
  -webkit-animation-name: slideouttoright;
  animation-name: slideouttoright;
  -webkit-transform: translateX(100%);
  -ms-transform: translateX(100%);
  transform: translateX(100%); }
.slide.reverse.in {
  -webkit-animation-name: slideinfromleft;
  animation-name: slideinfromleft; }

/* keyframes for slidein from sides */
@-webkit-keyframes slideinfromright {
  0% {
    -webkit-transform: translateX(100%);
    transform: translateX(100%); }

  100% {
    -webkit-transform: translateX(0);
    transform: translateX(0); } }
@keyframes slideinfromright {
  0% {
    -webkit-transform: translateX(100%);
    transform: translateX(100%); }

  100% {
    -webkit-transform: translateX(0);
    transform: translateX(0); } }

@-webkit-keyframes slideinfromleft {
  0% {
    -webkit-transform: translateX(-100%);
    transform: translateX(-100%); }

  100% {
    -webkit-transform: translateX(0);
    transform: translateX(0); } }

@keyframes slideinfromleft {
  0% {
    -webkit-transform: translateX(-100%);
    transform: translateX(-100%); }

  100% {
    -webkit-transform: translateX(0);
    transform: translateX(0); } }

/* keyframes for slideout to sides */
@-webkit-keyframes slideouttoleft {
  0% {
    -webkit-transform: translateX(0);
    transform: translateX(0);
    visibility: visible; }

  99% {
    visibility: visible; }

  100% {
    -webkit-transform: translateX(-100%);
    transform: translateX(-100%);
    visibility: hidden; } }
@keyframes slideouttoleft {
  0% {
    -webkit-transform: translateX(0);
    transform: translateX(0);
    visibility: visible; }

  99% {
    visibility: visible; }

  100% {
    -webkit-transform: translateX(-100%);
    transform: translateX(-100%);
    visibility: hidden; } }

@-webkit-keyframes slideouttoright {
  0% {
    -webkit-transform: translateX(0);
    transform: translateX(0);
    visibility: visible; }

  99% {
    visibility: visible; }

  100% {
    -webkit-transform: translateX(100%);
    transform: translateX(100%);
    visibility: hidden; } }

@keyframes slideouttoright {
  0% {
    -webkit-transform: translateX(0);
    transform: translateX(0);
    visibility: visible; }

  99% {
    visibility: visible; }

  100% {
    -webkit-transform: translateX(100%);
    transform: translateX(100%);
    visibility: hidden; } }

.slidefade.out {
  -webkit-animation-duration: 225ms;
  animation-duration: 225ms;
  -webkit-animation-name: slideouttoleft;
  animation-name: slideouttoleft;
  -webkit-transform: translateX(-100%);
  -ms-transform: translateX(-100%);
  transform: translateX(-100%); }
.slidefade.in {
  -webkit-animation-duration: 200ms;
  animation-duration: 200ms;
  -webkit-animation-name: fadein;
  animation-name: fadein;
  -webkit-transform: translateX(0);
  -ms-transform: translateX(0);
  transform: translateX(0); }
.slidefade.reverse.out {
  -webkit-animation-name: slideouttoright;
  animation-name: slideouttoright;
  -webkit-transform: translateX(100%);
  -ms-transform: translateX(100%);
  transform: translateX(100%); }

/* slide up/down */
.slidevert.out, .slidevert.in {
  -webkit-animation-duration: 350ms;
  animation-duration: 350ms;
  -webkit-animation-timing-function: ease-out;
  animation-timing-function: ease-out; }
.slidevert.out {
  -webkit-animation-name: slideouttobottom;
  animation-name: slideouttobottom;
  -webkit-transform: translateY(100%);
  -ms-transform: translateY(100%);
  transform: translateY(100%);
  visibility: hidden; }
.slidevert.in {
  -webkit-animation-name: slideinfromtop;
  animation-name: slideinfromtop;
  -webkit-transform: translateY(0);
  -ms-transform: translateY(0);
  transform: translateY(0);
  visibility: visible; }
.slidevert.reverse.out {
  -webkit-animation-name: slideouttotop;
  animation-name: slideouttotop;
  -webkit-transform: translateY(-100%);
  -ms-transform: translateY(-100%);
  transform: translateY(-100%); }
.slidevert.reverse.in {
  -webkit-animation-name: slideinfrombottom;
  animation-name: slideinfrombottom; }

@-webkit-keyframes slideinfromtop {
  0% {
    -webkit-transform: translateY(-100%);
    transform: translateY(-100%); }

  100% {
    -webkit-transform: translateY(0);
    transform: translateY(0); } }

@keyframes slideinfromtop {
  0% {
    -webkit-transform: translateY(-100%);
    transform: translateY(-100%); }

  100% {
    -webkit-transform: translateY(0);
    transform: translateY(0); } }

@-webkit-keyframes slideouttotop {
  0% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    visibility: visible; }

  99% {
    visibility: visible; }

  100% {
    -webkit-transform: translateY(-100%);
    transform: translateY(-100%);
    visibility: hidden; } }

@keyframes slideouttotop {
  0% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    visibility: visible; }

  99% {
    visibility: visible; }

  100% {
    -webkit-transform: translateY(-100%);
    transform: translateY(-100%);
    visibility: hidden; } }

@-webkit-keyframes slideinfrombottom {
  0% {
    -webkit-transform: translateY(100%);
    transform: translateY(100%); }

  100% {
    -webkit-transform: translateY(0);
    transform: translateY(0); } }

@keyframes slideinfrombottom {
  0% {
    -webkit-transform: translateY(100%);
    transform: translateY(100%); }

  100% {
    -webkit-transform: translateY(0);
    transform: translateY(0); } }

@-webkit-keyframes slideouttobottom {
  0% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    visibility: visible; }

  99% {
    visibility: visible; }

  100% {
    -webkit-transform: translateY(100%);
    transform: translateY(100%);
    visibility: hidden; } }

@keyframes slideouttobottom {
  0% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    visibility: visible; }

  99% {
    visibility: visible; }

  100% {
    -webkit-transform: translateY(100%);
    transform: translateY(100%);
    visibility: hidden; } }

/*
  WET-BOEW
  @title: Proximity CSS
 */
/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
/*
 * HOW TO USE THIS FILE
 * Use this file to override Bootstrap variables and WET custom variables.
 * If there is a Bootstrap variable not shown here that you want to override, go to "../lib/bootstrap-sass-official/assets/stylesheets/bootstrap/variables" to view the variables that you can override. Simply copy and paste the variable and its applicable section (if applicable) from the Bootstrap file into this override file and override the variables as applicable.
 */
.opct-100 {
  opacity: 1; }

.opct-90 {
  opacity: 0.9; }

.opct-80 {
  opacity: 0.8; }

.opct-70 {
  opacity: 0.7; }

.opct-60 {
  opacity: 0.6; }

.opct-50 {
  opacity: 0.5; }

.opct-40 {
  opacity: 0.4; }

.opct-30 {
  opacity: 0.3; }

.opct-20 {
  opacity: 0.2; }

.opct-10 {
  opacity: 0.1; }

/*
 *	Fix for missing bullets in Chrome and Safari
 */
[class*=clmn-] {
  list-style: outside;
  padding-left: 1.3em; }
  [class*=clmn-] > li {
    margin-left: 1.3em; }

.pstn-lft-xs, .pstn-lft-sm, .pstn-lft-md, .pstn-lft-lg, .pstn-rght-xs, .pstn-rght-sm, .pstn-rght-md, .pstn-rght-lg, .pstn-tp-xs, .pstn-tp-sm, .pstn-tp-md, .pstn-tp-lg, .pstn-bttm-xs, .pstn-bttm-sm, .pstn-bttm-md, .pstn-bttm-lg {
  margin: 0; }

.pstn-lft-xs {
  position: absolute;
  left: 0;
  right: auto; }

.pstn-rght-xs {
  position: absolute;
  right: 0;
  left: auto; }

.pstn-tp-xs {
  position: absolute;
  top: 0;
  bottom: auto; }

.pstn-bttm-xs {
  position: absolute;
  bottom: 0;
  top: auto; }

.mrgn-lft-0 {
  margin-left: 0; }

.mrgn-lft-sm {
  margin-left: 5px; }

.mrgn-lft-md {
  margin-left: 15px; }

.mrgn-lft-lg {
  margin-left: 30px; }

.mrgn-lft-xl {
  margin-left: 50px; }

.mrgn-bttm-0 {
  margin-bottom: 0; }

.mrgn-bttm-sm {
  margin-bottom: 5px; }

.mrgn-bttm-md {
  margin-bottom: 15px; }

.mrgn-bttm-lg {
  margin-bottom: 30px; }

.mrgn-bttm-xl {
  margin-bottom: 50px; }

.mrgn-tp-0 {
  margin-top: 0; }

.mrgn-tp-sm {
  margin-top: 5px; }

.mrgn-tp-md {
  margin-top: 15px; }

.mrgn-tp-lg {
  margin-top: 30px; }

.mrgn-tp-xl {
  margin-top: 50px; }

.mrgn-rght-0 {
  margin-right: 0; }

.mrgn-rght-sm {
  margin-right: 5px; }

.mrgn-rght-md {
  margin-right: 15px; }

.mrgn-rght-lg {
  margin-right: 30px; }

.mrgn-rght-xl {
  margin-right: 50px; }

.brdr-lft, .brdr-rght, .brdr-tp, .brdr-bttm {
  border: solid 0 #ccc; }

.brdr-lft {
  border-left-width: 1px; }

.brdr-rght {
  border-right-width: 1px; }

.brdr-tp {
  border-top-width: 1px; }

.brdr-bttm {
  border-bottom-width: 1px; }

.brdr-rds-0 {
  border-radius: 0; }

.tbl-gridify thead, .tbl-gridify tfoot {
  display: none; }
.tbl-gridify tbody, .tbl-gridify td, .tbl-gridify td {
  display: block; }

/*
 *	Fix for missing bullets in Chrome and Safari
 */
[class*=colcount-] {
  list-style-position: outside;
  padding-left: 1.3em; }
  [class*=colcount-] > li {
    margin-left: 1.3em; }
  [class*=colcount-].list-unstyled {
    list-style: none outside none;
    padding-left: 0; }
    [class*=colcount-].list-unstyled li {
      margin-left: 0; }

.colcount-xxs-2 {
  -webkit-column-count: 2;
  -moz-column-count: 2;
  column-count: 2; }

.colcount-xxs-3 {
  -webkit-column-count: 3;
  -moz-column-count: 3;
  column-count: 3; }

.colcount-xxs-4 {
  -webkit-column-count: 4;
  -moz-column-count: 4;
  column-count: 4; }

.full-width {
  width: 100%; }

/*
  WET-BOEW
  @title: List CSS
 */
.lst-lwr-alph {
  list-style-type: lower-alpha; }

.lst-upr-alph {
  list-style-type: upper-alpha; }

.lst-lwr-rmn {
  list-style-type: lower-roman; }

.lst-upr-rmn {
  list-style-type: upper-roman; }

.lst-num {
  list-style-type: decimal; }

.lst-spcd > li {
  margin-bottom: 10px; }
.lst-spcd ul, .lst-spcd ol {
  margin-top: 10px; }

/*
  WET-BOEW
  @title: Form additions to WET-BOEW
 */
label.required:before, legend.required:before, label.required strong.required, legend.required strong.required {
  color: #d3080c;
  font-style: italic; }

label.required:before, legend.required:before {
  content: "* ";
  margin-left: -0.665em; }

[dir=rtl] label.required:before, [dir=rtl] legend.required:before {
  margin-left: auto;
  margin-right: -0.665em; }

/*
  WET-BOEW
  @title: Details/summary CSS
 */
summary {
  cursor: pointer; }
  summary:hover, summary:focus {
    background: #ddd;
    color: #000; }
  summary > :first-child {
    display: inline; }

details {
  padding-left: 1.1em; }
  details[open] {
    padding-bottom: 1em; }
  details > summary {
    margin-left: -1.1em; }

[dir=rtl] details {
  padding-left: 0;
  padding-right: 1.1em; }
  [dir=rtl] details > summary {
    margin-left: 0;
    margin-right: -1.1em; }

/*
 Plugins
 */
/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
.cal-days td ul.ev-details, .cal-days td:hover ul {
  background-color: #fff;
  border: 1px solid #333;
  clip: rect(auto, auto, auto, auto);
  color: #000;
  height: inherit;
  list-style-type: none;
  margin: 0;
  margin-top: -0.5em;
  overflow: inherit;
  padding: 0;
  position: absolute;
  width: 10em;
  z-index: 5; }
  .cal-days td ul.ev-details a:hover, .cal-days td:hover ul a:hover, .cal-days td ul.ev-details a:focus, .cal-days td:hover ul a:focus {
    color: #fff; }

.cal-days a.cal-evt {
  background: #176ca7;
  color: #fff; }

.cal-cnt-fluid.cal-cnt, .cal-cnt-fluid table.cal-cnt {
  width: 100%; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
.cal-cnt .cal-goto-mnth, .cal-cnt .cal-goto-yr, .cal-cnt .cal-goto-btn, .cal-cnt .cal-goto-mnth, .cal-cnt .cal-goto-yr, .cal-cnt .cal-goto-btn {
  position: relative; }

.cal-cnt .cal-goto-mnth, .cal-cnt .cal-goto-yr, .cal-cnt .cal-goto-btn, .cal-cnt .cal-goto-mnth, .cal-cnt .cal-goto-yr, .cal-cnt .cal-goto-btn {
  display: inline-block;
  margin: 10px 5px; }

.cal-cnt .cal-hd, .cal-nxtmnth.active:hover, .cal-nxtmnth.active:focus, .cal-prvmnth.active:hover, .cal-prvmnth.active:focus, .cal-days .cal-currday, .cal-cnt .cal-hd, .cal-nxtmnth.active:hover, .cal-nxtmnth.active:focus, .cal-prvmnth.active:hover, .cal-prvmnth.active:focus, .cal-days .cal-currday {
  color: #fff; }

.cal-cnt .cal-goto-lnk, .cal-days a:hover, .cal-days a:focus, .cal-days .cal-currday a, .cal-cnt .cal-goto-lnk, .cal-days a:hover, .cal-days a:focus, .cal-days .cal-currday a {
  color: #fff !important; }

.cal-cnt .cal-goto-mnth, .cal-cnt .cal-goto-yr, .cal-cnt .cal-goto-mnth, .cal-cnt .cal-goto-yr {
  color: #000; }

.cal-cnt .cal-hd, .cal-days a:hover, .cal-days a:focus, .cal-days .cal-currday, .cal-days .cal-currday a, .cal-cnt .cal-hd, .cal-days a:hover, .cal-days a:focus, .cal-days .cal-currday, .cal-days .cal-currday a {
  background: #333; }

.cal-cnt {
  background: #fff;
  text-shadow: none;
  width: 18em; }
  .cal-cnt * {
    font-size: 100%; }
  .cal-cnt .cal-hd {
    font-weight: 700;
    overflow: hidden;
    padding: 0.5em 4px;
    position: relative;
    text-align: center; }
  .cal-cnt .cal-mnth {
    font-size: 110%; }
  .cal-cnt .cal-goto {
    display: inline-block; }
  .cal-cnt .cal-goto-btn input {
    min-width: 5em;
    padding: 0.1em 0.2em; }
  .cal-cnt td {
    border: 1px solid #aaa;
    padding: 0;
    text-align: center; }

.cal-nxtmnth, .cal-prvmnth {
  background: none;
  border: 0;
  display: inline-block;
  height: 2.5em;
  width: 2.5em; }
  .cal-nxtmnth:focus, .cal-prvmnth:focus {
    outline: 1px dotted;
    outline-offset: -2px; }
  .cal-nxtmnth[disabled], .cal-prvmnth[disabled] {
    opacity: 0.2; }
  .cal-nxtmnth.active, .cal-prvmnth.active {
    color: #ccc; }

.cal-wd {
  background: #555;
  border: 1px solid #333;
  color: #fff;
  padding: 0.5em 0;
  text-align: center; }

.cal-days a, .cal-days div, .cal-days a, .cal-days div {
  display: block;
  height: 100%;
  padding: 0.5em 0;
  width: 100%; }

.cal-days .cal-currday {
  font-weight: bolder; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
.cal-cnt .cal-goto-mnth, .cal-cnt .cal-goto-yr, .cal-cnt .cal-goto-btn, .cal-cnt .cal-goto-mnth, .cal-cnt .cal-goto-yr, .cal-cnt .cal-goto-btn {
  position: relative; }

.cal-cnt .cal-goto-mnth, .cal-cnt .cal-goto-yr, .cal-cnt .cal-goto-btn, .cal-cnt .cal-goto-mnth, .cal-cnt .cal-goto-yr, .cal-cnt .cal-goto-btn {
  display: inline-block;
  margin: 10px 5px; }

.cal-cnt .cal-hd, .cal-nxtmnth.active:hover, .cal-nxtmnth.active:focus, .cal-prvmnth.active:hover, .cal-prvmnth.active:focus, .cal-days .cal-currday, .cal-cnt .cal-hd, .cal-nxtmnth.active:hover, .cal-nxtmnth.active:focus, .cal-prvmnth.active:hover, .cal-prvmnth.active:focus, .cal-days .cal-currday {
  color: #fff; }

.cal-cnt .cal-goto-lnk, .cal-days a:hover, .cal-days a:focus, .cal-days .cal-currday a, .cal-cnt .cal-goto-lnk, .cal-days a:hover, .cal-days a:focus, .cal-days .cal-currday a {
  color: #fff !important; }

.cal-cnt .cal-goto-mnth, .cal-cnt .cal-goto-yr, .cal-cnt .cal-goto-mnth, .cal-cnt .cal-goto-yr {
  color: #000; }

.cal-cnt .cal-hd, .cal-days a:hover, .cal-days a:focus, .cal-days .cal-currday, .cal-days .cal-currday a, .cal-cnt .cal-hd, .cal-days a:hover, .cal-days a:focus, .cal-days .cal-currday, .cal-days .cal-currday a {
  background: #333; }

.cal-cnt {
  background: #fff;
  text-shadow: none;
  width: 18em; }
  .cal-cnt * {
    font-size: 100%; }
  .cal-cnt .cal-hd {
    font-weight: 700;
    overflow: hidden;
    padding: 0.5em 4px;
    position: relative;
    text-align: center; }
  .cal-cnt .cal-mnth {
    font-size: 110%; }
  .cal-cnt .cal-goto {
    display: inline-block; }
  .cal-cnt .cal-goto-btn input {
    min-width: 5em;
    padding: 0.1em 0.2em; }
  .cal-cnt td {
    border: 1px solid #aaa;
    padding: 0;
    text-align: center; }

.cal-nxtmnth, .cal-prvmnth {
  background: none;
  border: 0;
  display: inline-block;
  height: 2.5em;
  width: 2.5em; }
  .cal-nxtmnth:focus, .cal-prvmnth:focus {
    outline: 1px dotted;
    outline-offset: -2px; }
  .cal-nxtmnth[disabled], .cal-prvmnth[disabled] {
    opacity: 0.2; }
  .cal-nxtmnth.active, .cal-prvmnth.active {
    color: #ccc; }

.cal-wd {
  background: #555;
  border: 1px solid #333;
  color: #fff;
  padding: 0.5em 0;
  text-align: center; }

.cal-days a, .cal-days div, .cal-days a, .cal-days div {
  display: block;
  height: 100%;
  padding: 0.5em 0;
  width: 100%; }

.cal-days .cal-currday {
  font-weight: bolder; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
figure .pieLabel {
  background-color: #fff;
  border: solid #000 1px;
  color: #000;
  padding: 1px; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
.hght-inhrt {
  min-height: inherit; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
/*
 * HOW TO USE THIS FILE
 * Use this file to override Bootstrap variables and WET custom variables.
 * If there is a Bootstrap variable not shown here that you want to override, go to "../lib/bootstrap-sass-official/assets/stylesheets/bootstrap/variables" to view the variables that you can override. Simply copy and paste the variable and its applicable section (if applicable) from the Bootstrap file into this override file and override the variables as applicable.
 */
.fn-lnk:hover, .fn-lnk:focus, .wb-fnote dd:focus .fn-rtn a, .wb-fnote .fn-rtn a:hover, .wb-fnote .fn-rtn a:focus {
  background-color: #555;
  border-color: #555;
  color: #fff !important; }

.fn-lnk, .wb-fnote .fn-rtn a {
  background-color: #eee;
  border: 1px solid #ccc;
  padding: 1px 10px 2px;
  white-space: nowrap; }

.wb-fnote h2, .wb-fnote dd > ul:first-child, .wb-fnote dd > ol:first-child, .wb-fnote table:first-child {
  margin-top: 0.375em; }

.fn-lnk {
  margin-left: 5px; }

.wb-fnote {
  border-color: #ccc;
  border-style: solid;
  border-width: 1px 0;
  margin: 2em 10px 0; }
  .wb-fnote h2 {
    margin-left: 0;
    margin-right: 0; }
  .wb-fnote dl {
    margin: 0; }
  .wb-fnote dd {
    border: 1px solid transparent;
    margin: 0.375em 0;
    position: relative; }
    .wb-fnote dd:focus {
      background-color: #eee;
      border-color: #555; }
    .wb-fnote dd > ul, .wb-fnote dd > ol {
      margin: 0 0.375em 0.375em 4.125em; }
  .wb-fnote p {
    margin: 0 0 0 3.75em;
    padding: 0 0.375em 0.375em; }
    .wb-fnote p:first-child {
      padding-top: 0.375em; }
  .wb-fnote ul, .wb-fnote ol {
    margin-bottom: 0.375em; }
  .wb-fnote table {
    margin: 0 0.375em 0.375em 4.125em; }
  .wb-fnote .fn-rtn {
    margin: 0;
    overflow: hidden;
    padding-right: 0;
    padding-top: 0.375em;
    position: absolute;
    top: 0;
    width: 3.375em; }
    .wb-fnote .fn-rtn a {
      display: inline-block;
      padding-bottom: 0; }

/* Right to left (RTL) SCSS */
[dir="rtl"] sup .fn-lnk {
  margin-left: 0;
  margin-right: 5px; }
[dir="rtl"] .wb-fnote p {
  margin: 0 3.75em 0 0; }
[dir="rtl"] .wb-fnote .fn-rtn {
  margin-right: 0;
  padding-right: 0; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
.wb-frmvld label strong.error, .wb-frm label strong.error, .wb-frmvld legend .error, .wb-frm legend .error {
  display: inline-block;
  width: 100%; }

.wb-frmvld label strong.error .label, .wb-frm label strong.error .label, .wb-frmvld legend .error .label, .wb-frm legend .error .label {
  font-size: 100%; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
/*
 * HOW TO USE THIS FILE
 * Use this file to override Bootstrap variables and WET custom variables.
 * If there is a Bootstrap variable not shown here that you want to override, go to "../lib/bootstrap-sass-official/assets/stylesheets/bootstrap/variables" to view the variables that you can override. Simply copy and paste the variable and its applicable section (if applicable) from the Bootstrap file into this override file and override the variables as applicable.
 */
/* Magnific Popup CSS */
.mfp-bg {
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1042;
  overflow: hidden;
  position: fixed;
  background: #0b0b0b;
  opacity: 0.8;
  filter: alpha(opacity=80); }

.mfp-wrap {
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1043;
  position: fixed;
  outline: none !important;
  -webkit-backface-visibility: hidden; }

.mfp-container {
  text-align: center;
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  padding: 0 8px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box; }

.mfp-container:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle; }

.mfp-align-top .mfp-container:before {
  display: none; }

.mfp-content {
  position: relative;
  display: inline-block;
  vertical-align: middle;
  margin: 0 auto;
  text-align: left;
  z-index: 1045; }

.mfp-inline-holder .mfp-content, .mfp-ajax-holder .mfp-content {
  width: 100%;
  cursor: auto; }

.mfp-ajax-cur {
  cursor: progress; }

.mfp-zoom-out-cur, .mfp-zoom-out-cur .mfp-image-holder .mfp-close {
  cursor: -moz-zoom-out;
  cursor: -webkit-zoom-out;
  cursor: zoom-out; }

.mfp-zoom {
  cursor: pointer;
  cursor: -webkit-zoom-in;
  cursor: -moz-zoom-in;
  cursor: zoom-in; }

.mfp-auto-cursor .mfp-content {
  cursor: auto; }

.mfp-close, .mfp-arrow, .mfp-preloader, .mfp-counter {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none; }

.mfp-loading.mfp-figure {
  display: none; }

.mfp-hide {
  display: none !important; }

.mfp-preloader {
  color: #CCC;
  position: absolute;
  top: 50%;
  width: auto;
  text-align: center;
  margin-top: -0.8em;
  left: 8px;
  right: 8px;
  z-index: 1044; }
  .mfp-preloader a {
    color: #CCC; }
    .mfp-preloader a:hover {
      color: #FFF; }

.mfp-s-ready .mfp-preloader {
  display: none; }

.mfp-s-error .mfp-content {
  display: none; }

button.mfp-close, button.mfp-arrow {
  overflow: visible;
  cursor: pointer;
  background: transparent;
  border: 0;
  -webkit-appearance: none;
  display: block;
  outline: none;
  padding: 0;
  z-index: 1046;
  -webkit-box-shadow: none;
  box-shadow: none; }
button::-moz-focus-inner {
  padding: 0;
  border: 0; }

.mfp-close {
  width: 44px;
  height: 44px;
  line-height: 44px;
  position: absolute;
  right: 0;
  top: 0;
  text-decoration: none;
  text-align: center;
  opacity: 0.65;
  filter: alpha(opacity=65);
  padding: 0 0 18px 10px;
  color: #FFF;
  font-style: normal;
  font-size: 28px;
  font-family: Arial, Baskerville, monospace; }
  .mfp-close:hover, .mfp-close:focus {
    opacity: 1;
    filter: alpha(opacity=100); }
  .mfp-close:active {
    top: 1px; }

.mfp-close-btn-in .mfp-close {
  color: #333; }

.mfp-image-holder .mfp-close, .mfp-iframe-holder .mfp-close {
  color: #FFF;
  right: -6px;
  text-align: right;
  padding-right: 6px;
  width: 100%; }

.mfp-counter {
  position: absolute;
  top: 0;
  right: 0;
  color: #CCC;
  font-size: 12px;
  line-height: 18px;
  white-space: nowrap; }

.mfp-arrow {
  position: absolute;
  opacity: 0.65;
  filter: alpha(opacity=65);
  margin: 0;
  top: 50%;
  margin-top: -55px;
  padding: 0;
  width: 90px;
  height: 110px;
  -webkit-tap-highlight-color: rgba(0, 0, 0, 0); }
  .mfp-arrow:active {
    margin-top: -54px; }
  .mfp-arrow:hover, .mfp-arrow:focus {
    opacity: 1;
    filter: alpha(opacity=100); }
  .mfp-arrow:before, .mfp-arrow:after, .mfp-arrow .mfp-b, .mfp-arrow .mfp-a {
    content: '';
    display: block;
    width: 0;
    height: 0;
    position: absolute;
    left: 0;
    top: 0;
    margin-top: 35px;
    margin-left: 35px;
    border: medium inset transparent; }
  .mfp-arrow:after, .mfp-arrow .mfp-a {
    border-top-width: 13px;
    border-bottom-width: 13px;
    top: 8px; }
  .mfp-arrow:before, .mfp-arrow .mfp-b {
    border-top-width: 21px;
    border-bottom-width: 21px;
    opacity: 0.7; }

.mfp-arrow-left {
  left: 0; }
  .mfp-arrow-left:after, .mfp-arrow-left .mfp-a {
    border-right: 17px solid #FFF;
    margin-left: 31px; }
  .mfp-arrow-left:before, .mfp-arrow-left .mfp-b {
    margin-left: 25px;
    border-right: 27px solid #3F3F3F; }

.mfp-arrow-right {
  right: 0; }
  .mfp-arrow-right:after, .mfp-arrow-right .mfp-a {
    border-left: 17px solid #FFF;
    margin-left: 39px; }
  .mfp-arrow-right:before, .mfp-arrow-right .mfp-b {
    border-left: 27px solid #3F3F3F; }

.mfp-iframe-holder {
  padding-top: 40px;
  padding-bottom: 40px; }
  .mfp-iframe-holder .mfp-content {
    line-height: 0;
    width: 100%;
    max-width: 900px; }
  .mfp-iframe-holder .mfp-close {
    top: -40px; }

.mfp-iframe-scaler {
  width: 100%;
  height: 0;
  overflow: hidden;
  padding-top: 56.25%; }
  .mfp-iframe-scaler iframe {
    position: absolute;
    display: block;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
    background: #000; }

/* Main image in popup */
img.mfp-img {
  width: auto;
  max-width: 100%;
  height: auto;
  display: block;
  line-height: 0;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  padding: 40px 0 40px;
  margin: 0 auto; }

/* The shadow behind the image */
.mfp-figure {
  line-height: 0; }
  .mfp-figure:after {
    content: '';
    position: absolute;
    left: 0;
    top: 40px;
    bottom: 40px;
    display: block;
    right: 0;
    width: auto;
    height: auto;
    z-index: -1;
    -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
    background: #444; }
  .mfp-figure small {
    color: #BDBDBD;
    display: block;
    font-size: 12px;
    line-height: 14px; }
  .mfp-figure figure {
    margin: 0; }

.mfp-bottom-bar {
  margin-top: -36px;
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  cursor: auto; }

.mfp-title {
  text-align: left;
  line-height: 18px;
  color: #F3F3F3;
  word-wrap: break-word;
  padding-right: 36px; }

.mfp-image-holder .mfp-content {
  max-width: 100%; }

.mfp-gallery .mfp-image-holder .mfp-figure {
  cursor: pointer; }

@media screen and (max-width: 800px) and (orientation: landscape), screen and (max-height: 300px) {
  /**
       * Remove all paddings around the image on small screen
       */
  .mfp-img-mobile .mfp-image-holder {
    padding-left: 0;
    padding-right: 0; }
  .mfp-img-mobile img.mfp-img {
    padding: 0; }
  .mfp-img-mobile .mfp-figure:after {
    top: 0;
    bottom: 0; }
  .mfp-img-mobile .mfp-figure small {
    display: inline;
    margin-left: 5px; }
  .mfp-img-mobile .mfp-bottom-bar {
    background: rgba(0, 0, 0, 0.6);
    bottom: 0;
    margin: 0;
    top: auto;
    padding: 3px 5px;
    position: fixed;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box; }
    .mfp-img-mobile .mfp-bottom-bar:empty {
      padding: 0; }
  .mfp-img-mobile .mfp-counter {
    right: 5px;
    top: 3px; }
  .mfp-img-mobile .mfp-close {
    top: 0;
    right: 0;
    width: 35px;
    height: 35px;
    line-height: 35px;
    background: rgba(0, 0, 0, 0.6);
    position: fixed;
    text-align: center;
    padding: 0; } }

@media all and (max-width: 900px) {
  .mfp-arrow {
    -webkit-transform: scale(0.75);
    -ms-transform: scale(0.75);
    transform: scale(0.75); }
  .mfp-arrow-left {
    -webkit-transform-origin: 0;
    -ms-transform-origin: 0;
    transform-origin: 0; }
  .mfp-arrow-right {
    -webkit-transform-origin: 100%;
    -ms-transform-origin: 100%;
    transform-origin: 100%; }
  .mfp-container {
    padding-left: 6px;
    padding-right: 6px; } }

.mfp-ie7 .mfp-img {
  padding: 0; }
.mfp-ie7 .mfp-bottom-bar {
  width: 600px;
  left: 50%;
  margin-left: -300px;
  margin-top: 5px;
  padding-bottom: 5px; }
.mfp-ie7 .mfp-container {
  padding: 0; }
.mfp-ie7 .mfp-content {
  padding-top: 44px; }
.mfp-ie7 .mfp-close {
  top: 0;
  right: 0;
  padding-top: 0; }

.mfp-close:focus, .mfp-arrow:focus {
  outline: 1px dotted #fff;
  outline-offset: -2px; }

.lbx-hide-gal li {
  display: none;
  list-style-type: none; }
  .lbx-hide-gal li:first-child {
    display: block; }

.modal-dialog {
  left: auto;
  padding: 0;
  position: relative; }

.modal-content {
  background: transparent; }

.modal-body {
  background: #fff; }

.mfp-gallery .modal-body {
  padding: 20px 30px; }

.mfp-close {
  cursor: pointer !important;
  font-weight: 700;
  /* Should fix upstream in Magnific Popup rather than overriding in WET */ }

/* Should fix upstream in Magnific Popup rather than overriding in WET */
/* Should fix upstream in Magnific Popup rather than overriding in WET */
.mfp-bottom-bar .mfp-title {
  padding-right: 5px;
  width: 75%; }
.mfp-bottom-bar .mfp-counter {
  font-size: 1em;
  text-align: right;
  width: 25%; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
/*
 * Menu Sass
 */
.expicon {
  font-size: 0.7em;
  margin: 0 -0.35em 0 0.7em; }

.wb-menu .sm {
  display: none;
  max-height: 0;
  overflow: hidden;
  position: relative; }
  .wb-menu .sm.open {
    display: inline;
    max-height: 1000px;
    min-width: 12.5em;
    position: absolute;
    text-transform: none;
    top: auto;
    z-index: 500; }
    .wb-menu .sm.open li a {
      text-align: left; }
  .wb-menu .sm details > * {
    margin-left: auto;
    margin-right: auto; }
.wb-menu .menu {
  margin-left: 0;
  position: relative; }
  .wb-menu .menu > li {
    float: left;
    margin: 0;
    padding: 0; }
    .wb-menu .menu > li a {
      display: block;
      padding: 1em;
      text-align: center; }
      .wb-menu .menu > li a[aria-haspopup]:hover, .wb-menu .menu > li a[aria-haspopup]:focus {
        cursor: default; }
.wb-menu .sm-open .expicon {
  z-index: -1; }

#mb-pnl nav a.wb-navcurr, #mb-pnl nav summary.wb-navcurr {
  outline: 1px solid; }

#mb-pnl nav a.wb-navcurr:focus, #mb-pnl nav summary.wb-navcurr:focus {
  outline-style: dotted; }

#mb-pnl .srch-pnl, #mb-pnl nav {
  padding: 10px 20px 8px; }

#mb-pnl .srch-pnl form {
  white-space: nowrap; }
#mb-pnl .lng-ofr {
  padding: 7px 15px 0;
  text-align: right; }
  #mb-pnl .lng-ofr ul {
    margin-bottom: 0; }
  #mb-pnl .lng-ofr li {
    line-height: normal;
    padding-left: 10px;
    padding-right: 0; }
    #mb-pnl .lng-ofr li a {
      padding: 5px; }
#mb-pnl nav ul li.no-sect {
  padding-left: 1.27em; }
  #mb-pnl nav ul li.no-sect .list-group {
    margin-bottom: 0; }
  #mb-pnl nav ul li.no-sect a {
    margin: 0 0 0 -6px; }
#mb-pnl nav .mb-menu > li {
  padding: 10px 0 2px; }
#mb-pnl nav a {
  display: inline-block;
  margin: 6px 0 6px -6px;
  padding: 0 6px;
  width: 100%; }
#mb-pnl nav summary {
  padding-left: 3px; }
  #mb-pnl nav summary.wb-navcurr:focus {
    outline-offset: -2px; }
#mb-pnl details[open] {
  padding-bottom: 0; }
#mb-pnl details ul {
  padding-left: 1.2em; }
#mb-pnl details details {
  margin: 6px 0 6px -1.28em; }

.wb-disable #wb-srch, .wb-disable #wb-sm, .wb-disable #wb-sec, .wb-disable #wb-info {
  display: block !important; }

.wb-disable #wb-glb-mn {
  display: none !important; }

[dir=rtl] .wb-menu .menu {
  padding-right: 0; }
  [dir=rtl] .wb-menu .menu > li {
    float: right; }
[dir=rtl] .wb-menu .sm.open li a {
  text-align: right; }
[dir=rtl] .expicon {
  margin: 0 0.7em 0 -0.35em; }
[dir=rtl] #mb-pnl .lng-ofr {
  text-align: left; }
  [dir=rtl] #mb-pnl .lng-ofr li {
    padding-left: 0;
    padding-right: 10px; }
[dir=rtl] #mb-pnl nav ul li.no-sect {
  padding-left: 0;
  padding-right: 1.27em; }
[dir=rtl] #mb-pnl nav a {
  margin-left: 0;
  margin-right: -6px; }
[dir=rtl] #mb-pnl nav summary {
  margin-left: 0;
  margin-right: -3px;
  padding-left: 0;
  padding-right: 3px; }
[dir=rtl] #mb-pnl details ul {
  padding-left: 0;
  padding-right: 0.7em; }

/*
  Multimedia Player Code
 */
.wb-mltmd.audio .lastpnl, .wb-mltmd.youtube.cc_on .wb-mm-cc {
  display: none; }

.wb-mm-ctrls .btn:focus, .wb-mm-ctrls progress:focus, .wb-mm-ctrls input[type=range]:focus {
  outline: 1px solid #4aafff; }

.wb-mm-ctrls .fd-slider-bar, .wb-mm-ctrls .fd-slider-range {
  background: #aaa;
  border: 0; }

.xxsmallview .wb-mm-ctrls .frstpnl, .xxsmallview .wb-mm-ctrls .lastpnl {
  padding-top: 2em; }

.wb-mltmd video, .wb-mltmd object, .wb-mltmd iframe {
  margin-bottom: -7px;
  width: 100%; }

.wb-mm-cc {
  max-height: 0;
  padding: 0; }

.wb-mm-cc:before, .wb-mm-cc div {
  display: table-cell;
  height: 3em;
  vertical-align: middle; }

.wb-mltmd {
  display: block;
  position: relative;
  /*
	  Light Skinning of mediacontrols
	 */ }
  .wb-mltmd .display {
    cursor: pointer;
    position: relative; }
  .wb-mltmd .display:before {
    color: #fff;
    content: "";
    font-family: "Glyphicons Halflings";
    font-size: 65px;
    text-align: center; }
  .wb-mltmd video {
    height: auto;
    width: 100%; }
  .wb-mltmd.audio object {
    position: absolute; }
  .wb-mltmd.playing .display:before, .wb-mltmd.playing .display:after {
    display: none; }
  .wb-mltmd.playing .errmsg {
    display: none; }
  .wb-mltmd.waiting .display:before, .wb-mltmd.waiting .display:after {
    content: " ";
    display: block; }
  .wb-mltmd.cc_on .wb-mm-cc {
    display: table;
    height: 4em;
    padding: 0.5em; }
  .wb-mltmd.cc_on .cc:after {
    border-bottom: 3px solid #4aafff;
    content: " ";
    display: block;
    margin-left: -2px;
    width: 1.2em; }
  .wb-mltmd.youtube .display:before, .wb-mltmd.youtube .display:after {
    display: none; }
  .wb-mltmd.skn-lt {
    border-bottom: 1px solid #ddd;
    color: #000; }
    .wb-mltmd.skn-lt .wb-mm-ctrls {
      background: #fff;
      color: #000; }
      .wb-mltmd.skn-lt .wb-mm-ctrls .btn {
        background: #fff;
        border: 0;
        color: #000; }
  .wb-mltmd .wb-share {
    text-align: right; }

.wb-mm-cc {
  background-color: #000;
  color: #fff;
  text-align: center;
  -webkit-transition: all 0.26s ease;
  transition: all 0.26s ease;
  width: 100%; }
  .wb-mm-cc:before {
    content: " "; }

.wb-mm-ctrls .frstpnl, .wb-mm-ctrls .lastpnl, .wb-mm-ctrls .tline {
  display: table-cell;
  vertical-align: middle; }

.wb-mm-ctrls {
  background: #3e3e3e;
  color: #fff;
  display: table;
  padding-top: 2em;
  position: relative;
  width: 100%;
  /* Progress Bar */
  /* Slider polyfill styles */ }
  .wb-mm-ctrls .btn {
    background: transparent;
    border: 0;
    border-top-left-radius: 0 !important;
    border-top-right-radius: 0 !important;
    color: #fff;
    font-size: 130%; }
  .wb-mm-ctrls .frstpnl {
    text-align: center;
    width: 13em; }
  .wb-mm-ctrls .lastpnl {
    text-align: center;
    width: 3em; }
  .wb-mm-ctrls .tline .wb-mm-tmln-crrnt:after {
    content: " / ";
    padding: 0 0.5em; }
  .wb-mm-ctrls .wb-mm-txtonly {
    padding: 0 1em; }
    .wb-mm-ctrls .wb-mm-txtonly p {
      display: inline; }
  .wb-mm-ctrls .wb-mm-txtonly, .wb-mm-ctrls .wb-mm-prgrss {
    display: table-cell;
    vertical-align: middle; }
  .wb-mm-ctrls progress {
    /* Important Thing */
    -webkit-appearance: none;
    background: #fff;
    border: 7px solid #3e3e3e;
    border-radius: 14px;
    color: #176ca7;
    display: block;
    height: 30px;
    left: 0;
    padding: 2px;
    position: absolute;
    top: 0;
    width: 100%; }
    .wb-mm-ctrls progress.wb-progress-inited {
      overflow: hidden;
      padding: 0; }
    .wb-mm-ctrls progress::-webkit-progress-bar {
      background: #fff; }
    .wb-mm-ctrls progress::-webkit-progress-value {
      background: #176ca7;
      border-radius: 7px; }
    .wb-mm-ctrls progress::-moz-progress-bar {
      background: #176ca7;
      border-radius: 7px; }
  .wb-mm-ctrls .progress {
    height: 22px; }
  .wb-mm-ctrls input[type=range] {
    -webkit-appearance: none;
    background: transparent;
    display: inline-block;
    height: 2.5em;
    padding: 0;
    width: 7em; }
    .wb-mm-ctrls input[type=range]::-webkit-slider-runnable-track {
      background: #aaa;
      height: 4px; }
    .wb-mm-ctrls input[type=range]::-webkit-slider-thumb {
      margin-top: -8px; }
    .wb-mm-ctrls input[type=range]::-moz-range-track {
      background: #aaa;
      border: 0; }
    .wb-mm-ctrls input[type=range]::-moz-range-thumb {
      border-radius: 0;
      height: 1.3em;
      width: 10px; }
    .wb-mm-ctrls input[type=range]::-ms-track {
      height: 4px; }
    .wb-mm-ctrls input[type=range]::-ms-fill-upper {
      background: #aaa; }
    .wb-mm-ctrls input[type=range]::-ms-fill-lower {
      background: #aaa; }
    .wb-mm-ctrls input[type=range]::-ms-thumb {
      background: #fff;
      border: 1px outset #fff;
      height: 1.3em; }
  .wb-mm-ctrls .fd-slider {
    display: inline-block;
    height: 100%;
    margin-top: 10px;
    width: 7em; }
  .wb-mm-ctrls .fd-slider-handle {
    background: #fff;
    border: 1px outset #fff;
    width: 10px; }

.xxsmallview .wb-mm-ctrls .wb-mm-txtonly {
  left: 0;
  margin-top: -2em;
  position: absolute; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
/*
 *	Overlay base
 */
.wb-overlay {
  -webkit-background-clip: border-box;
  background-clip: border-box;
  background-color: #fff;
  border: 0;
  border-radius: 0;
  display: none;
  -webkit-transform: translateZ(0);
  transform: translateZ(0);
  z-index: 1050; }
  .wb-overlay.wb-inview {
    display: block; }
  .wb-overlay.open {
    display: inline-block;
    position: fixed; }

.wb-panel-l, .wb-panel-r {
  height: 100%;
  max-width: 90%;
  top: 0; }

.wb-bar-t, .wb-bar-b {
  border-bottom: 0;
  left: 0;
  max-height: 90%;
  min-width: 100%; }

.wb-popup-mid {
  max-height: 90%;
  max-width: 90%; }

/*
 *	Overlay styles
 */
.wb-panel-l {
  left: 0; }

.wb-panel-r {
  right: 0; }

.wb-bar-t {
  top: 0; }

.wb-bar-b {
  bottom: 0; }

.wb-popup-mid {
  border-radius: 6px;
  bottom: 0;
  left: 0;
  margin: auto;
  right: 0;
  top: 0; }

.wb-popup-full {
  height: 100%;
  left: 0;
  top: 0;
  width: 100%; }

/*
 *	Overlay parts
 */
.overlay-def {
  overflow-y: auto; }
  .overlay-def header {
    background-color: #000;
    color: #fff;
    display: block;
    padding: 0 44px 0 1em; }
  .overlay-def .modal-title {
    font-size: 1.15em;
    padding: 10px 0; }
  .overlay-def.wb-bar-t, .overlay-def.wb-bar-b {
    background-color: #000; }
  .overlay-def .mfp-close {
    color: #fff; }

.hidden-hd .modal-body {
  padding-top: 50px; }
.hidden-hd .overlay-close {
  background-color: #000;
  border-radius: 999px;
  height: 1em;
  line-height: 1em;
  margin-right: 20px;
  margin-top: 10px;
  width: 1em; }

[dir=rtl] .mfp-close {
  left: 0;
  right: auto; }
[dir=rtl] .wb-panel-l {
  left: auto;
  right: 0; }
[dir=rtl] .wb-panel-r {
  left: 0;
  right: auto; }
[dir=rtl] .overlay-def header {
  padding: 0 1em 0 44px; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
/* Pretty printing styles. Used with prettify.js. */
/* SPAN elements with the classes below are added by prettyprint. */
/* plain text */
.pln {
  color: #000; }

pre.prettyprint {
  background-color: #f5f5f5;
  border: 1px solid #ddd;
  color: #707070;
  font-size: 95%;
  padding: 8px;
  /* Specify class=linenums on a pre to get line numbering */ }
  pre.prettyprint.linenums {
    -webkit-box-shadow: 40px 0 0 #fbfbfc inset, 41px 0 0 #eee inset;
    box-shadow: 40px 0 0 #fbfbfc inset, 41px 0 0 #eee inset; }

ol.linenums {
  margin: 0 !important; }
  ol.linenums li {
    padding-left: 10px;
    text-shadow: 0 1px 0 #fff; }

/* Right to left (RTL) CSS */
[dir="rtl"] pre.prettyprint {
  direction: ltr; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
#wb-rsz {
  clip: rect(1px, 1px, 1px, 1px);
  margin: 0;
  overflow: hidden;
  position: absolute;
  top: -1000px; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
#wb-sessto-modal .modal-footer {
  background: #fff;
  margin-top: 0; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
.shr-pg .bitly:before, .shr-pg .blogger:before, .shr-pg .delicious:before, .shr-pg .digg:before, .shr-pg .diigo:before, .shr-pg .facebook:before, .shr-pg .feed:before, .shr-pg .gmail:before, .shr-pg .googleplus:before, .shr-pg .linkedin:before, .shr-pg .myspace:before, .shr-pg .pinterest:before, .shr-pg .reddit:before, .shr-pg .stumbleupon:before, .shr-pg .tumblr:before, .shr-pg .twitter:before, .shr-pg .yahoomail:before {
  background: url("../assets/sprites_share.png") no-repeat; }

.shr-pg .bitly:before {
  background-position: 0 0; }

.shr-pg .blogger:before {
  background-position: 0 -32px; }

.shr-pg .delicious:before {
  background-position: 0 -64px; }

.shr-pg .digg:before {
  background-position: 0 -96px; }

.shr-pg .diigo:before {
  background-position: 0 -128px; }

.shr-pg .facebook:before {
  background-position: 0 -160px; }

.shr-pg .feed:before {
  background-position: 0 -192px; }

.shr-pg .gmail:before {
  background-position: 0 -224px; }

.shr-pg .googleplus:before {
  background-position: 0 -256px; }

.shr-pg .linkedin:before {
  background-position: 0 -288px; }

.shr-pg .myspace:before {
  background-position: 0 -320px; }

.shr-pg .pinterest:before {
  background-position: 0 -352px; }

.shr-pg .reddit:before {
  background-position: 0 -384px; }

.shr-pg .stumbleupon:before {
  background-position: 0 -416px; }

.shr-pg .tumblr:before {
  background-position: 0 -448px; }

.shr-pg .twitter:before {
  background-position: 0 -480px; }

.shr-pg .yahoomail:before {
  background-position: 0 -512px; }

.shr-opn span {
  padding-right: 0.2em; }

.shr-pg .shr-lnk {
  font-size: 115%;
  line-height: 32px;
  margin-bottom: 8px;
  min-height: 32px;
  text-align: left;
  text-decoration: none;
  width: 100%; }
  .shr-pg .shr-lnk:before {
    content: " ";
    display: inline-block;
    height: 32px;
    margin-right: 0.6em;
    vertical-align: middle;
    width: 32px; }
.shr-pg .shr-dscl {
  padding-bottom: 0; }
.shr-pg .email:before {
  content: "\2709";
  display: inline-block;
  font-family: "Glyphicons Halflings";
  font-size: 32px;
  margin-right: 0.3em; }
.shr-pg .shr-pg {
  text-align: left; }
.shr-pg ul {
  list-style-type: none;
  margin: 10px;
  padding: 0; }

[dir=rtl] .shr-opn span {
  padding-left: 0.2em;
  padding-right: 0; }
[dir=rtl] .shr-pg {
  text-align: right; }
  [dir=rtl] .shr-pg .shr-lnk {
    text-align: right; }
    [dir=rtl] .shr-pg .shr-lnk:before {
      margin-left: 0.4em;
      margin-right: auto; }
[dir=rtl] .email:before {
  margin-left: 0.6em;
  margin-right: auto; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-eng.html / wet-boew.github.io/wet-boew/Licence-fra.html
 */
table.dataTable, .dataTables_wrapper .dataTables_scroll {
  clear: both; }

table.dataTable thead th:active, table.dataTable thead td:active {
  outline: none; }

.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter {
  font-weight: 400; }

table.dataTable thead th, table.dataTable tfoot th {
  font-weight: 700; }

table.dataTable thead th, table.dataTable thead td, table.dataTable tfoot th, table.dataTable tfoot td, table.dataTable.no-footer, .dataTables_wrapper.no-footer .dataTables_scrollBody {
  border-bottom: 1px solid #111; }

table.dataTable th.right, table.dataTable td.right {
  text-align: right; }

table.dataTable th.center, table.dataTable td.center, table.dataTable td.dataTables_empty {
  text-align: center; }

table.dataTable.rowborder tbody th, table.dataTable.rowborder tbody td, table.dataTable.display tbody th, table.dataTable.display tbody td {
  border-top: 1px solid #ddd; }

table.dataTable.rowborder tbody tr:first-child th, table.dataTable.rowborder tbody tr:first-child td, table.dataTable.display tbody tr:first-child th, table.dataTable.display tbody tr:first-child td, table.dataTable.cell-border tbody tr:first-child th, table.dataTable.cell-border tbody tr:first-child td {
  border-top: 0; }

table.dataTable.cell-border tbody th, table.dataTable.cell-border tbody td {
  border-right: 1px solid #ddd;
  border-top: 1px solid #ddd; }

table.dataTable.cell-border tbody tr th:first-child, table.dataTable.cell-border tbody tr td:first-child {
  border-left: 1px solid #ddd; }

.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing {
  color: #333; }

table.dataTable.display tbody tr:hover.selected > .sorting_1, table.dataTable.display tbody tr.odd:hover.selected > .sorting_1, table.dataTable.display tbody tr.even:hover.selected > .sorting_1, table.dataTable.order-column.hover tbody tr:hover.selected > .sorting_1, table.dataTable.order-column.hover tbody tr.odd:hover.selected > .sorting_1, table.dataTable.order-column.hover tbody tr.even:hover.selected > .sorting_1 {
  background-color: #a1aec7; }

table.dataTable.display tbody tr:hover.selected > .sorting_2, table.dataTable.display tbody tr.odd:hover.selected > .sorting_2, table.dataTable.display tbody tr.even:hover.selected > .sorting_2, table.dataTable.order-column.hover tbody tr:hover.selected > .sorting_2, table.dataTable.order-column.hover tbody tr.odd:hover.selected > .sorting_2, table.dataTable.order-column.hover tbody tr.even:hover.selected > .sorting_2 {
  background-color: #a2afc8; }

table.dataTable.display tbody tr:hover.selected > .sorting_3, table.dataTable.display tbody tr.odd:hover.selected > .sorting_3, table.dataTable.display tbody tr.even:hover.selected > .sorting_3, table.dataTable.order-column.hover tbody tr:hover.selected > .sorting_3, table.dataTable.order-column.hover tbody tr.odd:hover.selected > .sorting_3, table.dataTable.order-column.hover tbody tr.even:hover.selected > .sorting_3 {
  background-color: #a4b2cb; }

table.dataTable.display tbody tr.odd.selected > .sorting_1, table.dataTable.order-column.stripe tbody tr.odd.selected > .sorting_1 {
  background-color: #a6b3cd; }

table.dataTable.display tbody tr.odd.selected > .sorting_2, table.dataTable.order-column.stripe tbody tr.odd.selected > .sorting_2 {
  background-color: #a7b5ce; }

table.dataTable.display tbody tr.odd.selected > .sorting_3, table.dataTable.order-column.stripe tbody tr.odd.selected > .sorting_3 {
  background-color: #a9b6d0; }

table.dataTable.display tbody tr:hover.selected, table.dataTable.display tbody tr.odd:hover.selected, table.dataTable.display tbody tr.even:hover.selected, table.dataTable.hover tbody tr:hover.selected, table.dataTable.hover tbody tr.odd:hover.selected, table.dataTable.hover tbody tr.even:hover.selected {
  background-color: #a9b7d1; }

table.dataTable.display tbody tr.odd.selected, table.dataTable.stripe tbody tr.odd.selected {
  background-color: #abb9d3; }

table.dataTable.display tbody tr.even.selected > .sorting_1, table.dataTable.display tbody tr.selected > .sorting_1, table.dataTable.display tbody tr.selected > .sorting_2, table.dataTable.display tbody tr.selected > .sorting_3, table.dataTable.order-column tbody tr.selected > .sorting_1, table.dataTable.order-column tbody tr.selected > .sorting_2, table.dataTable.order-column tbody tr.selected > .sorting_3, table.dataTable.order-column.stripe tbody tr.even.selected > .sorting_1 {
  background-color: #acbad4; }

table.dataTable.display tbody tr.even.selected > .sorting_2, table.dataTable.order-column.stripe tbody tr.even.selected > .sorting_2 {
  background-color: #adbbd6; }

table.dataTable.display tbody tr.even.selected > .sorting_3, table.dataTable.order-column.stripe tbody tr.even.selected > .sorting_3 {
  background-color: #afbdd8; }

table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc {
  background-color: #e7e7e7; }

table.dataTable.display tbody tr:hover > .sorting_1, table.dataTable.display tbody tr.odd:hover > .sorting_1, table.dataTable.display tbody tr.even:hover > .sorting_1, table.dataTable.order-column.hover tbody tr:hover > .sorting_1, table.dataTable.order-column.hover tbody tr.odd:hover > .sorting_1, table.dataTable.order-column.hover tbody tr.even:hover > .sorting_1 {
  background-color: #eaeaea; }

table.dataTable.display tbody tr:hover > .sorting_2, table.dataTable.display tbody tr.odd:hover > .sorting_2, table.dataTable.display tbody tr.even:hover > .sorting_2, table.dataTable.order-column.hover tbody tr:hover > .sorting_2, table.dataTable.order-column.hover tbody tr.odd:hover > .sorting_2, table.dataTable.order-column.hover tbody tr.even:hover > .sorting_2 {
  background-color: #ebebeb; }

table.dataTable.display tbody tr:hover > .sorting_3, table.dataTable.display tbody tr.odd:hover > .sorting_3, table.dataTable.display tbody tr.even:hover > .sorting_3, table.dataTable.order-column.hover tbody tr:hover > .sorting_3, table.dataTable.order-column.hover tbody tr.odd:hover > .sorting_3, table.dataTable.order-column.hover tbody tr.even:hover > .sorting_3 {
  background-color: #eee; }

table.dataTable.display tbody tr.odd > .sorting_1, table.dataTable.order-column.stripe tbody tr.odd > .sorting_1 {
  background-color: #f1f1f1; }

table.dataTable.display tbody tr.odd > .sorting_2, table.dataTable.order-column.stripe tbody tr.odd > .sorting_2 {
  background-color: #f3f3f3; }

table.dataTable.display tbody tr:hover, table.dataTable.display tbody tr.odd:hover, table.dataTable.display tbody tr.odd > .sorting_3, table.dataTable.display tbody tr.even:hover, table.dataTable.hover tbody tr:hover, table.dataTable.hover tbody tr.odd:hover, table.dataTable.hover tbody tr.even:hover, table.dataTable.order-column.stripe tbody tr.odd > .sorting_3 {
  background-color: #f5f5f5; }

table.dataTable.display tbody tr.odd, table.dataTable.display tbody tr.even > .sorting_1, table.dataTable.display tbody tr > .sorting_1, table.dataTable.display tbody tr > .sorting_2, table.dataTable.display tbody tr > .sorting_3, table.dataTable.stripe tbody tr.odd, table.dataTable.order-column tbody tr > .sorting_1, table.dataTable.order-column tbody tr > .sorting_2, table.dataTable.order-column tbody tr > .sorting_3, table.dataTable.order-column.stripe tbody tr.even > .sorting_1 {
  background-color: #f9f9f9; }

table.dataTable.display tbody tr.even > .sorting_2, table.dataTable.order-column.stripe tbody tr.even > .sorting_2 {
  background-color: #fbfbfb; }

table.dataTable.display tbody tr.even > .sorting_3, table.dataTable.order-column.stripe tbody tr.even > .sorting_3 {
  background-color: #fdfdfd; }

table.dataTable, table.dataTable th, table.dataTable td {
  -webkit-box-sizing: content-box;
  -moz-box-sizing: content-box;
  box-sizing: content-box; }

table.dataTable thead .sorting_asc .sorting-icons:before, table.dataTable thead .sorting_desc .sorting-icons:after {
  background: #ccc;
  border: 1px solid #111; }

table.dataTable thead .sorting .sorting-icons:before, table.dataTable thead .sorting .sorting-icons:after, table.dataTable thead .sorting_asc .sorting-icons:after, table.dataTable thead .sorting_desc .sorting-icons:before {
  background: #fff;
  border: 1px solid #aaa;
  color: #757575; }

table.dataTable thead .sorting, table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc {
  cursor: pointer; }

/*
 * Table styles
 */
table.dataTable {
  border-collapse: separate;
  border-spacing: 0;
  margin: 0 auto;
  width: 100% !important; }
  table.dataTable thead .sorting-cnt {
    white-space: nowrap; }
    table.dataTable thead .sorting-cnt:before {
      content: " "; }
  table.dataTable thead .sorting-icons {
    display: inline-block;
    margin-top: 2px; }
    table.dataTable thead .sorting-icons:before {
      content: "\e093";
      padding: 0 0.1em 0 0; }
    table.dataTable thead .sorting-icons:after {
      content: "\e094";
      padding: 0 0.04em 0 0.06em; }
  table.dataTable tbody tr {
    background-color: #fff; }
    table.dataTable tbody tr.selected {
      background-color: #b0bed9; }

/*
 * Control feature layout
 */
.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody th > div.dataTables_sizing, .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody td > div.dataTables_sizing {
  height: 0;
  margin: 0 !important;
  overflow: hidden;
  padding: 0 !important; }

.dataTables_wrapper .dataTables_paginate .paginate_button.previous, .dataTables_wrapper .dataTables_paginate .paginate_button.current:first-child {
  border-bottom-left-radius: 4px;
  border-top-left-radius: 4px;
  margin-left: 0; }

.dataTables_wrapper .dataTables_paginate .paginate_button.next, .dataTables_wrapper .dataTables_paginate .paginate_button.current:last-child {
  border-bottom-right-radius: 4px;
  border-top-right-radius: 4px; }

.dataTables_wrapper {
  clear: both;
  position: relative;
  zoom: 1; }
  .dataTables_wrapper .dataTables_length {
    float: left; }
  .dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right; }
    .dataTables_wrapper .dataTables_filter input {
      margin-left: 0.5em; }
  .dataTables_wrapper .dataTables_info {
    clear: both;
    float: left; }
  .dataTables_wrapper .dataTables_paginate {
    padding-top: 1.25em;
    text-align: center; }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
      background-color: #eaebed;
      border: 1px solid #dcdee1;
      color: #335075;
      cursor: pointer;
      display: inline-block;
      line-height: 1.4375;
      margin-bottom: 0.5em;
      margin-left: -1px;
      padding: 10px 16px;
      position: relative;
      text-decoration: none; }
      .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #2572b4;
        border-color: #2572b4;
        color: #fff;
        cursor: default;
        z-index: 2; }
      .dataTables_wrapper .dataTables_paginate .paginate_button:hover, .dataTables_wrapper .dataTables_paginate .paginate_button:focus, .dataTables_wrapper .dataTables_paginate .paginate_button:active {
        background-color: #d4d6da;
        border-color: #bbbfc5;
        color: #335075; }
  .dataTables_wrapper .dataTables_processing {
    background: -webkit-gradient(linear, left top, right top, from(rgba(255, 255, 255, 0)), color-stop(25%, rgba(255, 255, 255, 0.9)), color-stop(75%, rgba(255, 255, 255, 0.9)), to(rgba(255, 255, 255, 0)));
    background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
    background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
    background-color: #fff;
    font-size: 1.2em;
    height: 40px;
    left: 50%;
    margin-left: -50%;
    margin-top: -25px;
    padding-top: 20px;
    position: absolute;
    text-align: center;
    top: 50%;
    width: 100%; }
  .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
    -webkit-overflow-scrolling: touch; }
  .dataTables_wrapper.no-footer div.dataTables_scrollHead table, .dataTables_wrapper.no-footer div.dataTables_scrollBody table {
    border-bottom: 0; }
  .dataTables_wrapper:after {
    clear: both;
    content: "";
    display: block;
    height: 0;
    visibility: hidden; }

[dir=rtl] table.dataTable thead .sorting, [dir=rtl] table.dataTable thead .sorting_asc, [dir=rtl] table.dataTable thead .sorting_desc, [dir=rtl] table.dataTable thead .sorting_asc_disabled, [dir=rtl] table.dataTable thead .sorting_desc_disabled {
  text-align: right; }

[dir=rtl] table.dataTable thead .sorting:after, [dir=rtl] table.dataTable thead .sorting_asc:after, [dir=rtl] table.dataTable thead .sorting_desc:after, [dir=rtl] table.dataTable thead .sorting_asc_disabled:after, [dir=rtl] table.dataTable thead .sorting_desc_disabled:after {
  margin-left: 0;
  margin-right: 5px; }

[dir=rtl] .dataTables_wrapper .dataTables_paginate .paginate_button.previous, [dir=rtl] .dataTables_wrapper .dataTables_paginate .paginate_button.current:first-child {
  border-bottom-left-radius: 0;
  border-top-left-radius: 0;
  border-bottom-right-radius: 4px;
  border-top-right-radius: 4px; }

[dir=rtl] .dataTables_wrapper .dataTables_paginate .paginate_button.next, [dir=rtl] .dataTables_wrapper .dataTables_paginate .paginate_button.current:last-child {
  border-bottom-left-radius: 4px;
  border-top-left-radius: 4px;
  border-bottom-right-radius: 0;
  border-top-right-radius: 0; }

[dir=rtl] .dataTables_wrapper .dataTables_info, [dir=rtl] .dataTables_wrapper .dataTables_length {
  float: right; }
[dir=rtl] .dataTables_wrapper .dataTables_filter {
  float: left;
  text-align: left; }
  [dir=rtl] .dataTables_wrapper .dataTables_filter input {
    margin-left: auto;
    margin-right: 0.5em; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
.wb-tabs, .wb-tabs.carousel-s1 figure, .wb-tabs.carousel-s2 figure {
  position: relative; }

.wb-tabs.carousel-s1 [role="tablist"] li, .wb-tabs.carousel-s2 [role="tablist"] li {
  z-index: 100; }

.wb-tabs.carousel-s1 figure, .wb-tabs.carousel-s2 figure {
  background: #243850;
  background: rgba(36, 56, 80, 0.9); }
  .wb-tabs.carousel-s1 figure img, .wb-tabs.carousel-s2 figure img {
    height: auto;
    width: 100%; }

.wb-tabs.carousel-s1 figcaption, .wb-tabs.carousel-s2 figcaption {
  bottom: 0;
  color: #fff;
  left: 0;
  padding: 0.5em 1em;
  position: relative;
  right: 0;
  z-index: 101; }

.wb-tabs.carousel-s1 [role="tabpanel"] a, .wb-tabs.carousel-s1 figcaption a, .wb-tabs.carousel-s2 [role="tabpanel"] a, .wb-tabs.carousel-s2 figcaption a {
  color: #fff; }

.wb-tabs.carousel-s2 [role="tablist"] li.prv, .wb-tabs.carousel-s2 [role="tablist"] li.nxt {
  background: none;
  margin: 0;
  padding: 0; }

.wb-tabs.carousel-s2 [role="tablist"] li.prv a, .wb-tabs.carousel-s2 [role="tablist"] li.nxt a {
  border: 0;
  padding: 10px 5px;
  width: 100%; }

.wb-tabs.carousel-s2 [role="tablist"] li.prv a .glyphicon, .wb-tabs.carousel-s2 [role="tablist"] li.nxt a .glyphicon, .wb-tabs.carousel-s2 [role="tablist"] li.plypause a {
  background: #fff;
  border-radius: 999px;
  -webkit-box-shadow: 0 0 4px #243850;
  box-shadow: 0 0 4px #243850; }

.wb-tabs.carousel-s2 [role="tablist"] li.prv a, .wb-tabs.carousel-s2 [role="tablist"] li.nxt a, .wb-tabs.carousel-s2 [role="tablist"] li.plypause a {
  color: #243850; }

.wb-tabs.carousel-s2 [role="tablist"] li.prv a .glyphicon, .wb-tabs.carousel-s2 [role="tablist"] li.nxt a .glyphicon {
  font-size: 1.75em;
  height: 1.75em;
  line-height: 1.75em;
  margin: auto 0;
  text-align: center;
  width: 1.75em; }

.wb-tabs.carousel-s2 [role="tablist"] li.prv a:focus, .wb-tabs.carousel-s2 [role="tablist"] li.prv a:hover, .wb-tabs.carousel-s2 [role="tablist"] li.nxt a:focus, .wb-tabs.carousel-s2 [role="tablist"] li.nxt a:hover {
  background: transparent; }

.wb-tabs.carousel-s2 [role="tablist"] li.prv a:focus .glyphicon, .wb-tabs.carousel-s2 [role="tablist"] li.prv a:hover .glyphicon, .wb-tabs.carousel-s2 [role="tablist"] li.nxt a:focus .glyphicon, .wb-tabs.carousel-s2 [role="tablist"] li.nxt a:hover .glyphicon, .wb-tabs.carousel-s2 [role="tablist"] li.plypause a:focus, .wb-tabs.carousel-s2 [role="tablist"] li.plypause a:hover {
  -webkit-box-shadow: none;
  box-shadow: none; }

.wb-tabs.carousel-s1 [role="tablist"] li.active a, .wb-tabs.carousel-s1 [role="tablist"] li:focus a, .wb-tabs.carousel-s1 [role="tablist"] li:hover a {
  border-top: 0;
  padding-top: 10px; }

.wb-tabs [role="tablist"] li, .wb-tabs [role="tablist"] li a, .wb-tabs.carousel-s1 [role="tablist"] li.control, .wb-tabs.carousel-s2 [role="tablist"] li.control {
  display: inline-block; }

.wb-tabs.carousel-s1 figcaption p, .wb-tabs.carousel-s2 figcaption p {
  margin-bottom: 0; }

.wb-tabs > details, .wb-tabs > .tabpanels > details {
  padding: 6px 12px; }
  .wb-tabs > details > summary, .wb-tabs > .tabpanels > details > summary {
    margin: -6px -12px;
    padding: 6px 12px; }

.csstransitions .wb-tabs [role="tabpanel"].out {
  position: absolute;
  top: 0;
  width: 100%;
  z-index: 0; }

.wb-tabs {
  /**
	 * Default, minimal, shared style
	 */
  /* For backwards compatibility. Should be removed in v4.1 */
  /**
	 * Style 1 - Basic carousel style
	 */
  /**
	 * Style 2 - Slider-like carousel style
	 */ }
  .wb-tabs > .tabpanels {
    overflow: hidden;
    position: relative; }
  .wb-tabs [role="tablist"] {
    list-style: none;
    margin: 0;
    padding: 0;
    position: relative; }
    .wb-tabs [role="tablist"] li {
      background: #ebf2fc;
      border-color: #ccc;
      border-style: solid;
      border-width: 1px;
      color: #000;
      cursor: pointer;
      margin: 0 10px 0 0;
      position: relative;
      text-align: center; }
      .wb-tabs [role="tablist"] li a {
        color: #000;
        padding: 10px;
        text-decoration: none; }
      .wb-tabs [role="tablist"] li:focus, .wb-tabs [role="tablist"] li:hover {
        background: #ccc;
        background: rgba(204, 204, 204, 0.9); }
      .wb-tabs [role="tablist"] li.active {
        background: #fff;
        border-bottom: 0;
        cursor: default;
        padding-bottom: 1px;
        z-index: 2; }
        .wb-tabs [role="tablist"] li.active a {
          cursor: default;
          padding-top: 6px;
          border-color: #666;
          border-style: solid;
          border-width: 4px 0 0 0; }
      .wb-tabs [role="tablist"] li.tab-count {
        line-height: normal; }
        .wb-tabs [role="tablist"] li.tab-count > div {
          position: relative;
          top: 0.4em; }
        .wb-tabs [role="tablist"] li.tab-count .curr-count {
          font-size: 1.5em; }
        .wb-tabs [role="tablist"] li.tab-count:focus, .wb-tabs [role="tablist"] li.tab-count:hover {
          background: transparent;
          cursor: default; }
    .wb-tabs [role="tablist"].generated li {
      border-bottom: 0;
      top: 1px; }
  .wb-tabs [role="tabpanel"] {
    overflow-x: auto;
    position: relative;
    z-index: 1; }
  .wb-tabs.carousel-s1 {
    border-top: 0; }
    .wb-tabs.carousel-s1 [role="tablist"] {
      bottom: 1em;
      left: 1em;
      position: static; }
      .wb-tabs.carousel-s1 [role="tablist"] li.prv {
        margin-right: 5px; }
      .wb-tabs.carousel-s1 [role="tablist"] li.tab-count {
        background: none;
        border: 0;
        font-size: 0.9em; }
        .wb-tabs.carousel-s1 [role="tablist"] li.tab-count > div {
          top: 0.7em; }
        .wb-tabs.carousel-s1 [role="tablist"] li.tab-count.active, .wb-tabs.carousel-s1 [role="tablist"] li.tab-count:focus, .wb-tabs.carousel-s1 [role="tablist"] li.tab-count:hover {
          cursor: default;
          top: 0; }
      .wb-tabs.carousel-s1 [role="tablist"] li.active, .wb-tabs.carousel-s1 [role="tablist"] li:focus, .wb-tabs.carousel-s1 [role="tablist"] li:hover {
        top: 1px; }
  .wb-tabs.carousel-s2 {
    background: #eee;
    padding-bottom: 4.375em; }
    .wb-tabs.carousel-s2 [role="tablist"] {
      bottom: 0;
      position: absolute;
      width: 100%; }
      .wb-tabs.carousel-s2 [role="tablist"] li {
        background: transparent;
        border: 0; }
        .wb-tabs.carousel-s2 [role="tablist"] li.prv a {
          padding-left: 1em; }
        .wb-tabs.carousel-s2 [role="tablist"] li.plypause {
          background: none;
          border: 0;
          float: right;
          margin-right: 0;
          padding: 2px 0; }
          .wb-tabs.carousel-s2 [role="tablist"] li.plypause a {
            font-size: 1.5em;
            margin-top: 0.4em;
            margin-right: 0.65em;
            padding: 8px 10px 4px; }

.wb-disable .csstransitions .wb-tabs [role="tabpanel"].out {
  position: static;
  width: auto; }
.wb-disable .wb-tabs [role="tablist"] {
  display: none; }
.wb-disable .wb-tabs [role="tabpanel"] {
  display: block;
  opacity: 1; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
.wb-disable .wb-twitter .twitter-timeline {
  text-indent: 0 !important; }

.wb-twitter .twitter-timeline {
  display: block;
  text-indent: -9999px; }
.wb-twitter iframe[style] {
  width: 100% !important; }

.wb-enable .wb-twitter .twitter-timeline {
  min-height: 100px;
  min-width: 100px;
  position: relative; }

/* Right to left (RTL) CSS */
[dir="rtl"] .wb-twitter .twitter-timeline {
  text-indent: 9999px; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
.wb-txthl .txthl {
  background-color: #ff0;
  color: #000;
  font-weight: 700; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-eng.html / wet-boew.github.io/wet-boew/Licence-fra.html
*/
.olButtonGeolocateItemActive, .olButtonGeolocateItemInactive {
  background: url("../assets/sprites_geomap.png") no-repeat; }

.olDragDown, .olControlDragFeatureOver {
  cursor: move; }

.olHandlerBoxZoomBox, .olHandlerBoxSelectFeature {
  background-color: #fff;
  font-size: 1px;
  opacity: 0.5;
  position: absolute; }

.olButtonGeolocateItemActive, .olButtonGeolocateItemInactive {
  -webkit-background-size: 33px auto;
  background-size: 33px auto; }

/**
 * Openlayer pan zoom bar button
 */
.olButton {
  height: 33px;
  width: 33px; }
  .olButton img {
    float: left;
    height: 33px;
    left: 0;
    margin: 0;
    top: 0;
    width: 33px; }

.olControlzoomin {
  left: 15px;
  top: 10px; }

.olControlzoomout {
  left: 15px;
  top: 43px; }

.olControlzoomworld {
  left: 15px;
  top: 83px; }

.olPanelGeolocate {
  left: 19px;
  top: 127px; }
  .olPanelGeolocate button {
    border: 0;
    cursor: pointer;
    height: 33px;
    width: 33px; }

.olButtonGeolocateItemInactive {
  background-position: 0 -34px; }

/*
 * When a potential text is bigger than the image it move the image
 * with some headers (closes #3154)
 */
.olControlPanZoomBar div {
  font-size: 1px; }

.olMap {
  cursor: default;
  z-index: 0; }

.olMapViewport {
  text-align: left; }

.olLayerDiv {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none; }
  .olLayerDiv img {
    max-width: none !important; }

.olControlMousePosition {
  bottom: 5px;
  display: block;
  font-family: Arial;
  font-size: smaller;
  left: 100px;
  position: absolute; }

.olControlScale {
  bottom: 3em;
  display: block;
  font-size: smaller;
  position: absolute;
  right: 3px; }

.olControlScaleLine {
  bottom: 15px;
  display: block;
  font-size: xx-small;
  left: 10px;
  position: absolute; }

.olControlScaleLineBottom {
  border: solid 2px #000;
  border-bottom: 0;
  margin-top: -2px;
  text-align: center; }

.olControlScaleLineTop {
  border: solid 2px #000;
  border-top: 0;
  text-align: center; }

.olControlAttribution {
  bottom: 5px;
  font-size: x-small;
  right: 5px; }

.olHandlerBoxZoomBox {
  border: 2px solid #f00; }

.olHandlerBoxSelectFeature {
  border: 2px solid #00f; }

.olPopupCloseBox {
  cursor: pointer; }

.olFramedCloudPopupContent {
  overflow: auto;
  padding: 5px; }

.olPopup h1, .olPopup h2, .olPopup h3, .olPopup h4, .olPopup h5, .olPopup h6, .olPopup p, .olPopup ol, .olPopup ul {
  margin: 5px; }

.olControlNoSelect {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none; }

.olImageLoadError {
  display: none !important; }

/**
 * Cursor styles
 */
.olCursorWait {
  cursor: wait; }

.olDrawBox {
  cursor: crosshair; }

.olControlDragFeatureActive.olControlDragFeatureOver.olDragDown {
  cursor: -webkit-grabbing;
  cursor: -moz-grabbing;
  cursor: grabbing; }

/**
 * Animations
 */
.olLayerGrid .olTileImage {
  -webkit-transition: opacity 0.2s linear;
  transition: opacity 0.2s linear; }

/**
 * GeoMap
 */
.wb-geomap-map {
  outline: 1px solid #ccc;
  position: relative; }
  .wb-geomap-map.active {
    outline-color: #07f; }

.wb-geomap-detail {
  margin-bottom: 10px;
  margin-top: 10px; }

.geomap-legend-detail {
  padding-top: 10px; }

.geomap-legend-symbol {
  height: 18px;
  margin: 5px;
  width: 18px; }

.geomap-clear-format {
  clear: both; }

.geomap-legend-label {
  display: inline; }

.geomap-lgnd-layer {
  margin-top: 20px !important; }

.geomap-geoloc {
  left: 70px;
  position: absolute;
  right: 70px;
  top: 15px;
  z-index: 10000; }
  .geomap-geoloc input[type="text"] {
    width: 80%; }

button.geomap-geoloc-aoi-btn {
  background-color: #fff;
  border-color: #eee;
  -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.25);
  box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.25);
  color: #666;
  position: absolute;
  right: 15px;
  top: 15px;
  z-index: 10000; }

.geomap-aoi legend {
  border: 0;
  font-size: 1em;
  margin-bottom: 1em; }
.geomap-aoi button.geomap-geoloc-aoi-btn {
  position: absolute;
  right: 15px;
  top: auto; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
.wb-zebra-col-hover .wb-group-summary col.table-hover, .table-hover .wb-group-summary tr:hover td, .table-hover .wb-group-summary tr:hover th {
  background-color: #fafaff; }

.wb-cell-layout {
  background-color: transparent; }

.wb-cell-key, .wb-cell-desc {
  font-style: italic; }

.wb-zebra > colgroup + colgroup {
  border-left: 2px solid #ddd; }

.wb-group-summary {
  background-color: #f0f2f4; }

.wb-zebra-col-hover col.table-hover {
  background-color: #f0f0f0; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
.feeds-cont.waiting:after, .feeds-cont.waiting:before {
  bottom: 0;
  content: " ";
  height: 50px;
  left: 0;
  margin: auto;
  position: absolute;
  right: 0;
  top: 0;
  width: 50px; }

.feeds-cont.waiting {
  min-height: 100px;
  min-width: 100px; }
  .feeds-cont.waiting:after {
    -webkit-animation-duration: 1000ms;
    animation-duration: 1000ms;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    -webkit-animation-name: spin;
    animation-name: spin;
    -webkit-animation-timing-function: linear;
    animation-timing-function: linear;
    background: url("../assets/loading.png") center center no-repeat;
    -webkit-background-size: 30px 30px;
    background-size: 30px 30px;
    z-index: 2; }
  .feeds-cont.waiting:before {
    background: rgba(0, 0, 0, 0);
    z-index: 1; }
.feeds-cont .feeds-date:before {
  content: "["; }
.feeds-cont .feeds-date:after {
  content: "]"; }

/*
 Polyfills
 */
/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
datalist {
  display: none; }

/*
  WET-BOEW
  @title: Details/summary polyfill pre-Modernizr CSS
 */
summary {
  display: block !important;
  visibility: visible !important; }

details:not([open]) details summary, details .out details summary {
  display: none !important; }

details:not([open]) {
  visibility: hidden; }
  details:not([open]) > details, details:not([open]) > * {
    display: none; }
details.alert:not([open]) {
  visibility: visible; }

.tabpanels > details:not([open]) {
  visibility: visible; }

.wb-disable details {
  visibility: visible !important; }
  .wb-disable details > * {
    display: block !important; }

/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
.datepicker-format {
  display: none; }

/*
 Views
 */
/* All screen views */
@media screen {
  /*
  WET-BOEW
  @title: All screen views
 */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  /* Pretty printing styles. Used with prettify.js. */
  /* string content - from #080 */
  /* a keyword - from #008 */
  /* a comment */
  /* a type name */
  /* a literal value */
  /* punctuation, lisp open bracket, lisp close bracket */
  /* a markup tag name - from #008 */
  /* a markup attribute name */
  /* a markup attribute value - from #080 */
  /* a declaration */
  /* a variable name */
  /* a function name */
  .nojs-show, .wb-disable .nojs-hide {
    display: none !important; }
  #wb-dtmd {
    margin: 2em 0 0; }
    #wb-dtmd dt, #wb-dtmd dd {
      display: inline;
      font-weight: normal;
      margin-right: 0; }
  .nowrap {
    white-space: nowrap; }
  .wb-disable .nojs-show {
    display: block !important; }
  .typ, .atn, .dec, .var {
    color: #606; }
  .pun, .opn, .clo {
    color: #660; }
  .str, .atv {
    color: #2f6d2f; }
  .kwd {
    color: #024b6e; }
  .com {
    color: #800; }
  .lit {
    color: #066; }
  .tag {
    color: #125b7e; }
  .fun {
    color: #f00; } }

/* Extra-small view and under */
@media screen and (max-width: 767px) {
  /*
  WET-BOEW
  @title: Extra-small view and under (screen only)
 */ }

/* Small view and under */
@media screen and (max-width: 991px) {
  /*
  WET-BOEW
  @title: Small view and under (screen only)
 */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  /**
 * Mobile-friendly styles
 */
  .dataTables_wrapper .dataTables_info {
    padding-bottom: 5px; }
  .dataTables_wrapper .dataTables_filter {
    float: left;
    text-align: left;
    width: 100%; }
  [dir=rtl] .dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right; }
  .wb-tabs > details, .wb-tabs > .tabpanels > details {
    border-bottom: #ccc solid 1px; }
    .wb-tabs > details:last-of-type, .wb-tabs > .tabpanels > details:last-of-type {
      border-bottom: 0; }
    .wb-tabs > details[style], .wb-tabs > .tabpanels > details[style] {
      min-height: 0 !important; }
    .wb-tabs > details[open] > summary, .wb-tabs > .tabpanels > details[open] > summary {
      margin-bottom: 0; }
  .wb-tabs {
    /* Only for backwards compatibility. Should be removed in v4.1. */
    border-color: #ccc;
    border-style: solid;
    border-width: 1px;
    border-radius: 4px;
    margin-bottom: 15px;
    padding-left: 0;
    padding-right: 0; }
    .wb-tabs.tabs-acc > ul {
      display: none; } }

/* Medium view and under */
@media screen and (max-width: 1199px) {
  /*
  WET-BOEW
  @title: Medium view and under (screen only)
 */ }

/* Large view and under */
@media screen and (max-width: 1599px) {
  /*
  WET-BOEW
  @title: Large view and under (screen only)
 */ }

/* Extra-small view and over */
@media screen and (min-width: 480px) {
  /*
  WET-BOEW
  @title: Extra-small view and over (screen only)
 */
  /*
  WET-BOEW
  @title: Proximity CSS - Extra-small view and over
 */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  .colcount-xs-2 {
    -webkit-column-count: 2;
    -moz-column-count: 2;
    column-count: 2; }
  .colcount-xs-3 {
    -webkit-column-count: 3;
    -moz-column-count: 3;
    column-count: 3; }
  .colcount-xs-4 {
    -webkit-column-count: 4;
    -moz-column-count: 4;
    column-count: 4; }
  #mb-pnl {
    min-width: 300px; }
  .dataTables_wrapper .dataTables_info:after {
    content: "|";
    font-size: 1.2em;
    line-height: 1em;
    padding: 0 0.25em; } }

/* Small view and over */
@media screen and (min-width: 768px) {
  /*
  WET-BOEW
  @title: Small view and over (screen only)
 */
  /*
  WET-BOEW
  @title: Proximity CSS - Small view and over
 */
  .colcount-sm-2 {
    -webkit-column-count: 2;
    -moz-column-count: 2;
    column-count: 2; }
  .colcount-sm-3 {
    -webkit-column-count: 3;
    -moz-column-count: 3;
    column-count: 3; }
  .colcount-sm-4 {
    -webkit-column-count: 4;
    -moz-column-count: 4;
    column-count: 4; }
  .pstn-lft-sm {
    position: absolute;
    left: 0;
    right: auto; }
  .pstn-rght-sm {
    position: absolute;
    right: 0;
    left: auto; }
  .pstn-tp-sm {
    position: absolute;
    top: 0;
    bottom: auto; }
  .pstn-bttm-sm {
    position: absolute;
    bottom: 0;
    top: auto; } }

/* Medium view and over */
@media screen and (min-width: 992px) {
  /*
  WET-BOEW
  @title: Medium view and over (screen only)
 */
  /*
  WET-BOEW
  @title: Proximity CSS - Medium view and over
 */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  [dir=rtl] main.col-md-push-3 {
    left: auto; }
  [dir=rtl] #wb-sec.col-md-pull-9 {
    right: auto; }
  .colcount-md-2 {
    -webkit-column-count: 2;
    -moz-column-count: 2;
    column-count: 2; }
  .colcount-md-3 {
    -webkit-column-count: 3;
    -moz-column-count: 3;
    column-count: 3; }
  .colcount-md-4 {
    -webkit-column-count: 4;
    -moz-column-count: 4;
    column-count: 4; }
  .pstn-lft-md {
    position: absolute;
    left: 0;
    right: auto; }
  .pstn-rght-md {
    position: absolute;
    right: 0;
    left: auto; }
  .pstn-tp-md {
    position: absolute;
    top: 0;
    bottom: auto; }
  .pstn-bttm-md {
    position: absolute;
    bottom: 0;
    top: auto; }
  #details-facebook, #details-flickr, #details-youtube {
    padding-left: 0;
    padding-right: 0; }
  .wb-tabs > details, .wb-tabs > .tabpanels > details {
    border-color: #ccc;
    border-style: solid;
    border-width: 1px;
    display: none; }
    .wb-tabs > details[open], .wb-tabs > .tabpanels > details[open] {
      display: block; }
      .wb-tabs > details[open] > summary, .wb-tabs > .tabpanels > details[open] > summary {
        display: none !important; }
  .wb-tabs {
    /* Only for backwards compatibility. Should be removed in v4.1. */ }
    .wb-tabs.carousel-s2.show-thumbs [role="tablist"] li.active a {
      border-color: #666;
      border-style: solid;
      border-width: 10px;
      margin-bottom: 1px;
      padding: 0; }
    .wb-tabs.carousel-s2.show-thumbs [role="tablist"] li[role="presentation"] {
      display: inline-block; }
      .wb-tabs.carousel-s2.show-thumbs [role="tablist"] li[role="presentation"] img {
        opacity: 0.5;
        width: 140px; }
    .wb-tabs.carousel-s2.show-thumbs [role="tablist"] li[class="active"] img {
      opacity: 1; }
    .wb-tabs.carousel-s2.show-thumbs [role="tablist"] li.prv, .wb-tabs.carousel-s2.show-thumbs [role="tablist"] li.tab-count, .wb-tabs.carousel-s2.show-thumbs [role="tablist"] li.nxt {
      display: none; } }

/* Large view and over */
@media screen and (min-width: 1200px) {
  /*
  WET-BOEW
  @title: Large view and over (screen only)
 */
  /*
  WET-BOEW
  @title: Proximity CSS - Medium view and over
 */
  .colcount-lg-2 {
    -webkit-column-count: 2;
    -moz-column-count: 2;
    column-count: 2; }
  .colcount-lg-3 {
    -webkit-column-count: 3;
    -moz-column-count: 3;
    column-count: 3; }
  .colcount-lg-4 {
    -webkit-column-count: 4;
    -moz-column-count: 4;
    column-count: 4; }
  .pstn-lft-lg {
    position: absolute;
    left: 0;
    right: auto; }
  .pstn-rght-lg {
    position: absolute;
    right: 0;
    left: auto; }
  .pstn-tp-lg {
    position: absolute;
    top: 0;
    bottom: auto; }
  .pstn-bttm-lg {
    position: absolute;
    bottom: 0;
    top: auto; } }

/* Extra-extra-small view */
@media screen and (max-width: 479px) {
  /*
  WET-BOEW
  @title: Extra-extra-small view (screen only)
 */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  #mb-pnl {
    min-width: 65%; }
  .dataTables_wrapper .dataTables_length {
    width: 100%; }
  .wb-tabs.carousel-s2 [role="tablist"] li.prv, .wb-tabs.carousel-s2 [role="tablist"] li.nxt {
    margin-right: 0; }
  .wb-tabs.carousel-s2 [role="tablist"] li.prv {
    margin-left: 0; }
    .wb-tabs.carousel-s2 [role="tablist"] li.prv a {
      padding: 10px 0 10px 0.4em; }
  .wb-tabs.carousel-s2 [role="tablist"] li.nxt a {
    padding: 10px 0; }
  .wb-tabs.carousel-s2 [role="tablist"] li.tab-count {
    font-size: 0.9em;
    margin-right: 5px; }
  .wb-tabs.carousel-s2 [role="tablist"] li.plypause {
    margin-right: 2%; }
    .wb-tabs.carousel-s2 [role="tablist"] li.plypause a {
      font-size: 1.3em;
      margin-right: 0;
      padding: 12px 10px 7px; } }

/* Extra-small view */
@media screen and (min-width: 480px) and (max-width: 767px) {
  /*
  WET-BOEW
  @title: Extra-small view (screen only)
 */ }

/* Small view */
@media screen and (min-width: 768px) and (max-width: 991px) {
  /*
  WET-BOEW
  @title: Small view (screen only)
 */ }

/* Medium view */
@media screen and (min-width: 992px) and (max-width: 1199px) {
  /*
  WET-BOEW
  @title: Medium view (screen only)
 */ }

/* Large view */
@media screen and (min-width: 1200px) and (max-width: 1599px) {
  /*
  WET-BOEW
  @title: Large view (screen only)
 */ }

/* Extra-large view */
@media screen and (min-width: 1600px) {
  /*
  WET-BOEW
  @title: Extra-large view (screen only)
 */
  /*
  WET-BOEW
  @title: Proximity CSS - Medium view and over
 */
  .colcount-xl-2 {
    -webkit-column-count: 2;
    -moz-column-count: 2;
    column-count: 2; }
  .colcount-xl-3 {
    -webkit-column-count: 3;
    -moz-column-count: 3;
    column-count: 3; }
  .colcount-xl-4 {
    -webkit-column-count: 4;
    -moz-column-count: 4;
    column-count: 4; } }

/* Print view */
@media print {
  /*
  WET-BOEW
  @title: Print view
 */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-eng.html / wet-boew.github.io/wet-boew/Licence-fra.html
*/
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  /*
  Multimedia Player Code (print view)
 */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  /* Use higher contrast and text-weight for printable form. */
  /*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
  /**
 * Print styles
 */
  .pg-brk-aft {
    page-break-after: always; }
  .fn-lnk, .wb-fnote .fn-rtn a {
    background-color: transparent;
    border: 0;
    padding: 0; }
  .wb-fnote {
    border-left: 0;
    border-right: 0;
    margin-bottom: 1em;
    margin-left: 0;
    margin-right: 0; }
    .wb-fnote dd {
      border: 0;
      display: inline-block;
      width: 100%; }
    .wb-fnote .fn-rtn {
      overflow: visible; }
      .wb-fnote .fn-rtn a:after {
        content: none; }
  .wb-geomap-detail, .olControlMousePosition, .olControlPanZoomBar {
    visibility: hidden; }
  .mfp-wrap, .mfp-container {
    position: static; }
  .mfp-arrow, .mfp-close {
    display: none !important; }
  .wb-mm-ctrls, .wb-mm-ovrly {
    display: none; }
  .kwd, .typ, .tag {
    font-weight: 700; }
  .kwd, .tag {
    color: #006; }
  .str, .atv {
    color: #060; }
  .pun, .opn, .clo {
    color: #440; }
  .typ, .atn {
    color: #404; }
  .com {
    color: #600;
    font-style: italic; }
  .lit {
    color: #044; }
  .wb-tabs [role="tablist"] {
    display: none !important; }
  .wb-tabs [role="tabpanel"] {
    display: block !important;
    opacity: 1 !important;
    position: static !important;
    visibility: visible !important; }
    .wb-tabs [role="tabpanel"] figcaption {
      position: static; }
    .wb-tabs [role="tabpanel"] summary {
      display: block !important; } }



/****** This poor CSS page :( 

GC Usability theme styles to override the other styles I think maybe

This is the theme-coa.css file from WET4


*****************/


@charset "utf-8";
/*!
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 * v4.0.12 - 2015-03-23
 *
 */
/*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
/*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
/*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
/*
 * HOW TO USE THIS FILE
 * Use this file to override Bootstrap variables and WET custom variables.
 * If there is a Bootstrap variable not shown here that you want to override, go to "../lib/bootstrap-sass-official/assets/stylesheets/bootstrap/variables" to view the variables that you can override. Simply copy and paste the variable and its applicable section (if applicable) from the Bootstrap file into this override file and override the variables as applicable.
 */
/*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
/*
  @title: Archive Styles
 */
#archived-bnr {
  background-color: #fd0; }
  #archived-bnr p {
    margin: 0;
    text-align: center; }
  #archived-bnr a {
    color: #000;
    display: block;
    font-weight: 700;
    padding: 0.75em 44px;
    text-decoration: none; }
    #archived-bnr a:focus, #archived-bnr a:hover {
      text-decoration: underline; }
  #archived-bnr .overlay-close {
    color: #000; }

/*
 Views
 */
/* All views */
/*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
/*
  @title: All views
 */
#wb-bc li:first-child:before, [dir=rtl] #wb-bc li:before, [dir=rtl] #wb-bc li:first-child:after {
  content: none;
  padding: 0; }

#wb-bc li:before, #wb-bc li:after {
  color: #333;
  font-family: "Glyphicons Halflings";
  font-size: 0.7em; }
#wb-bc li:before {
  content: "\e092"; }

[dir=rtl] #wb-bc li:after {
  content: "\e091";
  padding: 0 5px; }

/* All screen views */
@media screen {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: All screen views
 */
  #gcwu-sig, #wmms {
    height: 1.5em; }
  #wb-sttl a:link, #wb-sttl a:visited {
    text-decoration: none; }
  #wb-sttl a:hover, #wb-sttl a:focus {
    text-decoration: underline; }
  .wb-disable body {
    background: none !important; }
  .wb-disable header {
    background: #3f698f; }
  .wb-sl {
    background-color: #000;
    color: #fff;
    font-weight: 700; }
    .wb-sl:focus {
      color: #fff;
      text-decoration: none; }
  #wb-bar {
    background: #000;
    min-height: 2.6em; }
    #wb-bar a {
      color: #fff; }
  #gcwu-sig {
    margin: 10px 0; }
  #wb-sttl a {
    color: #fff !important; }
    #wb-sttl a span {
      line-height: normal; }
  #wb-sm .nvbar ul.menu > li > a:hover, #wb-sm .active a, #wb-sm .active summary, #wb-sm .sm, #wb-sm .sm a, #wb-sm .sm summary {
    background-color: #ccc;
    color: #000; }
  #wb-sm .nvbar ul.menu > li > a.wb-navcurr, #wb-sm .sm a.wb-navcurr, #wb-sm .sm summary.wb-navcurr, #wb-sm .sm .slflnk a.wb-navcurr {
    background: #0f315b;
    color: #fff; }
  #wb-sm {
    margin-top: -1px; }
    #wb-sm .nvbar {
      background-color: #146094;
      background-image: -webkit-gradient(linear, left top, left bottom, from(#146094), to(#23447e));
      background-image: -webkit-linear-gradient(#146094, #23447e);
      background-image: linear-gradient(#146094, #23447e);
      filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr="#FF146094", endColorstr="#FF23447E");
      border-top: 1px solid #87aec9;
      border-bottom: 4px solid #ccc; }
      #wb-sm .nvbar ul.menu {
        margin-bottom: 0; }
        #wb-sm .nvbar ul.menu > li {
          border-right: 1px solid #999;
          padding: 0; }
          #wb-sm .nvbar ul.menu > li.active {
            border-right-color: #ccc; }
    #wb-sm a, #wb-sm summary {
      color: #fff;
      display: block;
      font-weight: 700;
      padding: 0.48em 0.79em;
      text-decoration: none; }
    #wb-sm .sm {
      border-bottom: 4px solid #0f315b;
      border-radius: 0 0 3px 3px; }
      #wb-sm .sm a, #wb-sm .sm summary {
        font-weight: 400; }
        #wb-sm .sm a:link, #wb-sm .sm summary:link {
          text-decoration: none; }
        #wb-sm .sm a:hover, #wb-sm .sm a:focus, #wb-sm .sm summary:hover, #wb-sm .sm summary:focus {
          text-decoration: underline; }
      #wb-sm .sm .slflnk a {
        background: #bbb; }
  #wb-dtmd {
    float: right; }
  #wb-info {
    background: #efefef url("<?php echo $site_url ?>/mod/wet4/graphics/sft-deco.gif") repeat-x scroll center top; }
    #wb-info a:link, #wb-info a:visited {
      text-decoration: none; }
    #wb-info a:hover, #wb-info a:focus {
      text-decoration: underline; }
    #wb-info > .container {
      background: transparent url("<?php echo $site_url ?>/mod/wet4/graphics/sft-deco-leaf.gif") no-repeat top center; }
      #wb-info > .container > :before {
        background: transparent;
        content: " ";
        display: block;
        height: 25px;
        margin-left: -15px;
        margin-right: -15px; }
    #wb-info h2, #wb-info h3 {
      font-size: 120%;
      font-weight: 700; }
    #wb-info li {
      margin-bottom: 0.75em; }
  #gc-tctr {
    margin-bottom: 0;
    padding-top: 5px;
    padding-right: 0; }
    #gc-tctr > :first-child {
      border-right: 1px solid #999;
      line-height: 1.5;
      padding-right: 10px; }
  [dir=rtl] #wb-dtmd {
    float: left; }
  [dir=rtl] #wb-sec .list-group .list-group .list-group-item {
    padding-left: 15px;
    padding-right: 1.8em; }
  [dir=rtl] #gc-tctr > :first-child {
    border-left: 1px solid #999;
    border-right: 0;
    padding-left: 10px;
    padding-right: 0; } }

/* Extra-small view and under */
@media screen and (max-width: 767px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Extra-small view and under (screen only)
 */ }

/* Small view and under */
@media screen and (max-width: 991px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Small view and under (screen only)
 */
  #gcwu-sig, #gc-bar {
    display: none; }
  #wmms {
    height: 2em;
    margin-left: 15px;
    margin-top: 4px;
    position: absolute;
    top: 0.3em; }
  .wb-disable header {
    background: #ebeae9; }
  .wb-disable #wmms {
    position: static; }
  #wb-bar {
    min-height: 3em; }
  #wb-bnr {
    background-color: #174f88;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#4474ad), color-stop(#4474ad), to(#174f88));
    background-image: -webkit-linear-gradient(#4474ad, #4474ad, #174f88);
    background-image: linear-gradient(#4474ad, #4474ad, #174f88);
    filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr="#FF4474AD", endColorstr="#FF174F88"); }
  #wb-sttl {
    position: relative; }
    #wb-sttl a {
      font-size: 1.5em;
      text-shadow: 0 1px 1px #044062; }
  #wb-glb-mn .pnl-btn {
    float: right;
    margin: 0;
    position: relative;
    z-index: 2; }
    #wb-glb-mn .pnl-btn li {
      padding: 4px 0 4px 10px;
      width: 100%; }
    #wb-glb-mn .pnl-btn a {
      color: #000;
      display: block;
      font-size: 1.7em;
      line-height: 1em;
      width: 100%; }
    #wb-glb-mn .pnl-btn span .glyphicon-th-list {
      padding-left: 10px;
      top: 0; }
  #mb-pnl #wb-srch-sub-imprt, #mb-pnl #wb-srch-sub-imprt:hover, #mb-pnl #wb-srch-sub-imprt:focus, #mb-pnl #wb-srch-sub-imprt:active, #mb-pnl .sm-pnl a, #mb-pnl .sm-pnl summary, #mb-pnl .sm-pnl summary:hover, #mb-pnl .sm-pnl summary:focus {
    color: #fff; }
  #mb-pnl {
    background: #efefef; }
    #mb-pnl header {
      background-color: #174f88; }
    #mb-pnl nav a {
      color: #000;
      text-decoration: none; }
    #mb-pnl summary:hover, #mb-pnl summary:focus {
      background: transparent; }
    #mb-pnl .modal-body {
      background: #efefef;
      padding: 0; }
    #mb-pnl .srch-pnl .form-group {
      float: left;
      margin-right: 5px;
      width: 75%; }
    #mb-pnl #wb-srch-sub-imprt {
      background: #146094;
      border-color: #146094; }
      #mb-pnl #wb-srch-sub-imprt:hover, #mb-pnl #wb-srch-sub-imprt:focus, #mb-pnl #wb-srch-sub-imprt:active {
        background-color: #3276b1;
        border-color: #285e8e; }
    #mb-pnl .lng-ofr a {
      color: #000;
      text-decoration: none; }
    #mb-pnl .sm-pnl {
      background: #146094; }
  #wb-srch {
    margin-right: 15px;
    text-align: right; }
    #wb-srch .form-group {
      display: inline-block; }
  #wb-srch-sub {
    float: right;
    margin-left: 5px; }
  #wb-bc {
    background-color: #dfdfdd;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#f0efef), to(#dfdfdd));
    background-image: -webkit-linear-gradient(#f0efef, #dfdfdd);
    background-image: linear-gradient(#f0efef, #dfdfdd);
    filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr="#FFF0EFEF", endColorstr="#FFDFDFDD"); }
  #gc-info {
    display: none; }
  [dir=rtl] #wb-srch {
    margin-left: 15px;
    text-align: left; }
  [dir=rtl] #wb-srch-sub {
    float: right;
    margin-left: 5px;
    margin-right: 0; }
  [dir=rtl] #mb-pnl .srch-pnl .form-group {
    float: right;
    margin-left: 5px;
    margin-right: auto;
    width: 75%; }
  [dir=rtl] #wmms {
    left: auto;
    right: 15px; }
  [dir=rtl] #wb-glb-mn > ul {
    text-align: left; }
  [dir=rtl] #wb-glb-mn .pnl-btn {
    float: left; }
    [dir=rtl] #wb-glb-mn .pnl-btn span .glyphicon-th-list {
      padding-left: 0;
      padding-right: 10px; } }

/* Medium view and under */
@media screen and (max-width: 1199px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Medium view and under (screen only)
 */ }

/* Large view and under */
@media screen and (max-width: 1599px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Large view and under (screen only)
 */ }

/* Extra-small view and over */
@media screen and (min-width: 480px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Extra-small view and over (screen only)
 */ }

/* Small view and over */
@media screen and (min-width: 768px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Small view and over (screen only)
 */ }

/* Medium view and over */
@media screen and (min-width: 992px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Medium view and over (screen only)
 */
  #wb-info > .container > :before, body main.container, body > header + .container, #wb-bc .container, #wb-info > .container > :before {
    background-color: #fff;
    border-left: 1px solid #ccc;
    border-right: 1px solid #ccc; }
  #wb-srch input, #wb-srch .btn {
    border-radius: 2px;
    height: 26px; }
  #wmms {
    height: 2em; }
  [dir=rtl] #wmms, [dir=rtl] #gc-bar, [dir=rtl] #canada-ca {
    float: left; }
  #wmms, #gc-bar, #wb-srch, #canada-ca, [dir=rtl] #wb-sttl {
    float: right; }
  #wb-sm .sm a:link, #gc-bar a:link, #wb-sm .sm a:visited, #gc-bar a:visited {
    text-decoration: none; }
  #wb-sm .sm a:hover, #gc-bar a:hover, #wb-sm .sm a:focus, #gc-bar a:focus {
    text-decoration: underline; }
  body {
    background-image: url("<?php echo $site_url ?>/mod/wet4/graphics/header-leaf.jpg"), url("<?php echo $site_url ?>/mod/wet4/graphics/header-bg.jpg");
    background-repeat: no-repeat, repeat-x;
    background-position: center 2.7em; }
  #gcwu-sig {
    margin-left: 15px;
    position: absolute; }
  #wmms {
    margin-right: 15px;
    margin-top: 2.3em; }
  #wb-bar {
    line-height: 1; }
  #gc-bar {
    margin: 15px 10px; }
    #gc-bar li {
      padding: 0; }
    #gc-bar a {
      border-left: 1px solid #fff;
      padding: 0 0.5em; }
    #gc-bar > li:first-child a {
      border-left: 0; }
    #gc-bar ul li:last-child a {
      border-right: 0; }
  #wb-bnr > .container {
    position: relative; }
  #wb-sttl {
    display: table-row;
    margin-top: 5px;
    margin-bottom: 5px; }
    #wb-sttl a {
      display: table-cell;
      font-size: 1.9em;
      height: 3.6em;
      text-shadow: 1px 1px 1px #333;
      vertical-align: middle; }
  #wb-srch {
    background: #146094;
    border-left: 1px solid #15527d;
    border-right: 1px solid #15527d;
    border-top: 1px solid #87aec9;
    bottom: -1px;
    padding: 11px 15px 6px;
    position: absolute;
    right: 0;
    z-index: 2; }
    #wb-srch input {
      padding: 2px 0; }
    #wb-srch .btn {
      background-color: #ccc;
      background-image: -webkit-gradient(linear, left top, left bottom, from(#f0f0f0), to(#ccc));
      background-image: -webkit-linear-gradient(#f0f0f0, #ccc);
      background-image: linear-gradient(#f0f0f0, #ccc);
      filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr="#FFF0F0F0", endColorstr="#FFCCCCCC");
      line-height: 1;
      padding: 2px 6px; }
  #wb-sec .list-group a.list-group-item.wb-navcurr, #wb-sec .list-group a.list-group-item[href]:hover, #wb-sec .list-group a.list-group-item[href]:focus {
    background: #808080;
    color: white; }
  #wb-sec {
    margin-top: 38px;
    padding-bottom: 2em; }
    #wb-sec h3 {
      border: 1px solid #ddd;
      border-bottom: 3px solid #666;
      font-size: 1em;
      margin: 0;
      padding: 15px; }
      #wb-sec h3 a {
        color: #333;
        text-decoration: none; }
    #wb-sec .list-group {
      margin-bottom: 0; }
      #wb-sec .list-group a.list-group-item {
        background: #fff;
        border-radius: 0;
        color: #555;
        margin-top: -1px;
        text-decoration: none; }
      #wb-sec .list-group .list-group .list-group-item {
        background: #e6e6e6;
        color: black;
        padding-left: 1.8em; }
  #wb-info > .container > :before {
    background: transparent;
    content: " ";
    display: block;
    height: 25px;
    margin-left: -15px;
    margin-right: -15px; }
  #gc-info {
    background-color: #000;
    margin-top: 10px; }
    #gc-info ul {
      margin: 0; }
    #gc-info li {
      line-height: normal;
      margin: 22px 0 21px 40px; }
      #gc-info li:first-child {
        margin-left: 0; }
    #gc-info a {
      color: #fff; }
      #gc-info a span {
        font-weight: 700;
        text-transform: uppercase; }
        #gc-info a span:after {
          content: "\a";
          white-space: pre; }
  #canada-ca {
    margin: 1em 0 !important;
    padding-right: 0; }
    #canada-ca a {
      border-left: 1px solid #666;
      display: inline-block;
      font-size: 160%;
      padding-left: 44px;
      vertical-align: middle; }
  [dir=rtl] #wmms {
    margin-left: 15px; }
  [dir=rtl] #gcwu-sig {
    margin-right: 15px; }
  [dir=rtl] #gc-bar a {
    border-left: 0;
    border-right: 1px solid #fff; }
  [dir=rtl] #gc-bar > :first-child a {
    border-right: 0; }
  [dir=rtl] #gc-bar ul {
    padding: 0; }
    [dir=rtl] #gc-bar ul li a {
      border-right: 1px solid #fff; }
  [dir=rtl] #wb-srch {
    left: 0;
    right: auto; }
  [dir=rtl] #gc-info ul {
    padding-right: 0; }
  [dir=rtl] #gc-info li {
    margin: 22px 40px 21px 0; }
    [dir=rtl] #gc-info li:first-child {
      margin-right: 0; }
  [dir=rtl] #canada-ca {
    padding-left: 5px;
    padding-right: 0; }
    [dir=rtl] #canada-ca a {
      border-left: 0;
      border-right: 1px solid #666;
      padding-left: 0;
      padding-right: 44px; } }

/* Large view and over */
@media screen and (min-width: 1200px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Large view and over (screen only)
 */ }

/* Extra-extra-small view */
@media screen and (max-width: 479px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Extra-extra-small view (screen only)
 */ }

/* Extra-small view */
@media screen and (min-width: 480px) and (max-width: 767px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Extra-small view (screen only)
 */ }

/* Small view */
@media screen and (min-width: 768px) and (max-width: 991px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Small view (screen only)
 */
  #wb-srch {
    margin-bottom: 15px; }
  #wb-info h3 {
    white-space: nowrap; } }

/* Medium view */
@media screen and (min-width: 992px) and (max-width: 1199px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Medium view (screen only)
 */ }

/* Large view */
@media screen and (min-width: 1200px) and (max-width: 1599px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Large view (screen only)
 */ }

/* Extra-large view */
@media screen and (min-width: 1600px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Extra-large view (screen only)
 */ }

/* Print view */
@media print {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Print view
 */
  #wb-srch, #wb-sec, #wb-info, #wb-sm, #wb-glb-mn, #gc-bar {
    display: none !important; }
  #gcwu-sig {
    height: 30px; }
  #wmms {
    height: 30px;
    position: absolute;
    right: 0;
    top: 0; }
  header .brand {
    margin-bottom: 0; }
  #wb-bc .breadcrumb {
    margin-bottom: 0;
    padding-top: 0; }
  #wb-bc a[href]:after {
    content: ""; }
  h1 {
    margin-top: 0; } }

/*
 Views
 */
/* Medium view and over */
@media screen and (min-width: 992px) {
  body {
    background-position: center 3.85em; }
  #gcwu-sig {
    height: 61px; }
  #gcwu-sig {
    margin: 2px 0;
    margin-left: 15px; }
  #wb-bar {
    line-height: 1;
    min-height: 65px; }
  #gc-bar {
    /*line-height: 61px;*/
    margin: 2px 10px; } }



/************************* Theme.css from WET 4 (just to test) ***************/


@charset "utf-8";
/*!
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 * v4.0.12 - 2015-03-23
 *
 */
/*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
/*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
/*
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 */
/*
 * HOW TO USE THIS FILE
 * Use this file to override Bootstrap variables and WET custom variables.
 * If there is a Bootstrap variable not shown here that you want to override, go to "../lib/bootstrap-sass-official/assets/stylesheets/bootstrap/variables" to view the variables that you can override. Simply copy and paste the variable and its applicable section (if applicable) from the Bootstrap file into this override file and override the variables as applicable.
 */
/*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
/*
  @title: Archive Styles
 */
#archived-bnr {
  background-color: #fd0; }
  #archived-bnr p {
    margin: 0;
    text-align: center; }
  #archived-bnr a {
    color: #000;
    display: block;
    font-weight: 700;
    padding: 0.75em 44px;
    text-decoration: none; }
    #archived-bnr a:focus, #archived-bnr a:hover {
      text-decoration: underline; }
  #archived-bnr .overlay-close {
    color: #000; }

/*
 Views
 */
/* All views */
/*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
/*
  @title: All views
 */
#wb-bc li:first-child:before, [dir=rtl] #wb-bc li:before, [dir=rtl] #wb-bc li:first-child:after {
  content: none;
  padding: 0; }

#wb-bc li:before, #wb-bc li:after {
  color: #333;
  font-family: "Glyphicons Halflings";
  font-size: 0.7em; }
#wb-bc li:before {
  content: "\e092"; }

[dir=rtl] #wb-bc li:after {
  content: "\e091";
  padding: 0 5px; }

/* All screen views */
@media screen {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: All screen views
 */
  #gcwu-sig, #wmms {
    height: 1.5em; }
  #wb-sttl a:link, #wb-sttl a:visited {
    text-decoration: none; }
  #wb-sttl a:hover, #wb-sttl a:focus {
    text-decoration: underline; }
  .wb-disable body {
    background: none !important; }
  .wb-disable header {
    background: #3f698f; }
  .wb-sl {
    background-color: #000;
    color: #fff;
    font-weight: 700; }
    .wb-sl:focus {
      color: #fff;
      text-decoration: none; }
  #wb-bar {
    background: #000;
    min-height: 2.6em; }
    #wb-bar a {
      color: #fff; }
  #gcwu-sig {
    margin: 10px 0; }
  #wb-sttl a {
    color: #fff !important; }
    #wb-sttl a span {
      line-height: normal; }
  #wb-sm .nvbar ul.menu > li > a:hover, #wb-sm .active a, #wb-sm .active summary, #wb-sm .sm, #wb-sm .sm a, #wb-sm .sm summary {
    background-color: #ccc;
    color: #000; }
  #wb-sm .nvbar ul.menu > li > a.wb-navcurr, #wb-sm .sm a.wb-navcurr, #wb-sm .sm summary.wb-navcurr, #wb-sm .sm .slflnk a.wb-navcurr {
    background: #0f315b;
    color: #fff; }
  #wb-sm {
    margin-top: -1px; }
    #wb-sm .nvbar {
      background-color: #146094;
      background-image: -webkit-gradient(linear, left top, left bottom, from(#146094), to(#23447e));
      background-image: -webkit-linear-gradient(#146094, #23447e);
      background-image: linear-gradient(#146094, #23447e);
      filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr="#FF146094", endColorstr="#FF23447E");
      border-top: 1px solid #87aec9;
      border-bottom: 4px solid #ccc; }
      #wb-sm .nvbar ul.menu {
        margin-bottom: 0; }
        #wb-sm .nvbar ul.menu > li {
          border-right: 1px solid #999;
          padding: 0; }
          #wb-sm .nvbar ul.menu > li.active {
            border-right-color: #ccc; }
    #wb-sm a, #wb-sm summary {
      color: #fff;
      display: block;
      font-weight: 700;
      padding: 0.48em 0.79em;
      text-decoration: none; }
    #wb-sm .sm {
      border-bottom: 4px solid #0f315b;
      border-radius: 0 0 3px 3px; }
      #wb-sm .sm a, #wb-sm .sm summary {
        font-weight: 400; }
        #wb-sm .sm a:link, #wb-sm .sm summary:link {
          text-decoration: none; }
        #wb-sm .sm a:hover, #wb-sm .sm a:focus, #wb-sm .sm summary:hover, #wb-sm .sm summary:focus {
          text-decoration: underline; }
      #wb-sm .sm .slflnk a {
        background: #bbb; }
  #wb-dtmd {
    float: right; }
  #wb-info {
    background: #efefef url("<?php echo $site_url ?>/mod/wet4/graphics/sft-deco.gif") repeat-x scroll center top; }
    #wb-info a:link, #wb-info a:visited {
      text-decoration: none; }
    #wb-info a:hover, #wb-info a:focus {
      text-decoration: underline; }
    #wb-info > .container {
      background: transparent url("<?php echo $site_url ?>/mod/wet4/graphics/sft-deco-leaf.gif") no-repeat top center; }
      #wb-info > .container > :before {
        background: transparent;
        content: " ";
        display: block;
        height: 25px;
        margin-left: -15px;
        margin-right: -15px; }
    #wb-info h2, #wb-info h3 {
      font-size: 120%;
      font-weight: 700; }
    #wb-info li {
      margin-bottom: 0.75em; }
  #gc-tctr {
    margin-bottom: 0;
    padding-top: 5px;
    padding-right: 0; }
    #gc-tctr > :first-child {
      border-right: 1px solid #999;
      line-height: 1.5;
      padding-right: 10px; }
  [dir=rtl] #wb-dtmd {
    float: left; }
  [dir=rtl] #wb-sec .list-group .list-group .list-group-item {
    padding-left: 15px;
    padding-right: 1.8em; }
  [dir=rtl] #gc-tctr > :first-child {
    border-left: 1px solid #999;
    border-right: 0;
    padding-left: 10px;
    padding-right: 0; } }

/* Extra-small view and under */
@media screen and (max-width: 767px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Extra-small view and under (screen only)
 */ }

/* Small view and under */
@media screen and (max-width: 991px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Small view and under (screen only)
 */
  #gcwu-sig, #gc-bar {
    display: none; }
  #wmms {
    height: 2em;
    margin-left: 15px;
    margin-top: 4px;
    position: absolute;
    top: 0.3em; }
  .wb-disable header {
    background: #ebeae9; }
  .wb-disable #wmms {
    position: static; }
  #wb-bar {
    min-height: 3em; }
  #wb-bnr {
    background-color: #174f88;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#4474ad), color-stop(#4474ad), to(#174f88));
    background-image: -webkit-linear-gradient(#4474ad, #4474ad, #174f88);
    background-image: linear-gradient(#4474ad, #4474ad, #174f88);
    filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr="#FF4474AD", endColorstr="#FF174F88"); }
  #wb-sttl {
    position: relative; }
    #wb-sttl a {
      font-size: 1.5em;
      text-shadow: 0 1px 1px #044062; }
  #wb-glb-mn .pnl-btn {
    float: right;
    margin: 0;
    position: relative;
    z-index: 2; }
    #wb-glb-mn .pnl-btn li {
      padding: 4px 0 4px 10px;
      width: 100%; }
    #wb-glb-mn .pnl-btn a {
      color: #000;
      display: block;
      font-size: 1.7em;
      line-height: 1em;
      width: 100%; }
    #wb-glb-mn .pnl-btn span .glyphicon-th-list {
      padding-left: 10px;
      top: 0; }
  #mb-pnl #wb-srch-sub-imprt, #mb-pnl #wb-srch-sub-imprt:hover, #mb-pnl #wb-srch-sub-imprt:focus, #mb-pnl #wb-srch-sub-imprt:active, #mb-pnl .sm-pnl a, #mb-pnl .sm-pnl summary, #mb-pnl .sm-pnl summary:hover, #mb-pnl .sm-pnl summary:focus {
    color: #fff; }
  #mb-pnl {
    background: #efefef; }
    #mb-pnl header {
      background-color: #174f88; }
    #mb-pnl nav a {
      color: #000;
      text-decoration: none; }
    #mb-pnl summary:hover, #mb-pnl summary:focus {
      background: transparent; }
    #mb-pnl .modal-body {
      background: #efefef;
      padding: 0; }
    #mb-pnl .srch-pnl .form-group {
      float: left;
      margin-right: 5px;
      width: 75%; }
    #mb-pnl #wb-srch-sub-imprt {
      background: #146094;
      border-color: #146094; }
      #mb-pnl #wb-srch-sub-imprt:hover, #mb-pnl #wb-srch-sub-imprt:focus, #mb-pnl #wb-srch-sub-imprt:active {
        background-color: #3276b1;
        border-color: #285e8e; }
    #mb-pnl .lng-ofr a {
      color: #000;
      text-decoration: none; }
    #mb-pnl .sm-pnl {
      background: #146094; }
  #wb-srch {
    margin-right: 15px;
    text-align: right; }
    #wb-srch .form-group {
      display: inline-block; }
  #wb-srch-sub {
    float: right;
    margin-left: 5px; }
  #wb-bc {
    background-color: #dfdfdd;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#f0efef), to(#dfdfdd));
    background-image: -webkit-linear-gradient(#f0efef, #dfdfdd);
    background-image: linear-gradient(#f0efef, #dfdfdd);
    filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr="#FFF0EFEF", endColorstr="#FFDFDFDD"); }
  #gc-info {
    display: none; }
  [dir=rtl] #wb-srch {
    margin-left: 15px;
    text-align: left; }
  [dir=rtl] #wb-srch-sub {
    float: right;
    margin-left: 5px;
    margin-right: 0; }
  [dir=rtl] #mb-pnl .srch-pnl .form-group {
    float: right;
    margin-left: 5px;
    margin-right: auto;
    width: 75%; }
  [dir=rtl] #wmms {
    left: auto;
    right: 15px; }
  [dir=rtl] #wb-glb-mn > ul {
    text-align: left; }
  [dir=rtl] #wb-glb-mn .pnl-btn {
    float: left; }
    [dir=rtl] #wb-glb-mn .pnl-btn span .glyphicon-th-list {
      padding-left: 0;
      padding-right: 10px; } }

/* Medium view and under */
@media screen and (max-width: 1199px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Medium view and under (screen only)
 */ }

/* Large view and under */
@media screen and (max-width: 1599px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Large view and under (screen only)
 */ }

/* Extra-small view and over */
@media screen and (min-width: 480px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Extra-small view and over (screen only)
 */ }

/* Small view and over */
@media screen and (min-width: 768px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Small view and over (screen only)
 */ }

/* Medium view and over */
@media screen and (min-width: 992px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Medium view and over (screen only)
 */
  #wb-info > .container > :before, body main.container, body > header + .container, #wb-bc .container, #wb-info > .container > :before {
    background-color: #fff;
    border-left: 1px solid #ccc;
    border-right: 1px solid #ccc; }
  #wb-srch input, #wb-srch .btn {
    border-radius: 2px;
    height: 26px; }
  #wmms {
    height: 2em; }
  [dir=rtl] #wmms, [dir=rtl] #gc-bar, [dir=rtl] #canada-ca {
    float: left; }
  #wmms, #gc-bar, #wb-srch, #canada-ca, [dir=rtl] #wb-sttl {
    float: right; }
  #wb-sm .sm a:link, #gc-bar a:link, #wb-sm .sm a:visited, #gc-bar a:visited {
    text-decoration: none; }
  #wb-sm .sm a:hover, #gc-bar a:hover, #wb-sm .sm a:focus, #gc-bar a:focus {
    text-decoration: underline; }
  body {
    background-image: url("<?php echo $site_url ?>/mod/wet4/graphics/header-leaf.jpg"), url("<?php echo $site_url ?>/mod/wet4/graphics/header-bg.jpg");
    background-repeat: no-repeat, repeat-x;
    background-position: center 2.7em; }
  #gcwu-sig {
    margin-left: 15px;
    position: absolute; }
  #wmms {
    margin-right: 15px;
    margin-top: 2.3em; }
  #wb-bar {
    line-height: 1; }
  #gc-bar {
    margin: 15px 10px; }
    #gc-bar li {
      padding: 0; }
    #gc-bar a {
      border-left: 1px solid #fff;
      padding: 0 0.5em; }
    #gc-bar > li:first-child a {
      border-left: 0; }
    #gc-bar ul li:last-child a {
      border-right: 0; }
  #wb-bnr > .container {
    position: relative; }
  #wb-sttl {
    display: table-row;
    margin-top: 5px;
    margin-bottom: 5px; }
    #wb-sttl a {
      display: table-cell;
      font-size: 1.9em;
      height: 3.6em;
      text-shadow: 1px 1px 1px #333;
      vertical-align: middle; }
  #wb-srch {
    background: #146094;
    border-left: 1px solid #15527d;
    border-right: 1px solid #15527d;
    border-top: 1px solid #87aec9;
    bottom: -1px;
    padding: 11px 15px 6px;
    position: absolute;
    right: 0;
    z-index: 2; }
    #wb-srch input {
      padding: 2px 0; }
    #wb-srch .btn {
      background-color: #ccc;
      background-image: -webkit-gradient(linear, left top, left bottom, from(#f0f0f0), to(#ccc));
      background-image: -webkit-linear-gradient(#f0f0f0, #ccc);
      background-image: linear-gradient(#f0f0f0, #ccc);
      filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr="#FFF0F0F0", endColorstr="#FFCCCCCC");
      line-height: 1;
      padding: 2px 6px; }
  #wb-sec .list-group a.list-group-item.wb-navcurr, #wb-sec .list-group a.list-group-item[href]:hover, #wb-sec .list-group a.list-group-item[href]:focus {
    background: #808080;
    color: white; }
  #wb-sec {
    margin-top: 38px;
    padding-bottom: 2em; }
    #wb-sec h3 {
      border: 1px solid #ddd;
      border-bottom: 3px solid #666;
      font-size: 1em;
      margin: 0;
      padding: 15px; }
      #wb-sec h3 a {
        color: #333;
        text-decoration: none; }
    #wb-sec .list-group {
      margin-bottom: 0; }
      #wb-sec .list-group a.list-group-item {
        background: #fff;
        border-radius: 0;
        color: #555;
        margin-top: -1px;
        text-decoration: none; }
      #wb-sec .list-group .list-group .list-group-item {
        background: #e6e6e6;
        color: black;
        padding-left: 1.8em; }
  #wb-info > .container > :before {
    background: transparent;
    content: " ";
    display: block;
    height: 25px;
    margin-left: -15px;
    margin-right: -15px; }
  #gc-info {
    background-color: #000;
    margin-top: 10px; }
    #gc-info ul {
      margin: 0; }
    #gc-info li {
      line-height: normal;
      margin: 22px 0 21px 40px; }
      #gc-info li:first-child {
        margin-left: 0; }
    #gc-info a {
      color: #fff; }
      #gc-info a span {
        font-weight: 700;
        text-transform: uppercase; }
        #gc-info a span:after {
          content: "\a";
          white-space: pre; }
  #canada-ca {
    margin: 1em 0 !important;
    padding-right: 0; }
    #canada-ca a {
      border-left: 1px solid #666;
      display: inline-block;
      font-size: 160%;
      padding-left: 44px;
      vertical-align: middle; }
  [dir=rtl] #wmms {
    margin-left: 15px; }
  [dir=rtl] #gcwu-sig {
    margin-right: 15px; }
  [dir=rtl] #gc-bar a {
    border-left: 0;
    border-right: 1px solid #fff; }
  [dir=rtl] #gc-bar > :first-child a {
    border-right: 0; }
  [dir=rtl] #gc-bar ul {
    padding: 0; }
    [dir=rtl] #gc-bar ul li a {
      border-right: 1px solid #fff; }
  [dir=rtl] #wb-srch {
    left: 0;
    right: auto; }
  [dir=rtl] #gc-info ul {
    padding-right: 0; }
  [dir=rtl] #gc-info li {
    margin: 22px 40px 21px 0; }
    [dir=rtl] #gc-info li:first-child {
      margin-right: 0; }
  [dir=rtl] #canada-ca {
    padding-left: 5px;
    padding-right: 0; }
    [dir=rtl] #canada-ca a {
      border-left: 0;
      border-right: 1px solid #666;
      padding-left: 0;
      padding-right: 44px; } }

/* I'm guessing i put my own styles down here? If I don't know, now i know */

.card{
    
    padding: 1%;
    border: solid 1px #efefef;
    
}



/******************** Changing Bootstraps columns ********************/
    
    .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
        padding-left: 5px;
        padding-right: 5px;
    }
    
    /****************************************/
    
    /******************** Custom Panel ********************/
    
    .panel-custom {
        margin-bottom: 10px;
        border-radius: 0;
        border-color: #a6a8ab;
    }
    
    .panel-custom .panel-heading {
        border-radius: 0;
        background: #f1f1f2;
        border-left:  4px solid #335075;
        border-bottom: 1px solid #a6a8ab;
        color: #335075;
    }
    
    .panel-custom .panel-body {
        padding-left: 5px;
        padding-right: 5px;
        padding-top: 5px;
    }
    
    /****************************************/
    
    /******************** Custom Button Styles ********************/
    
    .btn-custom {
          color: #335075;
          background-color: #f3f3f3;
          border-color: #dcdee1;
        border-radius: 0;
    }
    
    .btn-custom:hover {
        background: #cfd1d5;
    }
    
    .btn-custom-cta {
        background: #335075;
        border-radius: 0;
        border-color: #d0d2d3;
        color: white;
    }
    
    .btn-custom-cta:hover {
        background: #283e56;
        color: white;
    }
    
    /****************************************/
    
    /******************** Removing Ugly rounded Corners ********************/
    
    .form-control {
        border-radius: 0;
    }
    
    .dropdown-menu {
        border-radius: 0;
    }
    
    /****************************************/
    
    /******************** Timestamp ********************/
    
    .timeStamp {
        color: #929497;
        font-size: 13px;
    }
    
    /****************************************/
    
    /******************** Feed Content Previews ********************/
    
    .actPre {
        padding-left: 5px;
        border-left: 2px solid #335075;
    }
    
    .discPre {
        padding-left: 5px;
        border-left: 2px solid #335075;
        font-size: 13px;
    }
    
    /****************************************/
    
    /******************** Pager ********************/
    
    .pagination {
        margin: 0;
    }
    
    .pagination li {
        border-radius: 0;
    }

    .pagination li a {
        border-radius: 0;
        margin-bottom: 0;
    }
    
    /****************************************/
    
    /******************** Discussion Styles ********************/
    
    .breadcrumb {
        margin-bottom: 5px;
    }
    
    .userControlDisc {
        margin-bottom: 5px;
    }
    
    .replyInfo {
        border-radius: 0;
        background: #f1f1f2;
        border-left:  4px solid #335075;
        border-right: 1px solid #a6a8ab;
        color: #335075;
        margin: -5px;
    }
    
    #commentSection {
        background: #f1f1f2;
        border: 1px solid #a6a8ab;
    }
    
    #commentSection button {
        margin-right: 5px;
        margin-bottom: 5px;
    }
    
    #textEditor {
        background: white;
        border: 1px solid #a6a8ab;
        width: 100%;
        height: 100px;
    }
    
    textarea {
       resize: none;
    }
    
    /****************************************/


    #linkedIn {
        width: 32px;
        height: 32px;
        background: url(../assets/sprites_share.png) 0 -288px;
    }

    #twitter {
        width: 32px;
        height: 32px;
        background: url(../assets/sprites_share.png) 0 -480px;
    }   

    #gPlus {
        width: 32px;
        height: 32px;
        background: url(../assets/sprites_share.png) 0 -256px;
    }  

/*Here are my custom styles for this prototype*/
.img-tn{
    width:60px;
    height: 60px;
    float: left;
    margin: 1%;
    
}

.img-act{
    width: 60px;
    height: 60px;
    margin: 1%;
}

.img-disc{
    width:85px;
    height: 85px;
}
.add-margin{
    margin: 1%;
} 

.btn-discuss{
    margin: 2% 10%;   
}

#profileContent{
    margin-top: 10px;   
}

.profileStr{
    padding: 5px;
    margin-bottom: 10px;
}

.profileNavHolder{
    margin-bottom: 20px;   
}

.tab-content {
    padding: 5px;
    border: 1px solid #ddd;
}

.tab-pane {
    /*margin-top: -25px;*/
}

.nav-tabs {
    border-bottom: none;
}

.tags {
    font-size: 13px;
}

#userMenu p {
    display: inline;
}

#groupSearchDropdown {
    padding: 10px;
}

#groupSearchDropdown button {
    margin-top: 10px;
}


.custom-message{
    margin-bottom:0;   
}

/* Large view and over */
@media screen and (min-width: 1200px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Large view and over (screen only)
 */ }

/* Extra-extra-small view */
@media screen and (max-width: 479px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Extra-extra-small view (screen only)
 */ }

/* Extra-small view */
@media screen and (min-width: 480px) and (max-width: 767px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Extra-small view (screen only)
 */ }

/* Small view */
@media screen and (min-width: 768px) and (max-width: 991px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Small view (screen only)
 */
  #wb-srch {
    margin-bottom: 15px; }
  #wb-info h3 {
    white-space: nowrap; } }

/* Medium view */
@media screen and (min-width: 992px) and (max-width: 1199px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Medium view (screen only)
 */ }

/* Large view */
@media screen and (min-width: 1200px) and (max-width: 1599px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Large view (screen only)
 */ }

/* Extra-large view */
@media screen and (min-width: 1600px) {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Extra-large view (screen only)
 */ }

/* Print view */
@media print {
  /*
 *
 * Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
 * wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html
 *
 */
  /*
  @title: Print view
 */
  #wb-srch, #wb-sec, #wb-info, #wb-sm, #wb-glb-mn, #gc-bar {
    display: none !important; }
  #gcwu-sig {
    height: 30px; }
  #wmms {
    height: 30px;
    position: absolute;
    right: 0;
    top: 0; }
  header .brand {
    margin-bottom: 0; }
  #wb-bc .breadcrumb {
    margin-bottom: 0;
    padding-top: 0; }
  #wb-bc a[href]:after {
    content: ""; }
  h1 {
    margin-top: 0; } }


