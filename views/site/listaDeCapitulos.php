<?php

/* @var $this yii\web\View */
$this->title = 'Listado';
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->registerJsFile('@web/js/admin.js',['depends' => [\app\assets\AppAsset::className()]]);
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
			<a class="listado-articles-item"
				href="<?=Url::base()?>/site/ver-capitulo"> <!-- .listado-articles-item-imagen -->
				<div class="listado-articles-item-imagen" style="background-image:url('<?=Url::base()?>/webAssets/uploads/<?=$capitulo->txt_imagen?>')">
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
				</div> <!-- end - .listado-articles-item-imagen --> <!-- .listado-articles-item-title -->
				<h3 class="listado-articles-item-title"><?=$capitulo->txt_nombre?></h3>
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

<!-- Btn Mostar Modal -->
<button id="modal-agregar-post-open"
	class="btn admin-agregar-btn-circle">
	<i class="ion ion-wand"></i>
</button>

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

			<!-- .modal-admin-cont-btn-guardar -->
<<<<<<< HEAD
			<button id="modal-agregar-post-open"
				class="btn modal-admin-cont-btn-guardar">Guardar</button>
=======
			<button id="modal-agregar-post-guardar" class="btn modal-admin-cont-btn-guardar ladda-button" data-style="zoom-out">
				<span class="ladda-label">Guardar</span>
			</button>
>>>>>>> e59b842772f7751a123d43e2c097e43108292e8f
			<!-- end - .modal-admin-cont-btn-guardar -->
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
		
		?>
			<!-- Título -->
		<!-- <label class="modal-admin-form-titulo" for="modal-admin-form-titulo">Dame un título...</label>
			<input class="modal-admin-form-titulo" type="text" id="modal-admin-form-titulo" placeholder="Dame un título..."> -->

		<!-- Título -->
		<h3 class="modal-admin-form-titulo" contentEditable="true" data-new="true" id="js-nombre-capitulo">Dame un
			título...</h3>

		<!-- .modal-admin-form-datepiker -->
		<div class="modal-admin-form-datepiker">
			<label for="datepicker">Selecciona una fecha de Publicación</label> <input
				type="text" id="datepicker" placeholder="20-oct-2016">
		</div>
		<!-- end - .modal-admin-form-datepiker -->

		<!-- .modal-admin-form-header -->
		<!-- <div class="modal-admin-form-header">
				<span>Agregar Header</span>
			</div> -->
			<!-- end - .modal-admin-form-header -->
			
			<!-- File Header -->
			<input type="file" class="modal-admin-form-header">
			
			<!-- Texto -->
			<!-- <label class="modal-admin-form-texto" for="modal-admin-form-texto">Dame un parrafo...</label>
			<textarea class="modal-admin-form-texto" id="modal-admin-form-texto" placeholder="Dame un parrafo..."></textarea> -->

			<!-- Texto -->
			<p class="modal-admin-form-texto" contentEditable="true">Dame un parrafo...</p>
			
			<!-- File Imagen -->
			<input type="file" class="modal-admin-form-imagen">

		<!-- .modal-admin-form-controlers -->
		<div class="modal-admin-form-controlers">

			<button id="modal-agregar-post-open"
				class="btn modal-admin-form-controlers-btn-circle modal-admin-form-controlers-btn-circle-texto">
				<i class="ion ion-document-text"></i>
			</button>

			<button id="modal-agregar-post-open"
				class="btn modal-admin-form-controlers-btn-circle modal-admin-form-controlers-btn-circle-imagen">
				<i class="ion ion-image"></i>
			</button>

		</div>
		<!-- end - .modal-admin-form-controlers -->

		<?php
		
		ActiveForm::end ();
		
		?>
		<!-- end - .modal-admin-form -->

	</div>
	<!-- end - .modal-content -->

</div>
