<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntHistorias;
use app\models\EntHistoriasExtend;
use app\models\EntCapitulos;
use yii\web\NotFoundHttpException;

class SiteController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [ 
				'access' => [ 
						'class' => AccessControl::className (),
						'only' => [ 
								'logout' 
						],
						'rules' => [ 
								[ 
										'actions' => [ 
												'logout' 
										],
										'allow' => true,
										'roles' => [ 
												'@' 
										] 
								] 
						] 
				],
				'verbs' => [ 
						'class' => VerbFilter::className (),
						'actions' => [ 
								'logout' => [ 
										'post' 
								] 
						] 
				] 
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [ 
				'error' => [ 
						'class' => 'yii\web\ErrorAction' 
				],
				'captcha' => [ 
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null 
				] 
		];
	}
	
	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex() {
		
		// Obtiene todas las historias activas
		$historias = EntHistorias::find ()->where ( [ 
				'b_habilitado' => 1 
		] )->all ();
		
		return $this->render ( 'index', [ 
				'historias' => $historias 
		] );
	}
	
	/**
	 * Login action.
	 *
	 * @return string
	 */
	public function actionLogin() {
		if (! Yii::$app->user->isGuest) {
			return $this->goHome ();
		}
		
		$model = new LoginForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->login ()) {
			return $this->goBack ();
		}
		return $this->render ( 'login', [ 
				'model' => $model 
		] );
	}
	
	/**
	 * Logout action.
	 *
	 * @return string
	 */
	public function actionLogout() {
		Yii::$app->user->logout ();
		
		return $this->goHome ();
	}
	
	
	/**
	 * Lista de capitulos por historia
	 *
	 * @param string $token        	
	 */
	public function actionListaDeCapitulos($token = null) {
		$historia = $this->getHistoriaByToken ( $token );
		
		$capituloForm = new EntCapitulos();
		return $this->render ( 'listaDeCapitulos', [ 
				'historia' => $historia,
				'capituloForm'=>$capituloForm
		] );
	}
	
	/**
	 * Visualizacion de capitulo seleccionado
	 *
	 * @param string $token        	
	 */
	public function actionVerCapitulo($token = null, $capitulo = null) {
		$this->layout = 'headerPost';
		$historia = $this->getHistoriaByToken ( $token );
		
		return $this->render ( 'verCapitulo' );
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
}
