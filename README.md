
# Blastream PHP Sdk

All URIs are relative to *https://api.v2.blastream.com/api-docs*

### Install

```
composer require blastream/php-sdk
```

### Examples

#### Create a channel and show iframe with administrator account
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
$iframe = $channel->getIframe(800, 600);
echo $iframe;
?>
```
#### Create a collaborator
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
$colaborator = $channel->createOrGetCollaborator('my-collaborator', 'moderator');
$iframe = $colaborator->getIframe(800, 600);
echo $iframe;
?>    
```
#### Create a participant
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetParticipant('my-channel', 'my-id', [
    'allow_cam' => 1
]);
$iframe = $channel->getIframe(800, 600, [
    'username' => 'toto', 'auto_join' => 1
]);
echo $iframe;
?>    
```
#### Update plan of a channel
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
$channel->updateSubscription('pro2', 'hourly');
?>
```
#### Update settings of a channel
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
$channel->updateSettings([
    'autojoin' => 1
]);
?>
```
#### Update custom design of a channel
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
$upload = $channel->uploadPic(IMAGE_FILE_NAME, IMAGE_FILE_ABSOLUTE_PATH);
$channel->setCustom([
    "colors"=>  [
      "#ff0000",
      "#ff0000",
      "#ff0000",
      "#ff0000"
    ],
    "logo" => $upload['file']
]);
?>
```