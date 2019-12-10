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
		$this->hasMany('EndBids', [
				'foreignKey'	=>	'product_id'
		]);
	}

	public function validationDefault(Validator $validator)
	{
		$validator
			->integer('id')
			->allowEmpty('id', 'create');
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
							'rule' => ['boolean'],
							'message' => '今日より前の日付はダメ',
					],
			])
			->notEmpty('start_date');
		$validator
			->date('end_date', ['ymd', 'mdy'])
			->requirePresence('end_date', 'create')
			->add('end_date',[
					'date' => [
							'rule' => ['boolean'],
							'message' => '今日より前の日付はダメ',
					],
			])
			->notEmpty('end_date');

		return $validator;
	}
}