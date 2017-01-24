<?php

namespace vendor\facebook;

use Yii;
use Facebook\Facebook;

class FacebookI {
	public $loginUrl;
	public $fb;
	public $alias;
	public $helper;
	
	/**
	 * Constructor de la clase
	 */
	function __construct() {
		$this->alias = Yii::getAlias ( '@app' ) . '/vendor/facebook/src/Facebook';
		require ($this->alias . DIRECTORY_SEPARATOR . 'autoload.php');
		// Yii::app ()->session ['ini'] = NULL;
		$this->fb = new Facebook ( [ 
				'app_id' => Yii::$app->params ['modUsuarios'] ['facebook'] ['APP_ID'],
				'app_secret' => Yii::$app->params ['modUsuarios'] ['facebook'] ['APP_SECRET'],
				// 'app_id' => '1029875693761281',
				// 'app_secret' => '392bdd02e9eaa3531ad48197564a5bb0',
				'default_graph_version' => 'v2.6' 
		] );
		// $this->helper = $this->fb->getRedirectLoginHelper ();
		$this->helper = $this->fb->getJavaScriptHelper ();
	}
	
	/**
	 * Valida si existe una sesion del usuario
	 */
	public function isLogged() {
		$accessToken = $this->existsSession ();
		
		if (empty ( $accessToken )) {
			$this->getUrl ();
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * Recupera data del usuario
	 */
	public function recoveryDataUser() {
		$accessToken = $this->existsSession ();
		
		$usuario = $this->managerSession ( $accessToken );
		
		return $usuario;
	}
	public function recoveryDataUserJavaScript() {
		$respuesta = array ();
		try {
			$accessToken = $this->helper->getAccessToken ();
		} catch ( Facebook\Exceptions\FacebookResponseException $e ) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage ();
			if ($e->getCode () == 100) {
				
				return "error";
			}
			
			return;
		} catch ( Facebook\Exceptions\FacebookSDKException $e ) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage ();
		}
		if (isset ( $accessToken )) {
			$this->fb->setDefaultAccessToken ( $accessToken );
			try {
				$respuesta = [ ];
				
				if (Yii::$app->params ['modUsuarios'] ['facebook'] ['dataBasic']) {
					$profile_request = $this->fb->get ( '/me?fields=first_name, email, name, last_name' );
					$profile_picture = $this->fb->get ( '/me/picture?redirect=false&type=large' );
					
					$profile = $profile_request->getGraphNode ()->asArray ();
					$picture = $profile_picture->getGraphUser ();
					
					$respuesta ["profile"] = $profile;
					$respuesta ["pictureUrl"] = $picture ["url"];
				}
				
				if(Yii::$app->params ['modUsuarios'] ['facebook'] ['friends']){
					$requestNumberFriends = $this->fb->get ( '/me/friends' );
					$friendsN = $requestNumberFriends->getGraphEdge ();
					
					//$respuesta['friendsInApp'] = $friendsN;
					
					foreach($friendsN as $key=>$value){
						$respuesta['friendsInApp'][] = json_decode($value); 
					}
					
				}
				
				
				
// 				print_r ( $friendsN ) . '<br><br><br>';
				
// 				$numberFriends = $friendsN->getTotalCount ();
				// $requestFriends = $this->fb->get('/me/taggable_friends?fields=name&limit='.$numberFriends);
				
				// $friends = $requestFriends->getGraphEdge();
				
				// if have more friends than 100 as we defined the limit above on line no. 68
				// if ($this->fb->next($friends)) {
				// $allFriends = array();
				// $friendsArray = $friends->asArray();
				// $allFriends = array_merge($friendsArray, $allFriends);
				// while ($friends = $fb->next($friends)) {
				// $friendsArray = $friends->asArray();
				// $allFriends = array_merge($friendsArray, $allFriends);
				// }
				// foreach ($allFriends as $key) {
				// echo $key['name'] . "<br>";
				// }
				// echo count($allfriends);
				// } else {
				// $allFriends = $friends->asArray();
				// $totalFriends = count($allFriends);
				// foreach ($allFriends as $key) {
				// echo $key['name'] . "<br>";
				// }
				// }
				
				// echo "------------------".$totalFriends."---------------------";
				
				// exit;
			} catch ( Facebook\Exceptions\FacebookResponseException $e ) {
				// When Graph returns an error
				echo 'Graph returned an error: ' . $e->getMessage ();
			} catch ( Facebook\Exceptions\FacebookSDKException $e ) {
				// When validation fails or other local issues
				echo 'Facebook SDK returned an error: ' . $e->getMessage ();
			}
		} else {
			echo "Unauthorized access!!!";
			
			exit ();
		}
		
		return $respuesta;
	}
	
	/**
	 * Obtener url para el callback y login de facebook
	 *
	 * @param unknown $helper        	
	 */
	public function getUrl() {
		$permissions = array (
				'email' 
		); // optional
		$this->loginUrl = $this->helper->getLoginUrl ( Yii::app ()->params ['Facebook'] ['callBack'], $permissions );
	}
	
	/**
	 *
	 * @param unknown $helper        	
	 */
	public function existsSession() {
		require ($this->alias . DIRECTORY_SEPARATOR . 'autoload.php');
		
		try {
			if (isset ( Yii::app ()->session ['facebook_access_token'] )) {
				
				$accessToken = Yii::app ()->session ['facebook_access_token'];
			} else {
				
				$accessToken = $this->helper->getAccessToken ();
			}
			
			return $accessToken;
		} catch ( Facebook\Exceptions\FacebookResponseException $e ) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage ();
			exit ();
		} catch ( Facebook\Exceptions\FacebookSDKException $e ) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage ();
			exit ();
		}
	}
	
	/**
	 *
	 * @param unknown $helper        	
	 * @param unknown $accessToken        	
	 * @param unknown $fb        	
	 * @param unknown $permissions        	
	 */
	public function managerSession($accessToken) {
		require ($this->alias . DIRECTORY_SEPARATOR . 'autoload.php');
		$respuesta = array ();
		
		if (isset ( $accessToken )) {
			if (isset ( Yii::app ()->session ['facebook_access_token'] )) {
				$this->fb->setDefaultAccessToken ( Yii::app ()->session ['facebook_access_token'] );
			} else {
				// getting short-lived access token
				Yii::app ()->session ['facebook_access_token'] = ( string ) $accessToken;
				// OAuth 2.0 client handler
				$oAuth2Client = $this->fb->getOAuth2Client ();
				// Exchanges a short-lived access token for a long-lived one
				$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken ( Yii::app ()->session ['facebook_access_token'] );
				Yii::app ()->session ['facebook_access_token'] = ( string ) $longLivedAccessToken;
				// setting default access token to be used in script
				$this->fb->setDefaultAccessToken ( Yii::app ()->session ['facebook_access_token'] );
			}
			// getting basic info about user
			try {
				$profile_request = $this->fb->get ( '/me?fields=first_name, email' );
				$profile_picture = $this->fb->get ( '/me/picture?redirect=false&type=large' );
				;
				$profile = $profile_request->getGraphNode ()->asArray ();
				$picture = $profile_picture->getGraphUser ();
				$respuesta ["profile"] = $profile;
				$respuesta ["pictureUrl"] = $picture ["url"];
			} catch ( Facebook\Exceptions\FacebookResponseException $e ) {
				// When Graph returns an error
				echo 'Graph returned an error: ' . $e->getMessage ();
				exit ();
			} catch ( Facebook\Exceptions\FacebookSDKException $e ) {
				// When validation fails or other local issues
				echo 'Facebook SDK returned an error: ' . $e->getMessage ();
				exit ();
			}
		} else {
			if ($this->helper->getError ()) {
				header ( 'HTTP/1.0 401 Unauthorized' );
				echo "Error: " . $this->helper->getError () . "\n";
				echo "Error Code: " . $this->helper->getErrorCode () . "\n";
				echo "Error Reason: " . $this->helper->getErrorReason () . "\n";
				echo "Error Description: " . $this->helper->getErrorDescription () . "\n";
			} else {
				header ( 'HTTP/1.0 400 Bad Request' );
				echo 'Bad request';
			}
			exit ();
		}
		
		return $respuesta;
	}
}
	
	
	

	

	

	

	