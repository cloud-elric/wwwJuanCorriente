<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\EntCapitulos;
use app\models\CatTiposElementos;
use yii\widgets\ActiveForm;
use app\models\EntHistoriasExtend;
use yii\web\Response;
use app\modules\ModUsuarios\models\Utils;
use yii\web\NotFoundHttpException;

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
		if (($historia = EntHistoriasExtend::getHistoriaByToken ( $token ))) {
			return $historia;
		} else {
			throw new NotFoundHttpException( 'The requested page does not exist.' );
		}
	}
	
	/**
	 * Guarda los elementos basicos de un capitulo
	 * @param unknown $token
	 */
	public function actionGuardarCapitulo($token=null){
		
		$historia = $this->getHistoriaByToken($token);
		
		$capitulo = new EntCapitulos();
		$capitulo->id_historia = $historia->id_historia;
		$capitulo->txt_token = Utils::generateToken('cap_');
		
		if($validacion = $this->validarCapitulo($capitulo)){
			return $validacion;
		}
		
		$capitulo->fch_creacion = Utils::getFechaActual();
		$capitulo->fch_publicacion = Utils::changeFormatDateInput($capitulo->fch_publicacion);
		
		if($capitulo->save()){
			return ['status'=>'success'];	
		}
		
		return ['status'=>'error'];
	}
	
	public function validarCapitulo($capitulo) {
		if (Yii::$app->request->isAjax && $capitulo->load ( Yii::$app->request->post () )) {
			Yii::$app->response->format = Response::FORMAT_JSON;
				
			return ActiveForm::validate ( $capitulo );
		}
	}
}