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

			<div class="ver-capitulo-post-desc ver-capitulo-post-hover-close">
				<div class="ver-capitulo-post-desc-text" contenteditable="true">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis exercitationem modi reiciendis, dignissimos culpa sequi eveniet ab nesciunt commodi soluta, quia ipsum reprehenderit vero magnam, tempora aut atque neque perferendis.
				</div>
				<span class="ver-capitulo-post-hover-close-btn"><i class="ion ion-close-round"></i></span>
			</div>

			<div class="ver-capitulo-post-imagen ver-capitulo-post-hover-close">
				<img src="<?=Url::base()?>/webAssets/images/monkey.png" alt="Article" contenteditable="true">
				<span class="ver-capitulo-post-hover-close-btn"><i class="ion ion-close-round"></i></span>
			</div>

			<input type="file" class="modal-admin-form-imagen">

		</div>
		<!-- end - .ver-capitulo-post -->

	</div>
	<!-- end - .container -->


	<!-- .ver-capitulo-controlers -->
	<div class="ver-capitulo-controlers">

		<button class="btn ver-capitulo-controlers-btn-circle ver-capitulo-controlers-btn-circle-texto">
			<i class="ion ion-document-text"></i>
		</button>

		<button class="btn ver-capitulo-controlers-btn-circle ver-capitulo-controlers-btn-circle-imagen">
			<i class="ion ion-image"></i>
		</button>

	</div>
	<!-- end - .ver-capitulo-controlers -->

</div>
<!-- end - .ver-capitulo -->

