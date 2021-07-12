<?php
# Create a collaborator
require '../vendor/autoload.php';
require '../config.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
$colaborator = $channel->createOrGetCollaborator('Collaborator Username', 'moderator'); //The collaborator username is unique for a channel
$iframe = $colaborator->getIframe(800, 600, [
    'username' => 'Username updated' //you can override nickname with username iframe parameters
]);
echo $iframe;
?>    