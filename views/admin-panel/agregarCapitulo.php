<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->registerJsFile('@web/js/admin.js',['depends' => [\app\assets\AppAsset::className()]]);
?>

<h4><?=$capitulo->isNewRecord?'Agregar':'Editar'?> <span>Capitulo</span>
</h4>

<?php
$form = ActiveForm::begin ( [ 
		'options' => [ 
				'enctype' => 'multipart/form-data' 
		],
		
		'layout' => 'horizontal',
		'id' => 'form-agregar-capitulo' 
] );

?>

	<label id="js-titulo-capitulo" onclick='editarTitulo();'>Dame un título</label>



<?php

ActiveForm::end ();

?>

<?php
// Imprime los diferentes tipos de elementos (texto, imagen, etc).
foreach ( $tiposElementos as $tipoElemento ) {
	?>
<button id="js-elemento-<?=$tipoElemento->txt_token?>" onclick="agregarElemento(<?=$tipoElemento->id_tipo_elemento?>)"
	class="js-elemento" data-token="<?=$tipoElemento->txt_token?>"><?=$tipoElemento->txt_nombre?></button>

<?php
}
?>
