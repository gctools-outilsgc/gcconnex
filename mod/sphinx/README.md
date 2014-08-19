# Sphinx Search for Elgg 1.8

Uses the open source Sphinx search engine to power search on your Elgg site.
This is (theoretically) much faster than mysql's fulltext search engine, and
also provides some nice features such as stemming.  Read more about Sphinx at
<http://sphinxsearch.com/>.

Currently uses Sphinx for `user`, `group`, and `object` searches only. Falls 
back to default Elgg search functionality for `tag` and `comment` searches.

## Installation
***WARNING: IT IS CRITICAL THAT YOUR ELGG DATA DIRECTORY BE INSTALLED OUTSIDE THE
WEB ROOT BEFORE INSTALLING THIS PLUGIN.  FAILING TO DO SO WILL GUARANTEE EXPOSURE
OF YOUR DATABASE CREDENTIALS TO THE GENERAL PUBLIC.***

Note: Your server may require certain permissions to allow you to install + run 
Sphinx. If you cannot get those permissions, you should not use this plugin.

Note: all commands are given as if on Linux.  For Windows, just add ".exe".

1. Place the plugin folder in your "mod" directory as "sphinx"
2. Go to /admin/plugins and activate the "Sphinx Search" plugin
3. Go to /admin/settings/sphinx and generate the configuration file.
4. Download Sphinx -- <http://sphinxsearch.com/downloads/beta/>
5. Install Sphinx -- <http://sphinxsearch.com/docs/manual-2.0.9.html#installation>
6. Start Sphinx
   
That's it! Here's how to start Sphinx:

	/path/to/sphinx/bin/searchd --stop
	/path/to/sphinx/bin/indexer --config /elgg/data/root/sphinx/sphinx.conf --all
	/path/to/sphinx/bin/searchd --config /elgg/data/root/sphinx/sphinx.conf
       
You should set up a cron to run the above commands 
every so often in order to keep the indexes fresh

## Testing
I have only tested this plugin on my local Windows machine. I would welcome reports
of tests in other environments as well!

## Resources
* <http://sphinxsearch.com/docs/manual-2.0.9.html>
* <http://www.ibm.com/developerworks/library/os-php-sphinxsearch/>
