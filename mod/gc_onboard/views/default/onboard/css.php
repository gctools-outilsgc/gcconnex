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
    border: solid 2px #567784 !important;
    border-radius: 4px !important;
}
.onboard-popover .btn-primary{
    background-color: #567784 !important;
    border-color: #567784;

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
     border: solid 2px #567784;
     border-radius: 50%;
     position:relative;
  
 }

 .step-list-item:after{
         content: "\f00c";
     font-family: FontAwesome;
     color: #567784;
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
 border:1px solid #567784;

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
     color: #567784!important;
     border: solid 3px #567784;
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

 .profile-step-holder{
     width:80%;

 }


 /*Additional Features Box*/

 .panel-onboard{
     border: solid 2px #567784 !important;
     border-radius: 1px;
 }

 .panel-onboard .btn-primary{
     background-color: #567784 !important;
     border-color: #567784;

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
     color: #047177;

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
     background-color: #567784 !important;
     border-color: #567784;

 }