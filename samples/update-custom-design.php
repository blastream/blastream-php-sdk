<?php
# Update custom design of a channel
require '../vendor/autoload.php';
require '../config.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
$upload = $channel->uploadPic(IMAGE_FILE_ABSOLUTE_PATH);
$channel->setCustom([
    "colors"=>  [
      "#ff0000",
      "#ff0000",
      "#ff0000",
      "#ff0000"
    ],
    "logo" => $upload['file']
]);
?>