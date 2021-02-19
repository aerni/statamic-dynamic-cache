![Statamic](https://flat.badgen.net/badge/Statamic/3.0+/FF269E) ![Packagist version](https://flat.badgen.net/packagist/v/aerni/dynamic-cache/latest) ![Packagist Total Downloads](https://flat.badgen.net/packagist/dt/aerni/dynamic-cache) ![License](https://flat.badgen.net/github/license/aerni/statamic-dynamic-cache)

# Dynamic Cache 
If you ever used Statamic's static caching with the `full` strategy, you know that it doesn't play well with forms and dynamic listings like `sort="random"`. This is where Dynamic Cache steps in. It dynamically updates the `exclude` and invalidation `rules` array in your `static_caching.php` config based on a boolean in your entries' content.

Dynamic Cache is a lifesaver for sites with complex page builders based on Replicator and Bard. Your page builder might have dozens of components and only one requiring dynamic functionality. Without this addon, you'd have to do without full static caching because you'd never know which page actually included that one component that doesn't work when cached statically.

## Features
- Adds your entries' URLs to the static caching `exclude` array
- Populates the invalidation `rules` array
- Updates the config whenever you save or delete an entry or change the structure of a collection
- Artisan Command to manually trigger a config update

>**Note:** This addon currently only works with collection entries.

## Installation
Install the addon using Composer:

```bash
composer require aerni/dynamic-cache
```

Publish the config of the package:

```bash
php please vendor:publish --tag=dynamic-cache-config
```

The following config will be published to `config/dynamic-cache.php`.

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Field Handle
    |--------------------------------------------------------------------------
    |
    | Define the name of the field handle you would like to use.
    | Default: 'exclude_from_static_cache'
    |
    */

    'handle' => 'exclude_from_static_cache',

];
```

## Configuration
You may change the field's handle that is used to check if an entry should be excluded from the static cache. The handle defaults to `exclude_from_static_cache`.

## Basic Usage
Dynamic Cache will look for `exclude_from_static_cache: true` in your entries. The best way to add this value to your content is by creating a Fieldset with a Hidden Fieldtype and adding it to your Blueprints where necessary.

If you use a page builder, I suggest adding the Fieldset to every Replicator or Bard set that requires dynamic functionality. This way, the entry will only be excluded from the static cache if the component in question is present. If it is not, the entry will be cached statically.

**Fieldset with Hidden Fieldtype:**
```yaml
title: 'Exclude From Static Cache'
fields:
  -
    handle: exclude_from_static_cache
    field:
      display: 'Exclude From Static Cache'
      type: hidden
      icon: hidden
      listable: hidden
      replicator_preview: false
      default: true
```

Alternatively, you can also use a Toggle Fieldtype to manually turn the static cache on and off. Just note that this kind of defeats the dynamic problem this addon is trying to solve …

**Fieldset with Toggle Fieldtype:**
```yaml
title: 'Exclude From Static Cache'
fields:
  -
    handle: exclude_from_static_cache
    field:
      display: 'Exclude From Static Cache'
      type: toggle
      icon: toggle
      listable: hidden
```

## Manual Config Changes
You are free to manually change the `exclude` and `rules` array in the `static_caching.php` config. Dynamic Cache is smart enough to merge your manual changes.

## Invalidation Rules
This addon will not generate any invalidation rules if the config is set to `rules => 'all'`.

## Commands
You may update the config with the following command:
```bash
php artisan dynamic-cache:update
```
This is useful if you change your entries in your code editor rather than in the Control Panel.
