[DEPRECATED] Further development of `croustille-io/twill-image` will be on [area17/twill-image](https://github.com/area17/twill-image).

# Twill Image

Image module for Twill.

- `<picture>` with `<source>`
- Twill's LQIP and background color image placeholder
- Art direction
- WebP and JPEG support
- Lazyload (fade-in) image and video with IntersectionOserver
- Support native lazyloading with `loading='lazy'

## Installation

```
composer require croustille/twill-image
```

Publish `config/images.php`.

```bash
php artisan vendor:publish --provider="Croustille\Image\ImageServiceProvider" --tag=config
```

Publish JavaScript assets for inclusion in frontend bundler.

```bash
php artisan vendor:publish --provider="Croustille\Image\ImageServiceProvider" --tag=js
```

Init lazyloading

```js
import { TwillImage } from '../../vendor/croustille/twill-image'

document.addEventListener('DOMContentLoaded', function () {
  const lazyloading = new TwillImage()
})
```

## Config

Example with a Twill crop `preview_image` defined here:

```php
    // ...
    'crops' => [
        'preview_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 10 / 16,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'landscape',
                    'ratio' => 10 / 16,
                ],
                [
                    'name' => 'portrait',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ],
    // ...
```

In `config/images.php`, defines image profiles and assocates Twill image roles to an image profile.

```php
<?php

return [

    'background_color' => '#e3e3e3',

    'lqip' => true,

    'webp_support' => true,

    'profiles' => [
        'generic_image' => [
            'default_width' => 1000,
            'sizes' => '(max-width: 767px) 100vw, 50vw',
            'sources' => [
                [
                    'crop' => 'mobile',
                    'media_query' => '(max-width: 767px)',
                    'widths' => [250, 500, 1000, 1500, 2000],
                ],
                [
                    // 'crop' => 'default',
                    'media_query' => '(min-width: 768px)',
                    'widths' => [250, 500, 1000, 1500, 2000],
                ]
            ]
        ],
    ],

    'roles' => [
        'preview_image' => 'generic_image',
    ],

];
```

## Usage

```php
{!! TwillImage::fullWidth($block, 'preview_image') !!}
{!! TwillImage::constrained($block, 'preview_image', ['width' => 1000]) !!}
{!! TwillImage::fixed($block, 'preview_image', ['width' => 400]) !!}

@php
// return source data as an array
$data = TwillImage::getSourceData($block, 'preview_image');
@endphp

// output image from source data array
{!! TwillImage::fromData($data) !!} {-- default to 'fullWidth' --}
{!! TwillImage::fromData($data, ['layout' => 'fullWidth', 'sizes' => '(max-width: 400px) 100vw, 50vw']) !!}
{!! TwillImage::fromData($data, ['layout' => 'constrained', 'width' => 400]) !!}
{!! TwillImage::fromData($data, ['layout' => 'fixed', 'width' => 100, 'height' => 150]) !!}
```

## Art direction

To use different images (and/or crops) with media queries, you need to set size and ratio for the sources other than default. An example on how to do this by adding some styles.

Let's say this is your profile sources config:

```php
...
'sources' => [
    [
        'crop' => 'mobile',
        'media_query' => '(max-width: 767px)',
        'widths' => [413, 826, 649, 989, 1299, 1519, 1919],
    ],
    [
        // 'crop' => 'default',
        'media_query' => '(min-width: 768px)',
        'widths' => [989, 1299, 1519, 1919, 2599, 3038],
    ]
],
```

```php
{!! TwillImage::fullWidth($block, 'preview_image', 'default', ['class' => 'art-directed']) !!}
```

Will output:

```html
<div class="twill-image-wrapper art-directed">...</div>
```

```css
@media screen and (max-width: 767px) {
  .art-directed {
    max-height: 400px;
  }
}
```
