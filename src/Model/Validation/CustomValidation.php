<?php
namespace App\Model\Validation;

use Cake\Validation\Validation;

/**
 * カスタムバリデーションクラス
 */
class CustomValidation extends Validation
{
	/**
	 * メールアドレスのバリデーション
	 * 日本の携帯キャリア(docomo, au)のドメインに限り、連続ドットや@直前のドットを許可する
	 * @param string $check
	 * @param bool $deep
	 * @return bool
	 */
	public static function dateCheck($value) {
		$now = date("Y/m/d H:i");
		if( $now  === $value || $now > $value ){
			
			return true;
		}
		return false;
	}
}