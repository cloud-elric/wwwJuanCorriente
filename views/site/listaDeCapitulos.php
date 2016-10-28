<?php

/* @var $this yii\web\View */
$this->title = 'Listado';
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\modules\ModUsuarios\models\Utils;

# $isAdmin = ! Yii::$app->user->isGuest;
$isAdmin = !Yii::$app->user->isGuest;

if ($isAdmin) {
	$this->registerJsFile ( '@web/js/admin.js', [ 
			'depends' => [ 
					\app\assets\AppAsset::className () 
			] 
	] );
	
	$this->registerJsFile ( '@web/js/editarCapitulo.js', [ 
			'depends' => [ 
					\app\assets\AppAsset::className () 
			] 
	] );
}
?>

<!-- .listado -->
<div class="listado">
	<!-- .container -->
	<div class="container">

		<!-- .listado-seach -->
		<div class="listado-seach">
			<input type="text">
			<button>
				<i class="ion ion-ios-search-strong"></i>
			</button>
		</div>
		<!-- end - .listado-seach -->

		<!-- .listado-articles -->
		<article class="listado-articles">
			

			<?php
			$numCapitulo = 1;
			$capitulos = $historia->entCapitulos;
			$numCapitulos = count ( $capitulos );
			foreach ( $capitulos as $capitulo ) {
				?>
			
			<!-- .listado-articles-item -->

			<a class="listado-articles-item listado-articles-item-hover-close" data-token="<?=$capitulo->txt_token?>" id="js-element-cap-<?=$capitulo->txt_token?>"

				href="<?=Url::base()?>/site/ver-capitulo?token=<?=$historia->txt_token?>&capitulo=<?=$capitulo->txt_token?>">
				<!-- .listado-articles-item-imagen -->
				<div class="listado-articles-item-imagen" style="background-image:url('<?=Url::base()?>/webAssets/uploads/<?=empty($capitulo->txt_imagen)?'noImage.jpg':$capitulo->txt_imagen?>')">
					<div class="listado-articles-item-capitulo">
						<h4>Capitulo <?=$numCapitulo?></h4>
					</div>
					<?php
				if ($numCapitulos == $numCapitulo) {
					?>
					<div class="listado-articles-item-new">
						<span>Nuevo</span>
					</div>
					<?php
				}
				?>


				<?php
				if ($isAdmin) {
					?>
						<!-- .listado-image -->
					<div class="listado-image" style="display:none;">
						<div class="listado-image-item">
							<!-- Input -->
							<input type="file" 
								class="inputfile modal-admin-form-imagen inputFileCard">
							<!-- Label -->
							<label class="js-label">Cambiar Imagen</label>
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
				<?php
				}
				?>

				</div> <!-- end - .listado-articles-item-imagen --> <!-- .listado-articles-item-title -->
				<h3 class="listado-articles-item-title"><?=$capitulo->txt_nombre?></h3>

				<?php
				if ($isAdmin) {
					?>
				<!-- Btn de Close -->
				<span class="listado-articles-item-hover-close-btn" style="display:none;"><i class="ion ion-close-round"></i></span>
				
				<?php 
				}
				?>
			</a>
			<!-- end - .listado-articles-item -->
			
			<?php
				$numCapitulo ++;
			}
			?>



		</article>
		<!-- end - .listado-articles -->

	</div>
	<!-- end - .container -->
</div>
<!-- end - .listado -->

<?php
if ($isAdmin) {
	?>

<!-- .listado-controlers -->
<div class="listado-controlers">

	<!-- Btn Mostar Modal -->
	<button id="modal-agregar-post-open"
		class="btn ver-capitulo-controlers-btn-circle listado-controlers-btn-circle-agregar">
		<i class="ion ion-wand"></i>
	</button>

	<button
		id="js-edicion-capitulos"
		class="btn ver-capitulo-controlers-btn-circle listado-controlers-btn-circle-editar">
		<i class="ion ion-android-create"></i>
	</button>

</div>
<!-- end - .listado-controlers -->


<!-- .modal -->
<div id="modal-agregar-post" class="modal modal-admin">

	<!-- .modal-content -->
	<div class="modal-content">

		<!-- Btn Close -->
		<!-- <span id="modal-agregar-post-close" class="modal-close"><i class="ion ion-close-round"></i></span> -->

		<!-- .modal-admin-header -->
		<div class="modal-admin-header">
			<!-- .modal-admin-cont-title -->
			<h2 class="modal-admin-cont-title">
				Agregar <span>Capítulo</span>
			</h2>
			<!-- end - .modal-admin-cont-title -->

		</div>
		<!-- end - .modal-admin-header -->

		<!-- .modal-admin-form -->
		<?php
	$form = ActiveForm::begin ( [ 
			'options' => [ 
					'enctype' => 'multipart/form-data',
					'class' => 'modal-admin-form' 
			],
			
			'layout' => 'horizontal',
			'id' => 'form-agregar-capitulo' 
	] );
	$capituloForm->fch_publicacion = Utils::changeFormatDate ( Utils::getFechaActual () );
	echo $form->field ( $capituloForm, 'txt_nombre' )->hiddenInput ()->label ( false );
	?>

		<div class="row">
			<div class="col-xs-12 col-md-8">

				<!-- Título -->
				<h3 class="modal-admin-form-titulo" contentEditable="true"
					data-new="esNuevo" id="js-nombre-capitulo">Dame un título...</h3>

				<!-- .modal-admin-form-datepiker -->
				<div class="modal-admin-form-datepiker">
					<label for="datepicker">Selecciona una fecha de Publicación</label> 
					<?php echo $form->field ( $capituloForm, 'fch_publicacion' )->textInput(['class'=>'datepicker','placeholder'=>'10-Oct-2016'])->label ( false );?>
					
				</div>
				<!-- end - .modal-admin-form-datepiker -->


			</div>

			<div class="col-xs-12 col-md-4">


				<!-- .listado-modal-image -->
				<div class="listado-modal-image">
					<div class="listado-modal-image-item" id="js-contenedor-image-cap">
						<!-- Input -->
						<input type="file" id="file-modal" name="imageCapitulo" class="inputfile modal-admin-form-imagen inputFileCapitulo">
						<!-- Label -->
						<label class="js-label-image-cap">Agregar Imagen</label>
						<!-- Progress Bar -->
						<div class="ver-capitulo-post-progress ver-capitulo-post-progress-middle">
							<div id="js-progress-bar" class="ver-capitulo-post-progress-bar"></div>
							<span id="js-progress-bar-texto" class="w3-center w3-text-white">0%</span>
						</div>
						<!-- Imagen -->
						
					</div>
				</div>
				<!-- end .listado-modal-image -->

			</div>

		</div>

		<input type="hidden" data-historia="<?=$historia->txt_token?>"
			id="js-historia" />
		<!-- Título -->
		<!-- <label class="modal-admin-form-titulo" for="modal-admin-form-titulo">Dame un título...</label>
			<input class="modal-admin-form-titulo" type="text" id="modal-admin-form-titulo" placeholder="Dame un título..."> -->



		<!-- .modal-admin-footer -->
		<div class="modal-admin-footer">
			<!-- .modal-admin-cont-btn-guardar -->
			<button id="modal-agregar-post-guardar"
				class="btn modal-admin-cont-btn-guardar ladda-button"
				data-style="zoom-out">
				<span class="ladda-label">Guardar</span>
			</button>
			<!-- end - .modal-admin-cont-btn-guardar -->
		</div>
		<!-- end - .modal-admin-footer -->



		<?php
	
	ActiveForm::end ();
	
	?>
		<!-- end - .modal-admin-form -->

	</div>
	<!-- end - .modal-content -->

</div>



<!-- .modal -->
<div id="modal-mensaje" class="modal modal-mensaje">

	<!-- .modal-content -->
	<div class="modal-content">

		<!-- Btn Close -->
		<span class="modal-close modal-mensaje-close"><i class="ion ion-close-round"></i></span>

		<p>
			Esta a punto de eliminar un capítulo con todo su contendio ¿Estas seguro de continuar?
		</p>
		
		<!-- .modal-footer -->
		<div class="modal-footer">
			
			<!-- Btn Mostar Modal -->
			<button class="btn btn-modal-mensaje modal-mensaje-close">
				No
			</button>

			<button class="btn btn-secundary" id="js-eliminar-capitulo" data-eliminar >
				Si, borrar capítulo
			</button>

		</div>
		<!-- end - .modal-footer -->

	</div>
	<!-- end - .modal-content -->

</div>
<!-- end - .modal -->

<?php }?>