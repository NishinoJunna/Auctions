<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class UsersController extends AppController{

	public function logout(){
		$this->Flash->success("ログアウトしました");
		return $this->redirect($this->MyAuth->logout());
	}

	public function edit(){
		$id=$this->MyAuth->user("id");
		$user=$this->Users->get($id,['contain'=>[]]);
		if($this->request->is(['patch','post','put'])){
			$user=$this->Users->patchEntity($user,$this->request->data);
			if($this->Users->save($user)){
				$this->MyAuth->setUser($user->toArray());
				$this->Flash->success(__('パスワードを変更しました'));
				return $this->redirect(['controller'=>'Homes']);
			}
			$this->Flash->error(__('パスワードの変更に失敗しました'));
		}
		unset($user["password"]);
		$this->set(compact('user'));
	}
}