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

     
     
/** Quick Discussion **/
     
     .quick-discuss panel-body, panel-footer{
    padding:1px;

}
.start-discussion-form{
    /*padding-right: 20px;*/

}

.quick-discuss-action-btn{
  

}
.toggle-quick-discuss{
    cursor:pointer;
    background-color: #f5f5f5;
    border-top: solid 1px #ddd;

}
#quick-discuss-panel .quick-start-collapse, #quick-discuss-panel  .quick-start-hide, #quick-discuss-panel  .alert-info{
    display:none;

}
.quick-start-discussion{
    border-bottom: 1px solid #ddd;
    margin-bottom: 5px;

}

     .quick-discuss-title{
         font-weight: bold;
         font-size: 1.3em;
     }