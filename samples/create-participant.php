<?php
# Create a participant
require '../vendor/autoload.php';
require '../config.php';

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