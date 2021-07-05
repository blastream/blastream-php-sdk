<?php
#require('Entreprise.php');
#require('Channel.php');
#require('Document.php');
#require('Collaborators.php');

namespace Blastream;

class Instance
{
    use Entreprise;
    use Channel;
    use Document;
    use Collaborators;
    
    private $_request_url = 'https://api.man.invaders.stream';
    
    private $_app_url = 'app.v2.blastream.com';

    private $_publick_key;

    private $_private_key;

    private $_token = false;

    private $_channel_url;

    private $_embed = 1;
    
    private $_whitelabel_url = false;

    //constructeur
    public function __construct($_publick_key, $_private_key, $custom_domain = '') {
        $this->_publick_key = $_publick_key;
        $this->_private_key = $_private_key;
        if ($custom_domain != '')
        {
            $this->_whitelabel_url = $custom_domain;
        }
    }
    
    public function getPublickKey() {
        return $this->_publick_key;
    }
    
    public function setUrlRequest($url) {
        $this->_request_url = $url;
    }
    
    protected function curl($url, $params = []) {

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->_request_url . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        if ($params['method'] == 'POST') 
            curl_setopt($ch, CURLOPT_POST, 1);
        
        if ($params['method'] == 'PUT') 
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
         
        if ($params['method'] == 'DELETE') 
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            
        if (isset($params['body'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params['body']));
        }
        
        $headers = array();
        
        if (isset($params['file'])) {
            $params['json'] = false;
            $headers[] = 'Content-Type: multipart/form-data';
            curl_setopt($ch, CURLOPT_POSTFIELDS, ['file' => new CURLFile( $params['file'], mime_content_type($params['file']), $params['name'])]);
        }
        
        if (!isset($params['json']) || $params['json'] != false) 
            $headers[] = 'Content-Type: application/json';
        
        if (strpos($url, '/entreprise') === 0) {
            $headers[] = 'X-Api-Public: ' . $this->_publick_key;
            $headers[] = 'X-Api-Private: ' . $this->_private_key;
        }
        else {
            if($this->_token == false)
                $this->thowException('token is not initialized, please createOrGetChannel before');
            $headers[] = 'X-Auth-Token: ' . $this->_token;
        }
        
        
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch))
        {
            $this->thowException('Error:' . curl_error($ch));
        }
        
        $info = curl_getinfo($ch);
        
        if($info['http_code'] != 200)
            $this->thowException(json_decode($result)->error);

        curl_close($ch);
        return json_decode($result, true);
    }
    
    public function get($url, $params = []) {
        $params['method'] = 'GET';
        return $this->curl($url, $params);
    }
    
    public function post($url, $params = []) {
        $params['method'] = 'POST';
        return $this->curl($url, $params);
    }
    
    public function put($url, $params = []) {
        $params['method'] = 'PUT';
        return $this->curl($url, $params);
    }
    
    public function delete($url, $params = []) {
        $params['method'] = 'DELETE';
        return $this->curl($url, $params);
    }
    
    public function thowException($error) {
        throw new Exception($error);
    }
    
    
    
    /******* NEW REQUEST TOKEN END *******/

    public function getIframe($width, $height, $params = []) {
        
        $url;
        if(!isset($params['url']))
            $url = $this->getUrl();
        else {
            $url = $params['url'];
            unset($params['url']);
        }
        
        $style = '';
        if(isset($params['style'])) {
            $style = $params['style'];
            unset($params['style']);
        }
        
        $params = array_merge($params, [
            'embed' => 1
        ]);
        
        $url .= '&' . http_build_query($params);

        $htmlFrame = '<iframe allow="microphone; camera; display-capture" width="'.$width.'" height="'.$height.'" src="' . $url . '" frameborder="0" scrolling="no" allowFullScreen="true" style="' . $style . '" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>';

        return $htmlFrame;
    }

    public function getUrl() {
        $url = $this->_channel_url;
        if ($this->_whitelabel_url) $url = str_replace($this->_app_url, $this->_whitelabel_url, $url);
        return $url . '?token=' . $this->_token . '&api=' . $this->_publick_key;
    }
    
}
?>
