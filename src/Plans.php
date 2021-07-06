<?php
namespace Blastream;


trait Plans
{
    public function getPlans() {
        return $this->get('/plans');
    }
}