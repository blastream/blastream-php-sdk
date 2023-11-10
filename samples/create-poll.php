<?php
# Create a collaborator
require '../vendor/autoload.php';
require '../config.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
try {
    $channel = $blastream->createOrGetChannel('my-channel');
    $poll = [
        "choices"=>[
            ["id"=> 1, "value"=> "A", "color"=> "#FFA900" ],
            ["id"=> 2, "value"=> "B", "color"=> "#3EC59B" ]
        ],
        "format"=> "multiple",
        "publish"=> 1,
        "question"=> "Question",
        "showResults"=> 1
    ];
    $channel->createPool($poll);
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}
?>    