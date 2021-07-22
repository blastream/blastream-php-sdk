<?php
# Update a scene
require '../vendor/autoload.php';
require '../config.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
$channel = $blastream->createOrGetChannel('my-channel');
$scenes = $channel->getScenes(); 

//can be 'overlay', 'logo' or 'background'
$upload = $channel->uploadScenePic('overlay', IMAGE_FILE_ABSOLUTE_PATH);
foreach($scenes as $scene) {
    if($scene->isDefault()) {
        $scene->update([
            'overlay' => [
                'src' => $upload['file'],
                'play' => true
            ],
            'background' => [
                'color' => '#ff0000'
            ]
        ]);
    }
}


?>    