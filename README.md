[![Build Status](https://travis-ci.org/gquemener/7digital-client.png)](https://travis-ci.org/gquemener/7digital-client)
[![Latest Stable Version](https://poser.pugx.org/gquemener/7digital-client/v/stable.png)](https://packagist.org/packages/gquemener/7digital-client)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/288367fa-47ff-4743-8528-5fc3d7e89ae6/mini.png)](https://insight.sensiolabs.com/projects/288367fa-47ff-4743-8528-5fc3d7e89ae6)
[![Scrutinizer Continuous Inspections](https://scrutinizer-ci.com/g/gquemener/7digital-client/badges/general.png?s=5433331e2f508458b863be1dea67344a887f4bb6)](https://scrutinizer-ci.com/g/gquemener/7digital-client/)

Installation
============

1. Add the following to your composer.json:

```yml
    "require": {
        "gquemener/7digital-client": "~1.0"
    }
```

2. Update your deps using `composer.phar update --prefer-dist``
3. Start playing!

Usage
=====

```php
<?php

require './vendor/autoload.php';

use SevenDigital\ApiClient;

$client = new ApiClient(/** consumer_key */);

$track = $client->getTrackService(); //Services artist, release and tag are also accessible the same way

$results = $track->search('Queen'); // Use the method name as described in the 7digital api documentation
                                    // (ex: http://api.7digital.com/1.2/static/documentation/7digitalpublicapi.html#track/search)
                                    // Required argument can be passed directly
                                    
$results = $track->search(array( // Other arguments must be passed as a hash
 'q'        => 'Queen',          // Method result will be an instance of \SimpleXMLElement (http://fr2.php.net/simplexmlelement)
 'pageSize' => 1,
));


```

If a method is missing, feel free to [contact me](mailto:gildas.quemener at gmail dot com) or [send a PR](https://github.com/gquemener/7digital-client/compare/).
