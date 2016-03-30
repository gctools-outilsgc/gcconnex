.missions-tab-bar { 
	background-color: #047177; 
	border-style: solid;
	border-color: #047177; 
	border-radius: 6px; 
	width: auto; 
	padding: 15px 10px 0px; 
	margin-bottom: 12px; 
	box-shadow: 1px 1px 5px #CCC; 
}

.missions-tab{ 
	background-color: #055959;
	font-size: 18px; 
	font-weight: bold; 
	border-style: solid;
	border-color: #055959; 
	border-radius: 6px; 
	padding: 5px;
	color: white
} 

.missions-tab a, .missions-tab a:visited {
	color: white;
}

.elgg-menu-mission-main a:visited, .mission-link-color:visited {
	color: #055959;
}

.mission-post-table {
	table-layout: fixed; 
	align: center;
} 

.mission-post-table td {
	padding-top: 4px;
	padding-bottom: 4px;
}

.mission-post-table-lefty { 
	text-align: right; 
	padding-right: 6px;
	width: 280px; 
}

.mission-post-table-righty { 
	text-align: left; 
	width: 520px; 
}

.mission-post-table-righty div { 
	width: 250px; 
}

.mission-post-table-day {
	display: inline-block;
}

.mission-post-table-day td {
	text-align: center;
	padding: 4px;
}

.mission-post-table-day h3, h4 {
	margin: 0px;
	padding: 8px 2px;
}

.mission-printer { 
	border-style: none; 
	border-width: 4px; 
	padding: 10px;
	position: relative;
} 

.mission-less {
	display: inline-block;
	border-style: solid; 
	width: 340px;
}

.mission-printer h5 { 
	display: inline; 
}

.mission-printer .elgg-button {
	margin: 4px;
	vertical-align: middle;
} 

.mission-gallery {
	vertical-align:baseline
}

.mission-gallery li {
	padding: 10px; 
	border-bottom: none; 
	vertical-align: baseline; 
}

.pagination {
	position: relative;
	left: 40%;
}

.elgg-menu {
	padding: 0px 15px; 
}

.mission-emphasis {
	display: inline;
	font-weight: bold;
}

.mission-emphasis-extra {
	display: block;
	font-weight: bold;
	font-size: 1.17em;
}

.mission-button-set {
	position: absolute;
	bottom: 4px;
	text-align: center;
	width: 94%;
}

.mission-user-card-info {
	position:absolute;
	bottom: 50px;
	text-align:center;
}

.mission-hr {
	color: #af3c43;
	border-color: #af3c43;
	background-color: #af3c43;
}

li.link-disabled a {
	pointer-events: none;
	cursor: default;
}

.mission-tab > li {
	width: 20%;
	text-align: center;
}

.mission-tab > li a {
	border-bottom-color: rgb(227,227,227); 
}

.tt-dropdown-menu {
    width: 310px;
    padding: 8px 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

.tt-suggestion {
    padding: 3px 20px;
    font-size: 18px;
    line-height: 24px;
}



#mission-graph-spinner {
	display:none;
}

/* ==========================================================
 * Spinner
 * =========================================================*/
.spinner{
     width:100px;
     height:100px;
     margin:30px auto;
     position:relative;
     -webkit-animation: rotateit 1.3s linear infinite;
     -moz-animation: rotateit 1.3s linear infinite;
     animation: rotateit 1.3s linear infinite;
}
@-webkit-keyframes rotateit {
     from {
          -webkit-transform: rotate(360deg);
     }
     to {
          -webkit-transform: rotate(0deg);
     }
}
@-moz-keyframes rotateit {
     from {
          -moz-transform: rotate(360deg);
     }
     to {
          -moz-transform: rotate(0deg);
     }
}
@keyframes rotateit {
     from {
          transform: rotate(360deg);
     }
     to {
          transform: rotate(0deg);
     }
}
/*=======================================================
 * Circles
 *======================================================*/
.spinner.circles div{
     width: 20px;
     height: 20px;
     border-radius:50%;
     background: black;
     position: absolute;
     top: 35px;
     left: 45px;
}
.spinner.circles div:nth-child(1){
     -webkit-transform: rotate(0deg) translate(0, -35px) scale(1.4);
     -moz-transform: rotate(0deg) translate(0, -35px) scale(1.4);
     transform: rotate(0deg) translate(0, -35px) scale(1.4);
}
.spinner.circles div:nth-child(2){
     -webkit-transform: rotate(45deg) translate(0, -35px) scale(1.2);
     -moz-transform: rotate(45deg) translate(0, -35px) scale(1.2);
     transform: rotate(45deg) translate(0, -35px) scale(1.2);
     opacity:0.7;
}
.spinner.circles div:nth-child(3){
     -webkit-transform: rotate(90deg) translate(0, -35px) scale(1.1);
     -moz-transform: rotate(90deg) translate(0, -35px) scale(1.1);
     transform: rotate(90deg) translate(0, -35px) scale(1.1);
     opacity:0.6;
}
.spinner.circles div:nth-child(4){
     -webkit-transform: rotate(135deg) translate(0, -35px) scale(0.9);
     -moz-transform: rotate(135deg) translate(0, -35px) scale(0.9);
     transform: rotate(135deg) translate(0, -35px) scale(0.9);
     opacity:0.5;
}
.spinner.circles div:nth-child(5){
     -webkit-transform: rotate(180deg) translate(0, -35px) scale(0.7);
     -moz-transform: rotate(180deg) translate(0, -35px) scale(0.7);
     transform: rotate(180deg) translate(0, -35px) scale(0.7);
     opacity:0.4;
}
.spinner.circles div:nth-child(6){
     -webkit-transform: rotate(225deg) translate(0, -35px) scale(0.5);
     -moz-transform: rotate(225deg) translate(0, -35px) scale(0.5);
     transform: rotate(225deg) translate(0, -35px) scale(0.5);
     opacity:0.3;
}
.spinner.circles div:nth-child(7){
     -webkit-transform: rotate(270deg) translate(0, -35px) scale(0.3);
     -moz-transform: rotate(270deg) translate(0, -35px) scale(0.3);
     transform: rotate(270deg) translate(0, -35px) scale(0.3);
     opacity:0.2;
}
.spinner.circles div:nth-child(8){
     -webkit-transform: rotate(315deg) translate(0, -35px) scale(0.1);
     -moz-transform: rotate(315deg) translate(0, -35px) scale(0.1);
     transform: rotate(315deg) translate(0, -35px) scale(0.1);
     opacity:0.1;
}