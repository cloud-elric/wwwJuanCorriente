$(document).ready(function(){
	 $(".animsition-effect").animsition({transition: function(url){
		 $('.animsition-effect').animsition('in');
	 }
	  });
	 
	 
	 $(".home-categorias-item").on('click', function(e){
		 e.preventDefault();
		 
		 $('.animsition-effect').animsition('out', $('.animsition-effect'), '');
	 })
});