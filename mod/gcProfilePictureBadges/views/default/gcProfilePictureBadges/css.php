<?php
/**
 * CSS gcProfilePictureBadges
 *
 * @package gcProfilePictureBadges
 *
 */
 ?>
<style>

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

    .ambBorder2 {
        border: 2px solid #f5db84;
    }
