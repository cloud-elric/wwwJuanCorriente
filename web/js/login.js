$('body').on('beforeSubmit', '#login-form', function() {
		var form = $(this);
		// return false if form still have some validation errors
		if (form.find('.has-error').length) {
			return false;
		}
		
		var button = document.getElementById('js-login-submit');
		var l = Ladda.create(button);
	 	l.start();
		
	});