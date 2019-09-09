<?php
/*
* Custom Styles for group layout and cover photo
*/
 ?>


 /* <style> /**/

.group-summary-holder{padding-bottom:10px}.group-summary-holder h1{border-bottom:none}.group-profile-image-size img{border-radius:6px!important}.group-profile-image-size{margin:-55px 10px 0 0}.group-title{border:none!important;font-size:26px}.group-title a{color:#4D4D4D!important}.group-title a:visited{color:#4D4D4D!important}.group-panel-body{padding:0 20px 20px}.group-padding-helper{padding-left:5px;padding-right:5px}.group-info-list li{padding:5px 0}.group-info-list li .info-title{font-weight:700;margin-right:8px}.elgg-list-group .elgg-item-group{padding:5px;border-bottom:1px solid #DCDCDC}.groups-profile{z-index:1}.group-cover-photo{width:100%;height:145px;position:relative;    background: -webkit-linear-gradient(left,#0d727a,#0d84b9);
    background: linear-gradient(90deg,#0d727a 0,#0d84b9);overflow:hidden}.group-place-holder-cover{width:100%;height:100px;position:relative;    background: -webkit-linear-gradient(left,#0d727a,#0d84b9);
    background: linear-gradient(90deg,#0d727a 0,#0d84b9);overflow:hidden}.group-cover-photo img{width:100%}.wet-group-tabs{margin-bottom:15px}.wet-group-tabs>li{margin-right:5px}

.au_subgroups_group_icon-small-wet4 .img-circle {
    border-radius: 2px !important;
}

.gprofile-tab-menu {
    margin-left: -15px;
}

.wet-group-tabs > li > a:focus {
    padding-bottom: 7px !important;
}

.groups-share-links a {
    padding: 8px;
}

 @media (max-width: 767px) {
   .group-cover-photo, .group-place-holder-cover {
       display:none;
   }
   .group-profile-image-size {
        margin: 10px 10px 0 0;
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
   .groups-share-links,
   .groups-info .group-invite {
        margin-right: 0;
        margin-bottom: 6px;
   }
   .groups-info .dropdown-toggle {
       margin-left: 5px !important;
       margin-bottom: 10px;
   }
}