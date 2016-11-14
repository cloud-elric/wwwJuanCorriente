<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

    <head>

        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
<script> var basePath = '<?=Yii::$app->urlManager->createAbsoluteUrl ( [''] );?>'; </script>
    </head>

    <body>

        <?php $this->beginBody() ?>
        <!-- .animsition -->
        <div class="animsition">
                
            <?php if(!Yii::$app->user->isGuest){?>
                <!-- <a class="btn btn-primary cerrar-sesion" href="salir">Salir</a> -->
                <a class="cerrar-sesion" href="salir"><i class="ion ion-android-exit"></i></a>
            <?php }?>
            
            <!-- header -->
            <header>
                <h1>Historias de México</h1>
            </header>
            <!-- end - header -->

            <!-- .page -->
            <div class="page">
                <?= $content ?>
            </div>
            <!-- end - .page -->
            
            <!-- footer -->
            <footer>
                <!-- .container-full -->
                <div class="container-full">
                    <h6>Síguenos</h6>
                    <div class="social-media">
                        <a href=""><i class="ion ion-social-facebook"></i></a>
                        <a href=""><i class="ion ion-social-twitter"></i></a>
                        <a href=""><i class="ion ion-social-pinterest"></i></a>
                    </div>
                </div>
                <!-- end - .container-full -->
            </footer>
            <!-- end - footer -->

        </div>
        <!-- end - .animsition -->
        <?php $this->endBody() ?>

    </body>

</html>
<?php $this->endPage() ?>