# Dynamic Cache ![Statamic](https://flat.badgen.net/badge/Statamic/3.0+/FF269E)
Dynamically exclude URLs from the static cache

## Installation
Install the addon using Composer.

```bash
composer require aerni/dynamic-cache
```

## Basic Usage

Add this to your content file to exclude the URL from the static cache:
```
exclude_from_static_cache: true
```

You can also create a fieldset with a hidden fieldtype with the handle `exclude_from_static_cache` and default value of `true`. Then pull this fieldset into your blueprint wherever you need.

## How it Works

This addon loops through all your entries and looks for the `exclude_from_static_cache` key with a value of `true`. It then adds the URLs of all entries that match this criteria to an array. This array is then merged with the URLs you might have manually added to the `exclude` array in your `static_caching.php` config. At the end, this new `exclude` config array will replace the existing `exclude` array in `static_caching.php`.

This logic fires whenever you save or delete an entry, or change the structure of a collection in the Control Panel.
