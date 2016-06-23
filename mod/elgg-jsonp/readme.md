JSONP support for Elgg
======================

This is a very simple elgg plugin that provides basic JSONP support.

It provides a jsonp wrapper for the existing json interface, allowing you to call remote elgg
data from within your javascript apis.

Known issues
------------
* If you are attempting to call data from the elgg export interface (https://mysite.com/export/jsonp/xxxx) 
  you will need to modify your .htaccess file adding [QSA,L] to the export interface definition lines, otherwise you'll only be
  able to return data to a function called "response".

See
---
 * Author: Marcus Povey <http://www.marcus-povey.co.uk>
 * Plugin Homepage <https://github.com/mapkyca/elgg-jsonp>

