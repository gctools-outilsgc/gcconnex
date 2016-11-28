<?php
/*
* Custom Styles for group layout and cover photo
*/
 ?>


 /* <style> /**/

 .group-summary-holder{

     padding:6px 0;
 }

 .group-summary-holder h1{
     border-bottom:none;

 }

 .group-profile-image-size img{
     width: 180% !important;

 }

 .au_subgroups_group_icon-medium-wet4{
        max-width:65%;
        margin: 0 auto;
     display: block !important;

 }

 .group-title {
   border:none !important;
   font-size: 26px;
 }

 /*** Group Cover Photo ***/

 .groups-profile{
     z-index: 1;
 }

 .group-cover-photo{
     width:100%;
     height: 185px;
     position: relative;
     margin-top: 60px;
     background-color:#047177;
     overflow:hidden;
 }

 .group-cover-photo img{
     width:100%;

 }


 @media (max-width: 767px) {
   .group-cover-photo{
       display:none;

   }
   .groups-profile{
       margin-top: 4px !important;
   }

 }

 @media (max-width: 992px) {
     .group-cover-photo{
       height: 170px;

   }
   .groups-profile{
       margin-top: 0px;
   }
      }

 /*** end of Group Cover Photo ***/
