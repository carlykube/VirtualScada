$(document).ready( function() {
	console.log("Found JS file");
	/*$('#left-accordion .panel-title').click( function() {
		var icon = $(this).find('i');
		if(icon.hasClass('fa-arrow-left')) {
			icon.removeClass('fa-arrow-left');
			icon.addClass('fa-arrow-down');
		} else if(icon.hasClass('fa-arrow-down')) {
			$('#left-accordion .panel-title i').removeClass('fa-arrow-down');
			icon.addClass('fa-arrow-left');
		}
	})*/
	$(".collapse").on('hide.bs.collapse', function() {
		var icon = $(this).parent().find('.panel-heading i');
		icon.removeClass('fa-arrow-down');
		icon.addClass('fa-arrow-left');
	});

	$(".collapse").on('show.bs.collapse', function() {
		var icon = $(this).parent().find('.panel-heading i');
		icon.removeClass('fa-arrow-left');
		icon.addClass('fa-arrow-down');
	});
});