<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use \Exception;
use Cake\Datasource\ConnectionManager;


class BidsController extends AppController{
	public function historyIndex(){
		$user=$this->MyAuth->user();
		$this->paginate = ['limit'=>10,'contain'=>['Users','Products'],
				'order'=>['created'=>'desc','product_id'=>'desc']];
		$bids = $this->paginate($this->Bids->find('all')
											->where(['Bids.user_id'=>$user['id']])
											->andWhere(['status'=>1]));
		$connection = ConnectionManager::get('default');
		//入札の最大値をとる
		$endbids = $connection
		->execute('select bt.max, bt.user_id, p.name, p.description, bt.bid, p.user_name, bt.created
					from 
						(select b.user_id, b1.max, b1.product_id, b.bid, b.created from
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
		$user_id=$this->MyAuth->user('id');
		$bid = $this->Bids->newEntity();
		$this->loadModel('Products');			
		try{
			$product = $this->Products->get($id);
			
			if($product['user_id'] == $user_id){
				throw new Exception();
			}
			$maxbid = $this->Bids->find()->where(['product_id'=>$id])->max('bid');
			if(isset($maxbid)){
				$max = $maxbid['bid'];
			}else{
				$max = $product['start_price'];	
			}
			$this->paginate = ['limit'=>10,'contain'=>['Users','Products'],
					'order'=>['created'=>'desc']];
			$histories = $this->paginate($this->Bids->find('all')->contain('Users')
					->where(['Bids.product_id'=>$id]));
			$this->set(compact('bid','product','max','histories'));
		}catch(Exception $e){
			$this->Flash->error(__("自分の商品、もしくは不正なIDです"));
			return $this->redirect(["controller"=>"Homes"]);
		}
	}
	
	public function getmaxajax(){
		date_default_timezone_set('Asia/Tokyo');
		
		$this->autoRender = false;
		$result = [];
			
		$user_id=$this->MyAuth->user('id');
		$bid = $this->Bids->newEntity();
		$product_id = $this->request->data['product_id'];
		$max = $this->Bids->find()->where(['product_id'=>$product_id])->max('bid');
		$product = $this->Bids->Products->get($product_id);
		
		if($this->request->is(['ajax'])){
			if($this->request->data['bid'] > $max['bid']){
				$bid->bid = $this->request->data['bid'];
				$bid->product_id = $product_id;
				$bid->user_id = $user_id;
				if($this->Bids->save($bid)){
					$bidsdata = $this->Bids->find('all')->contain('Users')
														->where(['product_id'=>$product_id])
														->order(["Bids.created"=>"desc"])
														->limit(10);
					$result['status']="success";
					foreach($bidsdata as $biddata){
						$result['bid'][]=number_format($biddata->bid);
						$result['email'][]=$biddata->user->email;
						$result['created'][]=h($biddata->created->format("Y年m月d日H時i分"));
					}
					echo json_encode($result);
					return;
				}else{
					$result['errors']=$bids->errors();
				}
			}elseif($this->request->data['bid']<=$max['bid']){
				$bidsdata = $this->Bids->find('all')->contain('Users')
													->where(['product_id'=>$product_id])
													->order(["Bids.created"=>"desc"])
													->limit(10);
				$result['status']="less";
				$result['max']=number_format($max['bid']);
				foreach($bidsdata as $biddata){
					$result['bid'][]=number_format($biddata->bid);
					$result['email'][]=$biddata->user->email;
					$result['created'][]=h($biddata->created->format("Y年m月d日H時i分"));
				}
				echo json_encode($result);
				return;
		
			}
		}
 		$result['status']="error";
 		echo json_encode($result);
		return;
	}
}
