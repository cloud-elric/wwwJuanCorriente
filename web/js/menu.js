/**
 * Click - Menu movil - animaciones
 */
(function($) {

// slideout nav
var $navContainer = $('#navContainer');
var $closeMainNav = $('.closeMainNav');

$closeMainNav.on('click', function(e) {
	e.preventDefault();
	if ($navContainer.hasClass('open')) {
		$navContainer.removeClass('open');
		$closeMainNav.removeClass('open');
		$("body").css("overflow-y", "auto");
	} else {
		$navContainer.addClass('open');
		$closeMainNav.addClass('open');
		$("body").css("overflow-y", "hidden");
	}
});

// main navigation animation
var unitAnimationDelay = 60; // ms
var $hasSubMenu = $('.hasSubMenu');
var $backToParent = $('.backToParent');
var $mainNavigationList = $('#mainNavigationList');

$hasSubMenu.on('click', function(e) {
	e.preventDefault();

	var $currentMenu = $(this).parent().parent();
	var subMenuId = $(this).data('menu');
	var $subMenu = $('#' + subMenuId);

	$currentMenu.addClass('animate-outToLeft');
	$subMenu.addClass('animate-inFromRight');

	$currentMenu.children().last().on('webkitAnimationEnd MSAnimationEnd oAnimationEnd animationend', function() {
		$currentMenu.removeClass('animate-outToLeft current');

	});

	$subMenu.children().last().on('webkitAnimationEnd MSAnimationEnd oAnimationEnd animationend', function() {
		$subMenu.removeClass('animate-inFromRight').addClass('current');
	});

});


$backToParent.on('click', function(e) {
	e.preventDefault();

	var $currentMenu = $(this).parent().parent();

	$currentMenu.addClass('animate-outToRight');
	$mainNavigationList.addClass('animate-inFromLeft');
	$currentMenu.children().last().on('webkitAnimationEnd MSAnimationEnd oAnimationEnd animationend', function() {
		$currentMenu.removeClass('animate-outToRight current');
	});
	$mainNavigationList.children().last().on('webkitAnimationEnd MSAnimationEnd oAnimationEnd animationend', function() {
		$mainNavigationList.removeClass('animate-inFromLeft').addClass('current');
	});
});

$('.mainNavigationList').each(function() {
	var i = 0;
	$(this).children().each(function() {
		var delay = parseInt(unitAnimationDelay * i);
		var item = $(this)[0];
		item.style.WebkitAnimationDelay = item.style.animationDelay = delay + 'ms';
		i++;
	});
});

})(jQuery);