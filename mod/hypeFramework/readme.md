# hypeFramework 1.9

## Introduction

hypeFramework 1.9 is wrapper plugin that provides classes, views, actions and
interfaces for other hypeJunction plugins. The previous 1.8 release has outgrown
itself - it was getting too complicated to read or to understand. Large parts of
the framework has been rewritten to make for a clean, readable and scalable
interface.

## What's New

### Forms Interface

* Forms have been liberated from cubersome entity-based logic. All forms are now
initialized and rendered dynamically
* Server-side form validation. Unvalidated forms are stored in the session global
and served back to user
* Uniform HTML markup

### List Interface

* New list rendering interface that builds on Elgg's getter functions and
"automates" filtering and pagination

### AJAX Interface

* Framework is no longer depedant on the JS infrastructure
* Thanks to the new xhr viewtype, all links fallback to default view should any
JS errors occur
* Callback-driven logic

### Location Interface

* New plugin hook handler that listens to changes in `$entity->location` metadata
and attempts to geocode location values via Google Maps API
* Location interface makes use of Elgg's goecode cache thus reducing the number
of API calls to Google Maps API

### Improved File and Icon Handling

* A number of improvements have been made to handling of file uploads and entity
icon generation

### CSS/JS

* Most of the CSS has been stripped to allow for better compatibility with
themes

### Less generalization

* 1.9 steps away from generalizing and rather provides for a more granular
Elgg-like approach