//var basePath = 'http://localhost/wwwJuanCorriente/web/';
//var basePath = 'http://notei.com.mx/test/wwwJuanCorriente/web/';

function eliminarElemento(token) {
	var tokenCapitulo = $("#js-capitulo").data('token');
	var url = basePath + 'admin-panel/eliminar-elemento-capitulo?capitulo='
			+ tokenCapitulo;

	$.ajax({
		url : url,
		data : {
			token : token
		},
		method : 'POST',
		success : function(response) {

		}
	})
}

// Revisa lo que hay que borrar
setInterval(function() {
	$('.pendienteEliminar').each(function(index) {
		var token = $(this).data('token');
		eliminarElemento(token, $(this));
		$(this).parent().remove();
	});
}, 1000);

// Metodo para eliminar elemento
$(document).on({
	'click' : function() {
		var token = $(this).data('token');
		var proceso = $(this).data('progress');

		if (!token) {
			var parent = $(this).parents('.js-elemento-leer');
			parent.css('display', 'none');
			parent.find('.js-elemento-editable').addClass('pendienteEliminar');
			
		}

		if (proceso == 'enProceso') {

		} else {
			$('#js-elemento-' + token).remove();

			eliminarElemento(token);
		}

	}
}, '.js-remove-element');

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
}, '.ver-capitulo-post-desc-text');

// Metodo para eliminar elemento
$(document).on({
	'click' : function(e) {

		var padre = $(this).parents('.ver-capitulo-post-image');
		padre.find('input').trigger('click');
	}
}, '.js-imagen-trigger');

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
					var index = $('.js-elemento-leer').length;
					
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
								element.parents('.js-elemento-leer').attr('id',
										"js-elemento-" + response.tk);
								element.parents('.js-elemento-leer').data('token', response.tk);
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
												+ 'Agregar texto'
												+ '</div>'
												+ '<span class="ver-capitulo-post-hover-close-btn js-remove-element" data-token><i class="ion ion-close-round"></i></span>'
												+ '<span class="ver-capitulo-post-hover-mover-btn js-mover-elemento"><i class="ion ion-arrow-move"></i></span>'
												+ '</div>';

										$('.ver-capitulo-post')
												.append(template);
									});

					$('.js-imagen')
							.on(
									'click',
									function(e) {
										var template = '<div class="ver-capitulo-post-image ver-capitulo-post-hover-close js-elemento-leer">'
												+ '<div class="ver-capitulo-post-image-item js-container-image">'
												+ '<input type="file" class="inputfile modal-admin-form-imagen" onchange="uploadImage($(this),this)" data-token>'
												+ '<label class="js-imagen-trigger">Imagen</label>'
												+ '<div class="ver-capitulo-post-progress">'
												+ '<div id="js-progress-bar" class="ver-capitulo-post-progress-bar"></div>'
												+ '<span id="js-progress-bar-texto" class="w3-center w3-text-white">0%</span>'
												+ '</div>'
												+ '<img class="js-element-img" alt="" style="display: block;">'
												+ '<div class="ver-capitulo-post-image-item-zoom">'
												+ '<a href="" title="The Cleaner">'
												+ '<i class="ion ion-arrow-expand"></i>'
												+ '</a>'
												+ '</div>'
												+'<span class="ver-capitulo-post-hover-close-btn js-remove-element" data-token><i class="ion ion-close-round"></i></span>'
												+ '<span class="ver-capitulo-post-hover-mover-btn js-mover-elemento"><i class="ion ion-arrow-move"></i></span>'
										'</div>' + '</div>';
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

				});

//Carga la imagen
function uploadImageHeader(input, jav) {

	var file = jav.files[0];

	if (!file) {

		return false;
	}

	var imagefile = file.type;

	var filename = input.val();

	if (filename.substring(3, 11) == 'fakepath') {
		filename = filename.substring(12);
	}// remove c:\fake at beginning from localhost chrome
	// var url = base+'usrUsuarios/guardarFotosCompetencia';

	var match = [ "image/jpeg", "image/jpg", 'image/png' ];

	if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {

		alert('Archivo no valido');

		return false;
	}

	readURLHeader(jav, input);

	guardarImagenHeader(input, jav)
}

function readURLHeader(input, element) {

	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = (function(f) {
			
			return function(e) {
                // //
				// element.parents('.js-container-image').css('background-image','url('+e.target.result+')');
				var padre = element.parents('.ver-capitulo-admin');
				
				padre.find('.ver-capitulo-header').css("background-image", 'url("'+e.target.result+'")');
				
				console.log(padre);
				
            };
			

			// progressBar();
		})(input.files[0]);

		reader.readAsDataURL(input.files[0]);
	}
}

function guardarImagenHeader(input, file) {

	var data = new FormData();

	data.append('fileUpload', file.files[0]);
 var tokenCapitulo = $("#js-capitulo").data('token');
	$.ajax({
		url : basePath + "admin-panel/guardar-imagen-header?capitulo="
				+ tokenCapitulo,
		type : "POST",
		data : data,
		processData : false, // Work around #1
		contentType : false, // Work around #2
		success : function(response) {

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

// Carga la imagen
function uploadImage(input, jav) {

	var file = jav.files[0];

	if (!file) {

		return false;
	}

	var imagefile = file.type;

	var filename = input.val();

	if (filename.substring(3, 11) == 'fakepath') {
		filename = filename.substring(12);
	}// remove c:\fake at beginning from localhost chrome
	// var url = base+'usrUsuarios/guardarFotosCompetencia';

	var match = [ "image/jpeg", "image/jpg", 'image/png' ];

	if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {

		alert('Archivo no valido');

		return false;
	}

	readURL(jav, input);
	guardarImagen(input, jav);

}



function readURL(input, element) {

	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = (function(f) {
			
			return function(e) {
                // //
				// element.parents('.js-container-image').css('background-image','url('+e.target.result+')');
				var padre = element.parents('.js-container-image');

				padre.addClass("ver-capitulo-post-image-item-file");
				
				var img = padre.find('.js-element-img');

				img.attr("src", e.target.result);

				var zoom = padre.find(".ver-capitulo-post-image-item-zoom a");
				zoom.attr("src", e.target.result);

				$(".ver-capitulo-post-image-item").addClass("ver-capitulo-post-image-item-active-zoom");
            };
			

			// progressBar();
		})(input.files[0]);

		reader.readAsDataURL(input.files[0]);
	}
}

function guardarImagen(input, file) {

	var tokenCapitulo = $("#js-capitulo").data('token');
	var data = new FormData();
	var index = $(".js-elemento-leer").length;

	if (index < 0) {
		index = 1;
	}

	var tokenElemento = input.data('token');

	data.append('fileUpload', file.files[0]);
	data.append('index', index);
	data.append('token', tokenElemento);

	$.ajax({
		url : basePath + "admin-panel/guardar-imagen-elemento?capitulo="
				+ tokenCapitulo,
		type : "POST",
		data : data,
		processData : false, // Work around #1
		contentType : false, // Work around #2
		success : function(response) {

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

// Function - Progress Bar [Cargar Imagen]
function progressBar() {
	var elem = document.getElementById("js-progress-bar");
	var width = 0;
	var id = setInterval(frame, 10);

	$(".ver-capitulo-post-progress")
			.addClass("ver-capitulo-post-progress-anim");

	function frame() {
		if (width >= 100) {
			clearInterval(id);
		} else {
			width++;
			elem.style.width = 'calc(' + width + '% - 4px)';
			document.getElementById("js-progress-bar-texto").innerHTML = width
					* 1 + '%';
		}
	}
}

$(function() {
	$("#sortable").sortable({

		cancel : '.ver-capitulo-post-desc-text',
		stop: function(evt, ui) {
			
			
			
				actualizarIndex();
			
			
        }
	});

	$(".ver-capitulo-post-desc-text").attr("contentEditable", true);
});

function actualizarIndex(){
	
	$('.js-elemento-leer').each(function(index){
		var token = $(this).data('token');
		if(token){
			var url = basePath + 'admin-panel/update-index?capitulo='+token;
		$.ajax({
			url:url,
			type:'POST',
			data:{index:(index)},
			success:function(resp){
				
			}
		});
		}
	});
	
}