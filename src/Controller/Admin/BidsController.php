<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use \Exception;
use Cake\Datasource\ConnectionManager;


class BidsController extends AppController{
	public function historyIndex(){
		$user=$this->MyAuth->user();
		$this->paginate = ['limit'=>10,'contain'=>['Users','Products'],
				'order'=>['product_id'=>'desc','created'=>'desc']];
		$bids = $this->paginate($this->Bids->find('all')
											->where(['Bids.user_id'=>$user['id']])
											->andWhere(['status'=>1]));
		$connection = ConnectionManager::get('default');
		//入札の最大値をとる
		$max = $connection
		->execute('select max(b.bid), b.user_id, p.name, p.description, b.bid
					from bids as b inner join
					(select pr.name, pr.description, u.email as user_name, pr.status, pr.id 
					from products as pr
					inner join users as u 
					on u.id = pr.user_id) p
					on b.product_id = p.id
					where p.status = 2
					group by product_id')
		->fetchAll('assoc');
		$endbids = array();
		foreach($max as $endbid){
			if($max['user_id']==$user['id']){
				$endbids[] = $endbid;
			}
		}
		$this->set(compact('bids','endbids'));
	}
	
	public function add($id = null){
		//自分の商品には入札できないようにする？
		$user_id=$this->MyAuth->user('id');
		$bid = $this->Bids->newEntity();
		$this->loadModel('Products');
		$product = $this->Products->get($id);
		$maxbid = $this->Bids->find()->where(['product_id'=>$id])->max('bid');
		if(isset($maxbid)){
			$max = $maxbid['bid'];
		}else{
			$max = $product['start_price'];	
		}
		if($this->request->is('post')){
			$data = $this->request->data['bid'];
			if($data > $max){
				$bid->bid = $data;
				$bid->product_id = $id;
				$bid->user_id = $user_id;
				if($this->Bids->save($bid)){
					$this->Flash->success(__('入札しました'));
					return $this->redirect(["controller"=>"Homes"]);
				}
				$this->Flash->error(__('入札に失敗しました'));
			}else{
				$this->Flash->error(__('現在価格より多い額で入札できます'));
			}
		}
		$this->set(compact('bid','product','max'));
	}
	
	public function bidsajax($id = null){
		$max = $this->Bids->find()->where(['product_id'=>$id])->max('bid');
		
	}
}
