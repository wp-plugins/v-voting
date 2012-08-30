<?php

/**
 * Load the index page 
 */
function bp_voting_directory_setup() {
	if ( bp_is_voting_component() && !bp_current_action() && !bp_current_item() ) {
		bp_update_is_directory( true, 'voting' );

		do_action( 'bp_voting_directory_setup' );

		bp_core_load_template( apply_filters( 'voting_directory_template', BP_voting_TEMPLATE . '/index' ) );
	}
}
add_action( 'bp_screens', 'bp_voting_directory_setup' );



/**
 * Sets up and displays the screen output for the sub nav item "voting/personal"
 */
function bp_voting_screen_personal() {
	global $bp;

	do_action( 'bp_voting_personal_screen' );

	// Displaying Content
	bp_core_load_template( apply_filters( 'bp_voting_template_screen_one', BP_voting_TEMPLATE . '/personal' ) );
}

function bp_voting_screen_personal1() {
	global $bp;

	do_action( 'bp_voting_personal_screen' );

	// Displaying Content
	bp_core_load_template( apply_filters( 'bp_voting_template_screen_one', BP_voting_TEMPLATE . 'default/personal' ) );
}
/* setup and display screen output for event/invited event
*
*/
function bp_voting_screen_invited() {
	global $bp;

//echo "hello";
	do_action( 'bp_voting_screen_invited' );

	// Displaying Content
	bp_core_load_template( apply_filters( 'bp_voting_template_screen_invited', BP_voting_TEMPLATE . '/invited' ) );
}
//cast vote
function bp_voting_screen_castvote() {
	global $bp;

	//echo "hello";
	do_action( 'bp_voting_screen_castvote' );

	// Displaying Content
	bp_core_load_template( apply_filters( 'bp_voting_template_screen_castvote', BP_voting_TEMPLATE . '/join' ) );
}
/**
 * Sets up and displays the screen output for the sub nav item "voting/add"
 */
function bp_voting_screen_add() {
    global $bp;
    
    if(bp_action_variables()) {
        bp_do_404();
        return;
    }
    
    messages_remove_callback_values();
    
    if( isset($_POST['add']) ) {
        
        // Check the nonce
        if(!wp_verify_nonce($_POST['_wpnonce'], 'project_form_nonce')) {
            bp_core_add_message( __( 'There was an error recording the event, please try again', 'bp-voting' ), 'error' );
            bp_core_load_template( apply_filters( 'bp_voting_template_personal', BP_voting_TEMPLATE . '/personal' ) );
        }
        
        if(empty($_POST['title-input']) OR empty($_POST['description'])) {
            bp_core_add_message(__('All fields are required', 'bp-voting'), 'error');
        } else  {
            
            // Check the url
           
            
            // Check description size
            if(strlen($_POST['description']) > BP_voting_DESC_MAX_SIZE) {
                $_POST['description'] = substr($_POST['description'], 0, BP_voting_DESC_MAX_SIZE);
            }
                
            // Save the item
            $posts = array( 'author_id' => bp_loggedin_user_id(), 'title' => $_POST['title-input'], 'description' => $_POST['description'],'startdate' => $_POST['startdate-input'], 'enddate' => $_POST['enddate-input'] );//these is were we come 2day
            
            // Is that a capture has been sent ?
            if(isset($_FILES['screenshot-input']) AND $_FILES['screenshot-input']['error'] == 0) {
                $posts['screenshot'] = $_FILES['screenshot-input'];
            }
            
            if ( $item = bp_voting_save_item( $posts ) ) {
                    bp_core_add_message( __( 'event has been saved', 'bp-voting' ) );
                    bp_core_redirect(bp_core_get_user_domain(bp_loggedin_user_id()) . bp_get_voting_slug());
                   
            } else {
                    bp_core_add_message( __( 'There was an error recording the event, please try again', 'bp-voting' ), 'error' );
            }
        }
        
    }

    do_action( 'bp_voting_add_screen' );

    // Displaying Content
    bp_core_load_template( apply_filters( 'bp_voting_template_add', BP_voting_TEMPLATE . '/add' ) );

}




/**
 * Sets up and displays the screen output for the sub nav item "voting/edit/%d"
 */
function bp_voting_screen_edit() {
	
    if(bp_is_voting_component() AND bp_is_current_action( 'edit' ) AND (bp_displayed_user_id() == bp_loggedin_user_id()) ) {
        
        if(isset($_POST['edit'])) {
            
            // Check to see if the project belong to the logged_in user
            global $project;
            $project_id = bp_action_variable();
            $project = new BP_voting_Item();
            $project->get(array('id' => $project_id));
            if($project->query->post->post_author != bp_loggedin_user_id()) {
                bp_core_add_message( __( 'There was an error recording the project, please try again', 'bp-voting' ), 'error' );
                bp_core_load_template( apply_filters( 'bp_voting_template_screen_add', BP_voting_TEMPLATE . '/personal' ) );

            }
            
            // Check the nonce
            if(!wp_verify_nonce($_POST['_wpnonce'], 'project_form_nonce')) {
                bp_core_add_message( __( 'There was an error recording the project, please try again', 'bp-voting' ), 'error' );
                bp_core_load_template( apply_filters( 'bp_voting_template_screen_add', BP_voting_TEMPLATE . '/personal' ) );
            }
            
            if(empty($_POST['title-input']) OR empty($_POST['description'])) {
                
                bp_core_add_message(__('All fields are required', 'bp-voting'), 'error');
                $project_id = bp_action_variable();
                global $project;
                $project = new BP_voting_Item();
                $project->get(array('id' => $project_id));
                
            } else  {
                // Edit the post
                $posts = array( 'id' => bp_action_variable(), 'author_id' => bp_loggedin_user_id(), 'title' => $_POST['title-input'], 'description' => $_POST['description'], 'startdate' => $_POST['startdate-input'], 'enddate' => $_POST['enddate-input']);
                
                // Is that a capture has been sent ?
                if(isset($_FILES['screenshot-input']) AND $_FILES['screenshot-input']['error'] == 0) {
                    $posts['screenshot'] = $_FILES['screenshot-input'];
                }
                
                if ( $item = bp_voting_save_item( $posts ) ) {
                    bp_core_add_message( __( 'Event has been edited', 'bp-voting' ) );
                   
                    bp_core_redirect(bp_core_get_user_domain(bp_loggedin_user_id()) . bp_get_voting_slug());
                } else {
                        bp_core_add_message( __( 'There was an error recording the item, please try again', 'bp-voting' ), 'error' );
                }
                
            }
            
        } else {
            // Create a global $project, so template will know that this is the edit page
            if($project_id = bp_action_variable()) {
                global $project;
                $project_id = bp_action_variable();
                $project = new BP_voting_Item();
                $project->get(array('id' => $project_id));
                
                if($project->query->post->post_author == bp_loggedin_user_id()) {
                    bp_core_load_template( apply_filters( 'bp_voting_template_screen_one', BP_voting_TEMPLATE . '/add' ) );
                }
                    
            }
        }
        
    }

}
add_action( 'bp_screens', 'bp_voting_screen_edit' );

?>
