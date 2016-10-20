<?php

/* @var $this yii\web\View */

$this->title = 'Inicio';
use yii\helpers\Url;
?>

<!-- .home -->
<div class="home">
	<!-- .container -->
	<div class="container">

		<!-- .home-categorias -->
		<div class="home-categorias">
			<div class="home-categorias-item active">Opción 1</div>
			<div class="home-categorias-item">Opción 2</div>
			<div class="home-categorias-item">Opción 3</div>
			<div class="home-categorias-item">Opción 4</div>
			<div class="home-categorias-item">Opción 5</div>
			<div class="home-categorias-item">Opción 6</div>
		</div>
		<!-- end - .home-categorias -->

		<article class="home-article active">
			<div class="row">
				<div class="col-xs-12 col-sm-6 home-article-col">
					<img class="home-article-imagen" src="<?=Url::base()?>/webAssets/images/portada.jpg" alt="Article">
				</div>
				<div class="col-xs-12 col-sm-6 home-article-col">
					<h3 class="home-article-title">Descripción 1</h3>
					<p class="home-article-desc">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus eligendi ea voluptas hic veritatis a aut modi consectetur voluptatum sapiente, culpa adipisci, distinctio nulla ipsum, magnam architecto doloribus, fugiat ex?. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde sapiente voluptates, inventore at maxime ex sunt exercitationem ipsum expedita, nesciunt molestiae labore dolorem accusantium cum ullam enim, laudantium, dolor harum.
					</p>
				</div>
			</div>
			<a class="btn btn-primary home-article-button ladda-button" data-style="zoom-out" href="<?=Url::base()?>/site/lista-de-capitulos"><span class="ladda-label">Comenzar a leer</span></a>
		</article>

		<article class="home-article">
			<div class="row">
				<div class="col-xs-12 col-sm-6 home-article-col">
					<img class="home-article-imagen" src="<?=Url::base()?>/webAssets/images/portada.jpg" alt="Article">
				</div>
				<div class="col-xs-12 col-sm-6 home-article-col">
					<h3 class="home-article-title">Descripción 2</h3>
					<p class="home-article-desc">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus eligendi ea voluptas hic veritatis a aut modi consectetur voluptatum sapiente, culpa adipisci, distinctio nulla ipsum, magnam architecto doloribus, fugiat ex?. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde sapiente voluptates, inventore at maxime ex sunt exercitationem ipsum expedita, nesciunt molestiae labore dolorem accusantium cum ullam enim, laudantium, dolor harum.
					</p>
				</div>
			</div>
			<a class="btn btn-primary home-article-button ladda-button" data-style="zoom-out" href="<?=Url::base()?>/site/lista-de-capitulos"><span class="ladda-label">Comenzar a leer</span></a>
		</article>

	</div>
	<!-- end - .container -->
</div>
<!-- end - .home -->