<?php
# Create a channel and show iframe with administrator account
require '../vendor/autoload.php';
require '../config.php';

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