![Alt text](https://raw.githubusercontent.com/algodommedia/bytesviewapi-php/main/bytesview-logo.png)

# <p align="center">BytesView PHP bindings
The BytesView PHP library provides convenient access to the BytesView API from applications written in the PHP language. It includes a pre-defined set of classes for API resources that initialize themselves dynamically from API responses which makes it compatible with a wide range of versions of the BytesView API.

[![License](https://img.shields.io/badge/license-MIT-blue)](https://github.com/algodommedia/bytesviewapi-python/blob/main/LICENSE)

<br />

## Requirements

PHP 7.0 and later.

<br />

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require bytesview/bytesviewapi
```

<br />

## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/algodommedia/bytesviewapi-php/releases). Then, to use the bindings, include the `autoload.php` file.

```php
require_once('/path/to/bytesviewapi-php/autoload.php');
```

<br />

## Dependencies

The bindings require the following extensions in order to work properly:

-   [`curl`](https://secure.php.net/manual/en/book.curl.php), although you can use your own non-cURL client if you prefer
-   [`json`](https://secure.php.net/manual/en/book.json.php)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.

<br />

## Documentation

See the [API docs](https://www.bytesview.com/docs/).

<br />

## Getting Started

### SENTIMENT API

`POST 1.1/static/sentiment`

```
require_once '../autoload.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj = new BytesviewApi(BYTESVIEW_API_KEY);

# Pass your desired strings in an array with unique key
$data = array("key1" => "We are good here","key2" => "this is not what we expect");

$response = $bytesviewapiObj->sentiment_api($data,'en');

```
`BYTESVIEW_API_KEY` : Your private Bytesview API key. 

`data` : You can pass your desired strings in the array format where each string has some unique key. 

`lang` : Pass [ISO code](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes) for the following supported language `English`, `Arabic`, `Turkish`, `Japanese`, `Spanish`, `French`, `German`, `Russian`, `Chinese(simplified)`, `Swedish`, `Czech`, `Danish`, `Greek`, `Korean`, `Latin`, `Hebrew`, `Indonesian`, `Kazakh`, `Armenian`, `Azerbaijani`, `Belarussian`, `Finnish`, `Bulgarian`, `Burmese`, `Persian`, `Portuguese`, `Urdu`, `Vietnamese`, `Thai`, `Hungarian`, `Italian`, `Polish`, `Ukrainian`, `Uzbek`. The default language is english(en).

<br />

### EMOTION API

`POST 1.1/static/emotion`

```
require_once '../autoload.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj = new BytesviewApi(BYTESVIEW_API_KEY);

# Pass your desired strings in an array with unique key
$data = array("key1" => "I am not feeling good","key2" => "happy that you come here");

$response = $bytesviewapiObj->emotion_api($data,'en');

```
`BYTESVIEW_API_KEY` : Your private Bytesview API key. 

`data` : You can pass your desired strings in the array format where each string has some unique key. 

`lang` : Pass [ISO code](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes) for the following supported language `English`, `Arabic`, `Turkish`, `Japanese`, `Spanish`, `French`, `German`, `Russian`, `Chinese(simplified)`, `Swedish`, `Czech`, `Danish`, `Greek`, `Korean`, `Latin`, `Hebrew`, `Indonesian`, `Kazakh`, `Armenian`, `Azerbaijani`, `Belarussian`, `Finnish`, `Bulgarian`, `Burmese`, `Persian`, `Portuguese`, `Urdu`, `Vietnamese`, `Thai`, `Hungarian`, `Italian`, `Polish`, `Ukrainian`, `Uzbek`. The default language is english(en).

<br />

### KEYWORDS API

`POST 1.1/static/keywords`

```
require_once '../autoload.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj = new BytesviewApi(BYTESVIEW_API_KEY);

# Pass your desired strings in an array with unique key
$data =  array("key1" => "Accessories for AirTags appearing online, Apple hasn't announced the tracking fobs");

$response = $bytesviewapiObj->keywords_api($data,'en');

```
`BYTESVIEW_API_KEY` : Your private Bytesview API key. 

`data` : You can pass your desired strings in the array format where each string has some unique key. 

`lang` : Pass [ISO code](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes) for the following supported language `English`, `French`, `Turkish`, `German`, `Japanese`, `Chinese(simplified)`, `Spanish`, `Arabic`, `Russian`, `Italian`, `Danish`. The default language is english(en).

<br />

### SEMANTIC API

`POST 1.1/static/semantic`

```
require_once '../autoload.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj 	=	new BytesviewApi(BYTESVIEW_API_KEY);

# Pass your both strings in an array with unique key
$data	=	array("string1" => "A smiling costumed woman is holding an umbrella.","string2" => "A happy woman in a fairy costume holds an umbrella.");

$response = $bytesviewapiObj->semantic_api($data,'en');

```
`BYTESVIEW_API_KEY` : Your private Bytesview API key. 

`data` : Pass your both strings in the array format with some unique key. 

`lang` : Language Code (English - en), Default language is english(en).

<br />

### NAME-GENDER API

`POST 1.1/static/name-gender`

```
require_once '../autoload.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj = new BytesviewApi(BYTESVIEW_API_KEY);

# Pass your desired names in the array format where each string has some unique key.
$data	=	array("key1" => "alvina","key2" => "نسترن","key3" => "ron","key4" => "rinki","key5" => "オウガ");

$response = $bytesviewapiObj->name_gender_api($data);

```
`BYTESVIEW_API_KEY` : Your private Bytesview API key. 

`data` : You can pass your desired names in the array format where each string has some unique key.

<br />

### NAMED-ENTITY API

`POST 1.1/static/ner`

```
require_once '../autoload.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj = new BytesviewApi(BYTESVIEW_API_KEY);

# Pass your desired strings in an array with unique key
$data = array("key1" => "Mauritania and the IMF agreed Poverty Reduction arrangement");

$response = $bytesviewapiObj->ner_api($data,'en');

```
`BYTESVIEW_API_KEY` : Your private Bytesview API key. 

`data` : You can pass your desired strings in the array format where each string has some unique key. 

`lang` : Language Code (English - en), Default language is english(en).

<br />

### INTENT API

`POST 1.1/static/intent`

```
require_once '../autoload.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj = new BytesviewApi(BYTESVIEW_API_KEY);

# Pass your desired strings in an array with unique key
$data = array("key1" => "Adam Rippon Wins 'Dancing With The Stars' Because It Was Destined");

$response = $bytesviewapiObj->intent_api($data,'en');

```
`BYTESVIEW_API_KEY` : Your private Bytesview API key. 

`data` : You can pass your desired strings in the array format where each string has some unique key. 

`lang` : Language Code (English - en), Default language is english(en).

<br />

### TOPIC API

`POST 1.1/static/topic`

```
require_once '../autoload.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj = new BytesviewApi(BYTESVIEW_API_KEY);

# Pass your desired strings in an array with unique key
$data = array("key1" => "Shriram Automall India Limited is hiring for Accounts Department.");

$response = $bytesviewapiObj->topic_api($data,'en');

```
`BYTESVIEW_API_KEY` : Your private Bytesview API key. 

`data` : You can pass your desired strings in the array format where each string has some unique key. 

`lang` : Language Code (English - en), Default language is english(en).

<br />

### FEATURE API

`POST 1.1/static/feature`

```
require_once '../autoload.php';

use BytesviewApi\BytesviewApi;

$bytesviewapiObj = new BytesviewApi(BYTESVIEW_API_KEY);

# Pass your desired strings in an array with unique key
$data = array("key1" => "This is probably one of the funniest films of the 1980's. Eddie Murphy does a fine job as con man Billy Ray and Dan Ackroyd is great as Louis.");

$response = $bytesviewapiObj->feature_api($data,'en');

```
`BYTESVIEW_API_KEY` : Your private Bytesview API key. 

`data` : You can pass your desired strings in the array format where each string has some unique key. 

`lang` : Language Code (English - en), Default language is english(en).

<br />

## License

Provided under [MIT License](https://github.com/algodommedia/bytesviewapi-python/blob/main/LICENSE) by Matt Lisivick.