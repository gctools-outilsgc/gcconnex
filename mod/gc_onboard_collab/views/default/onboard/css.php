<?php

/**
 * CSS view for onboarding plugin
 *
 * css description.
 *
 * @version 1.0
 * @author Nick
 */

?>
 /* <style> /**/



 /* ========================================================================
 * bootstrap-tour - v0.10.3
 * http://bootstraptour.com
 * ========================================================================
 * Copyright 2012-2015 Ulrich Sossou
 *
 * ========================================================================
 * Licensed under the MIT License (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://opensource.org/licenses/MIT
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================================
 */

.tour-backdrop{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1100;background-color:rgba(0,0,0,0.4);}.tour-step-backdrop{position:relative;z-index:1101}.tour-step-backdrop>td{position:relative;z-index:1101}.tour-step-background{position:absolute!important;z-index:1100;background:inherit;border-radius:4px}.popover[class*=tour-]{z-index:1102}.popover[class*=tour-] .popover-navigation{padding:9px 14px;overflow:hidden}.popover[class*=tour-] .popover-navigation [data-role=end]{float:right}.popover[class*=tour-] .popover-navigation [data-role=prev],.popover[class*=tour-] .popover-navigation [data-role=next],.popover[class*=tour-] .popover-navigation [data-role=end]{cursor:pointer}.popover[class*=tour-] .popover-navigation [data-role=prev].disabled,.popover[class*=tour-] .popover-navigation [data-role=next].disabled,.popover[class*=tour-] .popover-navigation [data-role=end].disabled{cursor:default}.popover[class*=tour-].orphan{position:fixed;margin-top:0}.popover[class*=tour-].orphan .arrow{display:none}


.onboard-popover{
    border: solid 2px #46246A !important;
    border-radius: 4px !important;
}
.onboard-popover .btn-primary{
    background-color: #46246A !important;
    border-color: #46246A;

}

 .step-counter{
     display: block;

 }
 .step-counter li{
     float: left;
     margin: 5px;

 }

 .step-list-item{
     color: #ddd;
     padding:4px 10px;
     border: solid 2px #46246A;
     border-radius: 50%;
     position:relative;

 }

 .step-list-item:after{
         content: "\f00c";
     font-family: FontAwesome;
     color: #46246A;
     position:absolute;
     font-size: 24px;
     top: -2px;
     left:2px;
 }
 .step-list-item:before{
   content:"";
   position: absolute;
   left: 100%;
   top: 50%;
   width: 13px;
   height: 0;
 border:1px solid #46246A;

 }
 .step-list-item:last-child:before{
   content:"";
   position: absolute;
   left: 100%;
   top: 50%;
   width: 0px;
   height: 0;
 border:0px solid #ddd;
 }

 .current-step{
     padding: 3px 9px;
     color: #46246A !important;
     border: solid 3px #46246A;
        font-weight:bold;
 }

 .current-step:after{
         content: "";
     font-family: FontAwesome;

 }

 .current-step ~ .step-list-item{
     border: solid 1px #ddd;


 }

 .current-step ~ .step-list-item:before{
   content:"";
   position: absolute;
   left: 100%;
   top: 50%;
   width: 13px;
   height: 0;
 border:1px solid #ddd;

 }

 .current-step ~  .step-list-item:last-child:before{
   content:"";
   position: absolute;
   left: 100%;
   top: 50%;
   width: 0px;
   height: 0;
 border:0px solid #ddd;
 }

 .current-step ~ .step-list-item:after{
         content: "";
     font-family: FontAwesome;

 }

 .final-tour-step{
     min-width: 500px;
 }

 @media screen and (max-width: 500px){
    .final-tour-step{
        min-width: 95%;
    }
 }

 .profile-step-holder{
     width:80%;

 }


 /*Additional Features Box*/

 .panel-onboard{
     border: solid 2px #46246A !important;
     border-radius: 3px;
 }

 .panel-onboard .btn-primary{
     background-color: #46246A !important;
     border-color: #46246A;

 }

 .feature-image{
     width: 100%;
      min-height: 155px;

 }
 .feature-image img{

     width: 100%;

 }

 .additional-feature-holder{
     margin-top: 20px;


 }
 .additional-feature-holder .feature-col{
     min-height: 300px;
     border-right: 1px solid #ddd;

 }

 .additional-feature-holder .feature-col:last-child{
     border-right: none;

 }

 .feature-desc h4{
     margin-top:0px;
     margin-bottom: 3px;

 }
 /**The Wire Popup**/
 .wire-hide{
     visibility:hidden;
     display:none;

 }

 .wire-button-holder{
     margin: 5px;

 }
 /**Onboarding Call to Action**/

 .onboarding-cta-holder{
     border: solid 2px #9dc2d1;
     width:100%;
     background-color: #f7fbfd;
     padding:5px;
     margin:6px 0px;
     box-shadow: 1px 1px 4px #CCC;;
     border-radius: 5px;
 }

 .onboard-icon{
     color: #46246a;

 }
 .onboard-icon i{
        padding-top:6px;

 }

 .onboarding-cta-holder h4{
     color: #49646d;
     margin-top: 5px;
     margin-bottom: 1px;

 }
 .onboard-cta-buttons{
     margin-top:5px;
     margin-bottom: 0px;

 }
 .onboard-cta-buttons li{
     margin-bottom: 5px;
 }

 .onboard-cta-close{
     margin-top: 10px;

 }

 .onboard-cta-buttons .btn-primary{
     background-color: #46246A !important;
     border-color: #46246A;

 }

 /** Welcome / Screen 1 / skills**/
 .tt-dropdown-menu {
     width: 310px;
     padding: 8px 0;
     background-color: #fff;
     border: 1px solid #ccc;
     border: 1px solid rgba(0, 0, 0, 0.2);
     border-radius: 8px;
     box-shadow: 0 5px 10px rgba(0,0,0,.2);
 }
     .tt-suggest-username-wrapper {
     padding-top: 3px;
 }

 .tt-suggestion {
     padding: 3px 20px;
     font-size: 18px;
     line-height: 24px;
 }

 .tt-suggestion.tt-is-under-cursor,
 .tt-suggestion.tt-cursor { /* UPDATE: newer versions use .tt-suggestion.tt-cursor */
     color: #fff;
     background-color: #46246A;
 }

 .picked-skill {
        display:inline-block;


     height: 30px;
     overflow-x: hidden;
     -ms-overflow-x: hidden;
     overflow-y: hidden;
     -ms-overflow-y: hidden;
     text-overflow: ellipsis;
     white-space: nowrap;
     font-family: arial, sans-serif;
     background-color: #f0f0f0;
     border-bottom: 1px solid lightgrey;
     border-right: 1px solid lightgrey;
     color: #335075;
    /* color: white;
     background: #46246A;*/
     padding: 3px 10px 3px 10px;
     border-radius: 5px;
     /* box-shadow: 5px 3px 5px #888888; */
     margin-left: 0px;
     margin-right: 5px;
 }

 .pop-skill {
        display:inline-block;
     height: 30px;
     overflow-x: hidden;
     -ms-overflow-x: hidden;
     overflow-y: hidden;
     -ms-overflow-y: hidden;
     text-overflow: ellipsis;
     white-space: nowrap;


     border: 1px solid #46246A;
     color: #46246A;
    /* color: white;
     background: #46246A;*/
     padding: 3px 10px 3px 10px;
     border-radius: 10px;
     /* box-shadow: 5px 3px 5px #888888; */
     margin-left: 0px;
     margin-right: 5px;
 }

 .pop-skill:hover {

     cursor: pointer;
     background: #46246A;
     color: white;
 }

 label {
     display: block;
 }

 .picked-skill:hover{

     box-shadow: rgba(0,0,0,0.25) 0 0 6px;
     cursor: pointer;
 }

 .yourSkills {

     border: 1px solid #ccc;
     padding: 10px;
     margin: 5px;
 }

 .close-x {
     color:rgba(180,0,0,0.5);
 }

 .close-x:hover {
     color:rgba(180,0,0,0.9);
 }

 .alert-gc {
     border: 2px solid #46246A;
     background: white;
     margin: 3px;
     padding:5px;
 }

 .alert-gc-icon {
     color: #46246A;
     margin:10px;
 }

 .alert-gc-msg {
     margin-left:5px;
 }

 .alert-gc-msg h3 {
     margin-top:10px;

 }
