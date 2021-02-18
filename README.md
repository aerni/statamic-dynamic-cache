# Dynamic Cache ![Statamic](https://flat.badgen.net/badge/Statamic/3.0+/FF269E)
If you ever used Statamic's static caching with the `full` strategy, you know that it doens't play well with forms and dynamic listings like `sort="random"`. This is where Dynamic Cache steps in. It dynamically updates the `exclude` and invaldation `rules` array in your `static_caching.php` config based on a boolean in your entries' content.

Dynamic Cache is a lifesaver for sites with complex page builders based on Replicator and Bard. Your page builder might have dozens of components of which only one requires dynamic functionality. Without this addon, you'd have to do without full static caching, because you'd never know which page would include that one component that doesn't work when chached statically.

>**Note:** This addon currently only works with collection entries.

## Features
- Adds your entries' URLs to the static caching `exclude` array
- Populates the invalidation `rules` array
- Updates the config whenever you save or delete an entry, or change the structure of a collection
- Artisan Command to manually trigger a config update

## Installation
Install the addon using Composer.

```bash
composer require aerni/dynamic-cache
```

Publish the config of the package.

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
You may change the handle of the field that is used to check if an entry should be excluded from the static cache. The field handle defaults to `exclude_from_static_cache`.

## Basic Usage
Dynamic Cache will look for `exclude_from_static_cache: true` in your entries. The best way to add this value to your content is by creating a Fieldset with a Hidden Fieldtype and adding it to your Blueprints where necessary.

If you use a page builder, I suggest you add the Fieldset to every Replicator or Bard set that requires dynamic functionality. This way, the entry will only be excluded from the static cache, if the component in question is present. If the component is not present, the entry will be cached statically.

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

Alternatively, you can also use a Toggle Fieldtype to manually turn the static cache on and off. Just note, that this kind of defeats the dynamic problem this addon is trying to solve …

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
You are free to manually change the `exclude` and `rules` array. This addon is smart enough to merge your manual changes.

## Invalidation Rules
This addon will not generate any invalidation rules if the config is set to `rules => 'all'`.

## Commands
You may update the config with the following command. This is useful if you change your entries in your code editor rather than in the Control Panel.

```bash
php artisan dynamic-cache:update
```
