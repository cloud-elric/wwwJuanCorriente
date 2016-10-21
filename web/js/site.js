var token='';
$(document).ready(function(){
	 $(".animsition-effect").animsition({transition: function(url){
//		 console.log(token);
		 
//		 $('.animsition-effect-'+token).animsition('in');
		 
		 
	 }
	  });
	 
	 $('.animsition-effect').on('animsition.outEnd', function(){
		 //$('.animsition-effect-'+token).addClass('active');
		 $('.animsition-effect.active').removeClass('active');
		 $('.animsition-effect-'+token).addClass('active');
		 $('.animsition-effect-'+token).animsition('in');
	 });
	 
	 
	 $(".home-categorias-item").on('click', function(e){
		 e.preventDefault();
		 token = $(this).data('token');
		 
		 var actual = $('.animsition-effect.active'); 
		 actual.animsition('out', $('.animsition-effect.active'), '');
		 
		$('.home-categorias-item').removeClass('active');
		 $(this).addClass('active');
		
		 
	 })
});