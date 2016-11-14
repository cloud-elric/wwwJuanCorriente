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