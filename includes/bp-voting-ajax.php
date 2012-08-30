<?php

/**
 * Intercepts the ajax request and returns projects
 */
function bp_voting_ajax_index_pagination() {    
    bp_core_load_template( apply_filters( 'voting_directory_template', BP_voting_TEMPLATE . '/projects-loop' ) );
}
add_action( 'wp_ajax_projects_filter', 'bp_voting_ajax_index_pagination' );
//our user checked user details list
add_action( 'wp_ajax_nopriv_grant_user_details2', 'grant_user_details2' );
add_action( 'wp_ajax_grant_user_details2', 'grant_user_details2' );

function grant_user_details2() {
		global $bp;
	if ( empty( $_POST['member_id'] ) )
		return false;

	$member_id = (int)$_POST['member_id'];
	if ( !get_userdata( $member_id ) )
		return false;

	$user = new BP_Core_User( $member_id );

	echo '<li id="uid-' . $user->id . '">';
	echo $user->avatar_thumb;
	echo '<h4>' . $user->user_link . '</h4>';
	echo '<span class="activity">' . esc_attr( $user->last_active ) . '</span>';
	echo '</li>';

}
add_action( 'wp_ajax_nopriv_voteme_addvote', 'voteme_addvote' );
add_action( 'wp_ajax_voteme_addvote', 'voteme_addvote' );
function voteme_addvote()
{
	$recptuserID= $_POST['postid'];
	$eventId= $_POST['eventid'];
	$currID= $_POST['currid'];
	global $wpdb;
	$table = $wpdb->prefix."events_voting";
	//CURRENT USER DETAILS ARE UPDATED HERE
	$votemecount = $wpdb->get_results("SELECT uservote_count,votevalue,totalvalue FROM $table WHERE event_id = $eventId AND user_id= $currID;");
	//$link = $votemecount.' <a onclick="votemeaddvote('.$post_ID.');">'.'Vote'.'</a>';
	
	//$r=addtwo($e+$r2);

	foreach ($votemecount as $vmc)
	{
		$results=$vmc->uservote_count;
		if($results>=1)
		{ 
		$uvotecount=$results - 1;//decremented uservote count
		$uvotevalue=$vmc->votevalue;
		}
		else
		{
			die("your vote's are over");
		}
	}
	$wpdb->get_results("update $table SET uservote_count=$uvotecount,totalvalue= $uvotecount*$uvotevalue WHERE event_id = $eventId AND user_id= $currID;");
	//RECIPT DETAILS ARE UPDATED HERE
	$RECPvotemecount = $wpdb->get_results("SELECT uservote_count,votevalue,totalvalue FROM $table WHERE event_id = $eventId AND user_id= $recptuserID;");
	//$link = $votemecount.' <a onclick="votemeaddvote('.$post_ID.');">'.'Vote'.'</a>';
	
	//$r=addtwo($e+$r2);
	
	foreach ($RECPvotemecount as $RECPvmc)
	{
		$RECPresults=$RECPvmc->uservote_count;
		$RECPuvotecount=$RECPresults + 1;//decremented uservote count
		$RECPuvotevalue=$vmc->votevalue;
	}
	$wpdb->get_results("update $table SET uservote_count=$RECPuvotecount,totalvalue= $RECPuvotecount*$RECPuvotevalue WHERE event_id = $eventId AND user_id= $recptuserID;");
	$RECPuvotecount.=' <a onclick="votemeaddvote('.$recptuserID.','.$eventId.','.$currID.');">'.'Vote'.'</a>';
	settype($RECPuvotecount,"string");
	//settype($results,"int");
	die($RECPuvotecount);
	
}
?>
