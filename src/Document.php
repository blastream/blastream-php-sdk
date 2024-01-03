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
    
    public function uploadFromUrl($url){
        $requestUrl = $this->_request_url;
        if($this->_request_url == 'https://api.v2.blastream.com')
            $this->_request_url = 'https://docs.v2.blastream.com';
        $res = $this->post('/upload-from-url', [
            'body' => [            
                'url' => $url
            ],
        ]);
        $this->_request_url = $requestUrl;
        return $res;
    }

    public function getFiles(){        
        return $this->get('/files');
    }

    public function updateFile($documentId, $name){        
        return $this->post('/document/' . $documentId, [
            'body' => [            
                'name' => $name
            ],
        ]);
    }

    public function removeFile($documentId){        
        return $this->delete('/document/' . $documentId);
    }

}
?>
