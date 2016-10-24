<?php

/* @var $this yii\web\View */

$this->title = 'Ver Capítulo';
use yii\helpers\Url;

$this->registerJsFile ( '@web/js/admin.js', [
		'depends' => [
				\app\assets\AppAsset::className ()
		]
] );

?>
<input type="hidden" data-historia="<?=$capitulo->txt_token?>" id="js-capitulo" />
<!-- .ver-capitulo -->
<div class="ver-capitulo" id="specialstuff">

	<!-- .ver-capitulo-header -->
	<div class="ver-capitulo-header">

		<h1>Historias de México</h1>

		<h2>El Milagro</h2>

		<!-- Leer de día o noche -->
		<i class="ion ion-ios-book ver-capitulo-leer"></i>

		<!-- Leer de día o noche -->
		<i class="ion ion-ios-book ver-capitulo-leer-full"></i>

		<!-- FullScreen -->
		<div class="ver-capitulo-full-screen" id="full-screen">
			<span>FullScreen</span> <i class="ion ion-arrow-expand"></i>
		</div>

		<!-- CloseScreen -->
		<div class="ver-capitulo-close-screen" id="close-screen">
			<span>Exit Screen</span> <i class="ion ion-arrow-shrink"></i>
		</div>
	</div>
	<!-- end - .ver-capitulo-header -->

	<!-- .container -->
	<div class="container">

		<!-- .ver-capitulo-post -->
		<div class="ver-capitulo-post">
			<!-- 
			<div class="ver-capitulo-post-imagen">
				<img src="<?=Url::base()?>/webAssets/images/monkey.png" alt="Article">
			</div>
			-->
		</div>
		<!-- end - .ver-capitulo-post -->

	</div>
	<!-- end - .container -->
</div>
<!-- end - .ver-capitulo -->

<!-- <input type="button" value="Go Fullscreen" id="fsbutton" /> -->

		<!-- .modal-admin-form-controlers -->
		<div class="modal-admin-form-controlers">

			<button 
				class="btn modal-admin-form-controlers-btn-circle modal-admin-form-controlers-btn-circle-texto js-texto">
				<i class="ion ion-document-text"></i>
			</button>

			<button 
				class="btn modal-admin-form-controlers-btn-circle modal-admin-form-controlers-btn-circle-imagen">
				<i class="ion ion-image"></i>
			</button>

		</div>
		<!-- end - .modal-admin-form-controlers -->