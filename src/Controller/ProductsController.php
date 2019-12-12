<?php
namespace App\Controller;

use App\Controller\AppController;

class ProductsController extends AppController
{
	public function indexOn()
	{
		date_default_timezone_set('Asia/Tokyo');
		$now = date("Y-m-d H:i:s");
		
		/*$produits = $this->Products->find('all');
		foreach ($produits as $produit){
			$start_date = h($produit->start_date->format("Ymdhi"));
			$end_date = h($produit->end_date->format("Ymdhi"));
			
			if($start_date <= $now){
				$this->Products->updateAll(["status"=>1], ["id" => $produit->id ] );
			}
			if($now > $end_date){
				$this->Products->updateAll(["status"=>2], ["id" => $produit->id ] );
			}
			
		}*/
		$this->Products->updateAll(["status"=>1], ["start_date <=" => $now ] );
		$this->Products->updateAll(["status"=>2], ["end_date <=" => $now ] );
		
		$this->paginate = [
				'limit'	=> 6,
				'contain'	=>	['Bids'],
		];


		$products = $this->paginate($this->Products->find('all')->contain('Bids')->where(['status'=> 1]));

		$this->set(compact('products'));
	}
	public function viewOn($id = null)
	{
		$maxbid = $this->loadModel('Bids')->find()->where(['product_id'=>$id])->max('bid');
		$product = $this->Products
			->get($id, ['contain' => ['Bids']]);
		if(empty($maxbid)){
			$maxbid = $product->start_price;
		}
		$this->set(compact('product','maxbid'));
	}
}


























