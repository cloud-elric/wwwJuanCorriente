
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

$(document).ready(function(){
	$('#js-nombre-capitulo').focusout(function() {
		var text = $(this).text();
	});
	
	$('#js-nombre-capitulo').on('DOMSubtreeModified',function() {
		console.log('Se cambio');
	});
	
	$('#js-nombre-capitulo').on('click',function() {
		var text = $(this).text();
	});
	
});

/**
 * 
 */
function guardarCapitulo(){
	
	
}