/**
 * @namespace Singleton object for holding the phloor javascript library
 */
elgg.provide('phloor');

var phloor = phloor || {};

phloor.global = this;

phloor.load_css_file = function(filename) {
  var link = document.createElement("link");
  link.setAttribute("href", filename);
  link.setAttribute("type", "text/css");
  link.setAttribute("rel", "stylesheet") ;
  
  return document.getElementsByTagName("head")[0].appendChild(link);
};
