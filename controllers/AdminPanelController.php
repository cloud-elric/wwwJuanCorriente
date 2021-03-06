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
use app\models\EntHistorias;

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
			$file->saveAs ( 'webAssets/uploads/' . $capitulo->txt_imagen, false );
			
			$raw_file_name = $file->tempName;
			
			// Valida que sea una imagen
			$size = getimagesize ( $raw_file_name );
			list ( $width, $height, $otro, $wh ) = getimagesize ( $raw_file_name );
			$basePath = 'webAssets/uploads/';
			
			$this->rezisePicture ( $basePath . $capitulo->txt_imagen, $width, $height, $width, $basePath . 'min_' . $capitulo->txt_imagen, $file->extension );
		}
		
		if ($capitulo->save ()) {
			
			$elemento = new EntElementos ();
			$elemento->id_tipo_elemento = ConstantesWeb::TIPO_ELEMENTO_HEADER;
			$elemento->b_header = 1;
			$elemento->txt_token = Utils::generateToken ( 'ele_' );
			
			$elemento->id_capitulo = $capitulo->id_capitulo;
			$elemento->id_historia = $capitulo->id_historia;
			$elemento->txt_valor = '-';
			$elemento->num_orden = '0';
			
			$elemento->save ();
			
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
			
			if (empty ( $elemento )) {
				$elemento = new EntElementos ();
				$elemento->id_tipo_elemento = ConstantesWeb::TIPO_ELEMENTO_IMAGEN;
				$elemento->b_header = 0;
				$elemento->txt_token = Utils::generateToken ( 'ele_' );
			}
			
			$elemento->id_capitulo = $capitulo->id_capitulo;
			$elemento->id_historia = $capitulo->id_historia;
			$elemento->txt_valor = Utils::generateToken ( 'imgC_' ) . '.' . $file->extension;
			$elemento->num_orden = $_POST ['index'];
			
			$elemento->save ();
			
			$file->saveAs ( 'webAssets/uploads/' . $elemento->txt_valor, false );
			
			$raw_file_name = $file->tempName;
			
			// Valida que sea una imagen
			$size = getimagesize ( $raw_file_name );
			list ( $width, $height, $otro, $wh ) = getimagesize ( $raw_file_name );
			$basePath = 'webAssets/uploads/';
			
			$this->rezisePicture ( $basePath . $elemento->txt_valor, $width, $height, $width, $basePath . 'min_' . $elemento->txt_valor, $file->extension );
			
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
				$file->saveAs ( 'webAssets/uploads/' . $capituloF->txt_imagen, false );
				
				$raw_file_name = $file->tempName;
				
				// Valida que sea una imagen
				$size = getimagesize ( $raw_file_name );
				list ( $width, $height, $otro, $wh ) = getimagesize ( $raw_file_name );
				$basePath = 'webAssets/uploads/';
				
				$this->rezisePicture ( $basePath . $capituloF->txt_imagen, $width, $height, $width, $basePath . 'min_' . $capituloF->txt_imagen, $file->extension );
				
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
	public function validarHistoria($historia) {
		if (Yii::$app->request->isAjax && $historia->load ( Yii::$app->request->post () )) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			
			$historia->txt_nombre = nl2br ( $historia->txt_nombre );
			$historia->txt_descripcion = nl2br ( $historia->txt_descripcion );
			
			return ActiveForm::validate ( $historia );
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
	
	/**
	 * Actualiza el index en la base de datoss
	 */
	public function actionUpdateIndex($capitulo) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		
		if (array_key_exists ( 'index', $_POST )) {
			
			$elemento = EntElementos::find ()->where ( [ 
					'txt_token' => $capitulo 
			] )->one ();
			
			if (! empty ( $elemento )) {
				
				$elemento->num_orden = $_POST ['index'];
				$elemento->save ();
				
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
	
	/**
	 */
	public function actionGuardarImagenHeader($capitulo) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		
		$capituloF = $this->getCapituloByToken ( $capitulo );
		
		$elemento = EntElementos::find ()->where ( [ 
				'id_capitulo' => $capituloF->id_capitulo,
				'b_header' => 1 
		] )->one ();
		
		$file = UploadedFile::getInstanceByName ( 'fileUpload' );
		
		if ($file && ! empty ( $elemento )) {
			$elemento->txt_valor = Utils::generateToken ( 'imc_' ) . '.' . $file->extension;
			
			if ($elemento->save ()) {
				$file->saveAs ( 'webAssets/uploads/' . $elemento->txt_valor, false );
				
				$raw_file_name = $file->tempName;
				
				// Valida que sea una imagen
				$size = getimagesize ( $raw_file_name );
				list ( $width, $height, $otro, $wh ) = getimagesize ( $raw_file_name );
				$basePath = 'webAssets/uploads/';
				
				$this->rezisePicture ( $basePath . $elemento->txt_valor, $width, $height, $width, $basePath . 'min_' . $elemento->txt_valor, $file->extension );
				
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
	
	/**
	 * Metodo para cambiar el tamaño de una imagen
	 *
	 * @param unknown $file        	
	 * @param unknown $ancho        	
	 * @param unknown $alto        	
	 * @param unknown $nuevo_ancho        	
	 * @param unknown $nuevo_alto        	
	 */
	private function rezisePicture($file, $ancho, $alto, $redimencionar, $nombreNuevo, $extension) {
		// Factor para el redimensionamiento
		$factor = $this->calcularFactor ( $ancho, $alto, $redimencionar );
		
		$nuevo_ancho = $ancho * $factor;
		$nuevo_alto = $alto * $factor;
		
		// Cargar
		$thumb = imagecreatetruecolor ( $nuevo_ancho, $nuevo_alto );
		
		// preserve transparency
		if ($extension == "gif" || $extension == "png") {
			imagecolortransparent ( $thumb, imagecolorallocatealpha ( $thumb, 0, 0, 0, 127 ) );
			imagealphablending ( $thumb, false );
			imagesavealpha ( $thumb, true );
		}
		
		if ($extension == 'jpg' || $extension == 'jpeg') {
			$origen = imagecreatefromjpeg ( $file );
			// Cambiar el tamaño
			imagecopyresampled ( $thumb, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto );
			
			imagejpeg ( $thumb, $nombreNuevo );
		} else if ($extension == 'png') {
			$origen = imagecreatefrompng ( $file );
			// Cambiar el tamaño
			imagecopyresampled ( $thumb, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto );
			
			imagepng ( $thumb, $nombreNuevo );
		}
		// else if($extension=='gif'){
		// $origen = imagecreatefromgif( $file );
		// // Cambiar el tamaño
		// imagecopyresampled ( $thumb, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto );
		
		// imagegif($thumb, $nombreNuevo );
		// }
	}
	public function actionEditarHistoria($token = null) {
		$historia = $this->getHistoriaByToken ( $token );
		
		if ($_POST ['valor']) {
			$historia->txt_descripcion = $_POST ['valor'];
			$historia->save ();
		}
	}
	
	/**
	 * Calcula el factor
	 *
	 * @param unknown $ancho        	
	 * @param unknown $alto        	
	 * @param unknown $redimension        	
	 */
	private function calcularFactor($ancho, $alto, $redimension) {
		if ($ancho >= $alto) {
			$factor = $redimension / $ancho;
		} else if ($ancho <= $alto) {
			$factor = $redimension / $alto;
		}
		
		return $factor;
	}
	
	/**
	 * Guarda la imagen
	 */
	public function actionGuardarImagenHistoria($token = null) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		
		$historia = $this->getHistoriaByToken ( $token );
		
		$file = UploadedFile::getInstanceByName ( 'fileHistoria' );
		
		if ($file) {
			
			$historia->txt_image = Utils::generateToken ( 'imc_' ) . '.' . $file->extension;
			
			if ($historia->save ()) {
				$file->saveAs ( 'webAssets/uploads/' . $historia->txt_image, false );
				
				$raw_file_name = $file->tempName;
				
				// Valida que sea una imagen
				$size = getimagesize ( $raw_file_name );
				list ( $width, $height, $otro, $wh ) = getimagesize ( $raw_file_name );
				$basePath = 'webAssets/uploads/';
				
				$this->rezisePicture ( $basePath . $historia->txt_image, $width, $height, $width, $basePath . 'min_' . $historia->txt_image, $file->extension );
				
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
	public function actionGuardarHistoria() {
		
		$historia = new EntHistorias ();
		$historia->txt_token = Utils::generateToken ( 'hst_' );
		
		if ($validacion = $this->validarHistoria ( $historia )) {
			return $validacion;
		}
		// Guarda la imagen
		$file = UploadedFile::getInstanceByName ( 'imageCapitulo' );
		
		if ($file) {
			$historia->txt_image = Utils::generateToken ( 'imgC_' ) . '.' . $file->extension;
			$file->saveAs ( 'webAssets/uploads/' . $historia->txt_image, false );
			
			$raw_file_name = $file->tempName;
			
			// Valida que sea una imagen
			$size = getimagesize ( $raw_file_name );
			list ( $width, $height, $otro, $wh ) = getimagesize ( $raw_file_name );
			$basePath = 'webAssets/uploads/';
			
			$this->rezisePicture ( $basePath . $historia->txt_image, $width, $height, $width, $basePath . 'min_' . $historia->txt_image, $file->extension );
		}
		
		if ($historia->save ()) {
			
			return [ 
					'status' => 'success',
					'tk' => $historia->txt_token,
					'i' => $historia->txt_image ? $historia->txt_image : 'noImage.jpg',
					'n' => $historia->txt_nombre 
			];
		}
		
		return [ 
				'status' => 'error' 
		];
	}
	
	
	public function actionEliminarHistoria($token=null){
		$historia = $this->getHistoriaByToken($token);
		
		$historia->delete();
	}
	
	public function actionEditarHistoriaNombre(){
		$token = $_POST['token'];
		$valor = $_POST['valor'];
		
		$historia = $this->getHistoriaByToken($token);
		
		$historia->txt_nombre = $valor;
		$historia->save();
	}
	
	
	public function actionGuardarAudioCapitulo($capitulo=null){
		
		Yii::$app->response->format = Response::FORMAT_JSON;
		
		$capitulo = $this->getCapituloByToken($capitulo);
		
		$file = UploadedFile::getInstanceByName ( 'fileUpload' );
		
		if ($file) {
				
			$capitulo->txt_audio= Utils::generateToken ( 'aud_' ) . '.' . $file->extension;
				
			if ($capitulo->save ()) {
				$file->saveAs ( 'audios/' . $capitulo->txt_audio, false );
		
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
}