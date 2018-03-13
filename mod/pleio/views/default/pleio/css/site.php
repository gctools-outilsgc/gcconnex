.pleio-logo {
	font-size: 0em;
	color: white;
	text-decoration: none;
	background: transparent url('/mod/pleio/_graphics/logo-grey.svg');
	background-position: center; 
	background-repeat: no-repeat;
	height: 28px;
	width: 70px;
	display: block;
}

.elgg-page-topbar {
	background: white url('/mod/pleio/_graphics/topbar.png') repeat-x bottom left;
	border-bottom: 1px solid #BDBDBD;
	height: 28px;
	z-index: 2;
	width: 100%;
	position: fixed;
	top: 0;
	left: 0;
}

.elgg-page-topbar-container {
	width: 1010px;
	margin: 0 auto;
}

.elgg-page-topbar > .elgg-inner {
	padding: 0px;
	position: relative;
	width: 990px;
	margin: 0 auto;
}

.elgg-page-topbar > .elgg-inner > .elgg-search {
	position: absolute;
	top: 4px;
	left: 130px;
	border-color: #BDBDBD;
	
}

.elgg-page-topbar > .elgg-inner > .elgg-search input[type="text"] {
	color: grey;
	border-color: #BDBDBD;
}

.elgg-page-topbar .search-advanced-type-selection > li > a {
	background: #BDBDBD;
}

#subsite-manager-login-dropdown {
	position: absolute;
    right: 0;
    top: 1px;
}

a.subsite-manager-account-dropdown-button {
	padding: 0px 6px 0 0;
	border: 1px solid #CCC;
	background: white;
	color: #CCC;
	font-weight: bold;
	line-height: 23px;
	font-size: 14px;
	height: 25px;
}

a.subsite-manager-account-dropdown-button:hover {
	background: #CCC;
	color: white;
	text-decoration: none;
}

a.subsite-manager-account-dropdown-button:after {
    content: " ▼";
    font-size: smaller;
}

.subsite-manager-account-dropdown-button .elgg-avatar {
	display: inline-block;
	width: 25px;
	vertical-align: middle;
	border-right: 1px solid #CCC;
	margin-right: 6px;
}

.subsite-manager-account-dropdown {
	width: 350px;
	padding: 15px;
	z-index: 9001;
}

.subsite-manager-account-dropdown .elgg-avatar {
	border: 1px solid #CCC;
	padding: 5px;
	float: left;
	margin-right: 10px;
}

.subsite-manager-account-dropdown-user {
	border-bottom: 1px solid #CCC;
}

.subsite-manager-account-dropdown-user > a {
	margin-left: 5px;
	line-height: 2em;
}

.subsite-manager-account-dropdown-messages {
	color: #383838;
}