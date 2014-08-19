<?php 
?>

elgg.provide('glee');

glee.createModal = function(name, file) {
 id = "#" + name;
 if ($(id).length == 0) {
  registration_modal = $('<div class="modal fade hidden" id="' + name + '"></div>');
  $("body").append(registration_modal);

  $(id).css("padding", "20px"); 
  $(id).html('<div class="progress progress-info progress-striped active"><div class="bar" style="width: 100%;" /></div>');

  elgg.get(file, {
   success: function(resultText, success, xhr) {           			
    if(success) { $(id).html(resultText); }
    else {
     //elgg.forward($(this).attr('href'));
     $(id).html('error');
    }
   }
  });
 }

 $(id).modal({
  keyboard: true
 });  
}

glee.bootstrapInit = function() {
    // "elgg-state-selecte" => "active"
    if ($(".elgg-state-selected").length) {
    	$(".elgg-state-selected").addClass('active');
    } 
    
    /**
     * Navigation
     */
    // "elgg-menu" => "nav"
  	//if ($(".elgg-menu").length) {
    //	$(".elgg-menu").addClass('nav');
    //}
    
    // "elgg-list" => "nav nav-stacked"
    if ($(".elgg-list").length) {
    	$(".elgg-list").addClass('nav');
    	//$(".elgg-list").addClass('nav-list');
    	$(".elgg-list").addClass('nav-stacked');
    }
    
    // "elgg-tabs" => "breadcrumb"
    if ($(".elgg-tabs").length) {
    	$(".elgg-tabs").addClass('nav');
    }   
    if ($(".elgg-htabs").length) {
    	$(".elgg-htabs").addClass('nav-stacked');
    }     
        
    // "elgg-breadcrumbs" => "breadcrumb"
    if ($(".elgg-breadcrumbs").length) {
    	$(".elgg-breadcrumbs").addClass('breadcrumb');
    }      
         
    // "elgg-pagination" wrapped with "pagination pagination-centered"
    if ($('elgg-pagination').length) {
    	$('elgg-pagination').wrap('<div class="pagination pagination-centered" />');
    } 
    
    /**
     * Buttons
     */ 
    // "elgg-button" => "btn"
    if ($(".elgg-button").length) {
    	$(".elgg-button").addClass('btn');
    }  
    // "elgg-button-submit" => "btn"
    if ($(".elgg-button-submit").length) {
    	$(".elgg-button-submit").addClass('btn-primary');
    }  
    // "elgg-button-cancel" => "btn"
    if ($(".elgg-button-cancel").length) {
    	$(".elgg-button-cancel").addClass('btn-inverse');
    }    
    // "elgg-button-delete" => "btn-danger"
  	if ($(".elgg-button-delete").length) {
    	$(".elgg-button-delete").addClass('btn-danger');
    } 
    
    /**
     * FORMS
     */
    // "elgg-form" => "form-horizontal"
    if ($('elgg-form').length) {
    	$('elgg-form').addClass('well');
    	$('elgg-form').addClass('form-horizontal');
    } 
	if ($('elgg-input-radios').length) {
    	$('elgg-input-radios').addClass('nav');
    } 
     
      
	if ($('elgg-sidebar').length) {
    	$('elgg-sidebar').addClass('well');
    }  
	if ($('elgg-sidebar-alt').length) {
    	$('elgg-sidebar-alt').addClass('well');
    }
 
	return true;
}

glee.workaroundsInit = function() {

 // stop forms from disappearing on dropdown menues
 $('.dropdown-menu').find('form').click(function (e) {
  e.stopPropagation();
 });
    
 return true;
}
 
elgg.register_hook_handler('init', 'system', glee.bootstrapInit);
elgg.register_hook_handler('init', 'system', glee.workaroundsInit);
