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
					<img class="home-article-imagen"
						src="<?=Url::base()?>/webAssets/images/<?=$historia->txt_image?>"
						alt="<?=$historia->txt_nombre ?>">
				</div>
				<div class="col-xs-12 col-sm-6 home-article-col">
					<h3 class="home-article-title">Descripción</h3>
					<p class="home-article-desc">
							<?=$historia->txt_descripcion?>
						</p>
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