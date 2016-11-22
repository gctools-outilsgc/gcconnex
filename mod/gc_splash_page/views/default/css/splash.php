<?php 
/**
  * gc_splash_page css/splash.php.php
  *
  * Css for splash page
  *
  * @version 1.0
  * @author Nick Pietrantonio    github.com/piet0024
 */

$site_url = elgg_get_site_url(); 
?>

<style>
/* SPLASH PAGE */

.splash object {
  height: auto;
  max-width: 100%; }

.splash #bg {
    background: url(<?php echo $site_url ?>/mod/wet4/graphics/splash_bg_3.gif) no-repeat center center fixed;
    -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;


  position: fixed;
    left: 0;
  top: 0;
  min-width: 100%;
min-height: 100%;}
  .splash #bg img {
    bottom: 0;
    left: 0;
    margin: auto;
    min-height: 50%;
    min-width: 50%;
    position: absolute;
    right: 0;
    top: 0; }

.splash_identifier{
    font-size: 4.0em;
    display: block;
    clear: both;
    float: right;
    margin: 12% 12% 2% 0;
    color: #055959;
}

.splash .sp-bx {
    border: solid 1px #dddddd;
    border-bottom: none;
    -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.09);
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.09);
  background-color: #f8f8f8;
  padding: 30px 30px 19px; }
  .splash .sp-bx .btn {
    -webkit-box-shadow: 0 4px #ddd;
            box-shadow: 0 4px #ddd;
    margin: 35px 0 14px;
    min-width: 110px; }
    @media (min-width: 768px) {
      .splash .sp-bx .btn {
        -webkit-box-shadow: 0 4px #ddd;
                box-shadow: 0 4px #ddd;
        margin: 35px 0 14px;
        min-width: 110px; } }
    @media (min-width: 992px) {
      .splash .sp-bx .btn {
        -webkit-box-shadow: 0 4px #ddd;
                box-shadow: 0 4px #ddd;
        margin: 35px 0 14px;
        min-width: 138px;
        padding: .5em 1.5em; } }
    @media (min-width: 1200px) {
      .splash .sp-bx .btn {
        -webkit-box-shadow: 0 4px #ddd;
                box-shadow: 0 4px #ddd;
        margin: 35px 0 14px;
        min-width: 138px;
        padding: .5em 1.5em; } }

.splash .glyphicon {
  color: #9e9e9e;
  font-size: 5px;
  top: -3px; }

.splash .sp-lk:link, .splash .sp-lk:visited {
  color: #335075;
  text-decoration: none; }

.splash .sp-lk:hover, .splash .sp-lk:active {
  color: #335075;
  text-decoration: underline; }

.splash .sp-hb {
    padding: 50px 0;
  margin: 0 auto;
  width: 300px; }
  @media (min-width: 768px) {
    .splash .sp-hb {
        padding: 50px 0;
      margin: 0 auto;
      width: 300px; } }
  @media (min-width: 992px) {
    .splash .sp-hb {
        padding: 175px 0;
      margin: 0 auto;
      width: 500px; } }
  @media (min-width: 1200px) {
    .splash .sp-hb {
        padding: 175px 0;
      margin: 0 auto;
      width: 500px; } }

.splash .sp-bx-bt {
    border: solid 1px #dddddd;
    border-top: none;
    -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.09);
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.09);
  background-color: #e1e4e7;
  padding: 30px; }
  @media (min-width: 768px) {
    .splash .sp-bx-bt {
      background-color: #e1e4e7;
      padding: 30px; } }
  @media (min-width: 992px) {
    .splash .sp-bx-bt {
      background-color: #e1e4e7;
      padding: 30px 30px 13px; } }
  @media (min-width: 1200px) {
    .splash .sp-bx-bt {
      background-color: #e1e4e7;
      padding: 30px 30px 13px; } }

      </style>