
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
$iframe = $channel->getIframe(800, 600, [
    'username' => 'admin username'
]);
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
$colaborator = $channel->createOrGetCollaborator('Collaborator Username', 'moderator'); //The collaborator username is unique for a channel
$iframe = $colaborator->getIframe(800, 600, [
    'username' => 'Username updated' //you can override nickname with username iframe parameters
]);
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
    'username' => 'my username', 
    'auto_join' => 1
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
#### Update a collaborator
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
$colaborator = $channel->createOrGetCollaborator('Collaborator Username', 'moderator'); 
$colaborator->update('New username', 'animator');

?>    
```
#### Update custom design of a channel
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
$upload = $channel->uploadPic(IMAGE_FILE_ABSOLUTE_PATH);
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
#### Update a scene
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
$scenes = $channel->getScenes(); 

//can be 'overlay', 'logo' or 'background'
$upload = $channel->uploadScenePic('overlay', IMAGE_FILE_ABSOLUTE_PATH);
foreach($scenes as $scene) {
    if($scene->isDefault()) {
        $scene->update([
            'overlay' => [
                'src' => $upload['file'],
                'play' => true
            ],
            'background' => [
                'color' => '#ff0000'
            ]
        ]);
    }
}


?>    
```