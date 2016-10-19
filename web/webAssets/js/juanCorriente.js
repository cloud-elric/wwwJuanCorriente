/**
 * Proyecto
 *
 * # author      Damián <@damian>
 * # copyright   Copyright (c) 2016, Proyecto
 *
 */

/**
 * ----------------------------
 *		Document Ready
 * ----------------------------
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

}); // end - READY

$(document).on("scroll", function(){
	var desplazamientoActual = $(document).scrollTop();

	if(desplazamientoActual > 100 ){
		$(".ver-capitulo-header").fadeTo( 18, 0.45 );
	}
	else{
		$(".ver-capitulo-header").fadeTo( 10, 1 );
	}
});