/**
 * Proyecto
 *
 * # author      Damián <@damian>
 * # copyright   Copyright (c) 2016, Proyecto
 *
 */

/**
 * ----------------------------
 *		Variables
 * ----------------------------
 *
 * - Modal
 *
 */

// Modal
var modal = document.getElementById('modal-agregar-post');
var modalOpen = document.getElementById("modal-agregar-post-open");
// var modalClose = document.getElementById("modal-agregar-post-close");

// Ver Capítulo
var estado = false;


/**
 * ----------------------------
 *		Document Ready
 * ----------------------------
 *
 * - Animsition
 * - Ladda
 * - Modal
 *
 */
$(document).ready(function(){

	/**
	 * Animsition
	 */
	$('.animsition').animsition();


	/**
	 * Ladda
	 */

	$('.home-article-button').click(function(e){

		var l = Ladda.create(this);
		l.start();
	});
	// Modal - Btn de Guardar
	$('#modal-agregar-post-guardar').click(function(e){
		e.preventDefault();
		var l = Ladda.create(this);
		l.start();
	});
	// Modal - Btn de Login
	$('.login-form-btn').click(function(){
		var l = Ladda.create(this);
		l.start();
	});

	/**
	 * Modal
	 */
	// Open Modal
	$(modalOpen).on("click", function(){
		modal.style.display = "flex";
	});

	/**
	 * Datepicker
	 */
	$( "#datepicker" ).datepicker();

	/**
	 * Animate - Login elementos
	 */
	$(".login-cont .animated").animate({ "opacity": "0" }, 0, function() {
		$(".login-cont").show();
		$(".login-cont .animated").each(function(index) {$( this ).addClass("delay-"+(index)+" fadeInUp");});
	});

	/**
	 * Cambio de color - White
	 */
	$('.ver-capitulo-leer').on("click", function(){
		$('body').toggleClass("body-white");
		$('.ver-capitulo').toggleClass("ver-capitulo-white");
		$('footer').toggleClass("footer-white");
	});
	

	// 
	// 
	// 


	/* 
	Native FullScreen JavaScript API
	-------------
	Assumes Mozilla naming conventions instead of W3C for now
	*/
	var fullScreenApi = { 
		supportsFullScreen: false,
		isFullScreen: function() { return false; }, 
		requestFullScreen: function() {}, 
		cancelFullScreen: function() {},
		fullScreenEventName: '',
		prefix: ''
	},
	browserPrefixes = 'webkit moz o ms khtml'.split(' ');
	
	// check for native support
	if (typeof document.cancelFullScreen != 'undefined') {
		fullScreenApi.supportsFullScreen = true;
	} else {	 
		// check for fullscreen support by vendor prefix
		for (var i = 0, il = browserPrefixes.length; i < il; i++ ) {
			fullScreenApi.prefix = browserPrefixes[i];
			
			if (typeof document[fullScreenApi.prefix + 'CancelFullScreen' ] != 'undefined' ) {
				fullScreenApi.supportsFullScreen = true;
				
				break;
			}
		}
	}
	
	// update methods to do something useful
	if (fullScreenApi.supportsFullScreen) {
		fullScreenApi.fullScreenEventName = fullScreenApi.prefix + 'fullscreenchange';
		
		fullScreenApi.isFullScreen = function() {
			switch (this.prefix) {	
				case '':
					return document.fullScreen;
				case 'webkit':
					return document.webkitIsFullScreen;
				default:
					return document[this.prefix + 'FullScreen'];
			}
		}
		fullScreenApi.requestFullScreen = function(el) {
			return (this.prefix === '') ? el.requestFullScreen() : el[this.prefix + 'RequestFullScreen']();
		}
		fullScreenApi.cancelFullScreen = function(el) {
			return (this.prefix === '') ? document.cancelFullScreen() : document[this.prefix + 'CancelFullScreen']();
		}		
	}

	// jQuery plugin
	if (typeof jQuery != 'undefined') {
		jQuery.fn.requestFullScreen = function() {
	
			return this.each(function() {
				var el = jQuery(this);
				if (fullScreenApi.supportsFullScreen) {
					fullScreenApi.requestFullScreen(el);
				}
			});
		};
	}

	// export api
	window.fullScreenApi = fullScreenApi;	

	// MAS
	// do something interesting with fullscreen support
	var fsButton = document.getElementById('fsbutton'),
		fsElement = document.getElementById('specialstuff'),
		fsStatus = document.getElementById('fsstatus');


	if (window.fullScreenApi.supportsFullScreen) {
		// fsStatus.innerHTML = 'YES: Your browser supports FullScreen';
		// fsStatus.className = 'fullScreenSupported';

		// handle button click
		fsButton.addEventListener('click', function() {
			window.fullScreenApi.requestFullScreen(fsElement);
		}, true);
		
		// fsElement.addEventListener(fullScreenApi.fullScreenEventName, function() {
		// 	if (fullScreenApi.isFullScreen()) {
		// 		fsStatus.innerHTML = 'Whoa, you went fullscreen';
		// 	} else {
		// 		fsStatus.innerHTML = 'Back to normal';
		// 	}
		// }, true);

		/**
		 * Cambio de color - White
		 */
		$('.ver-capitulo-leer-full').on("click", function(){
			alert();
			$('.ver-capitulo').toggleClass("ver-capitulo-white-full");
		});
		
	}
	else {
		fsStatus.innerHTML = 'SORRY: Your browser does not support FullScreen';
	}

	/**
	 * Click view Full
	 */
	$('.ver-capitulo-full-screen').on("click", function(){

		window.fullScreenApi.requestFullScreen(fsElement);
		
		$(".ver-capitulo").toggleClass("ver-capitulo-full");
		// $('.ver-capitulo-full-screen').fadeOut();
		

		if (estado == true) {
			$(this).text("Abrir");

			$(".ver-capitulo-leer").fadeOut();
			$(".ver-capitulo-leer-full").fadeIn();

			estado = false;
		} else {
			$(this).text("Cerrar");

			$(".ver-capitulo-leer").fadeIn();
			$(".ver-capitulo-leer-full").fadeOut();

			estado = true;
		}

	}, true);

}); // end - READY

/**
 * ----------------------------
 *		Document Scroll
 * ----------------------------
 *
 * - Scroll
 *
 */
$(document).on("scroll", function(){
	/**
	 * Scroll - Listado, ocultar o mostar imagen
	 */
	var desplazamientoActual = $(document).scrollTop();
	if(desplazamientoActual > 100 ){
		$(".ver-capitulo-header").fadeTo( 18, 0.45 );
	}
	else{
		$(".ver-capitulo-header").fadeTo( 10, 1 );
	}
});


/**
 * ----------------------------
 *		Click Window
 * ----------------------------
 *
 * - Modal
 *
 */
window.onclick = function(event) {
	// Modal - Close
	// if (event.target == modal) {
	// 	modal.style.display = "none";
	// }
}