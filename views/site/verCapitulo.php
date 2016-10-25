<?php

/* @var $this yii\web\View */
$this->title = 'Ver Capítulo';
use yii\helpers\Url;
use app\models\EntElementos;
use app\models\ConstantesWeb;

$this->registerJsFile ( '@web/js/admin.js', [ 
		'depends' => [ 
				\app\assets\AppAsset::className () 
		] 
] );

$this->registerJsFile ( '@web/js/jquery.form.js', [ 
		'depends' => [ 
				\app\assets\AppAsset::className () 
		] 
] );

$header = EntElementos::find ()->where ( [ 
		'id_capitulo' => $capitulo->id_capitulo,
		'b_header' => 1,
		'id_tipo_elemento' => ConstantesWeb::TIPO_ELEMENTO_HEADER 
] )->one ();

$editable = '';
$classEditable = '';
$isAdmin = true;

if ($isAdmin) {
	$editable = " contentEditable='true' data-new='noNuevo'  data-progress='noProceso' ";
	$classEditable = ' js-elemento-editable';
}
?>

<input type="hidden" data-token="<?=$capitulo->txt_token?>" id="js-capitulo" />

<!-- .ver-capitulo -->
<div class="ver-capitulo ver-capitulo-admin" id="specialstuff">

	<!-- .ver-capitulo-header -->
	<div class="ver-capitulo-header" style="background-image: url(<?=Url::base().(empty($header)?'/webAssets/images/portada.jpg':$header->txt_valor)?>)">

		<h1>Historias de México</h1>

		<h2><?=$capitulo->txt_nombre?></h2>

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
			
		<?php
		foreach ( $elementos as $elemento ) {
			if (! $elemento->b_header) {
				$closeButton = '';
				if ($isAdmin) {
					$closeButton = '<span class="ver-capitulo-post-hover-close-btn js-remove-element" data-token="' . $elemento->txt_token . '"><i class="ion ion-close-round"></i></span>';
				}
				
				?>
		<div
					class="ver-capitulo-post-desc ver-capitulo-post-hover-close js-elemento-leer"
					id="js-elemento-<?=$elemento->txt_token?>">
					<div class="ver-capitulo-post-desc-text <?=$classEditable?>"
						<?=$editable?> data-token="<?=$elemento->txt_token?>">
					<?=$elemento->txt_valor?>
				</div>
				<?=$closeButton?>
			</div>		
		
		<?php
			}
		}
		?>

			<!-- <div class="ver-capitulo-post-imagen ver-capitulo-post-hover-close">
					<img src="<?=Url::base()?>/webAssets/images/monkey.png"
						alt="Article"> <span class="ver-capitulo-post-hover-close-btn"><i
						class="ion ion-close-round"></i></span>
				</div>

			
				<input type="file" class="modal-admin-form-imagen" onchange="uploadImage($(this),this)"> 
				 -->

			<div class="ver-capitulo-post-image ver-capitulo-post-hover-close">
				<div class="ver-capitulo-post-image-item js-container-image">
					<input type="file" id="file" class="inputfile modal-admin-form-imagen" onchange="uploadImage($(this),this)">
					<label for="file">Agregar Imagen</label>
					<img src="" alt="">
					<span class="ver-capitulo-post-hover-close-btn"><i class="ion ion-close-round"></i></span>
				</div>
			</div>

			<div class="ver-capitulo-post-image ver-capitulo-post-hover-close">
				<div class="ver-capitulo-post-image-item js-container-image ver-capitulo-post-image-item-file">
					<input type="file" id="file" class="inputfile modal-admin-form-imagen" onchange="uploadImage($(this),this)">
					<label for="file">Agregar Imagen</label>
					<img src="<?=Url::base()?>/webAssets/images/portada.jpg" alt="Article" style="display: block;">
					<span class="ver-capitulo-post-hover-close-btn"><i class="ion ion-close-round"></i></span>
				</div>
			</div>

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