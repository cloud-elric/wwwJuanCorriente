var audio = new Audio(basePath+'audios/cortinilla.mp3');
audio.loop = true;

$(document).ready(function(){
	reproducirAudio();
	
	$('.js-silenciar-audio').on('click' , function(){
		var claseIconoSilencio = 'ion-android-volume-off';
		var claseIconoVolumen = 'ion-android-volume-up';
		
		if($(this).hasClass(claseIconoSilencio)){
			$(this).removeClass(claseIconoSilencio);
			$(this).addClass(claseIconoVolumen);
			 detenerAudio();
		}else{
			$(this).removeClass(claseIconoVolumen);
			$(this).addClass(claseIconoSilencio);
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