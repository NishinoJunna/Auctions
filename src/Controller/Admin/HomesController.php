<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Datasource\ConnectionManager;

class HomesController extends AppController {

	public function index() {
		$username = $this->MyAuth->user();
		$this->paginate = [
				'limit'	=> 6,
				'contain'	=>	['Bids']
		];
		$products = $this->paginate($this->loadModel('Products')->find('all')->contain('Bids')->where(['status'=> 1]));
		$id = $username["id"];
		$connection = ConnectionManager::get('default');
		$max_price = $connection
		->execute('select p.id, case max(bid) is null when 1 then p.start_price else max(bid) end max
					from bids as b 
					right join products as p
					on b.product_id = p.id 
					where p.status = 1
					group by product_id')
		->fetchAll('assoc');
		
		//var_dump($max_price);exit;
				
		$this->set(compact('products','id','max_price'));
	}
}