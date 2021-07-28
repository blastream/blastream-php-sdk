<?php
namespace Blastream;

class Channel extends Instance {
    
    use Document;
    use Collaborators;
    use Scenes;
    
    protected $_is_channel = true;
    
    public function setSlug($slug) {
        $this->_slug = $slug;
    }
    
    public function setAccessRule($privacy, $params = []) {
        if($privacy == 'PRIVATE')
            $privacy = 2;
        if($privacy == 'PUBLIC')
            $privacy = 0;
        return $this->put('/channel/rule', [
            'body' => [
                'privacy' => $privacy,
                'data' => $params
            ]
        ]);
    }
    
    public function createOrRefreshSpeakersToken() {
        return $this->put('/channel/speakers-token');
    }
    
    public function removeSpeakersToken() {
        return $this->delete('/channel/speakers-token');
    }
    
    public function getSpeakersToken() {
        return $this->get('/channel/speakers-token');
    }
    
    public function updateSettings($params) {
        return $this->post('/channel/settings', [
            'body' => [
                'data' => $params
            ]
        ]);
    }
    
    public function updateSubscription($plan, $billing) {
        return $this->post('/channel/subscription', [
            'body' => [
                'plan' => $plan,
                'billing' => $billing
            ]
        ]);
    }
    
    public function setCustom($params = []) {
        return $this->post('/channel/custom', [
            'body' => [
                'data' => $params
            ]
        ]);
    }
    
    public function removeCustom($params = []) {
        return $this->delete('/channel/custom');
    }
    
    public function disconnectAll() {
        return $this->post('/channel/disconnectall');
    }
}
?>