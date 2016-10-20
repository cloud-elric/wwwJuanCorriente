var contenedorElementos = $('#form-agregar-capitulo');

var tituloElementoInput=$('<input type="text" id="entcapitulos-txt_nombre" class="form-control" name="EntCapitulos[txt_nombre]" maxlength="200"  onchange="finalizarEditarTitulo()">');
var tituloLabel = $("#js-titulo-capitulo");

function agregarElemento(tipoElemento) {
	var elementoTemplate;
	
	// Dependiendo del tipo agregara un nuevo elemento
	switch (tipoElemento) {
	case 2: // Imagen
		elementoTemplate = '<input type="file" onchange="readURL(this)"/><img id="imagen">';
		break;
	case 3: // Texto
		elementoTemplate = '<textarea></textarea>';
		
		break;

	default:
		break;
	}

	// Se agrega el nuevo elemento al contenedor
	contenedorElementos.append(elementoTemplate);
	
}



function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#imagen').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function editarTitulo(){
	
	var text = tituloLabel.text();

	tituloElementoInput.val(text);
	tituloLabel.replaceWith(tituloElementoInput);
	
} 

function finalizarEditarTitulo(){
	var val = tituloElementoInput.val()
	tituloLabel.text(val);
	tituloElementoInput.replaceWith(tituloLabel);
	
} 


$(document).ready(function(){
	
});