<?php
namespace Blastream;

class Collaborator {
    
    public function __construct($data, $instance) {
        $this->_data = $data;
        $this->_instance = $instance;
    }
    
    public function getIframe($width, $height, $params = []) {
        $params['url'] = $this->_data['invite_link'].'?api=' . $this->_instance->getPublickKey();
        return $this->_instance->getIframe($width, $height, $params);
    }
    
    public function getDisplayname() {
        return $this->_data['displayname'];
    }
    
    public function getStatus() {
        return $this->_data['status'];
    }
    
    public function update($displayname, $status, $params = []) {
        $params['displayname'] = $displayname;
        $params['email'] = $this->_data['email'];
        $params['status'] = $status;
        $res = $this->_instance->post('/channel/collaborator/' . $this->_data['token'], [
            'body' => $params
        ]);
        $this->_data = $res;
    }
    
    public function remove() {
        $this->_instance->delete('/channel/collaborator/' . $this->_data['token']);
    }
}

trait Collaborators
{
    
    public function createOrGetCollaborator($displayname, $status, $params = []) {
        $colabs = $this->getCollaborators();
        foreach($colabs as $colab) {
            if($colab->getDisplayname() == $displayname && $colab->getStatus() == $status)
                return $colab;
        }
        return $this->createCollaborator($displayname, $status, $params);
    }
    
    public function createCollaborator($displayname, $status, $params = []) {
        $params['displayname'] = $displayname;
        $params['email'] = $this->slugify($displayname).'-'.time().'@mail.com';
        $params['status'] = $status;
        return new Collaborator($this->put('/channel/collaborator', [
            'body' => $params
        ]), $this);
    }
    
    public function getCollaborators($type = false) {
        if($type == false)
            $list = $this->get('/channel/collaborators');
        else
            $list = $this->get('/channel/collaborators/' . $type);
        
        $colabs = [];
        foreach($list as $colab) {
            $colabs[] = new Collaborator($colab, $this);
        }
        return $colabs;
    }
    
}
?>