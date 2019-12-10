<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class HomesController extends AppController {

	public function index() {
		$homeMenus = [];
		$homeMenus["受注一覧"] = ["controller"=>"","action"=>""];
		$homeMenus["受注新規登録"] = ["controller"=>"Orders","action"=>"add"];
		$homeMenus["商品一覧"] = ["controller"=>"Products","action"=>"index"];
		$homeMenus["商品新規登録"] = ["controller"=>"Products","action"=>"add"];
		$homeMenus["顧客一覧"] = ["controller"=>"Customers","action"=>"index"];
		$homeMenus["顧客新規登録"] = ["controller"=>"Customers","action"=>"add"];
		$this->set(compact("homeMenus"));
	}
}