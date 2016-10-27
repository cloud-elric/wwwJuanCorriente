var basePath = 'http://localhost/wwwJuanCorriente/web/';

function eliminarElemento(token){
	var tokenCapitulo = $("#js-capitulo").data('token');
	var url = basePath
	+ 'admin-panel/eliminar-elemento-capitulo?capitulo='
	+ tokenCapitulo;
	
	$.ajax({
		url:url,
		data: {
			token : token
		},
		method:'POST',
		success:function(response){
			
		}
	})
}

// Revisa lo que hay que borrar
setInterval(function(){ 
	$('.pendienteEliminar').each(function(index){
		var token = $(this).data('token');
		eliminarElemento(token, $(this));
		$(this).parent().remove();
	}); 
}, 1000);

// Metodo para eliminar elemento
$(document)
		.on(
				{
					'click' : function() {
						var token = $(this).data('token');
						var proceso = $(this).data('progress');

						if(!token){
							var parent = $(this).parents('.js-elemento-leer');
							parent.css('display','none');
							parent.find('.js-elemento-editable').addClass('pendienteEliminar');
						}
						
						if (proceso == 'enProceso') {

						} else {
							$('#js-elemento-' + token).remove();

							eliminarElemento(token);
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
								element.parents('.js-elemento-leer').attr('id',
										"js-elemento-" + response.tk);
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
												+ '</div>';

										$('.ver-capitulo-post')
												.append(template);
									});

					$('.js-imagen').on('click', function(e){
						var template = '<input type="file" class="modal-admin-form-imagen">';
						$('.ver-capitulo-post').append(template);
						$(template).trigger('click');
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
	
	guardarImagen(input, jav);
	
	readURL(jav, input);
	
	

}

function readURL(input, element) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			// element.parents('.js-container-image').css('background-image','url('+e.target.result+')');
			$('.js-container-image').addClass("ver-capitulo-post-image-item-file");
			$('.js-container-image img').show().attr("src", e.target.result);
			progressBar();
		}

		reader.readAsDataURL(input.files[0]);
	}
}

function guardarImagen(input, file){
	
	var tokenCapitulo = $("#js-capitulo").data('token');
	var data = new FormData();
	data.append('fileCapitulo',file.files[0]);
	$.ajax({
        url: basePath+"admin-panel/guardar-imagen-elemento?capitulo="+tokenCapitulo,
        type: "POST",
        data: data,
        processData: false, //Work around #1
        contentType: false, //Work around #2
        success: function(){
            
        },
        cache:false,
        error: function(){alert("Failed");},
        //Work around #3
        xhr: function() {
        	var xhr = new window.XMLHttpRequest();
            //Upload progress
            xhr.upload.addEventListener("progress", function(evt){
              if (evt.lengthComputable) {
                var percentComplete = evt.loaded / evt.total;
                //Do something with upload progress
                console.log('upload'+percentComplete);
              }
            }, false);
            //Download progress
            xhr.addEventListener("progress", function(evt){
              if (evt.lengthComputable) {
                var percentComplete = evt.loaded / evt.total;
                //Do something with download progress
                console.log('download'+percentComplete);
              }
            }, false);
            return xhr;
        }
    });
}

// Function - Progress Bar [Cargar Imagen]
function progressBar(){
	var elem = document.getElementById("js-progress-bar");
	var width = 0;
	var id = setInterval(frame, 10);

	$(".ver-capitulo-post-progress").addClass("ver-capitulo-post-progress-anim");

	function frame() {
		if (width >= 100) {
			clearInterval(id);
		} else {
			width++;
			elem.style.width = 'calc(' + width + '% - 4px)';
			document.getElementById("js-progress-bar-texto").innerHTML = width * 1  + '%';
		}
	}
}