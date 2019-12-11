<?php
namespace App\Controller;

use App\Controller\AppController;

class ProductsController extends AppController
{
	public function indexOn()
	{
		$produits = $this->Products->find('all');
		foreach ($produits as $produit){
			$produit->toArray()["start_date"];
			$p = implode("",$produit);
			var_dump($produit->toArray()["start_date"]);
			
			die;
			
		}
		$username = $this->MyAuth->user();
		$this->paginate = [
				'limit'	=> 6,
				'contain'	=>	['Bids'],
		];


		$products = $this->paginate($this->Products->contain('Bids')->find('all')->where(['status'=> 1]));

		$this->set(compact('products'));
	}
}