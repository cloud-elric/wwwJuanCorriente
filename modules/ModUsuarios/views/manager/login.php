<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params ['breadcrumbs'] [] = $this->title;

$this->registerJsFile ( '@web/js/login.js', [
		'depends' => [
				\app\assets\AppAsset::className ()
		]
] );


if (Yii::$app->params ['modUsuarios'] ['facebook'] ['usarLoginFacebook']) {
	?>
<script>

logInWithFacebook = function() {
	FB.login(function(response) {
		if (response.authResponse) {

			// Now you can redirect the user or do an AJAX request to
			// a PHP script that grabs the signed request from the cookie.
		}
		checkLoginState();
	}, {
		scope : '<?=Yii::$app->params ['modUsuarios'] ['facebook'] ['permisosForzosos']?>',
		auth_type : 'rerequest'
	});
	return false;
};

function statusChangeCallback(response) {

	// The response object is returned with a status field that lets the
	// app know the current login status of the person.
	// Full docs on the response object can be found in the documentation
	// for FB.getLoginStatus().
	if (response.status === 'connected') {

		FB.api('/me/permissions', function(response) {
			var declined = [];
			for (i = 0; i < response.data.length; i++) {
				if (response.data[i].status == 'declined') {
					declined.push(response.data[i].permission)
				}
			}
			if(declined.toString()=="email"){
				
				alert("Parece que no aceptaste la solicitud de Facebook o no nos compartiste tu correo electrónico.");
				
			}else{
				// Logged into your app and Facebook.
				window.location.replace('http://notei.com.mx/test/wwwLogin/web/callback-facebook');
				//window.location.replace('http://notei.com.mx/test/wwwComiteConcursante/index.php/usrUsuarios/callbackFacebook/t/3c391e5c9feec1f95282a36bdd5d41ba');
//				window.location
//						.replace('https://hazclicconmexico.comitefotomx.com/concursar/usrUsuarios/callbackFacebook/t/3c391e5c9feec1f95282a36bdd5d41ba');
			}
		});

		
	} else if (response.status === 'not_authorized') {
		alert("Rechazo ingresar mediante Facebook");
		// The person is logged into Facebook, but not your app.
	} else {
		
		// The person is not logged into Facebook, so we're not sure if
		// they are logged into this app or not.
	}
}

function checkLoginState() {

	// FB.api('/me/permissions', function(response) {
	// var declined = [];
	// for (i = 0; i < response.data.length; i++) {
	// if (response.data[i].status == 'declined') {
	// declined.push(response.data[i].permission)
	// }
	// }
	// alert(declined.toString())
	// });
	// FB.login(
	// function(response) {
	// console.log(response);
	// statusChangeCallback(response);
	// },
	// {
	// scope: 'email',
	// auth_type: 'rerequest'
	// }
	// );

	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
		
	});
}

window.fbAsyncInit = function() {
	FB.init({
		//appId : '1029875693761281',
		appId:'1754524001428992',
		cookie : true, // enable cookies to allow the server to access
		// the session
		xfbml : true, // parse social plugins on this page
		version : 'v2.6' // use any version
	});

};

// Load the SDK asynchronously
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id))
		return;
	js = d.createElement(s);
	js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>

<?php }?>

<!-- .login -->
<div class="login">
	<!-- .login-cont -->
	<div class="login-cont">

		<h1 class="animated">Historias de México</h1>
		<?php # Html::encode($this->title) ?>

		<?php
		
$form = ActiveForm::begin ( [ 
				'id' => 'login-form',
				'options' => [ 
						'class' => 'form-horizontal form-login' 
				],
				'fieldConfig' => [ 
						'template' => "<div class=\"col-lg-12 animated\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
						'labelOptions' => [ 
								'class' => 'col-lg-1 control-label' 
						] 
				] 
		] );
		?>

			<?= $form->field($model, 'username')->textInput(['autofocus' => true])?>

			<?= $form->field($model, 'password')->passwordInput()?>

			<div class="form-group">
			<div class="col-lg-12">
					<?= Html::submitButton('<span class="ladda-label">Login</span>', ['class' => 'btn login-form-btn ladda-button animated', 'name' => 'login-button', 'id'=>'js-login-submit','data-style'=>'zoom-in'])?>
				</div>
		</div>

		<?php ActiveForm::end(); ?>			

	</div>
	<!-- end - .login-cont -->
</div>
<!-- end - .login -->