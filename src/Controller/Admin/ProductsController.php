<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class ProductsController extends AppController
{
	public function index()
	{
		$username = $this->MyAuth->user();
		$this->paginate = [
				'limit'	=> 6,
				'contain'	=>	['Users'],
		];


		$products = $this->paginate($this->Products->find('all')->contain('Users')->where(['user_id'=>$username["id"]]));

		$this->set(compact('products'));
	}

	public function add()
	{
		date_default_timezone_set('Asia/Tokyo');

		$username = $this->MyAuth->user();
		$product = $this->Products->newEntity();
		if ($this->request->is('post')){
			$product->user_id = $username["id"];
			/*$start_date = $this->request->data->start_date;
			$end_date = $this->request->data->end_date;
			if($end_date < $start_date){
				$this->Flash->error(__('開始日'));
				return;
			}*/
			$product = $this->Products->patchEntity($product, $this->request->data);
			if($this->Products->save($product)){

				$this->Flash->success(__('商品を新規登録しました'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('商品の新規登録に失敗しました'));
		}
		$this->set(compact('product'));
	}

	public function viewOn(){
		$user = $this->MyAuth->user();
		$this->paginate = [
				'limit'	=> 6,
				'contain'	=>	['Users'],
		];
		$products = $this->paginate($this->Products->find()
								->where(['user_id'=>$user['id']])
								->andWhere(['status'=>1]));
		$this->set(compact('products'));
	}
	
	public function viewOff(){
		$user = $this->MyAuth->user();
		$this->paginate = [
				'limit'	=> 6,
				'contain'	=>	['Users'],
		];
		$products = $this->paginate($this->Products->find()
				->where(['user_id'=>$user['id']])
				->andWhere(['status'=>2]));
		$this->set(compact('products'));
	}
}

























