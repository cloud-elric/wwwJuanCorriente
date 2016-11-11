<?php

/* @var $this yii\web\View */
$this->title = 'Ver Capítulo';
use yii\helpers\Url;
use app\models\EntElementos;
use app\models\ConstantesWeb;

$header = EntElementos::find ()->where ( [ 
		'id_capitulo' => $capitulo->id_capitulo,
		'b_header' => 1,
		'id_tipo_elemento' => ConstantesWeb::TIPO_ELEMENTO_HEADER 
] )->one ();

$editable = '';
$classEditable = '';
$isAdmin = ! Yii::$app->user->isGuest;

if ($isAdmin) {
	$editable = " contentEditable='true' data-new='noNuevo'  data-progress='noProceso' ";
	$classEditable = ' js-elemento-editable';
	
	$this->registerJsFile ( 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', [ 
			'depends' => [ 
					\app\assets\AppAsset::className () 
			] 
	] );
	
	$this->registerJsFile ( '@web/js/admin.js', [ 
			'depends' => [ 
					\app\assets\AppAsset::className () 
			] 
	] );
} else {
	$this->registerJsFile ( '@web/js/usuario.js', [ 
			'depends' => [ 
					\app\assets\AppAsset::className () 
			] 
	] );
}
?>

<input type="hidden" data-token="<?=$capitulo->txt_token?>"
	id="js-capitulo" />

<!-- .ver-capitulo -->
<div class="ver-capitulo <?=$isAdmin?'ver-capitulo-admin':''?>"
	id="specialstuff">

	<!-- .ver-capitulo-header -->
	<div class="ver-capitulo-header" data-token='<?=empty($header)?'':$header->txt_valor?>' style="background-image: url(<?=Url::base().'/webAssets/uploads/'.(empty($header)?'portada.jpg':ConstantesWeb::PREX_IMG.$header->txt_valor)?>)">
	<?php if($isAdmin){?>
<div class="listado-image">
			<div class="listado-image-item">
				<!-- Input -->
				<input type="file"
					class="inputfile modal-admin-form-imagen inputFileCard"
					onchange='uploadImageHeader($(this), this)' id="js-header-img">
				<!-- Label -->
				<label for="js-header-img" class="js-label-header">Cambiar header</label>
				<!-- Progress Bar -->
				<div
					class="ver-capitulo-post-progress ver-capitulo-post-progress-full">
					<!-- 							class="ver-capitulo-post-progress ver-capitulo-post-progress-full ver-capitulo-post-progress-anim"> -->
					<div id="js-progress-bar" class="ver-capitulo-post-progress-bar"></div>
					<span id="js-progress-bar-texto" class="w3-center w3-text-white">0%</span>
				</div>
			</div>
		</div>
		<!-- end .listado-image -->
<?php }?>
		<h1>Historias de México</h1>

		<h2><?=$capitulo->txt_nombre?></h2>

		<!-- Btn to Back -->
		<a href="javascript: history.back(1)" class="ver-capitulo-back"> <i
			class="ion ion-android-arrow-back"></i>
		</a>

		<!-- Leer de día o noche -->
		<i class="ion ion-ios-book ver-capitulo-leer"></i>

		<!-- Desactivar sonido -->
		<i class="ion ion-android-volume-off ver-capitulo-leer js-silenciar-audio"
			style="left: initial; right: 60px; color: #8EF0EF;"></i>
		<!-- 		<i class="ion ion-android-volume-up ver-capitulo-leer"></i> -->


		<!-- Leer de día o noche FullScreen -->
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
		<div class="ver-capitulo-post" id="sortable">
			
		<?php
		foreach ( $elementos as $elemento ) {
			if (! $elemento->b_header) {
				$closeButton = '';
				if ($isAdmin) {
					$closeButton = '<span class="ver-capitulo-post-hover-close-btn js-remove-element" data-token="' . $elemento->txt_token . '"><i class="ion ion-close-round"></i></span><span class="ver-capitulo-post-hover-mover-btn js-mover-elemento"><i class="ion ion-arrow-move"></i></span>';
				}
				
				if ($elemento->id_tipo_elemento == ConstantesWeb::TIPO_ELEMENTO_TEXTO) {
					?>
		<div
				class="ver-capitulo-post-desc ver-capitulo-post-hover-close js-elemento-leer"
				id="js-elemento-<?=$elemento->txt_token?>"
				data-token="<?=$elemento->txt_token?>">
				<div class="ver-capitulo-post-desc-text <?=$classEditable?>"
					<?=$editable?> data-token="<?=$elemento->txt_token?>">
					<?=$elemento->txt_valor?>
				</div>
				<?=$closeButton?>
			</div>		
		
		<?php
				} else if ($elemento->id_tipo_elemento == ConstantesWeb::TIPO_ELEMENTO_IMAGEN) {
					?>
				<div data-token="<?=$elemento->txt_token?>"
				class="ver-capitulo-post-image ver-capitulo-post-hover-close js-elemento-leer"
				id="js-elemento-<?=$elemento->txt_token?>">
				<div
					class="ver-capitulo-post-image-item js-container-image ver-capitulo-post-image-item-file">
					<!-- Input -->
					<?php if($isAdmin){?>
					<input type="file" class="inputfile modal-admin-form-imagen"
						onchange="uploadImage($(this),this)"
						data-token="<?=$elemento->txt_token?>">
					<!-- Label -->
					<label class="js-imagen-trigger">Cambiar</label>
					<?php }?>
					<!-- Progress Bar -->
					<div class="ver-capitulo-post-progress">
						<div id="js-progress-bar" class="ver-capitulo-post-progress-bar"></div>
						<span id="js-progress-bar-texto" class="w3-center w3-text-white">0%</span>
					</div>
					<!-- Imagen -->
					<img class="js-element-img"
						src="<?=Url::base().'/webAssets/uploads/'.ConstantesWeb::PREX_IMG.$elemento->txt_valor?>"
						alt="" style="display: block;">
					<!-- Btn de Close -->
					<?=$closeButton?>
				</div>
			</div>

				<?php
				}
			}
		}
		?>


		</div>
		<!-- end - .ver-capitulo-post -->

	</div>
	<!-- end - .container -->


	<?php
	if ($isAdmin) {
		?>
	<!-- .ver-capitulo-controlers -->
	<div class="ver-capitulo-controlers">

		<button
			class="btn ver-capitulo-controlers-btn-circle ver-capitulo-controlers-btn-circle-texto js-texto">
			<i class="ion ion-document-text"></i>
		</button>

		<button
			class="btn ver-capitulo-controlers-btn-circle ver-capitulo-controlers-btn-circle-imagen js-imagen">
			<i class="ion ion-image"></i>
		</button>

	</div>
	<!-- end - .ver-capitulo-controlers -->

	<?php
	}
	?>

</div>
<!-- end - .ver-capitulo -->