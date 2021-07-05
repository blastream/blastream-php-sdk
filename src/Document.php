<?php
namespace Blastream;

trait Document
{
    
    public function uploadPic($name, $file) {
        return $this->post('/broadcaster/upload/pic', [
            'file' => $file,
            'name' => $name
        ]);
    }

}
?>