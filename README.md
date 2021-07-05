
# Blastream

All URIs are relative to *https://api.v2.blastream.com/api-docs*

# Create a channel
> createOrGetChannel($slug)

Create a channel with admin account and show iframe insterface

### Example

```
composer require blastream/php-sdk

```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 

try {
    $channel = $blastream->createOrGetChannel('yooo')
	$channel->getIframe(800, 600);
} catch (Exception $e) {
    echo 'Exception when calling PetApi->addPet: ', $e->getMessage(), PHP_EOL;
}

?>
```



