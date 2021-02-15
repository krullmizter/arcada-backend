$(document).ready(function(){
	$('#navbar__searchField').autocomplete({
        source: '../../php/includes/search/search.php',
        minLength: 1,
        close: function () { 
            $('.ui-autocomplete').show()
        },
        select: function(event, ui) {
            $.ajax({
                type: 'GET',
                url: '../../php/includes/search/searchQuickInfo.php',
                dataType: 'html',
                data: {title: ui.item.value},
                success: function(response){                    
                    $('.ui-menu').append(response);
                }
            });
        }
    });
});