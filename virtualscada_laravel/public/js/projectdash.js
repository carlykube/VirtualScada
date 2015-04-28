$(document).ready( function() {
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

	$("#screenOneLink").click(function() {
		$("#right-content .screen").hide();
		$("#screenTwoLink").removeClass("active");
		$("#screenThreeLink").removeClass("active");
		$(this).addClass('active');
		$("#right-content .screenOne").show();
	});

	$("#screenTwoLink").click(function() {
		$("#right-content .screen").hide();
		$("#screenOneLink").removeClass("active");
		$("#screenThreeLink").removeClass("active");
		$(this).addClass('active');
		$("#right-content .screenTwo").show();
	});

	$("#screenThreeLink").click(function() {
		$("#right-content .screen").hide();
		$("#screenTwoLink").removeClass("active");
		$("#screenOneLink").removeClass("active");
		$(this).addClass('active');
		$("#right-content .screenThree").show();
	});

	$('#draggable5').draggable({containment: '.projectpanel', scroll: false, grid: [30, 30]});
});