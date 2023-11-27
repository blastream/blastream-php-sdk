<?php
namespace Blastream;

trait Banners {
    
    public function createBanner($params) {
       return $this->put('/banner', [
            'body' => [
                'data' => $params
            ]
        ]);
    }
    
    public function getBanners() {
        return $this->get('/banners');
    }    

    public function getBanner($id) {
		return $this->get('/banner/'.$id);
    }
    
    public function updateBanner($id,$data) {
		return $this->post('/banner/'.$id, [
            'body' => [
                'data' => $data
            ]
        ]);
    }

    public function getBannerLogs() {
		return $this->get('/banner/logs');
    }	
   
    public function removeBanner($id) {
		return $this->delete('/banner/'.$id);
    }      
}