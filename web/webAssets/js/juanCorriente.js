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
	
	/**
	 * Click view Full
	 */
	$('.ver-capitulo-full-screen').on("click", function(){

		$('.ver-capitulo-full-screen').fadeOut();
		$('.ver-capitulo-close-screen').fadeIn();
		$('.ver-capitulo').fullscreen();
		$(".ver-capitulo").toggleClass("ver-capitulo-full");

		$(".ver-capitulo-leer").fadeOut();
		$(".ver-capitulo-leer-full").fadeIn();

	});

	/**
	 * Click close Full
	 */
	$('.ver-capitulo-close-screen').on("click", function(){

		$('.ver-capitulo-close-screen').fadeOut();
		$('.ver-capitulo-full-screen').fadeIn();
		$(".ver-capitulo").toggleClass("ver-capitulo-full");
		
		$.fullscreen.exit();
		
		$(".ver-capitulo-leer-full").fadeOut();
		$(".ver-capitulo-leer").fadeIn();

	});

	/**
	 * Click close Full (ESC)
	 */
	$(document).keyup(function (e) {
		if (e.keyCode == 27) {
			$('.ver-capitulo-close-screen').fadeOut();
			$('.ver-capitulo-full-screen').fadeIn();
			$(".ver-capitulo").toggleClass("ver-capitulo-full");
			$.fullscreen.exit();
			$(".ver-capitulo-leer-full").fadeOut();
			$(".ver-capitulo-leer").fadeIn();
		}
	});

	/**
	 * Cambio de color - White
	 */
	$('.ver-capitulo-leer-full').on("click", function(){
		$('.ver-capitulo').toggleClass("ver-capitulo-white-full");
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
	if (event.target == modal) {
		modal.style.display = "none";
	}
}