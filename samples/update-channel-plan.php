<?php
# Update plan of a channel
require '../vendor/autoload.php';
require '../config.php';

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