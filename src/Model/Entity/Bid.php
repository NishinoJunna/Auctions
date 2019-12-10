<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Bid extends Entity {

	protected $_accessible = [
			'*' => true,
			'id' => false
	];
	
}