<?php

/* @var $this yii\web\View */

$this->title = 'Listado';
use yii\helpers\Url;
?>

<!-- .listado -->
<div class="listado">
	<!-- .container -->
	<div class="container">
		
		<!-- .listado-seach -->
		<div class="listado-seach">
			<input type="text">
			<button><i class="ion ion-ios-search-strong"></i></button>
		</div>
		<!-- end - .listado-seach -->
		
		<!-- .listado-articles -->
		<article class="listado-articles">
			<!-- .listado-articles-item -->
			<a class="listado-articles-item" href="<?=Url::base()?>/site/ver-capitulo">
				<!-- .listado-articles-item-imagen -->
				<div class="listado-articles-item-imagen">
					<div class="listado-articles-item-capitulo">
						<h4>Capitulo 1</h4>
					</div>
					<div class="listado-articles-item-new">
						<span>Nuevo</span>
					</div>
				</div>
				<!-- end - .listado-articles-item-imagen -->
				<!-- .listado-articles-item-title -->
				<h3 class="listado-articles-item-title">El Milagro</h3>
			</a>
			<!-- end - .listado-articles-item -->

			<!-- .listado-articles-item -->
			<a class="listado-articles-item" href="<?=Url::base()?>/site/ver-capitulo">
				<!-- .listado-articles-item-imagen -->
				<div class="listado-articles-item-imagen">
					<div class="listado-articles-item-capitulo">
						<h4>Capitulo 1</h4>
					</div>
				</div>
				<!-- end - .listado-articles-item-imagen -->
				<!-- .listado-articles-item-title -->
				<h3 class="listado-articles-item-title">El Milagro</h3>
			</a>
			<!-- end - .listado-articles-item -->

			<!-- .listado-articles-item -->
			<a class="listado-articles-item" href="<?=Url::base()?>/site/ver-capitulo">
				<!-- .listado-articles-item-imagen -->
				<div class="listado-articles-item-imagen">
					<div class="listado-articles-item-capitulo">
						<h4>Capitulo 1</h4>
					</div>
				</div>
				<!-- end - .listado-articles-item-imagen -->
				<!-- .listado-articles-item-title -->
				<h3 class="listado-articles-item-title">El Milagro</h3>
				<!-- end - .listado-articles-item-title -->
			</a>
			<!-- end - .listado-articles-item -->

			<!-- .listado-articles-item -->
			<a class="listado-articles-item" href="<?=Url::base()?>/site/ver-capitulo">
				<!-- .listado-articles-item-imagen -->
				<div class="listado-articles-item-imagen">
					<div class="listado-articles-item-capitulo">
						<h4>Capitulo 1</h4>
					</div>
				</div>
				<!-- end - .listado-articles-item-imagen -->
				<!-- .listado-articles-item-title -->
				<h3 class="listado-articles-item-title">El Milagro</h3>
			</a>
			<!-- end - .listado-articles-item -->



		</article>
		<!-- end - .listado-articles -->

	</div>
	<!-- end - .container -->
</div>
<!-- end - .listado -->

<!-- Btn Mostar Modal -->
<button id="modal-agregar-post-open" class="btn admin-agregar-btn-circle"><i class="ion ion-wand"></i></button>

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
			<button id="modal-agregar-post-open" class="btn modal-admin-cont-btn-guardar">
				Guardar
			</button>
			<!-- end - .modal-admin-cont-btn-guardar -->
		</div>
		<!-- end - .modal-admin-header -->
		
		<!-- .modal-admin-form -->
		<form action="" class="modal-admin-form">

			<!-- Título -->
			<!-- <label class="modal-admin-form-titulo" for="modal-admin-form-titulo">Dame un título...</label>
			<input class="modal-admin-form-titulo" type="text" id="modal-admin-form-titulo" placeholder="Dame un título..."> -->
			
			<!-- Título -->
			<h3 class="modal-admin-form-titulo" contentEditable="true">Dame un título...</h3>

			<!-- <div class="component-calendar">
				<input class="calendar-date" type="text" value="">
				<span class="calendar-icon"><i class="fa fa-calendar"></i></span>
			</div> -->

			<!-- .modal-admin-form-datepiker -->
			<div class="modal-admin-form-datepiker">
				<label for="datepicker">Selecciona una fecha de Publicación</label>
				<input type="text" id="datepicker" placeholder="20 - octubre - 2016">
			</div>
			<!-- end - .modal-admin-form-datepiker -->

			<!-- .modal-admin-form-header -->
			<!-- <div class="modal-admin-form-header">
				<span>Agregar Header</span>
			</div> -->
			<!-- end - .modal-admin-form-header -->

			<input class="modal-admin-form-header" type="file" placeholder="Agregar Header">
			
			<!-- Texto -->
			<!-- <label class="modal-admin-form-texto" for="modal-admin-form-texto">Dame un parrafo...</label>
			<textarea class="modal-admin-form-texto" id="modal-admin-form-texto" placeholder="Dame un parrafo..."></textarea> -->

			<!-- Texto -->
			<p class="modal-admin-form-texto" contentEditable="true"></p>

			<!-- .modal-admin-form-controlers -->
			<div class="modal-admin-form-controlers">
				
				<button id="modal-agregar-post-open" class="btn modal-admin-form-controlers-btn-circle modal-admin-form-controlers-btn-circle-texto">
					<i class="ion ion-document-text"></i>
				</button>

				<button id="modal-agregar-post-open" class="btn modal-admin-form-controlers-btn-circle modal-admin-form-controlers-btn-circle-imagen">
					<i class="ion ion-image"></i>
				</button>

			</div>
			<!-- end - .modal-admin-form-controlers -->

		</form>
		<!-- end - .modal-admin-form -->

	</div>
	<!-- end - .modal-content -->

</div>
<!-- end - .modal -->

<!-- .admin -->
<div class="admin">
	<!-- .admin-cont -->
	<div class="admin-cont">
		<!-- .admin-cont-form -->
		<div class="admin-cont-form">
			d
		</div>
		<!-- end - .admin-cont-form -->
	</div>
	<!-- end - .admin-cont -->
</div>
<!-- end - .admin -->