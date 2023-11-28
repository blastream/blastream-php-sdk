<?php
# Create a collaborator
require '../vendor/autoload.php';
require '../config.php';

use Blastream\Instance as Blastream;

$blastream = new Blastream(PUBLIC_KEY, PRIVATE_KEY); 
try {
    $channel = $blastream->createOrGetChannel('my-channel');
    //INIT MODULE STATE FIRST TIME
    $channel->setBannerModule(1);
    
    $upload = $channel->uploadFromUrl('https://[....].jpg');
    $ban = [
       "name"=> "banner name",
       "title"=>"My awesome banner",
       "text"=> "Lorem ipsum is so cool !",
       "btn" => "KNOW MORE",
       "media_url_live"=> $upload['file'],
       "link"=>"https://www.mywebsite.com",
       "qty_available"=>"50",
       "show_qty"=>true,
       "show_timer"=>true,
       "price"=>"99",
       "show_price"=>true,
       "timer"=>"1200",
       "gong"=>true
    ];
     $res = $channel->createBanner($ban);
     var_dump($res);
}
catch (Exception $e) {
    echo 'Exception intercepted : ',  $e->getMessage(), "\n";
}
?>    