<?php
# Create a collaborator
require '../vendor/autoload.php';
require '../config.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
$colaborator = $channel->createOrGetCollaborator('my-collaborator', 'moderator');
$iframe = $colaborator->getIframe(800, 600);
echo $iframe;
?>    