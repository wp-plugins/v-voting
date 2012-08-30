jQuery(document).ready(function($) {

	$("#grant-invite-list input").click(function(event) {
		var member_id = $(this).val();
		if ( $(this).attr('checked') == false ) {
			$('#grant-user-list li#uid-' + member_id).remove();
			return;
		}

		$('.ajax-loader').toggle();
		$('div.item-list-tabs li.selected').addClass('loading');

		$.post( ajaxurl, {
			action: 'grant_user_details2',
			'cookie': encodeURIComponent(document.cookie),
			'member_id': member_id
		},
		function(response)
		{
			$('.ajax-loader').toggle();
			$('#grant-user-list').append(response);
			jQuery('div.item-list-tabs li.selected').removeClass('loading');
		});
	});



});

	
