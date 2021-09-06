<?php
namespace Blastream;

class Scene {
    
    public function __construct($data, $instance) {
        $this->_data = $data;
        $this->_instance = $instance;
    }
    
    public function update($data) {
        $res = $this->_instance->post('/channel/scene/' . $this->_data['id'], [
            'body' => [
                'data' => $data
            ]
        ]);
        $this->_data = $res;
    }
    
    public function getData() {
        return $this->_data;
    }
    
    public function isDefault() {
        return $this->_data['default_scene'];
    }
    
    public function remove($id, $data) {
        $this->_instance->delete('/channel/scene/' . $this->_data['id']);
    }
    
}

trait Scenes {
    
    public function createScene($name, $data) {
        if($this->isV1())
            return;
        $data['name'] = $name;
        return new Scene($this->put('/channel/scene', [
            'body' => [
                'data' => $data
            ]
        ]), $this);
    }
    
    public function getScenes() {
        if($this->isV1())
            return [];
        $list = $this->get('/channel/scenes');
        $scenes = [];
        foreach($list['list'] as $scene) {
            $scenes[] = new Scene($scene, $this);
        }
        return $scenes;
    }
    
    public function getScene($id) {
        if($this->isV1())
            return;
        $scene = $this->get('/channel/scene/' . $id);
        return new Scene($scene, $this);;
    }
    
    public function uploadScenePic($type, $file) {
        if($this->isV1())
            return;
        $res = $this->post('/broadcaster/upload/' . $type, [
            'file' => $file,
            'name'=> basename($file)
        ]);
        $res['file'] = './docs' . $res['file'];
        return $res;
    }
    
    
    
}
?>