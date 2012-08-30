function votemeaddvote(postId,eventID,currID)
{
	jQuery.ajax({
	type: 'POST',
	url: votemeajax.ajaxurl,
	data: {
	action: 'voteme_addvote',
	postid: postId,
	eventid:eventID,
	currid:currID
},
success:function(data, textStatus, XMLHttpRequest){
	var linkid = '#voteme-' + postId;
	jQuery(linkid).html('');
	jQuery(linkid).append(data);
	},
	error: function(MLHttpRequest, textStatus, errorThrown){
		alert(errorThrown);
		}
	});
}	


		
