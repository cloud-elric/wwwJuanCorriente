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