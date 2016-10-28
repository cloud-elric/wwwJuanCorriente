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
use app\models\EntElementos;
use yii\web\UploadedFile;
use app\models\ConstantesWeb;

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
				'tiposElementos' => $tiposElementos 
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
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
	
	/**
	 * Busca la historia por el token
	 *
	 * @param unknown $token        	
	 * @throws NotFoundHttpException
	 * @return boolean|\app\models\EntHistorias
	 */
	private function getCapituloByToken($token) {
		if (($capitulo = EntCapitulos::find ()->where ( [ 
				'txt_token' => $token 
		] )->one ())) {
			return $capitulo;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
	
	/**
	 * Guarda los elementos basicos de un capitulo
	 *
	 * @param unknown $token        	
	 */
	public function actionGuardarCapitulo($token = null) {
		$historia = $this->getHistoriaByToken ( $token );
		
		$capitulo = new EntCapitulos ();
		$capitulo->id_historia = $historia->id_historia;
		$capitulo->txt_token = Utils::generateToken ( 'cap_' );
		
		if ($validacion = $this->validarCapitulo ( $capitulo )) {
			return $validacion;
		}
		
		$capitulo->fch_creacion = Utils::getFechaActual ();
		$capitulo->fch_publicacion = Utils::changeFormatDateInput ( $capitulo->fch_publicacion );
		
		// Guarda la imagen
		$file = UploadedFile::getInstanceByName ( 'imageCapitulo' );
		
		if ($file) {
			$capitulo->txt_imagen = Utils::generateToken ( 'imgC_' ) . '.' . $file->extension;
			$file->saveAs ( 'webAssets/uploads/' . $capitulo->txt_imagen );
		}
		
		if ($capitulo->save ()) {
			
			return [ 
					'status' => 'success',
					'tk' => $capitulo->txt_token,
					'i' => $capitulo->txt_imagen ? $capitulo->txt_imagen : 'noImage.jpg',
					'n' => $capitulo->txt_nombre 
			];
		}
		
		return [ 
				'status' => 'error' 
		];
	}
	public function actionGuardarElementoCapitulo($capitulo) {
		$capitulo = $this->getCapituloByToken ( $capitulo );
		
		if (array_key_exists ( 'token', $_POST ) && ! empty ( $_POST ['token'] )) {
			$elemento = EntElementos::find ()->where ( [ 
					'txt_token' => $_POST ['token'] 
			] )->one ();
		} else {
			$elemento = new EntElementos ();
			$elemento->id_tipo_elemento = 3;
			$elemento->b_header = 0;
			$elemento->txt_token = Utils::generateToken ( 'ele_' );
		}
		
		$elemento->id_capitulo = $capitulo->id_capitulo;
		$elemento->id_historia = $capitulo->id_historia;
		$elemento->txt_valor = nl2br ( $_POST ['valor'] );
		$elemento->num_orden = $_POST ['index'];
		
		$elemento->save ();
		Yii::$app->response->format = Response::FORMAT_JSON;
		
		return [ 
				'status' => 'success',
				'tk' => $elemento->txt_token 
		];
	}
	
	/**
	 * Elimina el elemento de la base de datos
	 *
	 * @param unknown $capitulo        	
	 * @return string[]
	 */
	public function actionEliminarElementoCapitulo($capitulo) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		
		$capitulo = $this->getCapituloByToken ( $capitulo );
		
		if (array_key_exists ( 'token', $_POST ) && ! empty ( $_POST ['token'] )) {
			$elemento = EntElementos::find ()->where ( [ 
					'txt_token' => $_POST ['token'] 
			] )->one ();
			
			if ($elemento) {
				$elemento->delete ();
			}
			
			return [ 
					'status' => 'success' 
			];
		} else {
			return [ 
					'status' => 'error' 
			];
		}
	}
	
	/**
	 * Guarda una imagen del usuario
	 * 
	 * @param unknown $capitulo        	
	 */
	public function actionGuardarImagenElemento($capitulo) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		$capitulo = $this->getCapituloByToken ( $capitulo );
		
		$file = UploadedFile::getInstanceByName ( 'fileUpload' );
		
		if ($file) {
			$elemento = null;
			if (array_key_exists ( 'token', $_POST ) && ! empty ( $_POST ['token'] )) {
				$elemento = EntElementos::find ()->where ( [ 
						'txt_token' => $_POST ['token'] 
				] )->one ();
			} 
			
			if(empty($elemento)){
				$elemento = new EntElementos ();
				$elemento->id_tipo_elemento = ConstantesWeb::TIPO_ELEMENTO_IMAGEN;
				$elemento->b_header = 0;
				$elemento->txt_token = Utils::generateToken ( 'ele_' );
			}
			
			$elemento->id_capitulo = $capitulo->id_capitulo;
			$elemento->id_historia = $capitulo->id_historia;
			$elemento->txt_valor= Utils::generateToken ( 'imgC_' ) . '.' . $file->extension;
			$elemento->num_orden = $_POST ['index'];
			
			$elemento->save ();
			
			$file->saveAs ( 'webAssets/uploads/' . $elemento->txt_valor);
			
			return [ 
					'status' => 'success',
					'tk' => $elemento->txt_token 
			];
		}
		
		return [
				'status' => 'error'
		];
	}
	
	/**
	 * Guarda la imagen
	 */
	public function actionGuardarImagenCapitulo($historia, $capitulo) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		
		$historiaF = $this->getHistoriaByToken ( $historia );
		
		$capituloF = $this->getCapituloByToken ( $capitulo );
		
		$file = UploadedFile::getInstanceByName ( 'fileCapitulo' );
		
		if ($file) {
			$capituloF->txt_imagen = Utils::generateToken ( 'imc_' ) . '.' . $file->extension;
			
			if ($capituloF->save ()) {
				$file->saveAs ( 'webAssets/uploads/' . $capituloF->txt_imagen );
				
				return [ 
						'status' => 'success' 
				];
			}
		} else {
			return [ 
					'status' => 'error' 
			];
		}
	}
	public function validarCapitulo($capitulo) {
		if (Yii::$app->request->isAjax && $capitulo->load ( Yii::$app->request->post () )) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			
			return ActiveForm::validate ( $capitulo );
		}
	}
	
	/**
	 * Actualiza la informacion
	 * 
	 * @param unknown $token        	
	 */
	public function actionGuardarNombre($token) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		$capitulo = $this->getCapituloByToken ( $token );
		
		if (array_key_exists ( 'text', $_POST ) && ! empty ( $_POST ['text'] )) {
			
			$capitulo->txt_nombre = $_POST ['text'];
			$capitulo->save ();
			
			return [ 
					'status' => 'success',
					'text' => $capitulo->txt_nombre 
			];
		} else {
			return [ 
					'status' => 'error',
					'text' => $capitulo->txt_nombre 
			];
		}
	}
	
	/**
	 *
	 * @param unknown $token        	
	 */
	public function actionEliminarCapitulo($token) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		$capitulo = $this->getCapituloByToken ( $token );
		
		if ($capitulo->delete ()) {
			return [ 
					'status' => 'success' 
			];
		}
		
		return [ 
				'status' => 'error' 
		];
	}
}