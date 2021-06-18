# Discog PHP Client

[!![Packagist Version](https://img.shields.io/packagist/v/xyrotech/orin)](https://packagist.org/packages/xyrotech/orin)
[![Tests](https://github.com/xyrotech/orin/actions/workflows/run-tests.yml/badge.svg)](https://github.com/xyrotech/orin/actions/workflows/run-tests.yml)
[![Check & fix styling](https://github.com/xyrotech/orin/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/xyrotech/orin/actions/workflows/php-cs-fixer.yml)
[![Psalm](https://github.com/xyrotech/orin/actions/workflows/psalm.yml/badge.svg?branch=main)](https://github.com/xyrotech/orin/actions/workflows/psalm.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/xyrotech/orin.svg?style=flat-square)](https://packagist.org/packages/xyrotech/orin)

Orin is a Discogs API PHP client library which utilizes GuzzleHttp.

[:books: Documentation](https://xyrotech.github.io/orin/)

## Installation
You can install the package via composer: 

```bash
composer require xyrotech/orin
```

## Usage

Mimic the orin_config.test.php file in src directory, and fill out relevant fields for high tier rate limiting.

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

Clone the repository and install dependencies:

```bash
git clone https://github.com/xyrotech/orin.git && composer install
```

Update <code>/tests/configs/config.test.php</code> with your own authentication. Be sure to change the username and test name at the bottom of the config to match the account information.

```bash
composer test
```
> Orders may not work properly as it would require you to create a listing and buy it using another account to push the order to the "SOLD" status.

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
