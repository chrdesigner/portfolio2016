(function( $ ) {
	$(function() {
		var url = MyAutocomplete.url + '?action=my_search';
		$( '#s' ).autocomplete({
			source: url,
			delay: 500,
			minLength: 3,
			select: function(event, ui) {
		        //assign value back to the form element
		        if(ui.item){
		            $(event.target).val(ui.item.value);
		        }
		        //submit the form
		        $(event.target.form).submit();
		    },
			focus: function (event, ui) {
                $(".ui-helper-hidden-accessible").hide();
                event.preventDefault();
            }
		});	
	});
})( jQuery );