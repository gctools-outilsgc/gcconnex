# Plugin Loader
Forked from https://github.com/lowfill/elgg_default_plugin_order

## Elgg plugin
Plugin that allows import and export of your system's plugin configuration.

### Why use this?
When you have a large number of plugins that depend on being loaded in a
particular order, it is useful to export that order into something that can be
placed in source control, and easily re-imported for testing.

### Installation
Copy `plugin_loader` into your Elgg's `mod` directory.

### How to use it
Login to Elgg's administration and expand the `Utilities` section under
`Configure`, then choose `Plugin Loader`.

From there you can either `Import` from the specified config file, or `Export` into it.
