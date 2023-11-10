<?php
namespace Blastream;

trait Polls {
    
    public function createPool($params) {
        return $this->post('/poll', [
            'body' => [
                'discussion_id' => 0,
                'poll' => $params
            ]
        ]);
    }
    
    public function updatePoll($id,$data) {
        return($this->post('/poll/' . $id, [
            'body' => [
                'discussion_id' => 0,
                'poll' => $data
            ]
        ]));
    }    
    public function removePoll($id) {
        return($this->delete('/poll/' . $id));
    }
    
    public function publishPoll($id) {
        return($this->post('/poll/' . $id . '/publish'));
    }
    
    public function archivePoll($id) {
        return($this->post('/poll/' . $id . '/archive'));
    }    
    
    public function getPolls($state = ''){
        $uri = '/polls';
        if(in_array($state, ['pending','publish']))
            $uri .= '/' .$state;
        return $this->get($uri);
    }
    
}