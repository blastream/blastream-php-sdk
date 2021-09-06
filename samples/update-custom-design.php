<?php
# Update custom design of a channel
require '../vendor/autoload.php';
require '../config.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$blastream->setVersion(1);
$channel = $blastream->createOrGetChannel('my-channelaz');
$upload = $channel->uploadPic(IMAGE_FILE_ABSOLUTE_PATH);
$channel->setCustom([
    "colors"=>  [
      "#ff0000",
      "#ff0000",
      "#ff0000",
      "#ff0000"
    ],
    "js" => "alert('ok')",
    "css" => "",
    "logo" => $upload['file']
]);
?>