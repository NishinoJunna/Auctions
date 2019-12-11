<?php
namespace App\Model\Validation;

use Cake\Validation\Validation;

/**
 * �J�X�^���o���f�[�V�����N���X
 */
class CustomValidation extends Validation
{
	/**
	 * ���[���A�h���X�̃o���f�[�V����
	 * ���{�̌g�уL�����A(docomo, au)�̃h���C���Ɍ���A�A���h�b�g��@���O�̃h�b�g��������
	 * @param string $check
	 * @param bool $deep
	 * @return bool
	 */
	public static function dateCheck($value) {
		date_default_timezone_set('Asia/Tokyo');
		$now = date("YmdHi");
		$value = implode("",$value);
		if( $now === $value || $now > $value ){
			return false;
		}
		return true;
	}
}