<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class HomesController extends AppController {

	public function index() {
		$username = $this->MyAuth->user();
		$this->paginate = [
				'limit'	=> 6,
				'contain'	=>	['Bids']
		];
		$products = $this->paginate($this->loadModel('Products')->find('all')->contain('Bids')->where(['status'=> 1]));
		$id = $username["id"];
		$this->set(compact('products','id'));
	}
}