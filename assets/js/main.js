jQuery(document).ready(function($) {

	var header = $('#header');
    $('#container-main').css('padding-top', header.innerHeight());

	var footer = $('#footer');
	setTimeout(function(){
		$('body').css('margin-bottom', footer.innerHeight());
		$('#footer').css('height', footer.innerHeight());
	},3300);

});