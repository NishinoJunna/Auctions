<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class HomesController extends AppController {

	public function index() {
		$this->paginate = [
				'limit'	=> 6,
				'contain'	=>	[]
		];
		$products = $this->paginate($this->loadModel('Products')->find('all')->where(['status'=> 1]));
		
		$this->set(compact('products'));
	}
}