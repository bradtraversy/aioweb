$(function () {
    $('.checkall').on('click', function () {
        $(this).closest('fieldset').find(':checkbox').prop('checked', this.checked);
    });
});

$(function () {
	$('.item_type').change(function(){
		if($('.item_type').val() == 'page'){
			$('.page_select').show();
			$('.form_select').hide();
			$('.url_select').hide();
			$('.url_item').val(0);
			$('.form_item').val(0);
		} else if($('.item_type').val() == 'form'){
			$('.form_select').show();
			$('.page_select').hide();
			$('.url_select').hide();
			$('.url_item').val(0);
			$('.page_item').val(0);
		} else if($('.item_type').val() == 'url'){
			$('.url_select').show();
			$('.form_select').hide();
			$('.page_select').hide();
			$('.page_item').val(0);
			$('.form_item').val(0);
		}
	});
});

$(document).ready(function(){
	if($('.item_type').val() == 'page'){
			$('.page_select').show();
			$('.form_select').hide();
			$('.url_select').hide();
	} else if($('.item_type').val() == 'form'){
			$('.form_select').show();
			$('.page_select').hide();
			$('.url_select').hide();
	} else if($('.item_type').val() == 'url'){
			$('.url_select').show();
			$('.form_select').hide();
			$('.page_select').hide();
	}
});


/*
$(function () {
	$('.menu').change(function(){
		$.post( "http://localhost/aio_web/admin/menus/items/add", function( data ) {
			menu_select = $('.menu').val();
  		$( ".selected_menu" ).html(menu_select);
});
	});
});
*/