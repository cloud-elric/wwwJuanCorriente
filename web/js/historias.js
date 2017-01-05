/**
 * Variable auxiliar para conocer el estado de edición de los elementos
 */
var enEdicion = false;

// Metodo para eliminar elemento
$(document).on({
	'paste' : function(e) {

		e.preventDefault();
		var text = '';
		if (e.clipboardData || e.originalEvent.clipboardData) {
			text = (e.originalEvent || e).clipboardData.getData('text/plain');
		} else if (window.clipboardData) {
			text = window.clipboardData.getData('Text');
		}
		if (document.queryCommandSupported('insertText')) {
			document.execCommand('insertText', false, text);
		} else {
			document.execCommand('paste', false, text);
		}
	}
}, '.home-article-desc');

//Revisa lo que hay que borrar
setInterval(function() {
	$('.sinGuardar').each(function(index) {
		var element = $(this);
		if (($(this).text()).trim() == '') {
			$(this).text('Agregar texto');
			$(this).data('new', 'esNuevo');
		} else {
			var token = element.data('token');
			var url = basePath
					+ 'admin-panel/editar-historia?token='
					+ token;
			
			if (element.data('progress') == 'noProceso') {
				element.data('progress', 'enProceso');
				var valor = element.html();

				$.ajax({
					url : url,
					data : {
						valor : valor,
						token : token
					},
					method : "POST",
					success : function(response) {
						
						element.data('progress', 'noProceso');
						element.removeClass('sinGuardar');
					}
				});
			} else if (element.data('progress') == 'enProceso') {
				element.addClass('sinGuardar');
			}
		}
	});
}, 1000);

//Metodo para guardar al elemento
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
					var token = element.data('token');
					var url = basePath
							+ 'admin-panel/editar-historia?token='
							+ token;
					
					if (element.data('progress') == 'noProceso') {
						element.data('progress', 'enProceso');
						var valor = element.html();

						$.ajax({
							url : url,
							data : {
								valor : valor,
								token : token
							},
							method : "POST",
							success : function(response) {
								
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

		}, '.home-article-desc');

function cambiarImagen(input, elementjs){
	readURL(elementjs, input);
	guardarImagen(input, elementjs);
}

/**
 * Pone la imagen para vista previa
 * 
 * @param input
 * @param element
 */
function readURL(input, element) {
	
	var file = input.files[0];

	if (!file) {

		return false;
	}

	var imagefile = file.type;

	var filename = element.val();

	if (filename.substring(3, 11) == 'fakepath') {
		filename = filename.substring(12);
	}// remove c:\fake at beginning from localhost chrome
	// var url = base+'usrUsuarios/guardarFotosCompetencia';

	var match = [ "image/jpeg", "image/jpg", 'image/png' ];

	if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {

		alert('Archivo no valido');

		return false;
	}
	
	
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$(".image-change-"+element.data('token')).attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	}
}

/**
 * Guarda la imagen en la base de datos
 * 
 * @param input
 * @param file
 */
function guardarImagen(input, jav) {

	
	var token = input.data('token');
	
	var data = new FormData();
	data.append('fileHistoria', jav.files[0]);
	$.ajax({
		url : basePath + "admin-panel/guardar-imagen-historia?token="
				+ token,
		type : "POST",
		data : data,
		processData : false, // Work around #1
		contentType : false, // Work around #2
		success : function() {

		},
		cache : false,
		error : function() {
			alert("Failed");
		},
		// Work around #3
		xhr : function() {
			var xhr = new window.XMLHttpRequest();
			// Upload progress
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = evt.loaded / evt.total;
					// Do something with upload progress
					console.log('upload' + percentComplete);
				}
			}, false);
			// Download progress
			xhr.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = evt.loaded / evt.total;
					// Do something with download progress
					console.log('download' + percentComplete);
				}
			}, false);
			return xhr;
		}
	});
}

$(document).ready(function(){
	$("#js-edicion-capitulos").on('click', function(){
		
		if (!enEdicion) {
			enEdicion = true;
			habilitarEdicion();
		} else {
			enEdicion = false;
			desHabilitarEdicion();
		}
		
	});
});



function habilitarEdicion() {
	$("#js-edicion-capitulos i").removeClass('ion-android-create');
	$("#js-edicion-capitulos i").addClass('ion-checkmark-circled');
	$('.listado-image').css('display', 'block');
	$('.home-article-desc').attr('contenteditable', 'true');
	$('.home-categorias-item.active .tooltipitem').attr('contenteditable', 'true');

	$('#modal-agregar-post-open').css('display', 'none');
	$('.listado-articles-item-hover-close-btn').css('display', 'flex');
}

function desHabilitarEdicion() {
	$("#js-edicion-capitulos i").removeClass('ion-checkmark-circled');
	$("#js-edicion-capitulos i").addClass('ion-android-create');
	$('.listado-image').css('display', 'none');
	$('.home-article-desc').removeAttr('contenteditable');
	$('.home-categorias-item .tooltipitem').removeAttr('contenteditable');
	$('#modal-agregar-post-open').css('display', 'flex');

}


$('body')
.on(
		'beforeSubmit',
		'#form-agregar-historia',
		function() {
			var form = $(this);
			var token = $("#js-historia").data('historia');

			if (form.find('.has-error').length) {
				return false;
			}
			var button = document
					.getElementById('modal-agregar-post-guardar');
			var l = Ladda.create(button);
			l.start();

			$
					.ajax({
						url : basePath
								+ 'admin-panel/guardar-historia',
						type : 'post',
						data : new FormData(this),
						dataType : 'json',
						cache : false,
						contentType : false,
						processData : false,
						success : function(response) {
							if (response.hasOwnProperty('status')
									&& response.status == 'success') {

								window.location.href = basePath+'site/lista-de-capitulos?token='+response.tk;
								
								document.getElementById(
										"form-agregar-historia")
										.reset();
								

								$(modal).trigger('click');

								$("#js-contenedor-image-cap img")
										.remove();
								$(".modal-admin-form-titulo").html(
										'Dame un título...');
								
								$(".modal-admin-form-descripcion").html('Agrega la descripción de la historia');
							} else {

								$('#form-agregar-historia')
										.yiiActiveForm(
												'updateMessages',
												response, true);
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


$(document).ready(function(){
	
	$('#js-nombre-capitulo').focusout(function() {

		if (($(this).text()).trim() == '') {
			$(this).text('Dame un nombre...');
			$(this).data('new', 'esNuevo');
		} else {
			$("#enthistorias-txt_nombre").val($(this).text());

		}

	});
	
	
	$('#js-descripcion-historia').focusout(function() {

		if (($(this).text()).trim() == '') {
			$(this).text('Agrega la descripción de la historia');
			$(this).data('new', 'esNuevo');
		} else {
			$("#enthistorias-txt_descripcion").val($(this).html());

		}

	});
//	$('#modal-agregar-post-open').on('click', function(e){
//		e.preventDefault();
//		
//		$('#modal-agregar-post').css('display', 'flex');
//		
//	});
});

$(document).on({
	'click' : function(e) {
		$('.inputFileCapitulo').trigger('click');

	}
}, '.js-label-image-cap');

//funciones para el input de imagen
$(document).on({
	'change' : function(e) {
		$("#js-contenedor-image-cap img").remove();
		// guardarImagen($(this), this);
		readURLCap(this, $(this));
	}
}, '.inputFileCapitulo');


/**
 * Pone la imagen para vista previa
 * 
 * @param input
 * @param element
 */
function readURLCap(input, element) {
	
	var file = input.files[0];

	if (!file) {

		return false;
	}

	var imagefile = file.type;

	var filename = element.val();

	if (filename.substring(3, 11) == 'fakepath') {
		filename = filename.substring(12);
	}// remove c:\fake at beginning from localhost chrome
	// var url = base+'usrUsuarios/guardarFotosCompetencia';

	var match = [ "image/jpeg", "image/jpg", 'image/png' ];

	if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {

		alert('Archivo no valido');

		return false;
	}
	
	
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$("#js-contenedor-image-cap").addClass(
					"listado-modal-image-item-file");
			$("#js-contenedor-image-cap").append(
					'<img class="modal-admin-form-imagen" src="'
							+ e.target.result + '" style="display: block;"/>');

		}

		reader.readAsDataURL(input.files[0]);
	}
}