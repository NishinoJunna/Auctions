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
		$endbids = $connection
		->execute('select bt.max, bt.user_id, p.name, p.description, bt.bid, p.user_name
					from 
						(select b.user_id, b1.max, b1.product_id, b.bid from
						bids as b
						right join
							(select product_id, max(bid) as max from
							bids
							group by product_id) b1
						on b1.product_id = b.product_id
						and b1.max = b.bid) bt
					inner join
						(select pr.name, pr.description, u.email as user_name, pr.status, pr.id 
						from products as pr
						inner join users as u 
						on u.id = pr.user_id) p
					on bt.product_id = p.id
					where p.status = 2
					and bt.user_id = :user_id
					',["user_id"=>$user['id']])
		->fetchAll('assoc');
		
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
		
		$this->paginate = ['limit'=>10,'contain'=>['Users','Products'],
				'order'=>['product_id'=>'desc','created'=>'desc']];
		$histories = $this->paginate($this->Bids->find('all')
				->where(['Bids.product_id'=>$id]));
		$this->set(compact('bid','product','max','histories'));
	}
	
	public function getmaxajax(){
		$this->autoRender = false;
		$result = [];
		$bidding = [];
		$maxs = 0;
			
		$user_id=$this->MyAuth->user('id');
		$bid = $this->Bids->newEntity();
		$product_id = $this->request->data['product_id'];
		$max = $this->Bids->find()->where(['product_id'=>$product_id])->max('bid');
		
		if($this->request->is(['ajax'])){
			if($this->request->data['bid'] > $max['bid']){
				$bid->bid = $this->request->data['bid'];
				$bid->product_id = $product_id;
				$bid->user_id = $user_id;
				if($this->Bids->save($bid)){
					$result['status']="success";
					//$bidding = $this->request->data['bid'];
					//$maxs = 0;
					echo json_encode($result);
					return;
				}else{
					$result['errors']=$bids->errors();
				}
			}elseif($this->request->data['bid']<=$max['bid']){
				$result['status']="less";
				//$bidding = $this->request->data['bid'];
				//$maxs =$max['bid'];
						
				echo json_encode($result);
				return;
		
			}
		}
 		$result['status']="error";
 		echo json_encode($result);
		return;
	}
}
