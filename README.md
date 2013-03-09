Installation
============

1. Clone this repository
2. Install dependencies with `composer.phar install --prefer-dist`
3. Start playing!

Usage
=====

```php
<?php

require './vendor/autoload.php';

use SevenDigital\ApiClient;
use Guzzle\Http\Client;

$httpClient = new Client('http://api.7digital.com/{version}', array(
    'version' => '1.2'
));
$client = new ApiClient($httpClient, '**consumer_key**');

$track = $client->getTrackService();
$results = $track->search('Queen'); // Will return the api response parsed inside a SimpleXMLElement object
```
