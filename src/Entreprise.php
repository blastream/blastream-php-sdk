<?php
namespace Blastream;

trait Entreprise
{
    
    public function setSlug($slug) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug)));
        if (strlen($slug) > 64 || strlen($slug) < 2) {
            $this.thowException('slug is too long or too short');
        }
        $this->_slug = $slug;
    }
    
    public function createOrGetChannel($slug, $params = []) {
        $this->_slug = $slug;
        
        $result = $this->post('/entreprise/channel/' . $this->_slug, $params);
        $this->setResponseToken($result);
        
        return $this;
    }

    public function createOrGetParticipant($slug, $id, $params = []) {
        $this->setSlug($slug);
        
        if (!$id)
            $this->thowException('identifier_undefined');
        
        $params['id'] = $id;
        
        if(!isset($params['nickname'])) {
            $params['nickname'] = $id;
        }
        
        $result = $this->post('/entreprise/channel/' . $this->_slug . '/participant', [
            'body' => $params
        ]);
        
        $this->setResponseToken($result);
        return $this;
    }
    
    private function setResponseToken($res) {
        $this->_token = $res['token'];
        $this->_channel_url = $res['url'];
    }
    
    public function getToken() {
        return $this->_token;
    }
    
    public function getPlans() {
        return $this->get('/entreprise/plans');
    }
    
    public function revokeToken($token) {
        return $this->post('/entreprise/revoke-token/' . $token);
    }
    
    public function revokeTokens($slug) {
        return $this->post('/entreprise/revoke-tokens/' . $slug);
    }
    
    public function registerHook($url) {
        return $this->post('/entreprise/hook', [
            'body' => [
                'url' => $url
            ]
        ]);
    }
}
?>