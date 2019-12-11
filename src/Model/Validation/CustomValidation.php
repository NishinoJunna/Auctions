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
		date_default_timezone_set('Asia/Tokyo');
		$now = date("YmdHi");
		$value = implode("",$value);
		if( $now === $value || $now > $value ){
			return false;
		}
		return true;
	}
}