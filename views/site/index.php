<?php

/* @var $this yii\web\View */
$this->title = 'Inicio';
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$editable = '';
$classEditable = '';
// $isAdmin = ! Yii::$app->user->isGuest;
$isAdmin = ! Yii::$app->user->isGuest;

if ($isAdmin) {
	$editable = " data-new='noNuevo'  data-progress='noProceso'";
	
	$this->registerJsFile ( '@web/js/historias.js', [
			'depends' => [
					\app\assets\AppAsset::className ()
			]
	] );
}
?>


<?php 
if($isAdmin){
	?>
<script>
var isVarAdmin = true;
</script>
<?php }else{
?>
<script>
var isVarAdmin = false;
</script>
<?php }?>
<!-- .home -->
<div class="home">
	<!-- .container -->
	<div class="container">

		<!-- .home-categorias -->
		<div class="home-categorias">
			<?php
			$active = 1;
			foreach ( $historias as $historia ) {
				$class = '';
				if ($active == 1) {
					$class = 'active';
				}
				?>


				<div class="home-categorias-item tooltip <?=$class?> home-categorias-item-<?=$historia->txt_token?>" data-token="<?=$historia->txt_token ?>">
					<div class="tooltipitem" <?=$editable?> data-token="<?=$historia->txt_token ?>" ><?=$historia->txt_nombre?></div>
					<div class="tooltiptext" data-token="<?=$historia->txt_token ?>"><?=$historia->txt_nombre?></div>
				</div>
	
				
	
			<?php
				$active ++;
			}
			?>
			
			
		</div>
		<!-- end - .home-categorias -->

		<?php
		$active = 1;
		foreach ( $historias as $historia ) {
			$class = '';
			if ($active == 1) {
				$class = 'active';
			}
			?>
			
			<article class="home-article animsition-effect-<?=$historia->txt_token?> animsition-effect <?=$class?>">
			<div class="row">
			
				<div class="col-xs-12 col-sm-6 home-article-col">
					<img class="home-article-imagen image-change-<?=$historia->txt_token?>" data-token="<?=$historia->txt_token?>"
						src="<?=Url::base().'/webAssets/uploads/min_'.$historia->txt_image?>"
						alt="<?=$historia->txt_nombre ?>">
						
						<?php if($isAdmin){?>
						<!-- .listado-image -->
					<div class="listado-image" style="display: none;">
						<div class="listado-image-item">
							<!-- Input -->
							<input type="file" data-token='<?=$historia->txt_token?>' id="js-label-<?=$historia->txt_token?>" onchange="cambiarImagen($(this), this)"
								class="inputfile modal-admin-form-imagen inputFileCard">
							<!-- Label -->
							<label class="js-label" for="js-label-<?=$historia->txt_token?>">Cambiar Imagen</label>
						</div>
					</div>
					<!-- end .listado-image -->
					<?php }?>
				</div>
				<div class="col-xs-12 col-sm-6 home-article-col">
					<h3 class="home-article-title">Descripción</h3>
					<div data-token="<?=$historia->txt_token?>" class="home-article-desc" <?=$editable?>>
							<?=$historia->txt_descripcion?>
						</div>
				</div>
			</div>
			<?php if($isAdmin){?>
			<!-- .home-categorias-delete -->
			<span class="home-categorias-delete" data-token="delete-historia-<?=$historia->txt_token?>">
				<i class="ion ion-close-round"></i>
			</span>
			<!-- end - .home-categorias-delete -->
			<?php }?>
			<a class="btn btn-primary home-article-button ladda-button"
				href="<?=Url::base()?>/site/lista-de-capitulos?token=<?=$historia->txt_token?>" data-style="zoom-out"><span class="ladda-label">Comenzar a leer</span></a>
		</article>
		<?php
		$active ++;
		}
		?>
	</div>
	<!-- end - .container -->
</div>
<!-- end - .home -->

<div class="tooltip">
	<p>Hover over me</p>
	<span class="tooltiptext">Tooltip text</span>
</div>

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

	<button id="js-edicion-capitulos"
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
				Agregar <span>Historia</span>
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
			'id' => 'form-agregar-historia' 
	] );
	echo $form->field ( $historia, 'txt_nombre' )->hiddenInput ()->label ( false );
	
	echo $form->field($historia, 'txt_descripcion')->hiddenInput()->label(false);
	?>

		<div class="row">
			<div class="col-xs-12 col-md-8">

				<!-- Título -->
				<h3 class="modal-admin-form-titulo" contentEditable="true"
					data-new="esNuevo" id="js-nombre-capitulo">Dame un nombre...</h3>
					
				<div class="modal-admin-form-descripcion" data-new="esNuevo" contentEditable="true" id="js-descripcion-historia">
					Agrega la descripción de la historia
				</div>	

			</div>

			<div class="col-xs-12 col-md-4">


				<!-- .listado-modal-image -->
				<div class="listado-modal-image">
					<div class="listado-modal-image-item" id="js-contenedor-image-cap">
						<!-- Input -->
						<input type="file" id="file-modal" name="imageCapitulo"
							class="inputfile modal-admin-form-imagen inputFileCapitulo">
						<!-- Label -->
						<label class="js-label-image-cap">Agregar Imagen</label>
						<!-- Progress Bar -->
						<div
							class="ver-capitulo-post-progress ver-capitulo-post-progress-middle">
							<div id="js-progress-bar" class="ver-capitulo-post-progress-bar"></div>
							<span id="js-progress-bar-texto" class="w3-center w3-text-white">0%</span>
						</div>
						<!-- Imagen -->

					</div>
				</div>
				<!-- end .listado-modal-image -->

			</div>

		</div>

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

<?php }?>