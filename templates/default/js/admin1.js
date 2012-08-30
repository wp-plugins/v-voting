jQuery(document).ready(function($) {
	
	$("#grant-invite-list input").click(function(event) {
		var member_id = $(this).val();
		if ( $(this).attr('checked') == false ) {
			$('#grant-user-list li#uid-' + member_id).remove();
			return;
		}

		$('.ajax-loader').toggle();
		$('div.item-list-tabs li.selected').addClass('loading');
       var data = {type: 'POST',
	   url: 'wp-admin/admin.php',
	   action: 'grant_user_details2',
	   'member_id': member_id
		};
			             
	$.post(votemeajax1.ajaxurl, data, function(response) {
			alert(member_id);
			$('.ajax-loader').toggle();
			$('#grant-user-list').append(response);
			jQuery('div.item-list-tabs li.selected').removeClass('loading');
	
							});
	});

});
//new1
jQuery(document).ready(function(){
     jQuery('#json_click_handler').click(function(){
          doAjaxRequest();
     });
});
function doAjaxRequest(){
     // here is where the request will happen
     jQuery.ajax({
          url: 'http://www.yourwpdirectory.com/wp-admin/admin-ajax.php',
          data:{
               'action':'do_ajax',
               'fn':'get_latest_posts',
               'count':10
               },
          dataType: 'JSON',
          success:function(data){
                 // our handler function will go here
                 // this part is very important!
                 // it's what happens with the JSON data
                 // after it is fetched via AJAX!
                             },
          error: function(errorThrown){
               alert('error');
               console.log(errorThrown);
          }
 
     });
 
}
//new
 jQuery.ajax({
     url: votemeajax1.ajaxurl,
     data: ({action : 'user-details'}),
     success: function() {
      //Do stuff here
     }
     });
//vote me
function votemeaddvote(postId)
{
	jQuery.ajax({
	type: 'POST',
	url: votemeajax1.ajaxurl,
	data: {
	action: 'dpa_grant_user_details2',
	postid: postId
},
success:function(data, textStatus, XMLHttpRequest){
	var linkid = '#grant-user-list-' + postId;
	jQuery(linkid).html('');
	jQuery(linkid).append(data);
	},
	error: function(MLHttpRequest, textStatus, errorThrown){
		alert(errorThrown);
		}
	});
}
