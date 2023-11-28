<?php
namespace Blastream;


trait Space
{
    
    public function initChannel($result) {
        $channel = new Channel($this->_public_key, $this->_private_key, $this->_whitelabel_url);
        $channel->setTimeout($this->_timeout);
        $channel->setRequestUrl($this->_request_url);
        $channel->setSlug($this->_slug);
        $channel->setResponseToken($result);
        $channel->setId($result['id']);
        if(isset($result['justBeenCreated']))
            $channel->setJustBeenCreated($result['justBeenCreated']);
        if(isset($result['prefix']))
            $channel->setApiPrefix($result['prefix']);
        return $channel;
    }
    
    public function setSlug($slug) {
        if(preg_match('/[^a-z\-0-9]/i', $slug)) {
            $this->thowException('this is not a valid slug ! only alphanumeric and "-" character is accepted');
        }
        
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug)));
        if (strlen($slug) > 64 || strlen($slug) < 2) {
            $this->thowException('slug is too long or too short');
        }
        $this->_slug = $slug;
    }
    
    public function createOrGetChannel($slug, $params = []) {
        $this->setSlug($slug);
        
        if($this->isV1()) {
            $params = [
                'body' => [
                    'email' => $slug .'-whitelabel@blastream.com',
                    'nickname' => $slug,
                    'api_user_id' => $slug,
                    'status' => 'broadcaster'
                ]
            ];
            $result = $this->post('/api/token/request', $params);
        }
        else {
            $result = $this->post('/space/channel/' . $this->_slug, [
                'body' => $params
            ]);
        }
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
        
        if($this->isV1()) {
            $params = [
                'body' => [
                    'email' => $id . '-whitelabel@blastream.com',
                    'nickname' => $id,
                    'api_user_id' => $id,
                    'status' => 'member',
                    'channel' => $slug
                ]
            ];
            $result = $this->post('/api/token/request', $params);
        }
        else
            $result = $this->post('/space/channel/' . $this->_slug . '/participant', [
                'body' => $params
            ]);
        
        return $this->initChannel($result);
    }
    
    public function cloneChannel($channelSlugSource, $channelSlugTarget, $params = []) {
        $params['slug'] = $channelSlugTarget;
        return $this->post('/space/channel/' . $channelSlugSource . '/clone', [
            'body' => $params
        ]);
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

    public function getRooms(){
        $uri = '/space/channels';         
        return $this->get($uri);
    }
    
    public function getCurrentLiveRooms(){
        $uri = '/space/channels?liveOnly=1';         
        return $this->get($uri);
    }
}
?>
