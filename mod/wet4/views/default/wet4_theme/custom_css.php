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


.elgg-pagination_gsa {

  position: relative;
  left:<?php echo "{$gsa_pagination}%"; ?> !important;

}

/******************** Changing Bootstraps columns ********************/

    .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
        padding-left: 5px;
        padding-right: 5px;
    }

  /****************************************/

  /******************** Widgets ********************/

.widget-area-col {
    min-height:50px;
}

  /****************************************/

.list-break{
    margin-top: 5px !important;
    padding-bottom: 5px !important;
    border-bottom: 1px solid #ddd !important;
}

.list-break:last-child{
    border-bottom:none !important;
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
     height:40px;

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



 .noWrap {
     overflow-wrap: break-word;
  word-wrap: break-word;
  white-space:inherit;
 }



 .department-test{
     width: 43%;

 }

.elgg-menu-user-menu-subMenu {
    padding: 0;
}

.elgg-menu-user-menu-subMenu .elgg-menu-content {
    display: none;
}

.visited-link li a:visited{
   color: #055959;
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
    color: #a0a0a0;
}

.icon-unsel:hover{
    color:#047177;
}

.icon-sel{
   color:#047177;
}

.icon-sel:hover{
    color: #b6b6b6;
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
          color: #335075;
          background-color: #f3f3f3;
          border-color: #dcdee1;
        border-radius: 0;
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
    /****************************************/

    /******************** Removing Ugly rounded Corners ********************/

    .form-control {
        border-radius: 0;
    }

.dropdown a:focus {
   outline: 5px auto -webkit-focus-ring-color;;
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
        margin: 0;
        left: 10%;
    }

    .pagination li {
        border-radius: 0;
    }

    .pagination li a {
        border-radius: 0;
        margin-bottom: 0;
    }

    .elgg-pagination{
        left:25% !important;

    }
    .ui-autocomplete {
        padding-left: 0;
    }

    .elgg-tag {


        padding: 2px;
        border: 1px solid #055959;
        border-radius: 8px;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        color: white;
        margin: 1px;
    }

    .elgg-tag:hover{

        background: #f5f5f5;
    }

    .elgg-tag a {

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

    p {
            margin: 0 0 5.5px;

    }

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
    border:none;
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

.quick-discuss panel-body, panel-footer{
    padding:1px;

}
.start-discussion-form{
    padding-right: 20px;

}

.quick-discuss-action-btn{
    font-size: 1.3em;

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
    /*border: 1px solid #ddd;*/
}

.tab-pane {
    /*margin-top: -25px;*/
}

.nav-tabs {
    /*border-bottom: none;*/
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


.elgg-state-success {
  background-color: #dff0d8;
  border-color: #d6e9c6;
    position:fixed;
    z-index: 100000;

   margin: 0 auto;
    width: 70%;
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
      position:fixed;
    z-index: 100000;

   margin: 0 auto;
    width: 70%;
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
    background-color: #047177;
    color: #fff;
    min-height: 45px;
    /*padding-top: 5px;*/
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

#app-brand li a{
   text-decoration: none;
    color: black;
    padding: 30px 35px;
}
.app-name{
    font-size: 1.6em;
    padding-top:5px;
    padding-left: 20px;
    background-color: #055959;
    min-height: 45px;
    max-width: 165px;
   margin-left:-5px;
}

.app-name:before{
       content: '';
    display: block;
    position: absolute;
    left: 165px;
    top: 0;
    width: 0;
    height: 0;
	border-top: 22.5px solid transparent;
	border-bottom: 22.5px solid transparent;

	border-left: 20px solid #055959;
    clear: both;
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
    background-color: #efefef;
    border: 1px solid transparent;

}

/* removing arrow on like and share bubble
.entity-menu-bubble:before{
       content: '';
    display: block;
    position: absolute;
    left: -10px;
    top: 5px;
    width: 0;
    height: 0;
	border-top: 10px solid transparent;
	border-bottom: 10px solid transparent;

	border-right:10px solid #efefef;
    clear: both;
}
*/

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
