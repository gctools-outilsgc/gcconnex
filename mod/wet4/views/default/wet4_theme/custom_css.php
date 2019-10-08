<?php
/**
 * CSS Custom for wet4 theme
 *
 * @package wet4
 * @subpackage UI
 */


//This is a test to get images to work

$site_url = elgg_get_site_url();

$gsa_pagination = elgg_get_plugin_setting('gsa_pagination','gc_fedsearch_gsa');

?>
/* <style> /**/

/* I'm guessing i put my own styles down here? If I don't know, now i know */

.card{

    padding: 1%;
    border: solid 1px #efefef;

}

    label .error{
        margin-top:2px;
    }

label.error {
    background: #f3e9e8;
    border-left: 5px solid #d3080c;
    padding: 2px 6px;
    margin-top: 3px;
}
input.error{
    border: 1px solid #d3080c;

}
input.error:focus{
     border: 1px solid #d3080c;
    -webkit-box-shadow: inset 0 1px 1px rgba(255,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(255,0,0,.075) !important;
}
textarea.error{
    border: 1px solid #d3080c;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
}
textarea.error:focus{
     border: 1px solid #d3080c;
    -webkit-box-shadow: inset 0 1px 1px rgba(255,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075) !important;
}

.elgg-pagination_gsa {

  position: relative;
  left:<?php echo "{$gsa_pagination}%"; ?> !important;

}

.elgg-menu-owner-block {
  margin-left: 12px;
  z-index: 1;
  position: relative;
}

.questions-correct {
  color: #047177;
  width: 100%;
  text-align: center;
}

#question-answers article {
  border-left: 3px solid #047177;
}
#question-answers ul article {
  border-left: 0;
}

.question-auto  {
  background:white;
  border: 1px solid #ddd;
  border-top: none;
  padding:5px 0;
}

.question-auto p {
  margin:5px;
}

.question-auto ul li {
  padding: 5px 7px;
  border-bottom: 1px solid #ddd;
  padding-bottom: 5px;
}

.question-auto ul li:last-child {
  border-bottom: none;
}

.question-auto ul li:hover {
  background: #eee;
}

.addMoreFocus {
  display: block;
}

.btn:focus {
  box-shadow: 0 0 2px 2px #fca44c;
}

.btn a:focus {
  box-shadow: 0 0 2px 2px #fca44c;
}

.title-menu-container {
  text-align:right;
}

.title-menu-container ul {
  display: inline;
}

.two-column-menu .elgg-menu-owner-block {
  margin-bottom:15px;
  position:inherit;
}

/******************** Changing Bootstraps columns ********************/

    .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
        padding-left: 5px;
        padding-right: 5px;
    }

    .col-xs-2 {
          width: 16.6666666667% !important;
    }

  /****************************************/

  /******************** Widgets ********************/

.widget-area-col {
    min-height:50px;
}

  /****************************************/

.elgg-list-group {
    background-color: white;
    margin-top: 10px;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: 4px;
}

.panel .elgg-list-group {
    border: none;   
}

.elgg-module-aside .panel {
    border: none !important;
}

.elgg-module-aside .panel .panel-body {
    padding: 5px 0;
}

.elgg-list-group .au_subgroups_group_icon-medium-wet4 {
    margin: 10px 5px 10px 10px !important;
    display: inline-block !important;
    width: 50px !important;
    max-width: 100% !important;
}
.elgg-list-group .au_subgroups_group_icon-medium-wet4 img {
    border-radius: 2px !important;
}

  /******************** Split Inbox Styling ********************/

.message-dd-block{
  padding:8px;


}
.message-dd-holder{
  overflow-x: hidden;
  overflow-y: scroll;
max-height: 500px;
}

.message-dd-title{
  font-weight: bold;

}

.message-dd-no-results{
  width:50%;
  padding: 12px;
  margin: 0 auto;

}
.user-menu-message-dd{
  width:400px;
  min-height: 75px;
}

.no-style-link {
  text-decoration: none;
  color: #055959;
}

.no-style-link:hover {
  text-decoration: none;
  color: #047177;
}

.login-as-out {
  border: 1px solid rgba(188, 192, 198, 0);
  padding: 2px 10px;
}

.login-as-out:hover {
  border-radius:4px;
  background: #cfd1d5;
  border: 1px solid #bbbfc5;
  padding: 2px 10px;
}

.user-menu-message-dd:before{
  content: '';
  display: block;
  position: absolute;
  left: 85%;
  top: -12px;
  width: 0;
  height: 0;
  border-left: 12px solid transparent;
  border-right: 12px solid transparent;
  border-bottom: 12px solid rgba(0, 0, 0, 0.15);
  clear: both;
}

.user-menu-message-dd:after{
      content: '';
      display: block;
      position: absolute;
      left: 85%;
      top: -10px;
      width: 0;
      height: 0;
      border-left: 12px solid transparent;
      border-right: 12px solid transparent;
      border-bottom: 12px solid #fff;
      clear: both;

}

.notif-dd-position{
  left:auto;
  top:30px;
  right:0;
}
.message-dd-position{
  left:auto;
  top:30px;
  right:0;

}

.focus_dd_link{
  float:right;
  position: absolute;
  left: 50%;
  display:none;
}

/****************************************/

/*Place Holder color in user profile fields*/
   #editProfile .form-control::-moz-placeholder {
    color: #bbb !important;
    opacity: 1; }
   #editProfile .form-control:-ms-input-placeholder {
    color: #bbb !important; }
 #editProfile .form-control::-webkit-input-placeholder {
    color: #bbb !important; }

 .gcconnex-profile-name button:last-child{
     border: solid 1px #055959;

 }



    /******************** user menu ********************/

    .sr_menu_item {
      padding: 0 !important;
    }

    .dropdown .elgg-menu {
        padding: 0;
    }

    .subMenu .dropdownToggle {
        display: none;
    }

    .notif-ul{

     margin: 0px;
    }

    .bell-subbed .icon-unsel{
      color:#047177 !important;

    }

    .notif-badge {
      display: inline-block;
      margin-left: -1px;
      min-width: 10px;
      padding: 2px 5px;
      font-size: 12px;
      font-weight: bold;
      color: #fff;
      line-height: 1;
      vertical-align: top;
      white-space: nowrap;
      text-align: center;
      background-color: #d00;
      border-radius: 10px;

    }

    .notif-badge.um-badge {
        position:absolute;
        min-height:14px;
        min-width:14px;
        right:5px;
    }

    .init-badge {
        display: inline-block;
        width: 35px;
        height: 35px;
        padding: 8px 0px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        /* line-height: 1; */
        vertical-align: baseline;
        white-space: nowrap;
        text-align: center;
        background-color: #055959;
        border-radius: 25px;
        margin-right: 7px;
    }

    .userMenuAvatar {

        margin-bottom: -14px;
    }

    .user-menu{
      min-width: 400px;
    }

    .user-menu:after{
       content: '';
       display: block;
       position: absolute;
       left: 85%;
       top: -10px;
       width: 0;
       height: 0;
       border-left: 12px solid transparent;
       border-right: 12px solid transparent;
       border-bottom: 12px solid #fff;
       clear: both;
     }
     .user-menu:before{
       content: '';
       display: block;
       position: absolute;
       left: 85%;
       top: -12px;
       width: 0;
       height: 0;
       border-left: 12px solid transparent;
       border-right: 12px solid transparent;
       border-bottom: 12px solid rgba(0, 0, 0, 0.15) ;
       clear: both;
     }

     .elgg-menu-user-menu-default {
        margin-right: -35px;
        margin-bottom: 15px;
    }

    @media (max-width: 480px){
        .elgg-menu-user-menu-default {
            margin-right: -20px;
        }
    }

/****************************************/

/******************** Avatar ********************/

/** Sizing the Images to make medium images slightly smaller. They scale with the responsive class so it's all good **/
 .elgg-avatar-medium-wet4{
     max-width:65%;
     margin: 0 auto;
     display: block !important;

 }

 .elgg-avatar-wet4-sf{
        width:37%;

 }
 .medium-avatar-plus{
    margin: 0;
    width: 110%;

 }


 .elgg-module-aside .elgg-avatar {
     width:40px;
     height:inherit;

 }


 .pro-avatar {
     height:auto !important;
     width: 100% !important;
 }

 .pro-avatar img {
     margin: 0 auto;
 }

 .gcProfileBadge {

      width:25%;
      position:absolute;
      left: 5%;
 }

 .gcInitBadge {
         position: absolute;
          margin-left: auto;
          margin-right: auto;
          left:0;
          right:0;
          width:80%;
          bottom:-10%;

 }

 .elgg-avatar > .elgg-icon-hover-menu  {
     z-index: 1000;
 }

 elgg-menu-item-profile-card .gcInitBadge {
     left:-15%;
 }

     .gcProfileBadge-lower {
          position: absolute;
          margin-left: auto;
          margin-right: auto;
          left: 0;
          bottom: -16%;
          right: 0;
          pointer-events: none;
     }

     .ambBorder1 {
        border: 2px solid #005456;
     }

     .ambBorder2 {
         border: 2px solid #f5db84;
     }



/****************************************/

    #file_tools_list_files .ui-draggable, .file-tools-file.ui-draggable {
        background: none;
    }

.user-z-index{
    z-index: 10;

}



 .thCheck {

     width: 25px;
 }

 .thCheck span {

     display: none;
 }

 .river-group-link{
     font-size: 18px;
     padding-bottom: 4px;
     border-bottom: 1px solid #ddd;
 }
 .river-user-heading{
          padding-bottom: 4px;
     border-bottom: 1px solid #ddd;

 }

.elgg-river-image-block {
    position: relative;
}

 .elgg-river-image-block .elgg-river-image {
  float: left;
  margin-right: 8px;
}

.river-group-object .river-group-avatar {
  margin: -25px 12px 12px 12px !important;
  background-color: white;
}

.river-group-avatar .au_subgroups_group_icon-medium-wet4 {
    margin: 0 !important;
    display: inline-block !important;
    width: 65px !important;
    max-width: 100% !important;
}

.river-group-avatar .au_subgroups_group_icon-medium-wet4 img {
    border-radius: 0 !important;
}

.elgg-menu-river {
  float: none !important;
  margin-left: 0 !important;
  padding-left: 0 !important;
  height: 25px;
  margin-top: 10px;
}


.elgg-menu-river > li {
  margin-left: 0 !important;
  margin-right: 10px;
}

.elgg-menu-river > li > a .elgg-icon {
  color: #aaa;
  font-size: 22px;
  margin: 0 auto;
}

.elgg-list-river {
  border-top: none !important;
}

.elgg-list-river > li {
  border: none !important;
}

.elgg-river-attachments, .elgg-river-message, .elgg-river-content { 
  border-left: none !important;
  padding-left: 0px !important;
}

.elgg-river-responses .elgg-item-object-comment {
  position: relative;
  margin: 35px 0 0 0;
  border: none !important;
  padding: 8px 10px !important;
  margin-top: 14px;
}

.elgg-river-responses .elgg-output {
  background-color: #f8f9fa !important;
  border-radius: 8px;
  padding: 8px;
  margin-top: 5px;
}

.elgg-river-responses .elgg-body .elgg-output {
  margin-top: 5px !important;
}
 .noWrap {
     overflow-wrap: break-word;
  word-wrap: break-word;
  white-space:inherit;
 }

 .elgg-river-timestamp {
    color: #666;
    font-size: 85%;
    font-style: italic;
    line-height: 1.2em;
    display: inline-block;
}

.river-ribbon {
    position: absolute;
    right: -8px;
    background-color: #0d84b9;
    color: white;
    font-size: 13px;
    padding: 2px 6px;
    border-radius: 4px 0 0 4px;
}

.river-ribbon:after {
    position: absolute;
    content: '';
    top: 100%;
    background-color: transparent!important;
    left: auto;
    right: 0;
    border-style: solid;
    border-width: 8px 8px 0 0;
    border-color: transparent;
    border-top-color: #116084;
    width: 0;
    height: 0;
}

.elgg-avatar-small-wet4 > a > img {
    width: 45px !important;
    height: 45px !important;
    border-radius: 50% !important;
    background-clip: border;
    background-size: 45px;
}

.elgg-river-message {
    margin: 12px 0;
}

.elgg-river-file-attachment{
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    display: flex;
}
.elgg-river-file-attachment .river-file-title{
    font-weight: bold;
    margin-bottom: 5px;
}

.elgg-river-summary {
    padding-right: 45px;
}

 .department-test{
     width: 43%;
 }

.d-flex{
    display: flex!important;
}

.title-button-combo {
    align-items: center!important;
    padding-bottom: 2px;
    margin-bottom: 12px;
}
.title-button-combo h2 {
    margin-top: 16px;
}

.title-action-button {
    margin-left: auto!important;
    margin-top: 12px;
}
.title-action-button ul {
    padding-right: 0 !important;
}
.title-action-button ul li {
    padding-right: 0 !important;
}

.wet-image-block-body{
    margin-left: 8px;
    width: 100%;
}
.justify-content-center {
    justify-content: center!important;
}

.visited-link li a:visited{
   color: #137991;
}

.btn-primary:visited{
    color:#FFF;
}

#file-tools-folder-tree {

    padding-top:5px;
}

.elgg-gallery li {
        border: 0px;
    }

.icon-unsel{
    color: #919191;
}

.icon-unsel:hover{
    color:#047177;
}

.icon-sel{
   color:#047177;
}

.icon-sel:hover{
    color: #919191;
}

    .unread-custom span {
            color: #055959;
        font-weight: bold;
    }

    .message:hover {
       background: #F5F5F5;

    }

        .message:hover span {
            text-decoration: underline;
        }


        .panel-heading h2 {

            border-bottom: none;
        }

        .elgg-module-widget {
            overflow: hidden;

        }

        .summary-title a {
            font-size: 22px;
        }
        .summary-title{
            font-weight: normal;
            border:none;
            margin: 0 0 5px 0 !important;
            padding: 0 !important;
            display: inline-block;
        }


    .table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
        padding: 0;
    }

    .data-table-list-item input[type="checkbox"] {

        /*margin-top: 15px;*/
        margin-right: 5px;
        margin-left: 5px;
    }

    th input[type="checkbox"] {

        /*margin-top: 15px;*/
        margin-right: 5px;
        margin-left: 5px;
    }

    table.inboxTable .unread-custom {
        background-color: #f4f4f4;
        margin: 10px 0;
    }

    table.inboxTable .unread-custom:hover {
        background-color: #efefef;
    }

    table.inboxTable .read:hover {
        background-color: #efefef;
    }

/*This is where the elgg icons get loaded!*/
<?php echo elgg_view('css/elements/icons - Copy', $vars); ?>


.profile-info-head {
    margin: 5px 0;

}

    /****************************************/

    /******************** Custom Button Styles ********************/

    .btn-custom {
          color: #137991;
          background-color: white;
          border-color: #137991;
        border-radius: 5px;
    }

    .btn-custom a {
        color: #335075;
        text-decoration: none;
    }

    .btn-custom:hover {
        background: #cfd1d5;
    }

    .btn-custom:focus {
        background: #cfd1d5;
        border-color: lightblue;
    }

    .btn-custom-cta {
        background: #055959;
        border-radius: 0;
        border-color: #d0d2d3;
        color: white;
    }

    .btn-custom-cta:hover {
        background: #047177;
        color: white;
    }

    .btn-endorse {
          color: #335075;
          background-color: #efefef;
        border: 1px solid #dcdee1;

        border-radius: 0;
    }

    /**Login Page**/

    .login-engage-message{
        font-size: 1.2em;
        margin: 5px;
        margin-top:15px;
        margin-bottom: 15px;

    }

    .login-engage-list{
        list-style:none;
        margin: 5px 5px 15px 5px;
        font-size: 1em;
    }

    .login-engage-list li{
        margin: 30px 10px;
    }

    .login-engage-list i{
        color: #047177;
        padding-top: 2px;
    }


    .login-big-num{
        display:block;
        font-size: 1.4em;

    }

    .login-engage-bg{
        background-image: url("<?php echo $site_url.'mod/wet4/graphics/gcconnex_icon_transp.png'?>");
        background-repeat: no-repeat;
        background-size:contain;
        background-position: center center;
    }

    .login-stats-child:nth-child(2){
        border-right: solid 1px #ddd;
        border-left: solid 1px #ddd;

    }

    .elgg-form .form-control {
        margin-bottom: 20px;
    }

.dropdown a:focus {
   outline: 5px auto -webkit-focus-ring-color;
    outline: 1px dotted;
    border-radius: 2px;
}

    .dropdown-menu {
        border-radius: 0;
    }

    /****************************************/

    /******************** Timestamp ********************/

    .timeStamp {
        color: #606060;
        font-size: 16px;
    }

    /****************************************/

    /******************** Feed Content Previews ********************/

    .actPre {
        padding-left: 5px;
        border-left: 2px solid #055959;
    }

    .discPre {
        padding-left: 5px;
        border-left: 2px solid #055959;
        font-size: 13px;
    }

    /****************************************/

    /******************** Pager ********************/

    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: .35rem;
    }

    .elgg-pagination{
        left: 0 !important;
    }
    .ui-autocomplete {
        padding-left: 0;
    }

    .elgg-tag {
        padding: 3px;
        border: 1px solid #CAD7DC;
        color: white;
        margin: 1px 8px 1px 1px;
        background-color: #EBFAFF;
        position: relative;
    }
    .elgg-tag:hover{

        background: #f5f5f5;
    }

    .elgg-tag a {
        color: #707070;
        text-decoration: none;
    }

    /****************************************/

    /******************** Discussion Styles ********************/

    .breadcrumb {
        margin-bottom: 5px;
    }

    .elgg-form-group-operators-add fieldset {
        width: 100%;
    }

    .userControlDisc {
        margin-bottom: 5px;
    }

    .replyInfo {
        border-radius: 0;
        background: #f1f1f2;
        border-left:  4px solid #055959;
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
    .ideaPoints {
        font-size: 1.25em;
    }

    #linkedIn {
        width: 32px;
        height: 32px;
        background: url(<?php echo $site_url ?>/mod/wet4/graphics/sprites_share.png) 0 -288px;
    }

    #twitter {
        width: 32px;
        height: 32px;
        background: url(<?php echo $site_url ?>/mod/wet4/graphics/sprites_share.png) 0 -480px;
    }

    #gPlus {
        width: 32px;
        height: 32px;
        background: url(<?php echo $site_url ?>/mod/wet4/graphics/sprites_share.png) 0 -256px;
    }

/*Here are my custom styles for this prototype*/
#thewire-tools-reshare-wrapper-wet4 {
    max-width: 600px;
}

.elgg-menu-hz .removeMe {
    display: none;
}
.list-inline .removeMe {
    display: none;
}


/*****Custom index classes***/

.col-md-8 .custom-index-panel:first-of-type{
    background:transparent;
    border:none !important;
    box-shadow:none;

}
.col-md-8 .custom-index-panel:first-of-type .panel-heading{
    background:transparent;
    border:none;
    box-shadow:none;

}

.elgg-state-draggable .elgg-widget-handle{
    cursor:move;
    border:none;
}

.elgg-button-action{
    cursor:pointer;

}

.elgg-module-widget .elgg-menu-widget .elgg-menu-item-settings, .elgg-module-widget .elgg-menu-widget .elgg-menu-item-delete, .elgg-module-widget .elgg-menu-widget .elgg-menu-item-collapse{
    display:inline-block;

}

.elgg-state-unavailable .btn{
    background-color: #F2DEDE;
    border: 1px solid #843534;

}

.wet-widget-menu li{
    padding: 2px 6px 0 0;

}

.elgg-widget-placeholder{
    border: dashed 2px #DDDDDD;

}

.elgg-widget-content ul li .panel-river{
    border:none;
    box-shadow:none;
    -webkit-box-shadow:none;
}

.wet-river-album{
    margin: 0 !important;

}


#albums .elgg-item-object-album {

    display:inline-block;

    margin: 5px;
    clear:both;

}
#widget_manager_widgets_select .panel-heading{
    position: absolute;
    z-index: 44444;
    width: 91%;
}

#widget_manager_widgets_select .panel-body{
   margin-top:70px;
}

.multi-widget-count{
    -webkit-box-shadow:none;
    box-shadow:none;
    height:1em;
    color:#333333;
    margin:10px 0 0 0;
    text-shadow:none;
    border-radius:0px;
    padding:10px;
    background-color: #fff;
}

.elgg-layout-one-column #widgets-add-panel{
    margin-top: -15px;
        z-index: 1;

}

.min-height-cs{
    min-height: 15px;

}

.col-md-4 .panel ul li .panel-river{
border:none;
    box-shadow:none;
    -webkit-box-shadow:none;
}

.elgg-foot{
    margin-bottom: 5px;

}
    .newsfeed-filter-gear {
        font-size: 1.75em !important;
        margin-top: 3px;
    }

    .newsfeed-filter {
        width:90%;
        max-width: 500px;
        margin-top:10px;
    }

    .newsfeed-filter:after{
       content: '';
    display: block;
    position: absolute;
    right:2%;
    top: -12px;
    width: 0;
    height: 0;
	border-left: 12px solid transparent;
	border-right: 12px solid transparent;

	border-bottom: 12px solid #fff;
    clear: both;
}

.newsfeed-filter:before{
       content: '';
    display: block;
    position: absolute;
    right: 2%;
    top: -14px;
    width: 0;
    height: 0;
	border-left: 12px solid transparent;
	border-right: 12px solid transparent;

	border-bottom: 12px solid rgba(0, 0, 0, 0.15) ;
    clear: both;
}

.act-filter {
  margin: 0;
}

.act-filter:after{
   content: '';
   display: block;
   position: absolute;
   right:3%;
   top: -12px;
   width: 0;
   height: 0;
   border-left: 12px solid transparent;
   border-right: 12px solid transparent;
   border-bottom: 12px solid #fff;
   clear: both;
}

.act-filter:before{
   content: '';
   display: block;
   position: absolute;
   right: 3%;
   top: -14px;
   width: 0;
   height: 0;
   border-left: 12px solid transparent;
   border-right: 12px solid transparent;
   border-bottom: 12px solid rgba(0, 0, 0, 0.15) ;
   clear: both;
}

    .newsfeed-filter-gear {
        font-size: 1.75em !important;
        margin-top: 3px;
    }

    .newsfeed-filter {
        width:90%;
        max-width: 500px;
        margin-top:10px;
    }

    .newsfeed-filter:after{
       content: '';
    display: block;
    position: absolute;
    right:4%;
    top: -12px;
    width: 0;
    height: 0;
	border-left: 12px solid transparent;
	border-right: 12px solid transparent;

	border-bottom: 12px solid #fff;
    clear: both;
}
.newsfeed-filter:before{
       content: '';
    display: block;
    position: absolute;
    right: 4%;
    top: -14px;
    width: 0;
    height: 0;
	border-left: 12px solid transparent;
	border-right: 12px solid transparent;

	border-bottom: 12px solid rgba(0, 0, 0, 0.15) ;
    clear: both;
}


/******Padding Classes********/

.pad-lft-0 {
    padding-left: 0;
}

.list-inline .pad-rght-xs {
    padding-right: 5px;
}

.list-inline .pad-lft-0 {
    padding-left: 0;
}


/* Red Flag */
.red {
    background: red;
}

.replyContainer {
    max-width: 510px;

}

.thewire-characters-remaining {
    background: none;
}

.new-wire-list-object, .thewire-form {
    padding: 15px;
    border-bottom: 1px solid #DCDCDC;
}

.wire-share-container, .elgg-river-body .new-wire-reshare {
    width: 100%;
    margin-top: 10px;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    display: block;
}
a.wire-share-container:visited {
    color: #606060 !important;
}
.wire-share-container .elgg-avatar, .elgg-river-body .new-wire-reshare .elgg-avatar {
    width: 40px !important;
    height: 40px !important;
}
.wire-share-container .elgg-subtext, .elgg-river-body .new-wire-reshare {
    flex-shrink: 8;
}
.wire-share-container .wire-reshare-title, .elgg-river-body .new-wire-reshare .wire-reshare-title {
    font-weight: bold;
    color: #137991;
}


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


.newsfeed-button{
    width: 50%;
    left: 25%;
    position: relative;
    margin-top:8px;
}
.tab-content {
    padding: 5px;
}

.tags {
    font-size: 13px;
}

    .gsa-radio-filter li{
        float: left !important;
        padding: 8px;
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

.group-tab-menu-search-box{
    width:65% !important;
    margin-right: 3px;
}

.group-tab-menu-search-icon{
    color: #055959;
    padding-top: 2.5%;
}

.search-dropdown{
    padding:5px;
}

.gsa-filter-text{
    margin:8px;
    font-weight:bold;
}

.gsa-search-title{
    font-size:1.3em;
}
.gallery-margin li{
    margin:5px;
    border:none;
}

.removeMe {
    display: none;
}

.wet-ajax-loader{
    width: 31px;
    margin: 0 auto;
    margin-top: 20px;
    margin-bottom:20px;
}

.group-search-button{
    color: #055959;
}

.file-tools-file {
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}
.file-tools-file .summary-title {
    margin-bottom: 0px !important;
}
.file-tools-file .summary-title a {
    font-size: 18px !important;
}

/*Color box - Nick */

/*
    User Style:
    Change the following styles to modify the appearance of Colorbox.  They are
    ordered & tabbed in a way that represents the nesting of the generated HTML.
*/
#cboxOverlay{background:#efefef;}
#colorbox{outline:0;}
    #cboxTopLeft{width:25px; height:25px; background:none}
    #cboxTopCenter{height:25px; background:none;}
    #cboxTopRight{width:25px; height:25px; background:none;}
    #cboxBottomLeft{width:25px; height:25px; background:none;}
    #cboxBottomCenter{height:25px; background:none;}
    #cboxBottomRight{width:25px; height:25px; background:none;}
    #cboxMiddleLeft{width:25px; background:none;}
    #cboxMiddleRight{width:25px; background:none;}
    #cboxContent{background:#fff; overflow:hidden; border: solid 2px #ddd;
                         -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);

    }
        .cboxIframe{background:#fff;}
        #cboxError{padding:50px; border:1px solid #ccc;}
        #cboxLoadedContent{margin-bottom:20px; padding: 35px;}
        #cboxTitle{position:absolute; bottom:0px; left:0; text-align:center; width:100%; color:#999;}
        #cboxCurrent{position:absolute; bottom:0px; left:100px; color:#999;}
        #cboxLoadingOverlay{background:#fff url(<?php echo $site_url.'vendors/jquery/colorbox/theme/images/loading.gif';?>) no-repeat center center;}

        /* these elements are buttons, and may need to have additional styles reset to avoid unwanted base styles */
        #cboxPrevious, #cboxNext, #cboxSlideshow, #cboxClose {border:0; padding:0; margin:0; overflow:visible; width:auto; background:none; }

        /* avoid outlines on :active (mouseclick), but preserve outlines on :focus (tabbed navigating) */
        #cboxPrevious:active, #cboxNext:active, #cboxSlideshow:active, #cboxClose:active {outline:0;}

        #cboxSlideshow{position:absolute; bottom:0px; right:42px; color:#444;}
        #cboxPrevious{position:absolute; bottom:0px; left:0; color:#444;}
        #cboxNext{position:absolute; bottom:0px; left:63px; color:#444;}
        #cboxClose{position:absolute; bottom:100%; height: 25px; top:8px; right:20px; display:block; color:#444;}

/*** Messages ***/

.unread-custom{
    background-color: #F5F5F5;
    margin-bottom: 5px;
}
.unread-custom a{
    color: #055959;
    font-weight: bold;
}

.ui-autocomplete{
    background-color: white;
    max-width:400px;
    max-height: 450px;
    z-index:99999;
    overflow-y: scroll;
    border: 1px solid black;
     content: " ";
  display: block;
  list-style: none;
  clear: both;
}

.ui-autocomplete:hover{
    cursor: pointer;
}

.ui-autocomplete .ui-menu-item a:hover{
    color: #047177 !important;
}
.elgg-menu-hover{
    z-index: 1000;
    background-color:white;
    padding: 0;
    border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.15);
  -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  -webkit-background-clip: padding-box;
          background-clip: padding-box;
}

.elgg-menu-hover:before {
        content: '';
    display: block;
    position: absolute;
    left: 5%;
    top: -12px;
    width: 0;
    height: 0;
    border-left: 12px solid transparent;
    border-right: 12px solid transparent;
    border-bottom: 12px solid rgba(0, 0, 0, 0.15);
    clear: both;

}

    .elgg-menu-hover:after {
            content: '';
    display: block;
    position: absolute;
    left: 5%;
    top: -10px;
    width: 0;
    height: 0;
    border-left: 12px solid transparent;
    border-right: 12px solid transparent;
    border-bottom: 12px solid #fff;
    clear: both;
    }


.messages-chkbx{
    float:left;
    width:3%;
}

.messages-owner{
    width:15%;
    margin-right:3%;
}

.river-margin li{
    margin:5px;
}

/*** more messages stuff ;3****/

.elgg-message {
  padding: 15px;
  margin-bottom: 23px;
  min-width: 350px;
  box-shadow: 0 0 5px rgba(0,0,0,.15);
  border: 1px solid transparent;
  border-radius: 4px; }
  .elgg-message h4 {
    margin-top: 0;
    color: inherit; }
  .elgg-message .alert-link {
    font-weight: bold; }
  .elgg-message > p,
  .elgg-message > ul {
    margin-bottom: 0; }
  .elgg-message > p + p {
    margin-top: 5px; }

.elgg-message > :first-child{
     margin-left: 1.2em;
    margin-top: auto;
}

.elgg-message > :first-child:before{
    display: inline-block;
    font-family: "Glyphicons Halflings";
    margin-left: -1.3em;
    position: absolute;
}

.custom-message{
    position: fixed;
    z-index: 1039;
    right: 0;
    top: 0;
    padding-top: 20px;
    padding-right: 20px;
}

.elgg-state-success, .alert-success {
  background-color: #dff0d8;
  border-color: #d6e9c6;
    z-index: 100000;
   margin: 0 auto;
    width:100%;
    max-width: 350px;
    border-left: solid 5px #2b542c;
   }
  .elgg-state-success hr {
    border-top-color: #c9e2b3; }
  .aelgg-state-success .alert-link {
    color: #2b542c; }

details.elgg-state-success:before {
  color: #278400;
  content: "\e084"; }

.label-success[href]:active, .elgg-state-success, details.alert-success {
  background: #d8eeca;
  border-color: #278400; }

.elgg-state-success > :first-child:before {
  color: #278400;
  content: "\e084"; }


.elgg-state-error {
  background-color: #f2dede;
  border-color: #ebccd1;
    z-index: 100000;

   margin: 0 auto;
   width:100%;
    max-width: 350px;
    border-left: solid 5px #843534;
}
  .elgg-state-error hr {
    border-top-color: #e4b9c0; }
  .elgg-state-error .alert-link {
    color: #843534; }


.label-danger[href]:active, .elgg-state-error, details.alert-error,details.alert-danger {
  background: #f3e9e8;
  border-color: #d3080c; }

.elgg-state-error > :first-child:before {
  color: #d3080c;
  content: "\e101"; }


/** comment stuff ;) **/
.elgg-body{
    overflow:visible;
}

.edit-comment form fieldset{
    width:100%;
}

/** Photo Gallery Custom Classes**/

.panel-body-gallery {
 padding:7px;
}

/****** New Header style stuff *******/
#app-brand{
    background: #0d727a;
    background: -webkit-linear-gradient(left,#0d727a,#0d84b9);
    background: linear-gradient(90deg,#0d727a 0,#0d84b9);
    color: #fff;
    min-height: 45px;
}

#app-brand a{
   text-decoration: none;
    color: #fff;
}

.brand h1{
  border:none;
}

.brand h1 a{
    color: #055959 !important;
}

/*Styles from intranet footer*/
    footer .brand a {
      display: block;
      height: auto;
      padding-bottom: 0;
      position: relative;
      width: auto; }
      footer .brand a:after {
        bottom: 0;
        content: "";
        left: 0;
        position: absolute;
        right: 0;
        top: 0; }
    footer .brand object,
    footer .brand img {
      height: auto;
      max-height: 40px; }
	#wb-info .brand img, #wb-info .brand object {
		cursor: pointer;
	}
    footer .brand object,
    footer .brand img {
      height: auto;
      max-height: 2.500em;
	}

#mb-pnl object{
    display:none !important;
}
#app-brand li a{
   text-decoration: none;
    color:white;
}
.app-name{
    font-size: 1.6em;
    padding-top:5px;
}

@media (min-width: 992px) and (max-width: 1200px) {
      .app-name:before {
      left:155px; }
}


.tool-link{
    font-size:16px;
    padding:11px 0 0 20px;
}

.tool-link:hover{
    text-decoration: underline;
}

.tool-link-icon{
    width: 25px;
    margin:0 2px 5px 0;

}
    #friends_collections_accordian li h2 {
        background: #f5f5f5;
    border: 2px solid;
    margin: 10px 0 0;
    border-color: #ddd;
    webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.09);
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.09);
    }

    #friends_collections_accordian .friends-picker-main-wrapper {
            border: 2px solid;
            border-top: 0px solid transparent;
             border-color: #ddd;
    }

    .selected-circle {
        background: #f0f0f0;
    }

.bold-gc{
    font-weight: 800;
}


.tools-navigator{
    font-size: 1.1em;
    margin-top:10px;
}

.tools-navigator-menu{
    top:35px;
}

.tools-navigator-menu:before{
       content: '';
    display: block;
    position: absolute;
    left: 80%;
    top: -10px;
    width: 0;
    height: 0;
	border-left: 12px solid transparent;
	border-right: 12px solid transparent;
	border-bottom: 12px solid #fff;
    clear: both;
}
.tools-navigator-menu:after{
       content: '';
    display: block;
    position: absolute;
    left: 80%;
    top: -12px;
    width: 0;
    height: 0;
	border-left: 12px solid transparent;
	border-right: 12px solid transparent;

	border-bottom: 12px solid rgba(0, 0, 0, 0.15) ;
    clear: both;
}

#tools-dropdown{
    cursor: pointer;
}

.tools-dropdown-holder{
    min-width: 300px;
    color: black;
    padding: 10px;
}
.tools-navigator-menu li a{
    color:black;
}

.legend{
    margin: 15px 0;
}

figcaption{
    margin: 10px 0;
    font-weight:bold;
}


.wb-graph figure:first-child{
    width:100%;
    margin: 0 auto;

}

/****** Polls Custom stuff ******/
.polls-table th{
       font-weight: bold;
}

/******* Entity Menu Style ********/

.entity-menu-bubble{
    padding: 3px;
    border: 1px solid transparent;

}


.data-table-list-item{
    padding:10px;
    border-bottom: 1px solid #ddd;
}

.data-table-head{
    padding:10px;
}


/** Widget Stuff **/

.elgg-widget-title{
        margin:5px 0;
}

.widget-enter-selected{
    background-color: #eaebed;
}

.wet-hidden{
    display:none;
}

.pager-wet-hidden{
    display:none !important;

}
/**************Tabs for toggle language*******************/

.nav-tabs-language>li>a {
    margin-right: 2px;
    line-height: 1.42857143;
    border: 1px solid transparent;
    border-radius: 4px 4px 0 0
}

.nav-tabs-language>li>a:hover {
    border-color: #eee #eee #ddd
}

.nav-tabs-language>li.active>a,
.nav-tabs-language>li.active>a:focus,
.nav-tabs-language>li.active>a:hover {
    color: #555;
    cursor: default;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-bottom-color: transparent
}

.nav-tabs-language {
    margin-bottom: 0;
}

.nav-tabs-language > li > a:hover {
    background-color: #eee;
    text-decoration: none;
    padding-bottom: 4px;
}

.tab-content-border {
    padding: 10px;
    margin: 4px;
    margin-top: 0;
    border: 1px solid #ddd;
}

.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
    padding-bottom: 7px;
}

/*Style for Available content function*/

.change_language{
  border: solid 1px #055959;
  border-radius: 3px;
  padding:5px;
  text-align: center;
  cursor: pointer;
  margin-bottom: 5px;
}

.fake-link {
    color: blue;
    text-decoration: underline;
    cursor: pointer;
}

.indicator_summary{
  color:#6D6D6D;
  font-size: 12px
}

/*Related groups autocomplete*/
.ui-autocomplete .ui-menu-item {
  clear:both;
  overflow:auto;
}
.ui-autocomplete .ui-menu-item:hover {
  background:#eee;
}
.ui-autocomplete .ui-menu-item:focus {
  background:#eee;
}
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus {
  border:none;
}

.event-calendar-repeating-unselected {
    background-color: #fff;
  width: auto;
  color:#000;

}

.event-calendar-repeating-selected {
    background-color:#047177;
    color: #fff !important;
    width: auto;

}

.event-calendar-repeating-selected:hover {
  text-decoration: none;
  color: #000;
}

.event-calendar-repeating-unselected:hover {
    text-decoration: none;
    background-color:#047177;
    color: #fff;
}

.space_event{
  margin-right:5px;
}

.comment-container ul li {
    list-style: initial;
}

.comment-container ol li {
    list-style: decimal;
}

.full-width {
  width: 100%;
}

.community-content{
    padding-top:0
}