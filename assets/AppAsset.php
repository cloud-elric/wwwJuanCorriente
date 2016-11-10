<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'webAssets/plugins/animsition/css/animsition.min.css',
        'webAssets/plugins/ladda/css/ladda.min.css',
        'webAssets/plugins/ionicons/css/ionicons.min.css',
        'webAssets/plugins/flexboxgrid/css/flexboxgrid.min.css',
        'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',
        'webAssets/plugins/animate/css/animate.css',
        'webAssets/plugins/asScrollbar/dist/css/asScrollable.css',
        'webAssets/plugins/magnific-popup/css/magnific-popup.css',
        'webAssets/css/juanCorriente.css',
    ];
    public $js = [
        'webAssets/plugins/animsition/js/animsition.min.js',
        'webAssets/plugins/ladda/js/spin.min.js',
        'webAssets/plugins/ladda/js/ladda.min.js',
        'https://code.jquery.com/ui/1.12.1/jquery-ui.js',
        'webAssets/js/juanCorriente.js',
        'webAssets/plugins/fullScreen/js/fullscreen.min.js',
        'webAssets/plugins/asScrollbar/js/holder.js',
        'webAssets/plugins/asScrollbar/js/jquery-asScrollbar.js',
        'webAssets/plugins/asScrollbar/dist/jquery-asScrollable.js',
        'webAssets/plugins/magnific-popup/js/jquery.magnific-popup.min.js',
    	'js/site.js'	
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}