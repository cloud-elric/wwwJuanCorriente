<?php

/* @var $this yii\web\View */
$this->title = 'Ver Capítulo';
use yii\helpers\Url;
use app\models\EntElementos;
use app\models\ConstantesWeb;
use yii\web\View;

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
}
	$this->registerJsFile ( '@web/js/usuario.js', [ 
			'depends' => [ 
					\app\assets\AppAsset::className () 
			] 
	] );

?>

<input type="hidden" data-token="<?=$capitulo->txt_token?>"
	id="js-capitulo" />
	
<input type="hidden" data-token="<?=$historia?>" id="js-historia" />

<!-- .ver-capitulo-head -->
<div class="ver-capitulo-head">
	<!-- <a class="ver-capitulo-head-txt" href="#">Capítulo 1 - The chain</a> -->
	<a class="ver-capitulo-head-img" href="#"><img src="http://placehold.it/50x40" alt=""></a>
	<a class="ver-capitulo-head-img" href="#"><img src="http://placehold.it/50x40" alt=""></a>
	<a class="ver-capitulo-head-img" href="#"><img src="http://placehold.it/50x40" alt=""></a>
	<a class="ver-capitulo-head-img" href="#"><img src="http://placehold.it/50x40" alt=""></a>
	<a class="ver-capitulo-head-img" href="#"><img src="http://placehold.it/50x40" alt=""></a>
	<a class="ver-capitulo-head-img" href="#"><img src="http://placehold.it/50x40" alt=""></a>
</div>
<!-- end - .ver-capitulo-head -->

<!-- .ver-capitulo -->
<div class="ver-capitulo <?=$isAdmin?'ver-capitulo-admin':''?>"
	id="specialstuff">

	<!-- .ver-capitulo-header -->
	<div class="ver-capitulo-header" data-token='<?=empty($header)?'':$header->txt_valor?>' style="background-image: url(<?=Url::base().'/webAssets/uploads/'.(empty($header)?'portada.jpg':ConstantesWeb::PREX_IMG.$header->txt_valor)?>)">
		
	</div>

	<div class="ver-capitulo-cont">
	
	<!-- .ver-capitulo-header -->
	<div class="ver-capitulo-header-textos">
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

		<!-- Ver capítulos -->
		<p class="ver-capitulos">
			<i class="ion ion-ios-book "></i>
			<span>Capítulos</span>
		</p>

		<!-- .nav-capitulos -->
		<div class="nav-capitulos nav-scroll" data-options='{"direction": "vertical", "contentSelector": ">", "containerSelector": ">"}'>

			<div>
				<div>

					<!-- .nav-capitulos-cont -->
					<div class="nav-capitulos-cont">
						
						<!-- .close-nav-capitulos -->
						<span class="close-nav-capitulos"><i class="ion ion-close-round"></i></span>




					</div>
					<!-- end - .nav-capitulos-cont -->

				</div>
			</div>


		</div>
		<!-- end - .nav-capitulos -->


		<!-- FullScreen -->
		<div class="ver-capitulo-full-screen" id="full-screen">
			<span>FullScreen</span> <i class="ion ion-arrow-expand"></i>
		</div>

		<!-- CloseScreen -->
		<div class="ver-capitulo-close-screen" id="close-screen">
			<span>Exit Screen</span> <i class="ion ion-arrow-shrink"></i>
		</div>

		<!-- .ver-capitulo-options -->
		<div class="ver-capitulo-options">

			<!-- .ver-capitulo-options-texto-resize -->
			<div class="ver-capitulo-options-texto-resize">
				<button class="ver-capitulo-options-texto-resize-icon"><i id="icon-resize" class="ion ion-arrow-resize"></i></i></button>
				<div href="#" class="ver-capitulo-options-texto-resize-slider">
					<span>a</span>
					<input type="range" id="my-texto" min="16" max="40" step ="2" value="16">
					<span>a</span>
				</div>
			</div>
			<!-- end - .ver-capitulo-options-texto-resize -->

			<!-- .ver-capitulo-options-focus -->
			<span class="ver-capitulo-options-focus">
				<i class="ion ion-android-bulb"></i>
			</span>
			<!-- end - .ver-capitulo-options-focus -->

			<!-- .ver-capitulo-options-volume -->
			<span class="ver-capitulo-options-volume js-silenciar-audio">
				<i class="ion ion-android-volume-up"></i>
				<!-- <i class="ion ion-android-volume-off"></i> -->
			</span>
			<!-- end - .ver-capitulo-options-volume -->

		</div>
		<!-- end - .ver-capitulo-options -->

	</div>
	<!-- end - .ver-capitulo-header -->

	<!-- .container -->
	<div class="container popup-gallery">

		<!-- .ver-capitulo-post -->
		<div class="ver-capitulo-post" id="sortable">
			
		<?php
		foreach ( $elementos as $elemento ) {
			if (! $elemento->b_header) {
				$closeButton = '';
				if ($isAdmin) {
					$closeButton = '<span class="ver-capitulo-post-hover-close-btn js-remove-element" data-token="' . $elemento->txt_token . '"><i class="ion ion-close-round"></i></span><span class="ver-capitulo-post-hover-mover-btn js-mover-elemento"><i class="ion ion-arrow-move"></i></span>';
				}
				

				if($elemento->id_tipo_elemento ==ConstantesWeb::TIPO_ELEMENTO_TEXTO){
				?>
					<div
						class="ver-capitulo-post-desc ver-capitulo-post-hover-close js-elemento-leer"
						id="js-elemento-<?=$elemento->txt_token?>" data-token="<?=$elemento->txt_token?>">
						<div class="ver-capitulo-post-desc-text <?=$classEditable?>"
							<?=$editable?> data-token="<?=$elemento->txt_token?>">
							<?=$elemento->txt_valor?>
						</div>
						<?=$closeButton?>
					</div>
				<?php
				}else if($elemento->id_tipo_elemento ==ConstantesWeb::TIPO_ELEMENTO_IMAGEN){
					?>
				<div data-token="<?=$elemento->txt_token?>" class="ver-capitulo-post-image ver-capitulo-post-hover-close js-elemento-leer" id="js-elemento-<?=$elemento->txt_token?>">
				<div class="ver-capitulo-post-image-item ver-capitulo-post-image-item-active-zoom js-container-image ver-capitulo-post-image-item-file">

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
					<img class="ver-capitulo-post-image-imagen js-element-img" src="<?=Url::base().'/webAssets/uploads/'.ConstantesWeb::PREX_IMG.$elemento->txt_valor?>" alt="" style="display: block;">
					<div class="ver-capitulo-post-image-item-zoom">
						<a href="<?=Url::base().'/webAssets/uploads/'.ConstantesWeb::PREX_IMG.$elemento->txt_valor?>" title="The Cleaner">
							<i class="ion ion-arrow-expand"></i>
						</a>
					</div>

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


<!-- <div style="background-color: pink;">
	


<p id="demo"></p>

<a href="#" class="aumentarFont">[ + aumentar ]</a> 
<a href="#" class="disminuirFont">[ - disminuir ]</a> 
<a href="#" class="resetearFont">[ resetear ]</a>

</div> -->


	<!-- <div class="popup-gallery">
		<a href="http://farm9.staticflickr.com/8242/8558295633_f34a55c1c6_b.jpg" title="The Cleaner"><img src="http://farm9.staticflickr.com/8242/8558295633_f34a55c1c6_s.jpg" width="75" height="75"></a>
		<a href="http://farm9.staticflickr.com/8382/8558295631_0f56c1284f_b.jpg" title="Winter Dance"><img src="http://farm9.staticflickr.com/8382/8558295631_0f56c1284f_s.jpg" width="75" height="75"></a>
		<a href="http://farm9.staticflickr.com/8225/8558295635_b1c5ce2794_b.jpg" title="The Uninvited Guest"><img src="http://farm9.staticflickr.com/8225/8558295635_b1c5ce2794_s.jpg" width="75" height="75"></a>
		<a href="http://farm9.staticflickr.com/8383/8563475581_df05e9906d_b.jpg" title="Oh no, not again!"><img src="http://farm9.staticflickr.com/8383/8563475581_df05e9906d_s.jpg" width="75" height="75"></a>
		<a href="http://farm9.staticflickr.com/8235/8559402846_8b7f82e05d_b.jpg" title="Swan Lake"><img src="http://farm9.staticflickr.com/8235/8559402846_8b7f82e05d_s.jpg" width="75" height="75"></a>
		<a href="http://farm9.staticflickr.com/8235/8558295467_e89e95e05a_b.jpg" title="The Shake"><img src="http://farm9.staticflickr.com/8235/8558295467_e89e95e05a_s.jpg" width="75" height="75"></a>
		<a href="http://farm9.staticflickr.com/8378/8559402848_9fcd90d20b_b.jpg" title="Who's that, mommy?"><img src="http://farm9.staticflickr.com/8378/8559402848_9fcd90d20b_s.jpg" width="75" height="75"></a>
	</div> -->


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

</div>
<!-- end - .ver-capitulo -->

<?php 

$this->registerJs ( "
  		cargarCapitulos('".$historia."');
	", View::POS_END, 'cargarCapitulos' );

?>