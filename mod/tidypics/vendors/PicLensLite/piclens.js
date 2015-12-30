/* PicLens Lite: version 1.3.1 (14221)
 * Copyright (c) 2008 Cooliris, Inc.  All Rights Reserved.
 * 
 * The JavaScript part of PicLens Lite (i.e., this file) is BSD licensed (see: http://lite.piclens.com/bsdlicense)
 * This launcher includes and interacts with SWFObject (MIT), BrowserDetect (BSD Compatible), and Lytebox (CC Attribution 3.0).
 * 
 * There are two versions of this JS: 
 * http://lite.piclens.com/current/piclens.js				full commented file 		(~39KB)
 * http://lite.piclens.com/current/piclens_optimized.js		lighter deployment file		(~21KB)
 */
var PicLensLite = {
	// PUBLIC API

	// PicLens Lite can be deployed in one of two ways:
	// 1) include http://lite.piclens.com/current/piclens.js in the <head> of your webpage
	// 2) download the zip file and deploy it on your own website (unzip it anywhere, and point to the JS file in the <head> of your page)
	//    see: http://lite.piclens.com/releases/current.zip
	// 
	// For example: the directory layout looks like:
	//	 lite.piclens.com/current/ contains the SWF, JS, and image files
	//					 /lytebox/ contains slideshow support for browsers w/o Flash
	// 
	// Pointing to the JS directly will configure Lite relative to that URL.
	// Alternatively, you can customize the URLs with PicLensLite.setLiteURLs
	
	// 1) Call PicLensLite.start() to launch the default feed (specified in the head)
	// 2) Call PicLensLite.start({feedUrl:'http://myWebsite.com/myFeed.rss', ...}) to launch a specific feed
	//	Option 2 supports the following named arguments:
	//		feedUrl  : String  // is the URL to the specific Media RSS feed you want to launch
	//		feedData : String  // is the Media RSS feed itself (do not use feedUrl if you want to programmatically generate & pass in the feed text)
	//		guid	 : String  // starts from the item in the feed that is tagged w/ this unique id
	//		maxScale : Number  // normally, images fill the stage; 0 -> never scale up; any other positive number S --> scale up to S times the original size of the photo (but never bigger than the stage)
	//		loadFeedInFlash : Boolean // if true, we ask Flash to load the feed, instead of AJAX (expert option)
	//		loop	 : Boolean // if true, we turn looping on by default
	//		paused	 : Boolean // if true, we start the slideshow in paused mode
	// To enable smoothing for images. a crossdomain.xml file is required at the root of your image server.
	// Lite detects this crossdomain.xml and applies smoothing automatically.
	start : function (namedArgs) {
		this.determineBrowserParams();
		clearTimeout(this.REMOVE_TIMER_ID);
		clearTimeout(this.AUTO_CLOSE_TIMER_ID);
		this.ARGS = {}; // clear out previous args

		// handle named arguments
		if (typeof namedArgs !== "undefined" && namedArgs !== null) {
			this.ARGS = namedArgs;

			// if feedUrl is specified, it launches immediately
			if (namedArgs.feedUrl) {
				this.THE_FEED_URL = namedArgs.feedUrl;
				if (this.checkForPluginAndLaunchIfPossible(namedArgs.feedUrl, namedArgs.guid)) {
					return;
				}
				if (namedArgs.loadFeedInFlash) {
					// read up on flash crossdomain.xml if you choose this option
					// Flash can only load feeds from servers hosting a crossdomain.xml
					// pass the URL as a FlashVar, and load the contents via a GET request
					this.showFlashUI("");
				} else {
					// load the contents of the URL via AJAX, and launch the Flash UI afterward....
					this.loadViaXHR(namedArgs.feedUrl);
				}
			}
			// pass in the feed XML directly through Javascript
			// use feedUrl OR feedData, but not both!
			if (typeof namedArgs.feedData !== 'undefined') {
				this.showFlashUI(namedArgs.feedData);
			}
			
		} else {
			// find the feed from the header, since none was specified
			// build list of XML feeds
			var feeds = this.indexFeeds();
			if (feeds.length !== 0) { // view the first feed, if available
				var feed = feeds[0];
				this.THE_FEED_URL = feed.url;
				if (this.checkForPluginAndLaunchIfPossible(feed.url)) {
					return;
				}
				this.loadViaXHR(feed.url);
			}
		}
	},
	// check if the slideshow is currently running
	isRunning : function () {
		return this.LITE_IS_RUNNING;
	},
	// check if the browser plug-in is installed
	hasClient : function () {
		return this.hasCooliris();
	},
	// call this before starting lite. we currently support a single custom button
	// the icon is a 24x24 PNG
	// we will perform a GET request of a provided URL (w/ the item's GUID) when the user clicks
	// http://yourwebserver.com/buttonURL?itemGUID=guidVal
	addCustomButton : function (buttonRESTUrl, buttonLabel, buttonIcon) {
		this.CUSTOM_BUTTON = {targetURL: buttonRESTUrl, labelText: buttonLabel, iconImage: buttonIcon};
	},
	// OPTIONAL: provide callbacks to be notified in certain situations. Call this BEFORE PicLensLite.start(...)
	// 	onNoPlugins():Boolean
	//		is called when the user invokes Lite but does not have PicLens / Flash installed
	// 	onExit(itemUID):void
	//		is called when the user exits from Lite
	//		we provide the item's GUID if it exists, and the item's content URL otherwise
	//		itemUID is undefined if the user exited before Lite launched, or if the user did not have Flash
	setCallbacks : function (args) {
		if (args.onNoPlugins) {
			this.ON_NO_PLUGINS = args.onNoPlugins;
		}
		if (args.onExit) {
			this.ON_EXIT = args.onExit;
		}
	},
	// OPTIONAL: customize the location of resources. Call this BEFORE PicLensLite.start(...)
	// Normally, we locate the PicLensLite files relative to the JS file 
	// To use this function, pass in an object with the following named arguments:
	// args = {
	//		lite	: other paths can be determined from this (make sure it ends in a slash)
	//		swf		: the URL of the SWF file					1
	//		button	: image allowing users to download piclens	1
	//		lbox	: where to find lytebox						1
	//		lboxcss	: the CSS file								2
	//		lboxjs	: the JS file								2
	// }
	// 1: Can be determined from args.lite
	// 2: Can be determined from args.lbox or args.lite
	setLiteURLs : function (args) {
		if (!this.LITE_URL) {
			if (args.swf) {
				this.LITE_URL = args.swf;
			} else if (args.lite) {
				this.LITE_URL = args.lite + "PicLensLite.swf";
			} // if both lite & swf aren't set, it won't work
		}
		if (!this.BUTTON_URL) {
			if (args.button) {
				this.BUTTON_URL = args.button;
			} else if (args.lite) {
				this.BUTTON_URL = args.lite + "NoFlash.jpg";
			}
		}

		var lboxUrl = "";
		if (args.lbox) {
			lboxUrl = args.lbox;
		} else if (args.lite) {
			lboxUrl = args.lite + "../lytebox/";
		}
		
		if (!this.LBOX_CSS_URL) {
			if (args.lboxcss) {
				this.LBOX_CSS_URL = args.lboxcss;
			} else if (lboxUrl != "") {
				this.LBOX_CSS_URL = lboxUrl + "lytebox.css";
			}
		}

		if (!this.LBOX_JS_URL) {
			if (args.lboxjs) {
				this.LBOX_JS_URL = args.lboxjs;
			} else if (lboxUrl != "") {
				this.LBOX_JS_URL = lboxUrl + "lytebox.js";
			}
		}
	},



	//////////////////////////////////////////////////////////////////////////////////////////////////////////
	// The PRIVATE API is below
	// DO NOT USE these functions/variables directly; they WILL change in future releases
	// Email us to request changes to the public API
	ARGS			: {},
	DEBUG_NOCLIENT	: false,	// if true, we will NEVER launch the PicLens Client (for testing Lite)
	DEBUG_NOFLASH	: false,	// if true, we will assume the user does not have Flash (for testing Lite)
	HPAD			: 60,		// horizontal padding
	VPAD			: 20,		// vertical padding
	LITE_BG_DIV		: null,		// the grey/black background overlay
	LITE_FG_DIV		: null,		// the foreground div that contains the flash component
	LITE_URL		: null,		// the location of PicLensLite.SWF
	BUTTON_URL		: null,		// image to display if the user doesn't have flash
	LBOX_CSS_URL	: null,		// where to find lytebox css/js files
	LBOX_JS_URL		: null,
	LBOX_COUNT		: 0,		// try to start lytebox, but if it doesn't exist after a few tries, give up...
	SHOW_LBOX		: false,	// if true, skip flash altogether
	OS_WIN			: false,	// OS Detect
	OS_MAC			: false,	// sadly, sometimes we have to do something different depending on our Browser/OS/Configuration
	BROWSER_FFX		: false,	// Browser Detect
	BROWSER_SAF		: false,
	BROWSER_IE		: false,
	BROWSER_IE6		: false,
	OLD_B_MARGIN	: null,
	OLD_B_OVERFLOW	: null,
	OLD_B_HEIGHT	: null,
	OLD_H_OVERFLOW	: null,
	OLD_H_HEIGHT	: null,
	THE_FEED		: "",			// the feed text
	THE_FEED_URL	: "",			// the feed url
	LITE_IS_RUNNING		: false,	// use isRunning()
	piclensIsRunning_	: false,	// maintain compatibility with the Wordpress Plugin for a few iterations...
	FLASH_ID_1		: "pllflash1",	// outer
	FLASH_ID_2		: "pllflash2",	// inner
	FLASH_VER		: null,			// the version of Flash we're running 
	FLASH_URL		: "http://www.adobe.com/go/getflashplayer",
	PL_URL			: "http://download.piclens.com/partner/",   // downloads PL immediately
	PLC				: null,			// PicLens Client
	LEARN_PL_URL	: "http://affiliate.piclens.com/partner/",  // landing page to read about / download PL
	FONT			: "font-family: Lucida Grande, Myriad Pro, Verdana, Helvetica, Arial, sans-serif;",
	KEY_HANDLERS	: "",	// save the old key handlers, if any
	ON_NO_PLUGINS	: null, // callback
	ON_EXIT			: null, // callback
	AUTO_CLOSE_TIMER_ID		: 0,	// 
	REMOVE_TIMER_ID			: 0,	// the timer for removing the children...
	RESIZE_TIMER_IE6		: null,	// every second, autoresizes the UI
	RESIZE_HANDLER_EXISTS	: false,// add a handler to detect user resize events in safari
	CUSTOM_BUTTON			: null,	// add an action to the UI

	addKeyHandlers : function() {
		var self = this;
		if (typeof document.onkeydown !== 'undefined') { // save & later restore key handlers...
			this.KEY_HANDLERS = document.onkeydown;
		}
		document.onkeydown = function(e) {
			var keycode;
			if (typeof e === "undefined" || e === null) { // ie
				keycode = window.event.keyCode;
			} else { // mozilla
				keycode = e.which;
			}
			var val=self.handleKeyPress(keycode);
			if (typeof e != "undefined" && e != null) {
				e.returnValue = val;
			}
			return val;
		};
	},
	addMouseHandlers : function() {
		if (window.addEventListener) {		// Firefox/Opera
			window.addEventListener("DOMMouseScroll", this.handleMouseWheel, false);
		} else if (document.attachEvent) {	// IE
			document.attachEvent("onmousewheel", this.handleMouseWheel);
		}
		// must be outside of the if-else
        window.onmousewheel = document.onmousewheel = this.handleMouseWheel; // Safari & Others
	},
	// call this at the last possible moment (especially for Win/Firefox)
	appendElementsToDocument : function() { 
		if (this.BROWSER_FFX && this.OS_MAC) {	// avoid redraw bug by not showing the background
			this.LITE_BG_DIV.style.display = "none";
		}
		document.body.appendChild(this.LITE_BG_DIV);
		document.body.appendChild(this.LITE_FG_DIV);
	},
	autoResize : function() { // for the IE6 auto resize
		if (!this.isRunning()) {
			// unregister the timer
			clearInterval(this.RESIZE_TIMER_IE6);
			return;
		}
		
		// resize the BG and FG divs
		var size = this.getPageSize();
		var bg = this.LITE_BG_DIV;
		if (bg) {
			bg.style.height = size.h + 'px';
			bg.style.width  = size.w + 'px';
		}
		if (this.LITE_FG_DIV) {
			var fgs = this.LITE_FG_DIV.style;
			this.resizeToPaddedBox(fgs);
			this.resizeToFitPaddedBox(fgs, size);
			this.resizeFlashToFitPaddedBox();
		}
	},
	checkForPluginAndLaunchIfPossible : function (url, guid) {
		// if we have the correct version of piclens, pass it onto the client and do not use LITE
		if (this.hasCooliris()) {
			if (typeof(guid) != "undefined") {
				this.PLC.launch(url,'uid',guid);
			} else {
				this.PLC.launch(url,'','');
			}

			return true; // launched!
		}
		return false;
	},
	createBackgroundOverlay : function () {
		// create a background that covers the page
		var bg = document.createElement('div');
		this.LITE_BG_DIV = bg;
		bg.id = "lite_bg_div";
		
		var bgs = bg.style;
		bgs.position = 'fixed';

		// stick to the sides when the window resizes
		bgs.width = bgs.height = "100%";

		if (this.BROWSER_IE6) {
			var b = document.body;
			var bs = b.currentStyle;
			var de = document.documentElement;
			var ds = de.currentStyle;
			
			// save previous document styles
			this.OLD_B_MARGIN = bs.margin;
			this.OLD_B_OVERFLOW = bs.overflow;
			this.OLD_B_HEIGHT = bs.height;
			this.OLD_H_OVERFLOW = ds.overflow;
			this.OLD_H_HEIGHT = ds.height;
			this.OLD_SCROLL_Y = de.scrollTop;
			
			// simulate position:fixed...
			b.style.margin = "0";
			b.style.overflow = "auto";
			b.style.height = "100%";
			de.style.overflow = "auto";
			de.style.height = "100%";

			bgs.position = 'absolute';
			var page = this.getPageSize();
			bgs.height = page.h + 'px';
			bgs.width  = page.w + 'px';
		}
		
		bgs.left = bgs.right = bgs.top = bgs.bottom = '0';
		bgs.backgroundColor = '#000';
		bgs.zIndex = 9500;
		bgs.opacity = '0.5';
		bgs.filter = 'alpha(opacity=50)';		// IE7

		var self = this;
		bg.onclick = function () {
			self.exitPicLensLite();
		};
	},
	createForegroundFlashComponent : function () { // configure the box
		var fg = document.createElement('div');
		this.LITE_FG_DIV = fg;
		fg.id = "lite_fg_div";

		var fgs = fg.style;
		fgs.backgroundColor = '#000';
		fgs.position = 'fixed';
		fgs.border = '2px solid #555';
		fgs.zIndex = 9501;	   // above the bg

		this.resizeToPaddedBox(fgs);

		if (this.BROWSER_IE6) {
			fgs.position = 'absolute';
			this.resizeToFitPaddedBox(fgs);
		}
	},
	// this just removes the HTML elements
	// we call this from Flash (thus, we need to allow the function to return before removing the children)
	closeFlashUI : function (itemID) {
		var doc = document;
		
		// remove the keyboard & mouse handlers...
		doc.onkeydown = this.KEY_HANDLERS;
		window.onmousewheel = doc.onmousewheel = "";
		if (window.removeEventListener) {
			window.removeEventListener("DOMMouseScroll", this.handleMouseWheel, false);
		}
		if (doc.detachEvent) { // IE/Opera
			doc.detachEvent("onmousewheel", this.handleMouseWheel);
		}

		// hide the div now; remove them later
		this.LITE_BG_DIV.style.display = this.LITE_FG_DIV.style.display = 'none';
		this.REMOVE_TIMER_ID = setTimeout(function (){PicLensLite.removeChildren();}, 150); // 0.15s

		if (this.BROWSER_IE6) { // restore styles
			var b = document.body;
			var de = document.documentElement;
			b.style.margin = this.OLD_B_MARGIN;
			b.style.overflow = this.OLD_B_OVERFLOW;
			b.style.height = this.OLD_B_HEIGHT;
			de.style.overflow = this.OLD_H_OVERFLOW;
			de.style.height = this.OLD_H_HEIGHT;
			window.scrollTo(0, this.OLD_SCROLL_Y);
		}

		if (this.ON_EXIT !== null) {
			this.ON_EXIT(itemID); // call on exit
		}
		this.setRunningFlag(false);
	},
	// for handling cross-browser quirks...
	determineBrowserParams : function () {
		// BrowserDetect {.OS, .browser, .version} e.g., "Mac Firefox 2" and "Windows Explorer 7"
		var os = BrowserDetect.OS;
		var b = BrowserDetect.browser;
		this.OS_MAC = (os == "Mac");
		this.OS_WIN = (os == "Windows");
		this.BROWSER_FFX = (b == "Firefox");
		this.BROWSER_SAF = (b == "Safari");
		this.BROWSER_IE = (b == "Explorer");
		this.BROWSER_IE6 = (this.BROWSER_IE && BrowserDetect.version == "6");
		this.FLASH_VER = swfobjlite.getFlashPlayerVersion(); // what version of Flash is the browser running?
	},
	// we should tell Flash we are exiting when this is called...
	// this should only be called when the user clicks outside of the flash component
	// all other exits are handled through Flash
	exitPicLensLite : function () {
		var fl = this.getFlash();
		if (fl !== null && fl.fl_exitPicLensLite) {	// binding exists
			// tell flash that we are quitting
			fl.fl_exitPicLensLite();
			// close after .5 seconds, if nothing happened
			// TODO: make sure this doesn't crash any browsers
			// TODO: Check the Return Value to Fire this Timer?
			this.AUTO_CLOSE_TIMER_ID = setTimeout(function (){ if (PicLensLite.isRunning()) { PicLensLite.closeFlashUI();}}, 500); // 0.5s
		} else {
			// if it's not running already, we just remove the DIVs (flash isn't defined)
			this.closeFlashUI();
		}
	},
	// a website should include the absolute URL of the piclens.js in its header
	// This function looks for the script tag and extracts the ROOT_URL
	// <script type="text/javascript" src="ROOT_URL/piclens.js"></script>
	// we assume the SWF and JPEG/PNG/GIF files are relative to this ROOT_URL...
	findScriptLocation : function () {
		var scriptTags = document.getElementsByTagName("script");
		for (var i = 0; i != scriptTags.length; ++i) {
			var script = scriptTags[i];
			var type = script.getAttribute("type");
			if (type == "text/javascript") {
				var src = script.getAttribute("src");
				if (src === null) {
					continue;
				}
				var index = src.indexOf("piclens.js"); 
				if (index != -1) {
					this.setLiteURLs({lite:src.substring(0,index)});
					return;
				} else {
					index = src.indexOf("piclens_optimized.js");
					if (index != -1) {
						this.setLiteURLs({lite:src.substring(0,index)});
						return;
					}
				}
			}
		}
	},
	// returns an object describing the page size of the browser window
	getPageSize : function () {
		var xScroll, yScroll, winW, winH;
		var doc = document;
		var body = doc.body;
		var html;
		if (window.innerHeight && window.scrollMaxY) {
			xScroll = doc.scrollWidth;
			yScroll = (this.isFrame ? parent.innerHeight : self.innerHeight) + (this.isFrame ? parent.scrollMaxY : self.scrollMaxY);
		} else if (body.scrollHeight > body.offsetHeight){
			xScroll = body.scrollWidth;
			yScroll = body.scrollHeight;
		} else {
			html = doc.getElementsByTagName("html").item(0);
			xScroll = html.offsetWidth;
			yScroll = html.offsetHeight;
			xScroll = (xScroll < body.offsetWidth) ? body.offsetWidth : xScroll;
			yScroll = (yScroll < body.offsetHeight) ? body.offsetHeight : yScroll;
		}
		var docElement = doc.documentElement;
		if (self.innerHeight) {
			winW = (this.isFrame) ? parent.innerWidth : self.innerWidth;
			winH = (this.isFrame) ? parent.innerHeight : self.innerHeight;
		} else if (docElement && docElement.clientHeight) {
			winW = docElement.clientWidth;
			winH = docElement.clientHeight;
		} else if (body) {
			html = doc.getElementsByTagName("html").item(0);
			winW = html.clientWidth;
			winH = html.clientHeight;
			winW = (winW == 0) ? body.clientWidth : winW;
			winH = (winH == 0) ? body.clientHeight : winH;
		}
		var pageHeight = (yScroll < winH) ? winH : yScroll;
		var pageWidth = (xScroll < winW) ? winW : xScroll;
		return {pw:pageWidth, ph:pageHeight, w:winW, h:winH}; // pw and ph are the larger pair. use w and h.
	},
	getElementsFromXMLFeed : function () {
		var xmlDoc;
		if (window.ActiveXObject) { // IE
		  	xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
		  	xmlDoc.async=false;
		  	xmlDoc.loadXML(PicLensLite.THE_FEED);
		} else { // Mozilla, Firefox, Opera, etc.
			var parser = new DOMParser();
			xmlDoc = parser.parseFromString(PicLensLite.THE_FEED, "text/xml");
		}
		var elements = xmlDoc.getElementsByTagName('*');
		return elements;
	},
	getBasicSlideShowHTML : function () {
		if (!this.LBOX_JS_URL || !this.LBOX_CSS_URL) {
			return "";
		}
		
		// make sure the lytebox JS is included
		var head = document.getElementsByTagName('head').item(0);

		// add the script tag
		var script  = document.createElement('script');
		script.src  = this.LBOX_JS_URL;
		script.type = 'text/javascript';
		head.appendChild(script);
		
		// add the lytebox CSS too
		var link = document.createElement('link');
		link.rel = "stylesheet";
		link.href = this.LBOX_CSS_URL;
		link.type = "text/css";
		link.media = "screen";
		head.appendChild(link);

		// find all image URLs from the feed.
		var xmlElements = this.getElementsFromXMLFeed();

		var i;
		var hiddenURLs = "";
		for (i = 0; i < xmlElements.length; i++) {
			if (xmlElements[i].nodeName == "media:content") {	// what about the namespace?
				var url = xmlElements[i].getAttribute("url");
				if (url.indexOf(".flv") == -1) {				// images only... avoid FLV files
					hiddenURLs += '<a id="lboxImage" href="' + url + '" rel="lytebox[lite]"></a> ';
				}
			}
		}
		// rel="lytebox[lite]"
		var basicSlideShow = "<div id='lightbox_images' align='center' style='display: none; padding-top:10px; color:#FFFFFF; font-size:.8em; " +this.FONT+ " color:#999999;'>";
		basicSlideShow +=  '( Alternatively, <a onclick="javascript:PicLensLite.invokeLytebox();return false;" href="#" style="color:#656588">click here for a basic slideshow</a>. )';
		basicSlideShow += hiddenURLs;
		basicSlideShow += "</div><br/>";

		return basicSlideShow;
	},
	generateAlternativeContent : function () {
		var altContentHTML = '<div id="altContent" style="text-align:center; margin: 0 0 0 0; padding: 0 0 0 0; background-color: #000; min-width:860px;">';
		altContentHTML += '<div align="center" style="width: 100%; padding-top:60px; '+this.FONT+'">';

		var v = this.FLASH_VER;
		var flashMessage;
		if (v.major > 0) { // has some version of Flash
			flashMessage = "update your Flash Player from version "+ v.major + '.' + v.minor + '.' + v.release + " to version 9.0.28 or newer";
		} else {
			flashMessage = "install the most recent Flash Player";
		}
		
		var basicSlideShow = "";
		if (this.THE_FEED !== "") {   // do this if we've loaded the feed in AJAX
			basicSlideShow = this.getBasicSlideShowHTML();
		}
		
		var downloadPL = this.PL_URL;
		var learnPL = this.LEARN_PL_URL;
		var pid = this.ARGS.pid;
		if (pid) {
			downloadPL += pid + "/";
			learnPL += pid + "/";
		} else {
			var x = "000000000001/";
			downloadPL += x;
			learnPL += x;
		}
		
		if (this.SHOW_LBOX) {
			// don't show the image, because we will invoke lytebox immediately
		} else {
			var sp = "<span style='padding-left:25px; color:#C6C6C6; font-size:";
			altContentHTML += 
				"<div style='padding:10px;'>" + 
					sp+"1.5em; font-weight: bold; " +this.FONT+ "'>You're clicks away from going full screen!</span><br/>" + 
					sp+".9em; padding-bottom: 15px; " +this.FONT+ "'>You must get the <a href='"+downloadPL+"' style='color:#656588'>Cooliris</a> browser plugin, or "+flashMessage+".</span>" +
				"</div>";
			if (!this.BUTTON_URL) {
				altContentHTML +=
				'<a href="' + downloadPL + '" style="color:#ACD">Get Cooliris Now!</a>';
			} else {
				var area = '<area shape="rect" coords=';
				altContentHTML +=
				'<img src="'+this.BUTTON_URL+'" alt="" border="0" usemap="#Map">' + 
				'<map name="Map" id="Map">' + 
					area+'"0,0,33,33" href="#" onclick="javascript:PicLensLite.closeFlashUI();" />' +
					area+'"35,35,325,325" href="' + downloadPL +'" />' +
					area+'"593,209,825,301" href="' + this.FLASH_URL +'" />' +
					area+'"327,148,448,178" href="' + learnPL +'" />' +
				'</map>';
			}
		}

		altContentHTML += '</div>';
		altContentHTML += basicSlideShow;
		altContentHTML += '<div align="center" style="color:#666666; font-size:11px; '+this.FONT+'">&copy; 2008 Cooliris, Inc. All trademarks are property of their respective holders.<br/><br/><br/></div>';
		altContentHTML += '</div>';
		return altContentHTML;		
	},
	generateFlashVars : function () {
		var fv = '';
		var args = this.ARGS;
		if (typeof args.guid !== 'undefined') {
			fv += "&startItemGUID=" + args.guid;
		}
		if (args.loadFeedInFlash) {
			fv += "&feedURL=" + encodeURIComponent(this.THE_FEED_URL);	// may need crossdomain.xml to allow loading of feed
		}
		if (args.paused) {
			fv += "&paused=" + args.paused;
		}
		if (args.loop) {
			fv += "&loop=" + args.loop;
		}
		if (args.delay) { // seconds: from 1-10
			fv += "&delay=" + args.delay;
		}
		if (args.pid) {
			fv += "&pid=" + args.pid;
		}
		if (typeof args.maxScale != 'undefined') {	// allow 0
			fv += "&maxScale=" + args.maxScale;
		}
		if (typeof args.overlayToolbars != 'undefined') {
			fv += "&overlayToolbars=" + args.overlayToolbars;
		}
		var cb = this.CUSTOM_BUTTON;
		if (cb != null) {
			fv += "&cButtonURL=" + encodeURIComponent(cb.targetURL);
			if (cb.labelText != null) {
				fv += "&cButtonLabel=" + encodeURIComponent(cb.labelText);
			}
			if (cb.iconImage != null) {
				fv += "&cButtonIcon=" + encodeURIComponent(cb.iconImage);
			}
		}
		fv += "&swfURL="+encodeURIComponent(this.LITE_URL);
		fv = fv.substring(1); // kill the first &
		return fv;
	},
	// does the right thing for each browser
	// returns the Flash object, so we can communicate with it over the ExternalInterface
	getFlash : function () {
		// we should determine which one to pass back depending on Browser/OS configuration
		if (this.BROWSER_SAF || this.BROWSER_IE) {
			return document.getElementById(this.FLASH_ID_1); // outer <object>
		} else {
			return document.getElementById(this.FLASH_ID_2); // inner <object>
		}
	},
	getWindowSize : function () { // inner size
		var docElement = document.documentElement;
		var docBody = document.body;
		var w = 0, h = 0;
		if (typeof(window.innerWidth) == 'number') {
			// not IE
			w = window.innerWidth;
			h = window.innerHeight;
		} else if (docElement && (docElement.clientWidth || docElement.clientHeight)) {
			// IE 6+ in 'standards compliant mode'
			w = docElement.clientWidth;
			h = docElement.clientHeight;
		} else if (docBody && (docBody.clientWidth || docBody.clientHeight)) {
			// IE 4 compatible
			w = docBody.clientWidth;
			h = docBody.clientHeight;
		}
		return {w:w, h:h};
	},
	handleKeyPress : function (code) {
		if (!this.isRunning()) { return true; }
		var fl = this.getFlash();
		if (fl != null && fl.fl_keyPressed) {
			fl.fl_keyPressed(code); // forward to Flash
		} else {
			if (code == 27) { // ESC to close
				this.closeFlashUI();
				return false;
			}
		}
		if (code == 9 || code == 13) { // trap tab, enter
			return false;
		}
		return true; // allow the browser to process the key
	},
	handleMouseWheel : function (e) {
		// e.wheelDelta
		// Safari/Windows (MouseWheel Up is +120; Down is -120)
		var delta = 0;
		if (!e) {
			e = window.event;
		}
		if (e.wheelDelta) { // IE/Opera
			delta = e.wheelDelta/120;
			if (window.opera) {
				delta = -delta;
			}
		} else if (e.detail) { // Firefox/Moz
			var d = e.detail;
			// on mac, don't divide by 3...
			if (Math.abs(d) < 3) {
				delta = -d;
			} else {
				delta = -d/3;
			}
		}
		if (delta) {
			// don't send abs values < 1; otherwise, you can only scroll next
			PicLensLite.sendMouseScrollToFlash(delta);		
		}
		if (e.preventDefault) {
			e.preventDefault();
		}
		e.returnValue = false;
		return false;
	},
	hasPicLensClient : function () { // DEPRECATED! Use hasClient()
		return this.hasCooliris();
	},
	// check if Cooliris Client is available
	hasCooliris : function () {
		// a flag to turn off the client
		if (this.DEBUG_NOCLIENT) {
			return false;
		}
		
		// check if the bridge has already been defined
		var clientExists = false;
		if (this.PLC) {
			clientExists = true;
		} else if (window.piclens && window.piclens.launch) {
			this.PLC = window.piclens;
			clientExists = true;
		} else { // if not, try to define it here...
			var context = null;
			if (typeof PicLensContext != 'undefined') { // Firefox
				context = new PicLensContext();
			} else {									
				try { 
					context = new ActiveXObject("PicLens.Context"); // IE
				} catch (e) {
					if (navigator.mimeTypes['application/x-cooliris']) { // Safari
						context = document.createElement('object');
						context.style.height="0px";
						context.style.width="0px";
						context.type = 'application/x-cooliris';
						document.documentElement.appendChild(context);
					} else {
						context = null;
					}
				}
			}
			
			this.PLC = context;
			if (this.PLC) {
				clientExists = true;
			}
		}
		
		if (clientExists) { // check the version number
			if (this.BROWSER_SAF) { // for Safari, we just return true (the first v. was 1.8)
				return true;
			}
				
			var version;
			try { version = this.PLC.version; } catch (e) { return false; }
						
			var parts = version.split('.'); // minimum ver. is: 1.6.0.824
			if (parts[0] > 1) {			    // a ver. 2.X product
				return true;
			} else if (parts[0] == 1) {	    // a 1.X product
				if (parts[1] > 6) {		    // a 1.7.X product
					return true;
				} else if (parts[1] == 6) { // a 1.6 product
					if (parts[2] > 0) {	    // a 1.6.1.X product
						return true;
					} else if (parts[2] == 0) {
						if (parts[3] >= 824) { // 1.6.0.824 or newer...
							return true;
						}
					}
				}
			}
			return false; // a 0.X product
		} else {
			return false;
		}
	},
	invokeLytebox : function () {
		this.SHOW_LBOX = true; // user has specified that she wants to use the basic slideshow
		myLytebox.start(document.getElementById("lboxImage"), false, false);
		this.closeFlashUI();
	},
	showLyteboxLink : function () {
		myLytebox.updateLyteboxItems();
		myLytebox.doAnimations = false;
		var lboxImages = document.getElementById('lightbox_images');
		if (lboxImages != null) {
			lboxImages.style.display = "block";
			if (this.SHOW_LBOX && this.getFlash()==null) { // the user has clicked on lbox once, so we assume it going forward
				this.invokeLytebox();
			}
		}
	},
	startLytebox : function () { // allows us to include lytebox, unmodified
		if (typeof myLytebox != "undefined") {
			this.showLyteboxLink();
		} else {
			if (typeof initLytebox != "undefined") {
				initLytebox();
				this.showLyteboxLink();
			} else {
				if (this.LBOX_COUNT >= 4) {
					return; // give up after 600 ms
				}
				setTimeout(function (){PicLensLite.startLytebox();}, 150); // try again in 150 ms
				this.LBOX_COUNT++;
			}
		}
	},
	injectFlashPlayer : function () {
		var fg = this.LITE_FG_DIV;
		
		// determine the width and height of the flash component
		var flashWInner;
		var flashHInner;
		flashWInner = flashHInner = '100%';
		if (this.BROWSER_IE6) {
			flashWInner = flashHInner = '0';
		}
		
		var flashVars = this.generateFlashVars();
		var altContentHTML = this.generateAlternativeContent(); // non-flash content

		if (this.meetsReqs()) {
			var par = '<param name=';
			fg.innerHTML = 
				'<object id="'+ this.FLASH_ID_1 +'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%">' + // SAF & IE
					par+'"movie" value="' + this.LITE_URL + '" />' +
					par+'"quality" value="high"/> ' +
					par+'"bgcolor" value="#000000"/> ' +
					par+'"allowScriptAccess" value="always"/> ' +
					par+'"FlashVars" value="' + flashVars + '"/> ' +
					par+'"allowFullScreen" value="true"/> ' +
					par+'"wmode" value="window"/> ' +
					par+'"scale" value="noscale"/> ' +
						'<object type="application/x-shockwave-flash" data="' + this.LITE_URL + '" width="'+flashWInner+'" height="'+flashHInner+'" ' + // NOT IE
							'quality="high" ' +
							'bgcolor="#000000" id="'+ this.FLASH_ID_2 + '" ' + 
							'quality="high" ' +
							'FlashVars="' + flashVars + '" ' +
							'allowFullScreen="true" ' +
							'scale="noscale" ' + 
							'wmode="window" ' +
							'allowScriptAccess="always">' +
							altContentHTML + // IE
						'</object>'+ // NOT IE
				'</object>';
		} else {
			if (this.ON_NO_PLUGINS) {
				this.ON_NO_PLUGINS(); // callback instead of showing NoFlash.jpg
			} else {
				fg.innerHTML = altContentHTML;
				fg.style.minWidth = "860px";
				fg.style.minHeight = "550px";
			}
		}
		
		if (this.BROWSER_SAF) {
			this.resizeUI(); // fixes layout 
		}
	},
	// find the RSS feeds on this page, and return an array
	indexFeeds : function () {
		var linkTags = document.getElementsByTagName("link");
		var feeds = [];
		for (var i = 0; i != linkTags.length; ++i) {
			var link = linkTags[i], type = link.getAttribute("type");
			if (type == "application/rss+xml" || type == "text/xml") {
				feeds.push({ title: link.getAttribute("title"), url: link.getAttribute("href") });
			}
		}
		return feeds;
	},
	// once we get the response text, we launch flash
	loadViaXHR : function (url) {
		var self = this;
		var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("MSXML2.XMLHTTP.3.0");
		try {
			request.open("GET", url, true);
			request.onreadystatechange = function () {
				if (request.readyState == 4) {
					if ((request.status == 200 || request.status == 0)) { // 0 -> File System Testing
						if (request.responseText) {
							// at this point, we have the text
							self.showFlashUI(request.responseText);
						}
					} else {
						if (console) {console.log("PicLens Lite could not load the RSS Feed: " + url);}
					}
				}
			};
			request.send("");
		} catch (err) { // probably a crossdomain issue, so ask flash to try loading
			this.ARGS.loadFeedInFlash = true;
			this.showFlashUI("");
		}
	},
	meetsReqs : function () {
		if (this.DEBUG_NOFLASH) {
			return false;
		}
		// if IE7 and Flash detect returns v0, we show the Flash
		var ie7FlashDetectionWorkaround = (this.FLASH_VER.major == 0) && this.BROWSER_IE;
		var hasFlash = swfobjlite.hasFlashPlayerVersion("9.0.28");
		return hasFlash || ie7FlashDetectionWorkaround;
	},
	removeChildren : function () {
		this.REMOVE_TIMER_ID = 0;
		// remove the divs after a timeout
		if (this.LITE_BG_DIV !== null) {
			document.body.removeChild(this.LITE_BG_DIV);
			this.LITE_BG_DIV = null;
		}
		if (this.LITE_FG_DIV !== null) {
			document.body.removeChild(this.LITE_FG_DIV);
			this.LITE_FG_DIV = null;
		}
	},
	resizeFlashToFitPaddedBox : function () {
		var flash = this.getFlash();
		if (flash) {
			var size = this.getPageSize();
			var w = size.w - this.HPAD * 2;
			var h = size.h - this.VPAD * 2;
			flash.style.width = w; flash.style.height = h;
			flash.width = w; flash.height = h;
		}
	},
	resizeToFitPaddedBox : function (s, size) {
		if (typeof size == 'undefined') {
			size = this.getPageSize();
		}
		s.width = (size.w - this.HPAD * 2) + 'px';
		s.height = (size.h - this.VPAD * 2) + 'px';
	},
	resizeToPaddedBox : function (s) {
		s.left = s.right = this.HPAD + 'px';
		s.top = s.bottom = this.VPAD + 'px';
	},
	resizeUI : function () { // resize handler for Safari
		if (this.LITE_FG_DIV) {
			var fgs = this.LITE_FG_DIV.style;
			this.resizeToPaddedBox(fgs);
			this.resizeToFitPaddedBox(fgs);
			this.resizeFlashToFitPaddedBox();
		}
	},
	setRunningFlag : function (flag) {
		this.LITE_IS_RUNNING = flag;
		this.piclensIsRunning_ = flag;
	},
	setResizeHandler : function () { // for safari
		if (!this.RESIZE_HANDLER_EXISTS && this.BROWSER_SAF) {
			var self = this;
			window.addEventListener('resize', function () { self.resizeUI(); }, false);
			this.RESIZE_HANDLER_EXISTS = true;
		}
	},
	setResizeTimer : function () { // only do it for IE6...
		if (this.BROWSER_IE6) {
			this.RESIZE_TIMER_IE6 = setInterval(function () { PicLensLite.autoResize(); }, 1000);
		}
	},
	showFlashUI : function (feedText) {
		this.THE_FEED = feedText; // is "" if we are loading the feed in Flash
		this.findScriptLocation();
		this.createBackgroundOverlay();
		this.createForegroundFlashComponent();
		if (this.BROWSER_IE) {
			this.appendElementsToDocument();
		}
		this.injectFlashPlayer();
		if (!this.BROWSER_IE) {
			// Win Firefox needs this to be last
			// Other Browsers are OK with this
			this.appendElementsToDocument(); 
		}
		this.addKeyHandlers();
		this.addMouseHandlers();
		this.setRunningFlag(true);
		this.setResizeTimer();
		this.setResizeHandler();
		this.startLytebox();
	},
	sendMouseScrollToFlash : function (delta) {
		if (!this.isRunning()) { return; }
		var fl = this.getFlash();
		if (fl != null && fl.fl_mouseMoved) {
			fl.fl_mouseMoved(delta);
		}
	}
	// don't end the last function with a comma; it messes up IE7
};




/* SWFObject v2.0 <http://code.google.com/p/swfobject/> / Copyright 2007 Geoff Stearns, Michael Williams, and Bobby van der Sluis / MIT License */
var swfobjlite = function() {
	var UNDEF = "undefined",
		OBJECT = "object",
		SHOCKWAVE_FLASH = "Shockwave Flash",
		SHOCKWAVE_FLASH_AX = "ShockwaveFlash.ShockwaveFlash",
		win = window,
		doc = document,
		nav = navigator;
	
	var ua = function() {
		var w3cdom = typeof doc.getElementById != UNDEF && typeof doc.getElementsByTagName != UNDEF && typeof doc.createElement != UNDEF && typeof doc.appendChild != UNDEF
					&& typeof doc.replaceChild != UNDEF && typeof doc.removeChild != UNDEF && typeof doc.cloneNode != UNDEF,
			playerVersion = [0,0,0],
			d = null;
		if (typeof nav.plugins != UNDEF && typeof nav.plugins[SHOCKWAVE_FLASH] == OBJECT) {
			d = nav.plugins[SHOCKWAVE_FLASH].description;
			if (d) {
				d = d.replace(/^.*\s+(\S+\s+\S+$)/, "$1");
				playerVersion[0] = parseInt(d.replace(/^(.*)\..*$/, "$1"), 10);
				playerVersion[1] = parseInt(d.replace(/^.*\.(.*)\s.*$/, "$1"), 10);
				playerVersion[2] = /r/.test(d) ? parseInt(d.replace(/^.*r(.*)$/, "$1"), 10) : 0;
			}
		}
		else if (typeof win.ActiveXObject != UNDEF) {
			var a = null, fp6Crash = false;
			try {
				a = new ActiveXObject(SHOCKWAVE_FLASH_AX + ".7");
			}
			catch(e) {
				try { 
					a = new ActiveXObject(SHOCKWAVE_FLASH_AX + ".6");
					playerVersion = [6,0,21];
					a.AllowScriptAccess = "always";  // Introduced in fp6.0.47
				}
				catch(e) {
					if (playerVersion[0] == 6) {
						fp6Crash = true;
					}
				}
				if (!fp6Crash) {
					try {
						a = new ActiveXObject(SHOCKWAVE_FLASH_AX);
					}
					catch(e) {}
				}
			}
			if (!fp6Crash && a) { // a will return null when ActiveX is disabled
				try {
					d = a.GetVariable("$version");  // Will crash fp6.0.21/23/29
					if (d) {
						d = d.split(" ")[1].split(",");
						playerVersion = [parseInt(d[0], 10), parseInt(d[1], 10), parseInt(d[2], 10)];
					}
				}
				catch(e) {}
			}
		}
		var u = nav.userAgent.toLowerCase(),
			p = nav.platform.toLowerCase(),
			webkit = /webkit/.test(u) ? parseFloat(u.replace(/^.*webkit\/(\d+(\.\d+)?).*$/, "$1")) : false, // returns either the webkit version or false if not webkit
			ie = false,
			windows = p ? /win/.test(p) : /win/.test(u),
			mac = p ? /mac/.test(p) : /mac/.test(u);
		/*@cc_on
			ie = true;
			@if (@_win32)
				windows = true;
			@elif (@_mac)
				mac = true;
			@end
		@*/
		return { w3cdom:w3cdom, pv:playerVersion, webkit:webkit, ie:ie, win:windows, mac:mac };
	}();

	return { // PUBLIC API
		hasFlashPlayerVersion : function(rv) {
			var pv = ua.pv, v = rv.split(".");
			v[0] = parseInt(v[0], 10);
			v[1] = parseInt(v[1], 10);
			v[2] = parseInt(v[2], 10);
			return (pv[0] > v[0] || (pv[0] == v[0] && pv[1] > v[1]) || (pv[0] == v[0] && pv[1] == v[1] && pv[2] >= v[2])) ? true : false;
		},
		getFlashPlayerVersion: function() {
			return { major:ua.pv[0], minor:ua.pv[1], release:ua.pv[2] };
		}
	};
}();




	
/* BrowserDetect: http://www.quirksmode.org/js/detect.html */
var BrowserDetect={
	init:function() { this.browser = this.searchString(this.dataBrowser) || "Unknown Browser"; this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown Version"; this.OS = this.searchString(this.dataOS) || "Unknown OS"; },
	searchString:function(data) { for (var i=0;i<data.length;i++)	{ var dataString = data[i].string; var dataProp = data[i].prop; this.versionSearchString = data[i].versionSearch || data[i].identity; if (dataString) { if (dataString.indexOf(data[i].subString) != -1) {return data[i].identity;} } else if (dataProp) { return data[i].identity; } } },
	searchVersion:function(dataString) { var index = dataString.indexOf(this.versionSearchString); if (index == -1) {return;} return parseFloat(dataString.substring(index+this.versionSearchString.length+1)); },
	dataBrowser:[
		{ string: navigator.userAgent, subString: "OmniWeb", versionSearch: "OmniWeb/", identity: "OmniWeb" },
		{ string: navigator.vendor, subString: "Apple", identity: "Safari" },
		{ prop: window.opera, identity: "Opera" },
		{ string: navigator.vendor, subString: "iCab", identity: "iCab" },
		{ string: navigator.vendor, subString: "KDE", identity: "Konqueror" },
		{ string: navigator.userAgent, subString: "Firefox", identity: "Firefox" },
		{ string: navigator.vendor, subString: "Camino", identity: "Camino" },
		{ string: navigator.userAgent, subString: "Netscape", identity: "Netscape" }, // newer Netscapes (6+)
		{ string: navigator.userAgent, subString: "MSIE", identity: "Explorer", versionSearch: "MSIE" },
		{ string: navigator.userAgent, subString: "Gecko", identity: "Mozilla", versionSearch: "rv" },
		{ string: navigator.userAgent, subString: "Mozilla", identity: "Netscape", versionSearch: "Mozilla" } // older Netscapes (4-)
	],
	dataOS:[{ string: navigator.platform, subString: "Win", identity: "Windows" }, { string: navigator.platform, subString: "Mac", identity: "Mac" }, { string: navigator.platform, subString: "Linux", identity: "Linux" } ]
};
BrowserDetect.init();