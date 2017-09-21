# elgg_solr

Speed up site search by using a dedicated Solr search index

* Search Entities
* Search tags (exact match)
* Search File contents

This plugin follows the structure of the default Elgg search plugin, can be extended using the same search plugin hooks.


## Elgg Dependencies

This plugin depends on the default elgg search plugin (bundled with Elgg)

This plugin depends on the vroom plugin - https://github.com/jumbojett/vroom


## Git Dev

If grabbing the plugin from Github, install dependencies by running ```composer install```


## Installation

Install to elgg mod directory as 'elgg_solr'.

Enable the plugin in the Admin page, move to position below the search plugin.

Configure Solr with the schema.xml included in the root directory of this plugin.

Enter and save the connection information on the plugin settings page.

Trigger a reindex from the plugin setting page.

Ensure daily cron is configured and active

## Tips

Add the following line to the 'schema.xml' file to allow French characters to be ignored during search:

`<tokenizer class="solr.WhitespaceTokenizerFactory"/>`
`<filter class="solr.ASCIIFoldingFilterFactory"/>`
