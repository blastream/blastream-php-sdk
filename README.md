
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
$blastream->setTimeout(6000);
try {
    $channel = $blastream->createOrGetChannel('my-channel');
    $iframe = $channel->getIframe(800, 600, [
        'username' => 'admin username'
    ]);
    echo $iframe;
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}
?>
```
#### Create a collaborator
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
try {
    $channel = $blastream->createOrGetChannel('my-channel');
    $colaborator = $channel->createOrGetCollaborator('alan', 'animator'); //The collaborator username is unique for a channel
    $iframe = $colaborator->getIframe(800, 600);
    echo $iframe;
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}
?>    
```
#### Create a participant
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
try {
    $channel = $blastream->createOrGetParticipant('my-channel', 'my-part');
    $iframe = $channel->getIframe(800, 600);
    echo $iframe;
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}
?>    
```
#### Get replays of a channel
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
try {
    $channel = $blastream->createOrGetChannel('my-channel');
    $list = $channel->getReplays();
    print_r($list);
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}
?>
```
#### Register a hook url to notified when a new replay is available
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
try {
    $blastream->registerHook('https://http.jay.invaders.stream/hook_from_blastream.php');
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}

?>    
```
#### Update plan of a channel
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
try {
    $channel = $blastream->createOrGetChannel('my-channel');
    $channel->updateSubscription('pro2', 'hourly');
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}
?>
```
#### Update access rule of a channel
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
try {
    $channel = $blastream->createOrGetChannel('my-channel');
    //can be PUBLIC or PRIVATE
    $channel->setAccessRule('PRIVATE', [
        'knock' => 1 //can be knock or password, if you set password you have to put the password value : password => 'my-password'
    ]);
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}
?>
```
#### Update settings of a channel
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
try {
    $channel = $blastream->createOrGetChannel('my-channel');
    $channel->updateSettings([
        'autojoin' => 1
    ]);
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}
?>
```
#### Update a collaborator
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
try {
    $channel = $blastream->createOrGetChannel('my-channel');
    $colaborator = $channel->createOrGetCollaborator('Collaborator Username', 'moderator'); 
    $colaborator->update('New username', 'animator');
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}
?>    
```
#### Update custom design of a channel
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
try {
  $channel = $blastream->createOrGetChannel('my-channel');
  $upload = $channel->uploadPic(IMAGE_FILE_ABSOLUTE_PATH);
  $channel->setCustom([
      "colors"=>  [
        "#ff0000",
        "#ff0000",
        "#ff0000",
        "#ff0000"
      ],
      "js" => "alert('ok')",
      "css" => "",
      "logo" => $upload['file']
  ]);
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}
?>
```
#### Update a scene
```php
<?php
require './vendor/autoload.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
try {
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
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}

?>    
```