/**
 * Variable auxiliar para conocer el estado de edición de los elementos
 */
var enEdicion = false;

/**
 * Agrega tarjeta del nuevo capitulo
 * 
 * @param json
 */
function agregarTarjetaCapitulo(json) {
	var tokenHistoria = $("#js-historia").data('historia');
	var numeroCap = $('.listado-articles-item').length;
	var template = '<a class="listado-articles-item listado-articles-item-hover-close" id="js-element-cap-'+json.tk+'" data-token="'
			+ json.tk
			+ '" href="/wwwJuanCorriente/web/site/ver-capitulo?token='
			+ tokenHistoria
			+ '&capitulo='
			+ json.tk
			+ '">'
			+ '<div class="listado-articles-item-imagen" style="background-image:url(\''
			+ basePath
			+ 'webAssets/uploads/'
			+ json.i
			+ '\')">'
			+ '<div class="listado-articles-item-capitulo">'
			+ '<h4>Capitulo '
			+ (numeroCap + 1)
			+ '</h4>'
			+ '</div>'
			+ '<div class="listado-articles-item-new">'
			+ '<span>Nuevo</span>'
			+ '</div>'
			+ '<div class="listado-image" style="display:none;">'
			+ '<div class="listado-image-item">'
			+ '<input type="file" class="inputfile modal-admin-form-imagen inputFileCard">'
			+ '<label class="js-label">Cambiar Imagen</label>'
			+ '<div class="ver-capitulo-post-progress ver-capitulo-post-progress-full">'
			+ '<div id="js-progress-bar" class="ver-capitulo-post-progress-bar"></div>'
			+ '<span id="js-progress-bar-texto" class="w3-center w3-text-white">0%</span>'
			+ '</div>'
			+ '</div>'
			+ '</div>'
			+ '</div>'
			+ '<h3 class="listado-articles-item-title">'
			+ json.n
			+ '</h3>'
			+ '<span class="listado-articles-item-hover-close-btn" style="display:none;"><i class="ion ion-close-round"></i></span>'
			+ '</a>';

	$('.listado-articles').append(template);
}

function habilitarEdicion() {
	$("#js-edicion-capitulos i").removeClass('ion-android-create');
	$("#js-edicion-capitulos i").addClass('ion-checkmark-circled');
	$('.listado-image').css('display', 'block');
	$('.listado-articles-item-title').attr('contenteditable', 'true');
	$('.listado-articles-item').each(function(index) {
		var url = $(this).attr('href');
		$(this).attr('href', 'javascript:void(0)');
		$(this).data('url', url);
	});

	$('#modal-agregar-post-open').css('display', 'none');
	$('.listado-articles-item-hover-close-btn').css('display', 'flex');
}

function desHabilitarEdicion() {
	$("#js-edicion-capitulos i").removeClass('ion-checkmark-circled');
	$("#js-edicion-capitulos i").addClass('ion-android-create');
	$('.listado-image').css('display', 'none');
	$('.listado-articles-item-title').removeAttr('contenteditable');
	$('.listado-articles-item').each(function(index) {
		var url = $(this).data('url');
		$(this).attr('href', url);
		$(this).data('url', '');
	});

	$('#modal-agregar-post-open').css('display', 'block');
	$('.listado-articles-item-hover-close-btn').css('display', 'none');
}

// Click para cada item
$(document).on({
	'click' : function(e) {
		$('.inputFileCapitulo').trigger('click');

	}
}, '.js-label-image-cap');

// Click al boton de eliminar capitulo
$(document).on({
	'click' : function(e) {
		
		$('#js-eliminar-capitulo').data('eliminar', '')
		
		var token = $(this).parents('.listado-articles-item').data('token');
		
		$('#js-eliminar-capitulo').data('eliminar', token);
		
		modalMensaje.style.display = "flex";
	}
}, '.listado-articles-item-hover-close-btn');

// Click para cambiar de imagen
$(document).on({
	'click' : function(e) {
		if (enEdicion) {
			e.stopPropagation();

			if (e.target.nodeName != 'INPUT') {
				var input = $(this).find('.inputfile');
				input.trigger('click');
			}
		}
	}
}, '.listado-articles-item-imagen');

// funciones para el input
$(document).on({
	'change' : function(e) {
		guardarImagen($(this), this);
		readURL(this, $(this));
	}
}, '.inputFileCard');

// funciones para el input de imagen
$(document).on({
	'change' : function(e) {
		$("#js-contenedor-image-cap img").remove();
		// guardarImagen($(this), this);
		readURLCap(this, $(this));
	}
}, '.inputFileCapitulo');

// funciones para el input de imagen
$(document).on({
	'focus' : function() {

	},
	'focusout' : function() {
		var elemento = $(this);
		var token = elemento.parents('.listado-articles-item').data('token');
		var url = basePath + 'admin-panel/guardar-nombre?token=' + token;
		var text = elemento.text();
		$.ajax({
			url : url,
			data : {
				text : text
			},
			type : 'POST',
			success : function(response) {
				elemento.text(response.text);
			}
		})
	},
	'DOMSubtreeModified' : function() {

	}

}, '.listado-articles-item-title');

/**
 * Pone la imagen para vista previa
 * 
 * @param input
 * @param element
 */
function readURL(input, element) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			var parent = element.parents('.listado-articles-item-imagen');
			parent.css('background-image', 'url("' + e.target.result + '")');
		}

		reader.readAsDataURL(input.files[0]);
	}
}

/**
 * Pone la imagen para vista previa
 * 
 * @param input
 * @param element
 */
function readURLCap(input, element) {
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

/**
 * Guarda la imagen en la base de datos
 * 
 * @param input
 * @param file
 */
function guardarImagen(input, jav) {

	var tokenHistoria = $("#js-historia").data('historia');
	var tokenCapitulo = input.parents('.listado-articles-item').data('token');
	var data = new FormData();
	data.append('fileCapitulo', jav.files[0]);
	$.ajax({
		url : basePath + "admin-panel/guardar-imagen-capitulo?historia="
				+ tokenHistoria + "&capitulo=" + tokenCapitulo,
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

$(document).ready(function() {
	$('#js-edicion-capitulos').on("click", function() {
		if (!enEdicion) {
			enEdicion = true;
			habilitarEdicion();
		} else {
			enEdicion = false;
			desHabilitarEdicion();
		}
	});
	
	/**
	 * Si el usuario permite borrar el capitulo
	 */
	$("#js-eliminar-capitulo").on("click", function(){
		var token = $(this).data('eliminar');
		var url = basePath + 'admin-panel/eliminar-capitulo?token='+token;
		
		$("#js-element-cap-"+token).remove();
		actualizarNumCapitulo();
		$('.modal-mensaje-close').trigger('click');
		
		$.ajax({
			url:url,
			success:function(response){
				
			},error:function(){
				alert();
			}
		});
	});
	
});


function actualizarNumCapitulo(){
	$('.listado-articles-item-capitulo').each(function(index){
		$(this).text('Capítulo '+(index+1));
	});
}

$('body')
		.on(
				'beforeSubmit',
				'#form-agregar-capitulo',
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
										+ 'admin-panel/guardar-capitulo?token='
										+ token,
								type : 'post',
								data : new FormData(this),
								dataType : 'json',
								cache : false,
								contentType : false,
								processData : false,
								success : function(response) {
									if (response.hasOwnProperty('status')
											&& response.status == 'success') {

										document.getElementById(
												"form-agregar-capitulo")
												.reset();
										agregarTarjetaCapitulo(response);

										$(modal).trigger('click');

										$("#js-contenedor-image-cap")
												.removeClass(
														"listado-modal-image-item-file");
										$("#entcapitulos-txt_nombre").val('');
										$("#entcapitulos-fch_publicacion").val(
												'');
										$("#js-contenedor-image-cap img")
												.remove();
										$(".modal-admin-form-titulo").text(
												'Dame un título...');
									} else {

										$('#form-agregar-capitulo')
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
