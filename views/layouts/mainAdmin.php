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

    </head>

    <body>

        <?php $this->beginBody() ?>
        <!-- .animsition -->
        <div class="animsition">
            
            <?php if(!Yii::$app->user->isGuest){?>
                <a class="btn btn-primary cerrar-sesion" href="site/salir">Salir</a>
            <?php }?>
            
            <!-- header -->
            <header class="header-admin">
                <h1>Historias de México</h1>
                <div class="header-admin-agregar"></div>
            </header>
            <!-- end - header -->

            <!-- .page -->
            <div class="page">
                <?= $content ?>
            </div>
            <!-- end - .page -->

        </div>
        <!-- end - .animsition -->
        <?php $this->endBody() ?>

    </body>

</html>
<?php $this->endPage() ?>