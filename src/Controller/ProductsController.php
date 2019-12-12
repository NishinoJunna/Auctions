<?php
namespace App\Controller;

use App\Controller\AppController;

class ProductsController extends AppController
{
	public function indexOn()
	{
		$now = date("YmdHi");
		
		$produits = $this->Products->find('all');
		foreach ($produits as $produit){
			$start_date = h($produit->start_date->format("Ymdhi"));
			$end_date = h($produit->end_date->format("Ymdhi"));
			
			if($start_date <= $now){
				$this->Products->updateAll(["status"=>1], ["id" => $produit->id ] );
			}
			if($now > $end_date){
				$this->Products->updateAll(["status"=>2], ["id" => $produit->id ] );
			}
			
		}
		
		$this->paginate = [
				'limit'	=> 6,
				'contain'	=>	[],
		];


		$products = $this->paginate($this->Products->find('all')->where(['status'=> 1]));

		$this->set(compact('products'));
	}
}