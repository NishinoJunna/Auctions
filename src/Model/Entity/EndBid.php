<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class EndBid extends Entity
{
	protected $_accessible = [
			'*'		=> true,
			'id'	=> false
	];
}