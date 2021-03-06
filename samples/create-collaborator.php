<?php
# Create a collaborator
require '../vendor/autoload.php';
require '../config.php';

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