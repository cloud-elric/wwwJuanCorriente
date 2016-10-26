/**
 * Variable auxiliar para conocer el estado de edición de los elementos
 */
var enEdicion = false;

function agregarTarjetaCapitulo(json) {
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