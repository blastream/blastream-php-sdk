<?php
# Create a channel and show iframe with administrator account
require '../vendor/autoload.php';
require '../config.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
$iframe = $channel->getIframe(800, 600);
echo $iframe;
?>