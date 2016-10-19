<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\EntCapitulos;
use app\models\CatTiposElementos;

class AdminPanelController extends Controller {
	
	/**
	 * Reglas de acceso
	 *
	 * {@inheritdoc}
	 *
	 * @see \yii\base\Component::behaviors()
	 */
	// public function behaviors() {
	// return [
	// 'access' => [
	// 'class' => AccessControl::className (),
	// 'only' => [
	// 'index',
	// ],
	// 'rules' => [
	// [
	// 'allow' => true,
	// // 'actions' => [
	// // 'logout'
	// // ],
	// 'roles' => [
	// '@'
	// ]
	// ]
	// ]
	// ]
	// ];
	// }
	public function actionIndex($pre) {
		
		echo $pre . md5 ( uniqid ( $pre ) ) . uniqid ();
	}
	public function actionFormularioAgregar() {
		$capitulo = new EntCapitulos ();
		$tiposElementos = CatTiposElementos::find ()->where ( [ 
				'b_habilitado' => 1 
		] )->all ();
		
		return $this->render ( 'agregarCapitulo', [ 
				'capitulo' => $capitulo,
				'tiposElementos'=>$tiposElementos
		] );
	}
	
	/**
	 * Busca la historia por el token
	 *
	 * @param unknown $token        	
	 * @throws NotFoundHttpException
	 * @return boolean|\app\models\EntHistorias
	 */
	private function getHistoriaByToken($token) {
		if (($historia = EntHistoriasExtend::getHistoriaByToken ( $token )) !== null) {
			return $historia;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}