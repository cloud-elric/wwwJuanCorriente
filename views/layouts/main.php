<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
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
		<link rel="shortcut icon" href="<?php echo Yii::$app->getHomeUrl(); ?>/favicon.png" type="image/x-icon" />
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
                <a class="cerrar-sesion" href="<?=Yii::$app->urlManager->createAbsoluteUrl ( ['site/salir'] );?>"><i class="ion ion-android-exit"></i></a>
            <?php }?>
            
            <!-- header -->
            <header>
                <a class="logoSite" href="<?=Yii::$app->urlManager->createAbsoluteUrl ( [''] );?>"><h1></h1></a>
            </header>
            <!-- end - header -->

            <!-- .page -->
            <div class="page">
                <?= $content ?>
            </div>
            <!-- end - .page -->
            
            <!-- footer -->
            <footer>
                <!-- .container -->
                <div class="container">

                    <!-- .footer-siguenos -->
                    <div class="footer-siguenos">
                        <h6>Síguenos</h6>
                        <div class="social-media">
                            <a href=""><i class="ion ion-social-facebook"></i></a>
                            <a href=""><i class="ion ion-social-twitter"></i></a>
                            <a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <!-- end - .footer-siguenos -->

                    <!-- .footer-suscribete -->
                    <div class="footer-suscribete">
                        <h6>Suscríbete</h6>
                        <p>¿Quieres recibir notificaciones cada que haya un capítulo nuevo?</p>
                        <form name="suscribir" method="post" id="formaDeSuscripccion">
                            <div class="inputs">
                                <input type="text" name="e-mail" placeholder="Dejanos tu correo" class="emailInput">
                            </div>
                            <div class="actions">
                                <button type="submit" data-style="slide-up" class="mailSubmit ladda-button"><span class="ladda-label"><i class="ion ion-paper-airplane"></i></span></button>
                            </div>
                            <div class="loader">
                                <div class="msg">
                                    <p></p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--  end - .footer-suscribete -->

                </div>
                <!-- end - .container -->
            </footer>
            <!-- end - footer -->

        </div>
        <!-- end - .animsition -->
        <?php $this->endBody() ?>

    </body>

</html>
<?php $this->endPage() ?>