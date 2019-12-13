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
		$products = $this->paginate($this
				->Products
				->find('all',['order' =>['Products.created' => 'DESC'] ])
				->contain('Users')
				->where(['user_id'=>$username["id"]]));
				
		$this->set(compact('products','endBid'));
	}

	public function add()
	{
		date_default_timezone_set('Asia/Tokyo');

		$username = $this->MyAuth->user();
		$product = $this->Products->newEntity();
		if ($this->request->is('post')){
			$product->user_id = $username["id"];
			$p = $this->request->data;
			
			$start_date = $p["start_date"];
			$end_date = $p["end_date"];
			$start_date = implode("",$start_date);
			$end_date = implode("",$end_date);
			
			if($end_date < $start_date){
				$this->Flash->error(__('開始日時が終了日時より前に設定できません'));
				return $this->redirect(['action' => 'index']);
			}
			
			$end_date = $p["end_date"];
			$end_date = implode("-",$end_date);
			$end_date = substr($end_date, 0, -6);
			$end_date = new \DateTime($end_date);
			$now = date("Y-m-d");
			$now = new \DateTime($now);
			$interval = date_diff($now,$end_date);
			$rest = $interval->format('%a');
			
			if($rest > 30){
				$this->Flash->error(__('開催期間は最長一月です。'));
				return $this->redirect(['action' => 'index']);;
			}
			
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


	public function edit($id = null)
	{
		//date_default_timezone_set('Asia/Tokyo');
		$username = $this->MyAuth->user();
		
		$product = $this->Products->get($id, [
				'contain'	=> []
		]);
		//$start = $this->Products->find()->where(['status'=>1])->andWhere(['id'=> $id])->toArray();
		$startBid = $this->Products->find()->contain('Bids')->where(['status'=>1])->andWhere(['id'=> $id])->toArray();
		
		$endBid = $this->Products->find()->contain('Bids')->where(['status'=>2])->andWhere(['id'=> $id])->toArray();
		if(!empty($endBid)){
			$this->Flash->error(__('オークション終了した商品です'));
			return $this->redirect(['action' => 'index']);
		}
		$activBid = $this->loadModel('Bids')->find()->contain('Products')->where(['Products.status'=>1])->andWhere(['product_id'=> $id])->toArray();
		
		if($this->request->is(['patch', 'post', 'put'])){
			//$product->user_id = $username["id"];
			$product = $this->Products->patchEntity($product, $this->request->data);
			if($this->Products->save($product)){
				$this->Flash->success(__('商品を更新しました'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('商品の更新に失敗しました'));
		}
		$this->set(compact('product','startBid','activBid'));

	}

	public function indexOn($id = null){
		$this->paginate = [
				'limit'	=> 10,
				'contain'	=>	['Users'],
		];
		$bids = $this->paginate($this->Products->Bids->find()->contain(["Users","Products"])
								->where(['product_id'=>$id])
								->andWhere(['Products.status'=>1])
								->order(["Bids.created"=>"desc"]));
		
		$this->set(compact('bids'));
		
	}
	
	public function indexOff($id = null){
		$this->paginate = [
				'limit'	=> 10,
				'contain'	=>	['Users'],
		];
		$bids = $this->paginate($this->Products->Bids->find()->contain(["Users","Products"])
				->where(['product_id'=>$id])
				->andWhere(['Products.status'=>2])
				->order(["Bids.created"=>"desc"]));
		
		$this->set(compact('bids'));

	}
	
	/*public function edit($id = null)
	{
		date_default_timezone_set('Asia/Tokyo');
		$username = $this->MyAuth->user();
		
		$product = $this->Products->get($id, [
				'contain'	=> []
		]);
		//$start = $this->Products->find()->where(['status'=>1])->andWhere(['id'=> $id])->toArray();
		$startBid = $this->Products->find()->contain('Bids')->where(['status'=>1])->andWhere(['id'=> $id])->toArray();
		
		$endBid = $this->Products->find()->contain('Bids')->where(['status'=>2])->andWhere(['id'=> $id])->toArray();
		if(!empty($endBid)){
			$this->Flash->error(__('オークション終了した商品です'));
			return $this->redirect(['action' => 'index']);
		}
		$activBid = $this->loadModel('Bids')->find()->contain('Products')->where(['Products.status'=>1])->andWhere(['product_id'=> $id]);
		
		if($this->request->is(['patch', 'post', 'put'])){
			//$product->user_id = $username["id"];
			$product = $this->Produtcs->patchEntity($product, $this->request->data);
			if($this->Products->save($product)){
				$this->Flash->success(__('商品を更新しました'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('商品の更新に失敗しました'));
		}
		$this->set(compact('product','startBid'));

	}*/
}

























