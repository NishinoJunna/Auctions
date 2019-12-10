<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class BidsTable extends Table {

	public function initialize(array $config){
		parent::initialize($config);
		$this->table('bids');
		$this->primaryKey('id');
		$this->addBehavior('Timestamp');
		$this->belongsTo('Products',[
				'foreignKey'=>'product_id',
				'joinType' => 'inner'
		]);
		$this->belongsTo('Users',[
				'foreignKey'=>'user_id',
				'joinType'=>'inner'
		]);
	}
	public function validationDefault(Validator $validator){
		$validator
		->integer('id')
		->allowEmpty('id','create');
		$validator
		->requirePresence('bid','create')
		->notEmpty('bid');
		$validator
		->requirePresence('product_id','create')
		->notEmpty('bid');
		$validator
		->requirePresence('user_id','create')
		->notEmpty('user_id');

		return $validator;
	}
	public function buildRules(RulesChecker $rules){
		$rules->add($rules->existsIn(['product_id'],'Products'));
		$rules->add($rules->existsIn(['user_id'],'Users'));
		return $rules;
	}
	
}