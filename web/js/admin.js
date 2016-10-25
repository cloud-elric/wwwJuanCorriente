var basePath = 'http://localhost/wwwJuanCorriente/web/';

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
			+ '<h3 class="listado-articles-item-title">The chain</h3>' + '</a>';
}

// Metodo para eliminar elemento
$(document).on({
	'click' : function() {
		var token = $(this).data('token');
		var proceso = $(this).data('progress');
		
		if(proceso=='enProceso'){
			alert();
		}else{
			$('#js-elemento-' + token).remove();
		}
		
	}
}, '.js-remove-element');

// Metodo para guardar al elemento
$(document).on(
		{
			'focus' : function() {
				var esNuevo = $(this).data('new');
				if (esNuevo == 'esNuevo') {
					$(this).text('');
				}
			},
			'focusout' : function() {
				var element = $(this);
				if (($(this).text()).trim() == '') {
					$(this).text('Agregar texto');
					$(this).data('new', 'esNuevo');
				} else {
					var tokenCapitulo = $("#js-capitulo").data('token');
					var url = basePath
							+ 'admin-panel/guardar-elemento-capitulo?capitulo='
							+ tokenCapitulo;
					var index = element.index();
					var tokenElemento = element.data('token');
					if (element.data('progress') == 'noProceso') {
						element.data('progress', 'enProceso');
						var valor = element.html();

						$.ajax({
							url : url,
							data : {
								valor : valor,
								index : index,
								token : tokenElemento
							},
							method : "POST",
							success : function(response) {
								element.data('token', response.tk);
								element.parents('.js-elemento-leer').attr('id', "js-elemento-"+response.tk);
								element.next().data('token', response.tk);
								element.data('progress', 'noProceso');
							}
						});
					} else if (element.data('progress') == 'enProceso') {
						element.addClass('sinGuardar');
					}
				}
			},
			'DOMSubtreeModified' : function() {
				$(this).data('new', 'noNuevo');
			}

		}, '.js-elemento-editable');

$(document)
		.ready(
				function() {

					/**
					 * Elemento de la fecha
					 */
					$(".datepicker").datepicker();

					/**
					 * Agrega un nuevo elemento del tipo texto
					 */
					$(".js-texto")
							.on(
									"click",
									function() {
										var template = '<div class="ver-capitulo-post-desc ver-capitulo-post-hover-close js-elemento-leer">'
												+ '<div class="ver-capitulo-post-desc-text  js-elemento-editable" contenteditable="true" data-new="esNuevo" data-progress="noProceso" data-token>'
													+'Agregar texto'
												+ '</div>'
												+ '<span class="ver-capitulo-post-hover-close-btn js-remove-element" data-token><i class="ion ion-close-round"></i></span>'
												+ '</div>';

										$('.ver-capitulo-post')
												.append(template);
									});

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

					$('#js-nombre-capitulo').on('DOMSubtreeModified',
							function() {

								$(this).data('new', 'noNuevo');

							});

					$('#js-nombre-capitulo').on('click', function() {
						var text = $(this).text();
					});

					$('body')
							.on(
									'beforeSubmit',
									'#form-agregar-capitulo',
									function() {
										var form = $(this);
										var token = $("#js-historia").data(
												'historia');
										// return false if form still have some
										// validation
										// errors
										if (form.find('.has-error').length) {
											return false;
										}
										var button = document
												.getElementById('modal-agregar-post-guardar');
										var l = Ladda.create(button);
										l.start();
										// submit form
										$
												.ajax({
													url : basePath
															+ 'admin-panel/guardar-capitulo?token='
															+ token,// url para
													// peticion
													type : 'post', // Metodo en
													// el que se
													// enviara
													// la
													// informacion
													data : new FormData(this), // La
													// informacion
													// a
													// mandar
													dataType : 'json', // Tipo
													// de
													// respuesta
													cache : false, // sin cache
													contentType : false,
													processData : false,
													success : function(response) { // Cuando
														// la
														// peticion sea
														// exitosamente se
														// ejecutara la
														// funcion
														// Si la respuesta
														// contiene la propiedad
														// status
														// y es success
														if (response
																.hasOwnProperty('status')
																&& response.status == 'success') {
															// Reseteamos el
															// modal
															document
																	.getElementById(
																			"form-agregar-capitulo")
																	.reset();

															$(modal).trigger(
																	'click');
														} else {
															// Muestra los
															// errores
															$(
																	'#form-agregar-capitulo')
																	.yiiActiveForm(
																			'updateMessages',
																			response,
																			true);
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