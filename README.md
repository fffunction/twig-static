# twig-static
[![Build Status](https://travis-ci.org/fffunction/twig-static.svg?branch=master)](https://travis-ci.org/fffunction/twig-static)

## Usage

Add the filter to Twig:
```php
$twig->addFilter('static', new Twig_Filter_Function(
    create_static_filter('path/to/assets/', '/url/to/prepend/')
));
```

Then pass paths to the filter in your templates:
```twig
{{ 'js/app.bundle.js' | static }}
{# /url/to/prepend/js/app.bundle.js?v=1a2b3c4 #}
```

## API

`create_static_filter(sting $asset_root, string $asset_url): function`
- `$asset_root`: a relative path from the app root to the assets root dir
- `$asset_url`: a path to prepend to the returned url
