jQuery(document).ready(function($) {

	$('ul.menu, ul.submenu, div.menu ul, div.submenu ul').superfish({
		delay:       100,								// .5 second delay on mouseout
		animation:   {opacity:'show',height:'show'},	// fade-in and slide-down animation
		dropShadows: false								// disable drop shadows
	});

});
