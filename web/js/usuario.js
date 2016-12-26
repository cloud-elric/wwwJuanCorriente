var audio = new Audio(basePath+'audios/cortinilla.mp3');
audio.loop = true;

$(document).ready(function(){
	reproducirAudio();
	
	$('.js-silenciar-audio').on('click' , function(){
		var claseIconoSilencio = 'ion-android-volume-off';
		var claseIconoVolumen = 'ion-android-volume-up';
		
		if($(this).find('i').hasClass(claseIconoVolumen)){
			$(this).find('i').removeClass(claseIconoVolumen);
			$(this).find('i').addClass(claseIconoSilencio);
			 detenerAudio();
		}else{
			$(this).find('i').removeClass(claseIconoSilencio);
			$(this).find('i').addClass(claseIconoVolumen);
			reproducirAudio();
		}
	});
});

function reproducirAudio(){
	
	audio.play();
}

function detenerAudio(){
	audio.pause();
}

function cargarCapitulos(token){
	var url = basePath+'site/cargar-capitulos-historia?token='+token;
	$.ajax({
		url:url,
		success:function(resp){
			
			$.each(resp,function(index, value){
				
				var template = '<div class="nav-capitulos-item" data-token="'+value.txt_token+'">'+
				'<h4 class="nav-capitulos-item-capitulo">Capítulo '+(index+1)+'</h4>'+
				'<div class="nav-capitulos-item-imagen" style="background-image: url('+basePath+'webAssets/uploads/min_'+value.txt_imagen+');">'+
				'</div>'+
				'<h3 class="nav-capitulos-item-titulo">'+
					value.txt_nombre+
				'</h3>'+
			'</div>';
				$('.nav-capitulos-cont').append(template);
			});
			
			
			
			
		}
	});
	
	$(document).on({
		'click' : function(e) {
			var token = $(this).data('token');
			var historia = $('#js-historia').data('token');
			
			window.location = basePath+"site/ver-capitulo?token="+historia+"&capitulo="+token;

		}
	}, '.nav-capitulos-item');	
	
}