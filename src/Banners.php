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
    
    public function setBannerModule($bool){
        return $this->post('/channel/modules', [
            'body' => [
                'modules' => [
                    [
                        'name' => 'banner',
                        'active' => ($bool == 1 ? 1 : 0)
                    ]
                ]
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
	
    public function showBanner($id) {
		return $this->post('/banner/'.$id.'/play');
    }
    
    public function hideBanner($id) {
		return $this->post('/banner/'.$id.'/stop');
    }
    
    public function updateBannerQuantity($id, $qty) {
		return $this->post('/banner/'.$id.'/update_qty', [
            'body' => [
                'new_qty' => $qty
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
