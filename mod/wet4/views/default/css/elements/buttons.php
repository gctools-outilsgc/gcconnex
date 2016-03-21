<?php
/**
 * CSS buttons
 *
 * @package Elgg.Core
 * @subpackage UI
 */
?>
/* <style> /**/

/* **************************
	BUTTONS
************************** */

/******* Boostrapy buttons from WET 4 **************/

.btn {
  display: inline-block;
  margin-bottom: 0;
  font-weight: normal;
  text-align: center;
  vertical-align: middle;
  -ms-touch-action: manipulation;
  touch-action: manipulation;
  cursor: pointer;
  background-image: none;
  border: 1px solid transparent;
  white-space: nowrap;
  padding: 6px 12px;
  font-size: 16px;
  line-height: 1.4375;
  border-radius: 4px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none; }
  .btn:focus, .btn.focus, .btn:active:focus, .btn:active.focus, .btn.active:focus, .btn.active.focus {
    outline: thin dotted;
    outline: 5px auto -webkit-focus-ring-color;
    outline-offset: -2px; }
  .btn:hover, .btn:focus, .btn.focus {
    color: #335075;
    text-decoration: none; }
  .btn:active, .btn.active {
    outline: 0;
    background-image: none;
    -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125); }
  .btn.disabled, .btn[disabled], fieldset[disabled] .btn {
    cursor: not-allowed;
    pointer-events: none;
    opacity: 0.65;
    filter: alpha(opacity=65);
    -webkit-box-shadow: none;
    box-shadow: none; }

.btn-default {
  color: #335075;
  background-color: #eaebed;
  border-color: #dcdee1; }
  .btn-default:hover, .btn-default:focus, .btn-default.focus, .btn-default:active, .btn-default.active, .open > .btn-default.dropdown-toggle {
    color: #335075;
    background-color: #cfd1d5;
    border-color: #bbbfc5; }
  .btn-default:active, .btn-default.active, .open > .btn-default.dropdown-toggle {
    background-image: none; }
  .btn-default.disabled, .btn-default.disabled:hover, .btn-default.disabled:focus, .btn-default.disabled.focus, .btn-default.disabled:active, .btn-default.disabled.active, .btn-default[disabled], .btn-default[disabled]:hover, .btn-default[disabled]:focus, .btn-default[disabled].focus, .btn-default[disabled]:active, .btn-default[disabled].active, fieldset[disabled] .btn-default, fieldset[disabled] .btn-default:hover, fieldset[disabled] .btn-default:focus, fieldset[disabled] .btn-default.focus, fieldset[disabled] .btn-default:active, fieldset[disabled] .btn-default.active {
    background-color: #eaebed;
    border-color: #dcdee1; }
  .btn-default .badge {
    color: #eaebed;
    background-color: #335075; }

.btn-primary {
  color: #fff;
  background-color: #2572b4;
  border-color: #143d5f; }
  .btn-primary:hover, .btn-primary:focus, .btn-primary.focus, .btn-primary:active, .btn-primary.active, .open > .btn-primary.dropdown-toggle {
    color: #fff;
    background-color: #1c588a;
    border-color: #091d2d; }
  .btn-primary:active, .btn-primary.active, .open > .btn-primary.dropdown-toggle {
    background-image: none; }
  .btn-primary.disabled, .btn-primary.disabled:hover, .btn-primary.disabled:focus, .btn-primary.disabled.focus, .btn-primary.disabled:active, .btn-primary.disabled.active, .btn-primary[disabled], .btn-primary[disabled]:hover, .btn-primary[disabled]:focus, .btn-primary[disabled].focus, .btn-primary[disabled]:active, .btn-primary[disabled].active, fieldset[disabled] .btn-primary, fieldset[disabled] .btn-primary:hover, fieldset[disabled] .btn-primary:focus, fieldset[disabled] .btn-primary.focus, fieldset[disabled] .btn-primary:active, fieldset[disabled] .btn-primary.active {
    background-color: #2572b4;
    border-color: #143d5f; }
  .btn-primary .badge {
    color: #2572b4;
    background-color: #fff; }

.btn-success {
  color: #fff;
  background-color: #1b6c1c;
  border-color: #071a07; }
  .btn-success:hover, .btn-success:focus, .btn-success.focus, .btn-success:active, .btn-success.active, .open > .btn-success.dropdown-toggle {
    color: #fff;
    background-color: #114311;
    border-color: black; }
  .btn-success:active, .btn-success.active, .open > .btn-success.dropdown-toggle {
    background-image: none; }
  .btn-success.disabled, .btn-success.disabled:hover, .btn-success.disabled:focus, .btn-success.disabled.focus, .btn-success.disabled:active, .btn-success.disabled.active, .btn-success[disabled], .btn-success[disabled]:hover, .btn-success[disabled]:focus, .btn-success[disabled].focus, .btn-success[disabled]:active, .btn-success[disabled].active, fieldset[disabled] .btn-success, fieldset[disabled] .btn-success:hover, fieldset[disabled] .btn-success:focus, fieldset[disabled] .btn-success.focus, fieldset[disabled] .btn-success:active, fieldset[disabled] .btn-success.active {
    background-color: #1b6c1c;
    border-color: #071a07; }
  .btn-success .badge {
    color: #1b6c1c;
    background-color: #fff; }

.btn-info {
  color: #fff;
  background-color: #4d4d4d;
  border-color: #1a1a1a; }
  .btn-info:hover, .btn-info:focus, .btn-info.focus, .btn-info:active, .btn-info.active, .open > .btn-info.dropdown-toggle {
    color: #fff;
    background-color: #343434;
    border-color: black; }
  .btn-info:active, .btn-info.active, .open > .btn-info.dropdown-toggle {
    background-image: none; }
  .btn-info.disabled, .btn-info.disabled:hover, .btn-info.disabled:focus, .btn-info.disabled.focus, .btn-info.disabled:active, .btn-info.disabled.active, .btn-info[disabled], .btn-info[disabled]:hover, .btn-info[disabled]:focus, .btn-info[disabled].focus, .btn-info[disabled]:active, .btn-info[disabled].active, fieldset[disabled] .btn-info, fieldset[disabled] .btn-info:hover, fieldset[disabled] .btn-info:focus, fieldset[disabled] .btn-info.focus, fieldset[disabled] .btn-info:active, fieldset[disabled] .btn-info.active {
    background-color: #4d4d4d;
    border-color: #1a1a1a; }
  .btn-info .badge {
    color: #4d4d4d;
    background-color: #fff; }

.btn-warning {
  color: #000;
  background-color: #f2d40d;
  border-color: #917f08; }
  .btn-warning:hover, .btn-warning:focus, .btn-warning.focus, .btn-warning:active, .btn-warning.active, .open > .btn-warning.dropdown-toggle {
    color: #000;
    background-color: #c2a90a;
    border-color: #574b05; }
  .btn-warning:active, .btn-warning.active, .open > .btn-warning.dropdown-toggle {
    background-image: none; }
  .btn-warning.disabled, .btn-warning.disabled:hover, .btn-warning.disabled:focus, .btn-warning.disabled.focus, .btn-warning.disabled:active, .btn-warning.disabled.active, .btn-warning[disabled], .btn-warning[disabled]:hover, .btn-warning[disabled]:focus, .btn-warning[disabled].focus, .btn-warning[disabled]:active, .btn-warning[disabled].active, fieldset[disabled] .btn-warning, fieldset[disabled] .btn-warning:hover, fieldset[disabled] .btn-warning:focus, fieldset[disabled] .btn-warning.focus, fieldset[disabled] .btn-warning:active, fieldset[disabled] .btn-warning.active {
    background-color: #f2d40d;
    border-color: #917f08; }
  .btn-warning .badge {
    color: #f2d40d;
    background-color: #000; }

.btn-danger {
  color: #fff;
  background-color: #bc3331;
  border-color: #6b1c1c; }
  .btn-danger:hover, .btn-danger:focus, .btn-danger.focus, .btn-danger:active, .btn-danger.active, .open > .btn-danger.dropdown-toggle {
    color: #fff;
    background-color: #942626;
    border-color: #3b0f0f; }
  .btn-danger:active, .btn-danger.active, .open > .btn-danger.dropdown-toggle {
    background-image: none; }
  .btn-danger.disabled, .btn-danger.disabled:hover, .btn-danger.disabled:focus, .btn-danger.disabled.focus, .btn-danger.disabled:active, .btn-danger.disabled.active, .btn-danger[disabled], .btn-danger[disabled]:hover, .btn-danger[disabled]:focus, .btn-danger[disabled].focus, .btn-danger[disabled]:active, .btn-danger[disabled].active, fieldset[disabled] .btn-danger, fieldset[disabled] .btn-danger:hover, fieldset[disabled] .btn-danger:focus, fieldset[disabled] .btn-danger.focus, fieldset[disabled] .btn-danger:active, fieldset[disabled] .btn-danger.active {
    background-color: #bc3331;
    border-color: #6b1c1c; }
  .btn-danger .badge {
    color: #bc3331;
    background-color: #fff; }

.btn-link {
  color: #295376;
  font-weight: normal;
  border-radius: 0; }
  .btn-link, .btn-link:active, .btn-link.active, .btn-link[disabled], fieldset[disabled] .btn-link {
    background-color: transparent;
    -webkit-box-shadow: none;
    box-shadow: none; }
  .btn-link, .btn-link:hover, .btn-link:focus, .btn-link:active {
    border-color: transparent; }
  .btn-link:hover, .btn-link:focus {
    color: #0535d2;
    text-decoration: underline;
    background-color: transparent; }
  .btn-link[disabled]:hover, .btn-link[disabled]:focus, fieldset[disabled] .btn-link:hover, fieldset[disabled] .btn-link:focus {
    color: #767676;
    text-decoration: none; }

.btn-lg, .btn-group-lg > .btn {
  padding: 10px 16px;
  font-size: 18px;
  line-height: 1.33;
  border-radius: 6px; }

.btn-sm, .btn-group-sm > .btn {
  padding: 5px 10px;
  font-size: 14px;
  line-height: 1.5;
  border-radius: 3px; }

.btn-xs, .btn-group-xs > .btn {
  padding: 1px 5px;
  font-size: 14px;
  line-height: 1.5;
  border-radius: 3px; }

.btn-block {
  display: block;
  width: 100%; }

.btn-block + .btn-block {
  margin-top: 5px; }

input[type="submit"].btn-block, input[type="reset"].btn-block, input[type="button"].btn-block {
  width: 100%; }


/****** Button Groups **********/

.btn-group, .btn-group-vertical {
  position: relative;
  display: inline-block;
  vertical-align: middle; }
  .btn-group > .btn, .btn-group-vertical > .btn {
    position: relative;
    float: left; }
    .btn-group > .btn:hover, .btn-group > .btn:focus, .btn-group > .btn:active, .btn-group > .btn.active, .btn-group-vertical > .btn:hover, .btn-group-vertical > .btn:focus, .btn-group-vertical > .btn:active, .btn-group-vertical > .btn.active {
      z-index: 2; }

.btn-group .btn + .btn, .btn-group .btn + .btn-group, .btn-group .btn-group + .btn, .btn-group .btn-group + .btn-group {
  margin-left: -1px; }

.btn-toolbar {
  margin-left: -5px; }
  .btn-toolbar:before, .btn-toolbar:after {
    content: " ";
    display: table; }
  .btn-toolbar:after {
    clear: both; }
  .btn-toolbar .btn-group, .btn-toolbar .input-group {
    float: left; }
  .btn-toolbar > .btn, .btn-toolbar > .btn-group, .btn-toolbar > .input-group {
    margin-left: 5px; }

.btn-group > .btn:not(:first-child):not(:last-child):not(.dropdown-toggle) {
  border-radius: 0; }

.btn-group > .btn:first-child {
  margin-left: 0; }
  .btn-group > .btn:first-child:not(:last-child):not(.dropdown-toggle) {
    border-bottom-right-radius: 0;
    border-top-right-radius: 0; }

.btn-group > .btn:last-child:not(:first-child), .btn-group > .dropdown-toggle:not(:first-child) {
  border-bottom-left-radius: 0;
  border-top-left-radius: 0; }

.btn-group > .btn-group {
  float: left; }

.btn-group > .btn-group:not(:first-child):not(:last-child) > .btn {
  border-radius: 0; }

.btn-group > .btn-group:first-child > .btn:last-child, .btn-group > .btn-group:first-child > .dropdown-toggle {
  border-bottom-right-radius: 0;
  border-top-right-radius: 0; }

.btn-group > .btn-group:last-child > .btn:first-child {
  border-bottom-left-radius: 0;
  border-top-left-radius: 0; }

.btn-group .dropdown-toggle:active, .btn-group.open .dropdown-toggle {
  outline: 0; }

.btn-group > .btn + .dropdown-toggle {
  padding-left: 8px;
  padding-right: 8px; }

.btn-group > .btn-lg + .dropdown-toggle, .btn-group > .btn-lg + .btn-group-lg > .btn, .btn-group-lg > .btn-group > .btn-lg + .btn {
  padding-left: 12px;
  padding-right: 12px; }

.btn-group.open .dropdown-toggle {
  -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
  box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125); }
  .btn-group.open .dropdown-toggle.btn-link {
    -webkit-box-shadow: none;
    box-shadow: none; }

.btn .caret {
  margin-left: 0; }

.btn-lg .caret, .btn-lg .btn-group-lg > .btn, .btn-group-lg > .btn-lg .btn {
  border-width: 5px 5px 0;
  border-bottom-width: 0; }

.dropup .btn-lg .caret, .dropup .btn-lg .btn-group-lg > .btn, .btn-group-lg > .dropup .btn-lg .btn {
  border-width: 0 5px 5px; }

.btn-group-vertical > .btn, .btn-group-vertical > .btn-group, .btn-group-vertical > .btn-group > .btn {
  display: block;
  float: none;
  width: 100%;
  max-width: 100%; }
.btn-group-vertical > .btn-group:before, .btn-group-vertical > .btn-group:after {
  content: " ";
  display: table; }
.btn-group-vertical > .btn-group:after {
  clear: both; }
.btn-group-vertical > .btn-group > .btn {
  float: none; }
.btn-group-vertical > .btn + .btn, .btn-group-vertical > .btn + .btn-group, .btn-group-vertical > .btn-group + .btn, .btn-group-vertical > .btn-group + .btn-group {
  margin-top: -1px;
  margin-left: 0; }

.btn-group-vertical > .btn:not(:first-child):not(:last-child) {
  border-radius: 0; }
.btn-group-vertical > .btn:first-child:not(:last-child) {
  border-top-right-radius: 4px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0; }
.btn-group-vertical > .btn:last-child:not(:first-child) {
  border-bottom-left-radius: 4px;
  border-top-right-radius: 0;
  border-top-left-radius: 0; }

.btn-group-vertical > .btn-group:not(:first-child):not(:last-child) > .btn {
  border-radius: 0; }

.btn-group-vertical > .btn-group:first-child:not(:last-child) > .btn:last-child, .btn-group-vertical > .btn-group:first-child:not(:last-child) > .dropdown-toggle {
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0; }

.btn-group-vertical > .btn-group:last-child:not(:first-child) > .btn:first-child {
  border-top-right-radius: 0;
  border-top-left-radius: 0; }

.btn-group-justified {
  display: table;
  width: 100%;
  table-layout: fixed;
  border-collapse: separate; }
  .btn-group-justified > .btn, .btn-group-justified > .btn-group {
    float: none;
    display: table-cell;
    width: 1%; }
  .btn-group-justified > .btn-group .btn {
    width: 100%; }
  .btn-group-justified > .btn-group .dropdown-menu {
    left: auto; }
