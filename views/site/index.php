<?php

/* @var $this yii\web\View */
$this->title = 'Inicio';
use yii\helpers\Url;

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
				<div class="home-categorias-item <?=$class?> home-categorias-item-<?=$historia->txt_token?>"
				data-token="<?=$historia->txt_token ?>"><?=$historia->txt_nombre?></div>
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

<?php }?>