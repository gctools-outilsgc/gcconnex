<?php
	/**
	 * Custom Index page css extender
	 * 
	 * @package custom_index
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Fx NION 
	 * @copyright Fx NION  2008-20014
	 * @link http://fxnion.free.fr/
	 */
	 $ciw_bodywidth = elgg_get_plugin_setting("ciw_bodywidth", "custom_index_widgets");
	 if ($ciw_bodywidth == NULL){
		$ciw_bodywidth = '990px';
	 }
	 $ciw_responsive = elgg_get_plugin_setting("ciw_responsive", "custom_index_widgets");
	 $ciw_responsive_ok = ($ciw_responsive == NULL || ($ciw_responsive === "yes"));
	 
	 
?>

/* <?php echo $ciw_bodywidth;?> */
/* <?php echo $ciw_responsive;?> */

/* Sys Styles */
div{ 
 -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
 -moz-box-sizing: border-box;    /* Firefox, other Gecko */
 box-sizing: border-box;         /* Opera/IE 8+ */
}
.left { float : left;}
.rigth { float : right;}
.clear { clear: both;}
.centered{ width: 75%; margin: 0 auto;}

/* FLUID : START */
.elgg-page-default { min-width: 0px; }
.elgg-page-default .elgg-page-body > .elgg-inner { max-width: <?php echo $ciw_bodywidth;?> ; width: <?php echo $ciw_bodywidth;?> ; }
.elgg-page-default .elgg-page-header > .elgg-inner { max-width: <?php echo $ciw_bodywidth;?> ; width: <?php echo $ciw_bodywidth;?>; }
/* FLUID : END */

.col{ padding: 1.205%; margin-bottom: 1.205%;}
.col .col { margin-bottom: 0px;}
.full, .half, .onethird, .twothird, .grid1, .grid2, .grid3, .grid4, .grid5, .grid6, .grid7, .grid8, .grid9, .grid10, .grid11 { float: left; display: inline; /*margin-left: 1.205%;*/} 
.grid1, .offset1{ width: 7.229%; }
.grid2, .offset2{ width: 15.663%; }
.grid3, .offset3{ width: 24.096%; }
.onethird, .grid4, .offset4{ width: 32.53%; }
.grid5, .offset5{ width: 40.964%; }
.half, .grid6, .offset6{ width: 49.398%; }
.grid7, .offset7{ width: 57.831%; }
.twothird, .grid8, .offset8{ width: 66.265%; }
.grid9, .offset9{ width: 74.699%; }
.grid10, .offset10{ width: 83.133%; }
.grid11, .offset11{ width: 91.566%; }
.full, .grid12, .offset12{ width: 98.795%; }
.first { margin-left: 0; clear: left; }											

<?php if ($ciw_responsive_ok):?>									
/* RESPONSIVE : START */
@media only screen and (max-width: 767px) {
	
	.elgg-page-default { min-width: 0px; }
	.elgg-page-default .elgg-page-body > .elgg-inner { width: 100%; }
	.elgg-page-default .elgg-page-header > .elgg-inner { width: 100%; }
	.elgg-page-default .elgg-page-header .elgg-search-header { bottom: 66px;}
	
	.full, .half, .onethird, .twothird, .grid1, .grid2, .grid3, .grid4, .grid5, .grid6, .grid7, .grid8, .grid9, .grid10, .grid11 { width: 100%;}
}
/* RESPONSIVE : END */
<?php endif;?>

#rightcolumn_widgets, #leftcolumn_widgets, #middlecolumn_widgets{	min-height: 1px;}

