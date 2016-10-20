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
	$('#ladda-1').click(function(e){
		e.preventDefault();
		var l = Ladda.create(this);
		l.start();
	});
	$('#ladda-2').click(function(e){
		e.preventDefault();
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
