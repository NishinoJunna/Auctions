<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

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
			
			$start_date = $p["start_date"];
			$end_date = $p["end_date"];
			$end_date = implode("-",$end_date);
			$end_date = substr($end_date, 0, -6);
			$start_date = implode("-",$start_date);
			$start_date = substr($start_date, 0, -6);
			$end_date = new \DateTime($end_date);
			$start_date = new \DateTime($start_date);
			$interval = date_diff($start_date,$end_date);
			$rest = $interval->format('%a');
			
			if($rest > 30){
				$this->Flash->error(__('開催期間は最長一月です。'));
				return $this->redirect(['action' => 'index']);;
			}
			
			/*//保存先のパスを保存、WWW_ROOT はwebrootを示します。
			$path = WWW_ROOT . "upimg/";
			
			//アップロードしたファイルの一時的なパスを取得します
			$img = $p["image"]["name"];
			
			$img = explode(".", $img);
			$fname = $img[0];
			//var_dump($_FILES['image']); die();
			
			//現在ある記事のidの最大値を取得します
			$box = $this->Products->find('All', ['order' =>['Products.id' => 'DESC']])->first()->toArray();
			
			
			$id = $box["id"];
			//今回追加する記事番号にします
			$id++;
			$new_file_name = $fname . $id . "." . "jpg";
			$to_path = $path . $fname . $id . "." . "jpg";
			
			
			
			//画像のフォルダとファイル名を指定して保存します
			if(!move_uploaded_file($_FILES['image']['tmp_name'], $to_path)) {
				$this->Flash->error(__('画像ファイル保存できませんでした'));
				return $this->redirect(array('action' => 'index'));
			}
			
			//DB保存用にファイル名を保存します
			if ($file_name != '') {
			
				if (move_uploaded_file($_FILES['ufile']['tmp_name'], $to_path)) {
					echo "Successful<BR/>";
			
			
					echo "File Name :" . $new_file_name . "<BR/>";
					echo "File Size :" . $_FILES['ufile']['size'] . "<BR/>";
					echo "File Type :" . $_FILES['ufile']['type'] . "<BR/>";
				} else {
					echo "Error";
				}
			} */
				
			
			
			
			
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
		$max = $this->Products->Bids->find()->contain(["Users","Products"])
				->where(['product_id'=>$id])
				->andWhere(['Products.status'=>2])
				->max('bid');
		$maxbid = $max['bid'];
		$this->set(compact('bids','maxbid'));

	}

}

























