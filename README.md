# Discog PHP Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/xyrotech/orin.svg?style=flat-square)](https://packagist.org/packages/xyrotech/orin)
[![Tests](https://github.com/xyrotech/orin/actions/workflows/run-tests.yml/badge.svg)](https://github.com/xyrotech/orin/actions/workflows/run-tests.yml)
[![Check & fix styling](https://github.com/xyrotech/orin/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/xyrotech/orin/actions/workflows/php-cs-fixer.yml)
[![Psalm](https://github.com/xyrotech/orin/actions/workflows/psalm.yml/badge.svg?branch=main)](https://github.com/xyrotech/orin/actions/workflows/psalm.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/xyrotech/orin.svg?style=flat-square)](https://packagist.org/packages/xyrotech/orin)

This is where your description should go. Try and limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require xyrotech/orin
```

## Usage

Mimic the config.test.php file in src directory, and fill out relevant fields for high tier rate limiting.

```php
$config = include('orin_config.php');

$discog = new Xyrotech\Orin($config);

$artist = $discog->artist(45);

echo $artist->name;
```

### Output
```php
'Aphex Twin'
```

This library follows the [API Documentation](https://www.discogs.com/developers) heavily. All endpoints have a corresponding methods. i.e.  [All Label Release](https://www.discogs.com/developers/#page:database,header:database-all-label-releases) would have the equivalent method below

```php
$config = include('orin_config.php');

$discog = new Xyrotech\Orin($config);

$label = $discog->all_label_releases(1);

var_dump($label->releases); // An array of label releases
```
## Testing

```bash
composer test
```

```bash
composer format
```

```bash
composer psalm
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Adekunle Adelakun](https://github.com/kunli0)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
