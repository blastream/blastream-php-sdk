<?php
namespace Blastream;

trait Document
{
    
    public function uploadPic($name, $file = false) {
        if($file === false) {
            $file = $name;
            $name = basename($file);
        }
        return $this->post('/broadcaster/upload/pic', [
            'file' => $file,
            'name' => $name
        ]);
    }

}
?>