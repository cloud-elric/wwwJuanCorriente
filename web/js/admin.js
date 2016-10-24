var basePath = 'http://localhost/wwwJuanCorriente/web/';
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

		reader.onload = function(e) {
			$('#imagen').attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	}
}

function agregarTarjeta() {
	var template = '<a class="listado-articles-item" href="/wwwJuanCorriente/web/site/ver-capitulo">'
						+ '<div class="listado-articles-item-imagen" style="background-image:url(\'/wwwJuanCorriente/web/webAssets/uploads/chain_pg002.jpg\')">' 
								+ '<div class="listado-articles-item-capitulo">'
										+ '<h4>Capitulo 2</h4>' 
								+ '</div>'
								+ '<div class="listado-articles-item-new">' 
									+ '<span>Nuevo</span>'
								+ '</div>' 
						+ '</div>'
						+ '<h3 class="listado-articles-item-title">The chain</h3>' 
					+ '</a>';
}

$(document).ready(
		function() {

			/**
			 * Elemento de la fecha
			 */
			$(".datepicker").datepicker();

			$('#js-nombre-capitulo').focusout(function() {

				if (($(this).text()).trim() == '') {
					$(this).text('Dame un título...');
					$(this).data('new', 'esNuevo');
				} else {
					$("#entcapitulos-txt_nombre").val($(this).text());

				}

			});

			$('#js-nombre-capitulo').focus(function() {
				var esNuevo = $(this).data('new');
				if (esNuevo == 'esNuevo') {
					$(this).text('');
				}

			});

			$('#js-nombre-capitulo').on('DOMSubtreeModified', function() {

				$(this).data('new', 'noNuevo');

			});

			$('#js-nombre-capitulo').on('click', function() {
				var text = $(this).text();
			});

			$('body').on(
					'beforeSubmit',
					'#form-agregar-capitulo',
					function() {
						var form = $(this);
						var token = $("#js-historia").data('historia');
						// return false if form still have some validation
						// errors
						if (form.find('.has-error').length) {
							return false;
						}
						var button = document
								.getElementById('modal-agregar-post-guardar');
						var l = Ladda.create(button);
						l.start();
						// submit form
						$.ajax({
							url : basePath
									+ 'admin-panel/guardar-capitulo?token='
									+ token,// url para peticion
							type : 'post', // Metodo en el que se enviara la
											// informacion
							data : new FormData(this), // La informacion a
														// mandar
							dataType : 'json', // Tipo de respuesta
							cache : false, // sin cache
							contentType : false,
							processData : false,
							success : function(response) { // Cuando la
															// peticion sea
															// exitosamente se
															// ejecutara la
															// funcion
								// Si la respuesta contiene la propiedad status
								// y es success
								if (response.hasOwnProperty('status')
										&& response.status == 'success') {
									// Reseteamos el modal
									document.getElementById(
											"form-agregar-capitulo").reset();

									$(modal).trigger('click');
								} else {
									// Muestra los errores
									$('#form-agregar-capitulo').yiiActiveForm(
											'updateMessages', response, true);
								}
								l.stop();
							},
							error : function() {
								l.stop();
							},
							statusCode : {
								404 : function() {
									alert("page not found");
								}
							}

						});
						return false;
					});

		});

/**
 * e
 */
function guardarCapitulo() {

}