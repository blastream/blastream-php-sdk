<?php
namespace Blastream;


trait Space
{
    
    public function initChannel($result) {
        $channel = new Channel($this->_public_key, $this->_public_key, $this->_whitelabel_url);
        $channel->setRequestUrl($this->_request_url);
        $channel->setSlug($this->_slug);
        $channel->setResponseToken($result);
        return $channel;
    }
    
    public function setSlug($slug) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug)));
        if (strlen($slug) > 64 || strlen($slug) < 2) {
            $this.thowException('slug is too long or too short');
        }
        $this->_slug = $slug;
    }
    
    public function createOrGetChannel($slug, $params = []) {
        $this->_slug = $slug;
        
        $result = $this->post('/space/channel/' . $this->_slug, $params);
        
        return $this->initChannel($result);
    }

    public function createOrGetParticipant($slug, $id, $params = []) {
        $this->setSlug($slug);
        
        if (!$id)
            $this->thowException('identifier_undefined');
        
        $params['id'] = $id;
        
        if(!isset($params['nickname'])) {
            $params['nickname'] = $id;
        }
        
        $result = $this->post('/space/channel/' . $this->_slug . '/participant', [
            'body' => $params
        ]);
        
        return $this->initChannel($result);
    }
    
    private function setResponseToken($res) {
        $this->_token = $res['token'];
        $this->_channel_url = $res['url'];
    }
    
    public function getToken() {
        return $this->_token;
    }
    
    public function revokeToken($token) {
        return $this->post('/space/revoke-token/' . $token);
    }
    
    public function revokeTokens($slug) {
        return $this->post('/space/revoke-tokens/' . $slug);
    }
    
    public function registerHook($url) {
        return $this->post('/space/hook', [
            'body' => [
                'url' => $url
            ]
        ]);
    }
}
?>