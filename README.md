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

$httpClient = new Client('http://api.7digital.com');
$client = new ApiClient($httpClient, '7dbnjtfeujwb');

$track = $client->getTrackService();
$results = $track->search('Queen');
```
