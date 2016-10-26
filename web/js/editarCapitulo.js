/**
 * Variable auxiliar para conocer el estado de edición de los elementos
 */
var enEdicion = false;

/**
 * Agrega tarjeta del nuevo capitulo
 * @param json
 */
function agregarTarjetaCapitulo(json) {
	var numeroCap = $('.listado-articles-item').length;
	var template = '<a class="listado-articles-item" href="'+basePath+'site/ver-capitulo?token=hit_a4266c5404adf0a5d30156a245d5dee85807aa6e08540&amp;capitulo=cap_0fa10729da2e014a82aff88e0ab03ce8580920e80c5bd">'+
						'<div class="listado-articles-item-imagen" style="background-image:url(\''+basePath+'webAssets/uploads/'+json.i+'\')">'+
							'<div class="listado-articles-item-capitulo">'+
								'<h4>Capitulo '+(numeroCap+1)+'</h4>'+
							'</div>'+
						'</div> '+
						'<h3 class="listado-articles-item-title">'+json.n+'</h3>'+
					'</a>';
	
	$('.listado-articles').append(template);
}

function habilitarEdicion(){
	
}

function desHabilitarEdicion(){
	
}

$(document).ready(function(){
	$('#js-edicion-capitulos').on("click", function(){
		if(!enEdicion){
			enEdicion = true;
		}else{
			enEdicion = false;
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