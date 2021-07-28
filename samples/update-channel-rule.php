<?php
# Update settings of a channel
require '../vendor/autoload.php';
require '../config.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
//can be PUBLIC or PRIVATE
$channel->setAccessRule('PRIVATE', [
    'knock' => 1 //can be knock or password, if you set password you have to put the password value : password => 'my-password'
]);
?>