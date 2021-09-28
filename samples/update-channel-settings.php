<?php
# Update settings of a channel
require '../vendor/autoload.php';
require '../config.php';

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