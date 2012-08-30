<?php

/**
 * Delte an item 
 */
function bp_voting_item_delete() {
    
    if(bp_is_voting_component() AND bp_is_current_action( 'delete' ) AND (bp_displayed_user_id() == bp_loggedin_user_id()) ) {
        if($project_id = bp_action_variable() AND wp_verify_nonce($_REQUEST['_wpnonce'], 'delete_project')) {
            
                if(bp_voting_delete_item( $project_id ) )
                    bp_core_add_message( __( 'Event deleted !', 'bp-voting' ) );
                else
                    bp_core_add_message( __( 'An error occured, please try again.', 'bp-voting' ), 'error' );
                
        } else {
            bp_core_add_message( __( 'An error occured, please try again.', 'bp-voting' ), 'error' );
        }
        bp_core_redirect( bp_core_get_user_domain(bp_loggedin_user_id()) . bp_get_voting_slug() );
    }
    
}
add_action( 'bp_actions', 'bp_voting_item_delete' );
//join action is performaed here
function bp_voting_item_join() {

	if(bp_is_voting_component() AND bp_is_current_action( 'join' )  ) {
		if($project_id = bp_action_variable() AND wp_verify_nonce($_REQUEST['_wpnonce'], 'delete_project')) {

			if(bp_voting_delete_item( $project_id ) )
				bp_core_add_message( __( 'Event deleted !', 'bp-voting' ) );
			else
				bp_core_add_message( __( 'An error occured, please try again.', 'bp-voting' ), 'error' );

		} else {
			bp_core_add_message( __( 'An error occured, please try again.', 'bp-voting' ), 'error' );
		}
		bp_core_redirect( VOTEMESURL.'templates/default/join.php' );
	}

}
add_action( 'bp_actions', 'bp_voting_item_join' );

?>
