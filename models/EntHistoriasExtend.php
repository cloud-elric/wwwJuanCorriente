<?php

namespace app\models;

use Yii;

class EntHistoriasExtend extends \yii\db\ActiveRecord {
	
	/**
	 * Busca una historia por su token
	 * 
	 * @param unknown $token        	
	 * @return boolean|EntHistorias
	 */
	public static function getHistoriaByToken($token) {
		$historia = EntHistorias::find ()->where ( [ 
				'txt_token' => $token,
				'b_habilitado' => 1 
		] )->one ();
		
		if (empty ( $historia )) {
			return '';
		}
		
		return $historia;
	}
}
