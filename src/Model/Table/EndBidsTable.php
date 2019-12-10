<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class EndBidsTable extends Table
{
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->table('EndBids');
		$this->displayField('id');
		$this->primaryKey('id');
		$this->addBehavior('Timestamp');

		$this->belongsTo('Users', [
				'foreignKey'	=>	'user_id',
				'joinType'		=>	'INNER'
		]);
		$this->belongsTo('Products', [
				'foreignKey'	=>	'product_id',
				'joinType'		=>	'INNER'
		]);
	}

	public function validationDefault(Validator $validator)
	{
		
	}

	public function buildRules(RulesChecker $rules)
	{
		$rules->add($rules->existsIn(['product_id'], 'Products'));
		$rules->add($rules->existsIn(['user_id'], 'Users'));
		return $rules;
	}
}