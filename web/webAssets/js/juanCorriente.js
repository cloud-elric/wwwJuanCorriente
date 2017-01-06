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

// Modal - Agregar
var modal = document.getElementById('modal-agregar-post');
var modalOpen = document.getElementById("modal-agregar-post-open");
// var modalClose = document.getElementById("modal-agregar-post-close");

// Modal - Mensaje
var modalMensaje = document.getElementById('modal-mensaje');
var modalOpenMensaje = document.getElementById("modal-mensaje-open");
var modalCloseMensaje = document.getElementsByClassName("modal-mensaje-close");

// Body Alto
var bodysHeight = 0;

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

	$('.ver-capitulos').addClass("ver-js-capitulos");

	/**
	 * Ladda
	 */

	$('.home-article-button').click(function(e){
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
	
	/**
	 * Click view Full
	 */
	$('.ver-capitulo-full-screen').on("click", function(){

		// $(".ver-capitulo").removeClass("ver-capitulo-white");

		// var heightScreen = $( window ).height();
		// alert(heightScreen);

		// $('.ver-capitulo-full-screen').fadeOut();
		// $('.ver-capitulo-full-screen').fadeOut();
		$('.ver-capitulo-full-screen').hide();
		$('.ver-capitulo-close-screen').css("display", "flex");
		$('.ver-capitulo').fullscreen();
		$(".ver-capitulo").addClass("ver-capitulo-full");

		// $(".asScrollable-container").css("height", heightScreen + "px");
		
		$(".asScrollable-container").toggleClass("asScrollable-container-full");
		$(".asScrollable-bar-vertical").delay(400).css("height", "calc(100vh - 10px)");
		
		$('.ver-capitulos').removeClass("ver-js-capitulos");
		$(".ver-capitulos").addClass("ver-js-capitulos-full");
		// $(".nav-capitulos-cont").delay(400).css("height", "100vh");

		// $(".ver-capitulo-leer").fadeOut();
		// $(".ver-capitulo-leer-full").fadeIn();

		// $('body').toggleClass("body-white");
		// $('footer').toggleClass("footer-white");

	});

	/**
	 * Click close Full
	 */
	$('.ver-capitulo-close-screen').on("click", function(){

		// $('.ver-capitulo-full-screen').fadeIn();
		// $('.ver-capitulo-close-screen').fadeOut();
		$('.ver-capitulo-full-screen').css("display", "flex");
		$('.ver-capitulo-close-screen').hide();
		$(".ver-capitulo").removeClass("ver-capitulo-full");

		$(".asScrollable-container").toggleClass("asScrollable-container-full");
		$(".asScrollable-bar-vertical").delay(400).css("height", "calc(100vh - 10px)");

		$('.ver-capitulos').addClass("ver-js-capitulos'");
		$(".ver-capitulos").removeClass("ver-js-capitulos-full");

		// $(".asScrollable-bar-vertical").delay(400).css("height", "100vh");
		// $(".nav-capitulos-cont").delay(400).css("height", "100%");
		
		$.fullscreen.exit();

	});


	/**
	 * Click close Full (ESC)
	 */
	$(document).keyup(function (e) {
		if (e.keyCode == 27) {
		
			// $('.ver-capitulo-full-screen').fadeIn();
			// $('.ver-capitulo-close-screen').fadeOut();
			$('.ver-capitulo-full-screen').css("display", "flex");
			$('.ver-capitulo-close-screen').hide();
			$(".ver-capitulo").removeClass("ver-capitulo-full");

			$(".asScrollable-container").toggleClass("asScrollable-container-full");
			$(".asScrollable-bar-vertical").delay(400).css("height", "calc(100vh - 10px)");

			$('.ver-capitulos').addClass("ver-js-capitulos'");
			$(".ver-capitulos").removeClass("ver-js-capitulos-full");

			// $(".asScrollable-bar-vertical").delay(400).css("height", "100vh");
			// $(".nav-capitulos-cont").delay(400).css("height", "100%");
			
			$.fullscreen.exit();

		}
	});

	/**
	 * Cambio de color - White
	 */
	$('.ver-capitulo-leer-full').on("click", function(){
		$('.ver-capitulo').toggleClass("ver-capitulo-white-full");
	});
	

	/**
	 * Modal - Mensaje
	 */
	// Open Modal
	$(modalOpenMensaje).on("click", function(){
		
		modalMensaje.style.display = "flex";
	});
	// Close Modal
	$(modalCloseMensaje).on("click", function(){
		
		modalMensaje.style.display = "none";
	});


	/**
	 * Click - Open Ver Capitulos
	 */
	$("body").on("click", '.ver-js-capitulos', function(){
		$(".nav-capitulos").toggleClass('nav-capitulos-toggle');
		$("body").css("overflow", "hidden");
	});

	/**
	 * Click - Open Ver Capitulos
	 */
	$("body").on("click", '.ver-js-capitulos-full', function(){
		$(".nav-capitulos").toggleClass('nav-capitulos-toggle');
	});

	/**
	 * Click - Close Ver Capitulos
	 */
	$('.close-nav-capitulos').click(function(){
		// $(this).toggleClass('open');
		$(".nav-capitulos").toggleClass('nav-capitulos-toggle');
		$("body").css("overflow", "auto");
	});


	/**
	 * asScrollbar (init - direction)
	 */
	Holder.run();
	$('.nav-scroll').asScrollable();
	$('.nav-scroll').on('asScrollable::scrolltop', function(e, api, direction) {
	console.info('top:' + direction);
	});
	$('.nav-scroll').on('asScrollable::scrollend', function(e, api, direction) {
	console.info('end:' + direction);
	});


	/**
	 * Click - Variables - Funcion para agrandar div y ver input[RANGE]
	 */
	var slider = document.querySelector(".ver-capitulo-options-texto-resize-slider"),
		estado = true;
	$(".ver-capitulo-options-texto-resize-icon").on("click", function(){

		if (estado) {
			slider.classList.add("ver-capitulo-options-texto-resize-slider-anim");
			$("#icon-resize").removeClass("ion-arrow-resize").addClass("ion-close-round");
			estado = false;
		} else {
			slider.classList.remove("ver-capitulo-options-texto-resize-slider-anim");
			$("#icon-resize").removeClass("ion-close-round").addClass("ion-arrow-resize");
			estado = true;
		}

	});

	/**
	 * Change - Input[RANGE] optener size y agrandar texto
	 */
	$( "#my-texto" ).change(function() {
		var x = document.getElementById("my-texto").value;
		$('.ver-capitulo-post-desc').css('font-size', x + "px");

		$('.ver-capitulo-post-desc').animate({fontSize: x + "px"}, 300);
	});

	/**
	 * Click - Modo de Lectura (FOCUS)
	 */
	$('.ver-capitulo-options-focus').click(function(){
		$("body").toggleClass('body-focus');
		$(".ver-capitulo").toggleClass('ver-capitulo-focus');
		$("footer").toggleClass('footer-focus');
	});


	/**
	 * Obtener alto de body
	 */
	bodysHeight = $("body").height();
	// alert(bodysHeight);


	/**
	 * Inicializar Popup Gallery
	 */
	$('.popup-gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title');
			}
		}
	});

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
		$(".ver-capitulo-header").fadeTo( 18, 0.15 );
	}
	else{
		$(".ver-capitulo-header").fadeTo( 10, 1 );
	}

	// if(desplazamientoActual >100){
	// 	bodysHeight
	// }
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
	// Modal Agregar - Close
	if (event.target == modal) {
		modal.style.display = "none";
	}
	// Modal Mensaje - Close
	if (event.target == modalMensaje) {
		modalMensaje.style.display = "none";
	}
}
