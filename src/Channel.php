<?php
namespace Blastream;

class Channel extends Instance {
    
    use Document;
    use Collaborators;
    use Scenes;
    
    protected $_is_channel = true;
    protected $_id = 0;
    protected $_apiPrefix = '';
    protected $_justBeenCreated = false;
    
    public function setSlug($slug) {
        $this->_slug = $slug;
    }
    
    public function setId($id) {
        $this->_id = $id;
    }
    
    public function getId() {
        return $this->_id;
    }
    
    public function setJustBeenCreated($justBeenCreated) {
        $this->_justBeenCreated = $justBeenCreated;
    }
    
    public function hasJustBeenCreated() {
        return $this->_justBeenCreated;
    }
    
    public function setAccessRule($privacy, $params = false) {
        if($params == false)
            $params = new \stdClass();
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
    
    public function getReplays() {
        return $this->get('/channel/videos');
    }
    
    public function getSettings() {
        return $this->get('/channel/settings');
    }
    
    public function updateAdvancedSettings($params) {
        $settings = $this->getSettings();
        foreach($params as $key => $value)
            $settings['advanced'][$key] = $value;
        return $this->updateSettings([
            'advanced' => $settings['advanced']
        ]);
    }
    
    public function updateSettings($params) {
        return $this->post('/channel/settings', [
            'body' => [
                'data' => $params
            ]
        ]);
    }
    
    public function updateChatSettings($params) {
        return $this->post('/chat/settings', [
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
        if($this->isV1()) {
            if(!isset($prams['css']))
                $prams['css'] = '';
            if(!isset($prams['js']))
                $prams['js'] = '';
        }
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
    
    public function sendMessage($params) {
        $this->_is_channel = false;
        $result = $this->post('/api/msg', [
            'body' => [
                'msg' => $params['msg'],
                'username' => $params['username'],
                'slug' => $this->_slug
            ]
        ]);
        $this->_is_channel = true;
        return $result;
    }
    
    public function remove() {
        $this->_is_channel = false;
        $result = $this->delete('/space/' . $this->_slug);
        $this->_is_channel = true;
        return $result;
    }
    
    public function startLivestreaming() {
        return $this->post('/channel/livestreaming/start');
    }
    
    public function stopLivestreaming() {
        return $this->post('/channel/livestreaming/stop');
    }
    
    public function startRecord() {
        return $this->post('/channel/startrecord');
    }
    
    public function stopRecord() {
        return $this->post('/channel/stoprecord');
    }
    
    public function setApiPrefix($prefix) {
        $this->_apiPrefix = $prefix;
    }
    
    public function getApiPrefix() {
        return $this->_apiPrefix;
    }
    
    public function setMode($mode) {
        if($mode == 'vodToLive') {
            $settings = $this->getSettings();
            $settings['advanced']['live_blastream_source'] = 'vod';
            $settings['advanced']['live_proto'] = 'hls';
            $this->updateSettings([
                'advanced' => $settings['advanced'],
                'autojoin' => 0,
                'autolivestream' => 1,
                'allowed_request_cam' => 0
            ]);
        }
        
    }
    
    public function getSession() {
        return $this->get('/live/session?channel_slug=' . $this->_slug);
    }
    
    public function startSession($params = []) {
        $session = $this->getSession();
        return $this->get('/videoconf/' . $this->_id . '/session/' . $session['token'] . '?' . http_build_query($params));
    }
    
    public function stopSession() {
        $slugA = explode('_', $this->_slug);
        return $this->post('/channel/' . $this->_apiPrefix . '_' . $this->_apiPrefix . '_' . $this->_slug . '/stopvisio');
    }

    public function createSimulcast($name, $rtmpUrl, $rtmpKey, $params = []) {
        return $this->put('/simulcast', [
            'body' => [
                'name' => $name,
                'rtmp_url' => $rtmpUrl, 
                'rtmp_key' => $rtmpKey,
                'rtmp_username' => isset($params['rtmp_username']) ? $params['rtmp_username'] : '',
                'rtmp_password' => isset($params['rtmp_password']) ? $params['rtmp_password'] : '',
                'active' => 1,
                'chat' => 0,
                'service' => 'rtmp'
            ]
        ]);
    }
    
    public function deleteSimulcast($simulcastId) {
        return $this->delete('/simulcast/' . $simulcastId);
    }

    public function getStatSessions($start = 0, $limit = 25) {
        return $this->get('/channel/session_stats/?start=' . $start . '&limit=' . $limit);
    }
    
    public function getStatSession($id) {
        return $this->get('/channel/session_stats/' . $id);
    }

    public function publishReplay($replayId) {
        return $this->post('/video/'.$replayId.'/activate');
    }
}
?>
