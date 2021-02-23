# BytesView PHP bindings

The BytesView PHP library provides convenient access to the BytesView API from applications written in the PHP language. It includes a pre-defined set of classes for API resources that initialize themselves dynamically from API responses which makes it compatible with a wide range of versions of the BytesView API.

## Requirements

PHP 5.6.0 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require bytesview/bytesviewapi-php
```

## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/algodommedia/bytesviewapi-php/releases). Then, to use the bindings, include the `autoload.php` file.

```php
require_once('/path/to/bytesviewapi-php/autoload.php');
```

## Dependencies

The bindings require the following extensions in order to work properly:

-   [`curl`](https://secure.php.net/manual/en/book.curl.php), although you can use your own non-cURL client if you prefer
-   [`json`](https://secure.php.net/manual/en/book.json.php)
-   [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) (Multibyte String)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.

## Getting Started



## Documentation

See the [API docs](https://www.bytesview.com/docs/).

