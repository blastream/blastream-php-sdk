<?php
# Update a collaborator
require '../vendor/autoload.php';
require '../config.php';

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