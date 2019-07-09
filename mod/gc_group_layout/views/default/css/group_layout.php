<?php
/*
* Custom Styles for group layout and cover photo
*/
 ?>


 /* <style> /**/

 .group-summary-holder{
    padding-bottom: 10px;
 }

 .group-summary-holder h1{
     border-bottom:none;

 }

 .group-profile-image-size img{
     width: 180% !important;
     border-radius: 6px !important;
 }

.group-profile-image-size {
    margin: -55px 10px 0px 0px;
}

 .group-title {
   border:none !important;
   font-size: 26px;
 }

.group-panel-body{
    padding: 0px 20px 20px 20px;
}

.group-padding-helper{
    padding-left: 5px;
    padding-right: 5px;
}

.group-info-list li {
    padding: 5px 0;
}

.group-info-list li .info-title {
    font-weight: bold;
    margin-right: 8px;
}

 /*** Group Cover Photo ***/

 .groups-profile{
     z-index: 1;
 }

 .group-cover-photo{
     width:100%;
     height: 145px;
     position: relative;
     background-color:#047177;
     overflow:hidden;
 }

 .group-place-holder-cover {
     width: 100%;
     height: 100px;
     position: relative;
     background-color:#047177;
     overflow: hidden;
 }
 .group-cover-photo img{
     width:100%;

 }
.wet-group-tabs{
    margin-bottom: 15px;
}

.wet-group-tabs li {
    margin-right: 5px;
}

 @media (max-width: 767px) {
   .group-cover-photo, .group-place-holder-cover {
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
