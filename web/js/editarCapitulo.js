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
	var numeroCap = $('.listado-articles-item').length;
	var template = '<a class="listado-articles-item" href="'
			+ basePath
			+ 'site/ver-capitulo?token=hit_a4266c5404adf0a5d30156a245d5dee85807aa6e08540&amp;capitulo=cap_0fa10729da2e014a82aff88e0ab03ce8580920e80c5bd">'
			+ '<div class="listado-articles-item-imagen" style="background-image:url(\''
			+ basePath + 'webAssets/uploads/' + json.i + '\')">'
			+ '<div class="listado-articles-item-capitulo">' + '<h4>Capitulo '
			+ (numeroCap + 1) + '</h4>' + '</div>' + '</div> '
			+ '<h3 class="listado-articles-item-title">' + json.n + '</h3>'
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
}

// Click para cada item
$(document).on({
	'click' : function(e) {

		// if (enEdicion) {
		// e.preventDefault();
		//
		// }

	}
}, 'a.listado-articles-item');

// Click para cambiar de imagen
$(document).on({
	'click' : function(e) {
		if (enEdicion) {
			e.stopPropagation();
			
			if(e.target.nodeName!='INPUT'){
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
}, '.inputfile');
/**
 * Pone la imagen para vista previa
 * @param input
 * @param element
 */
function readURL(input, element) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			var parent = element.parents('.listado-articles-item-imagen');
			parent.css('background-image', 'url("'+e.target.result+'")' );
		}

		reader.readAsDataURL(input.files[0]);
	}
}

/**
 * Guarda la imagen en la base de datos
 * @param input
 * @param file
 */
function guardarImagen(input, jav){
	
	var tokenHistoria = $("#js-historia").data('historia');
	var tokenCapitulo = input.parents('.listado-articles-item').data('token');
	var data = new FormData();
	data.append('fileCapitulo',jav.files[0]);
	$.ajax({
        url: basePath+"admin-panel/guardar-imagen-capitulo?historia="+tokenHistoria+"&capitulo="+tokenCapitulo,
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
});

$('body').on(
		'beforeSubmit',
		'#form-agregar-capitulo',
		function() {
			var form = $(this);
			var token = $("#js-historia").data('historia');

			if (form.find('.has-error').length) {
				return false;
			}
			var button = document.getElementById('modal-agregar-post-guardar');
			var l = Ladda.create(button);
			l.start();

			$.ajax({
				url : basePath + 'admin-panel/guardar-capitulo?token=' + token,
				type : 'post',
				data : new FormData(this),
				dataType : 'json',
				cache : false,
				contentType : false,
				processData : false,
				success : function(response) {
					if (response.hasOwnProperty('status')
							&& response.status == 'success') {

						document.getElementById("form-agregar-capitulo")
								.reset();
						agregarTarjetaCapitulo(response);
						$(modal).trigger('click');
					} else {

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