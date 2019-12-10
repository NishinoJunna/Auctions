<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Bids extends Entity {

	protected $_accessible = [
			'*' => true,
			'id' => false
	];
	
}