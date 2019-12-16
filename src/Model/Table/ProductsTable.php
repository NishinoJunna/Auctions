<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductsTable extends Table
{
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->table('products');
		$this->displayField('name');
		$this->primaryKey('id');

		$this->addBehavior('Timestamp');

		$this->hasMany('Bids', [
				'foreignKey'	=>	'product_id'
		]);
		$this->belongsTo('Users',[
				'foreignKey'=>'user_id',
				'joinType'=>'inner'
		]);
	}

	public function validationDefault(Validator $validator)
	{
		$validator->provider('upload', \Josegonzalez\Upload\Validation\ImageValidation::class);
		$validator->provider('Custom', 'App\Model\Validation\CustomValidation');
		$validator
		->integer('id')
		->allowEmpty('id', 'create');
		$validator
		->integer('user_id')
		->allowEmpty('user_id', 'create');
		$validator
		->integer('status')
		->allowEmpty('status', 'create');
		$validator
		->requirePresence('name', 'create')
		->notEmpty('name');
		$validator
		->integer('start_price')
		->requirePresence('start_price', 'create')
		->notEmpty('start_price');
		$validator
		->requirePresence('description', 'create')
		->notEmpty('description');
		$validator
		->date('start_date', ['ymd', 'mdy'])
		->requirePresence('start_date', 'create')
		->add('start_date',[
				'date' => [
						'rule' => ['dateCheck'],
						'provider' => 'Custom',
						'message' => '今日より前の日付はダメ',
				],
		])
		->notEmpty('start_date');
		$validator
		->date('end_date', ['ymd', 'mdy'])
		->requirePresence('end_date', 'create')
		->add('end_date',[
				'date' => [
						'rule' => 'dateCheck',
						'provider' => 'Custom',
						'message' => '今日より前の日付はダメ',
				],
		])
		->notEmpty('end_date');
		
		$validator
			->requirePresence('image', 'create')
			->notEmpty('image');
		
		return $validator;
	}
	public function buildRules(RulesChecker $rules){
		$rules->add($rules->existsIn(['user_id'],'Users'));
		return $rules;
	}

}