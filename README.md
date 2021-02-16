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
