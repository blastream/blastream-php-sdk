<?php
# Register a hook url to notified when a new replay is available
require '../vendor/autoload.php';
require '../config.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
try {
    $blastream->registerHook('https://http.jay.invaders.stream/hook_from_blastream.php');
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}

?>    