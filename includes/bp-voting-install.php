<?php

/**
 * Setup the default options in the wp_options table
 */
function bp_voting_default_options() {
    
	global $wpdb;
	$table = $wpdb->prefix."events_voting";
	$structure = "CREATE TABLE IF NOT EXISTS $table (
	 id INT(9) unsigned NOT NULL AUTO_INCREMENT,
	 event_id INT(9) unsigned NOT NULL,
	user_id BIGINT(20) NOT NULL,
	uservote_count BIGINT(20) DEFAULT '10' NOT NULL,votevalue BIGINT(20) DEFAULT '1' NOT NULL,totalvalue BIGINT(20) DEFAULT '10' NOT NULL,
	PRIMARY KEY id (id),
	CONSTRAINT user_event_pair UNIQUE (user_id, event_id)
	);";
	//query to create event_voting table these will contain three cloumns: event_id,user_id and uservote_count which will help to declare the winner at the end
	$wpdb->query($structure);
    
	// The default max size for the description of a project
    add_option('bp_voting_desc_max_size', '720');
    
    // The default template
    add_option('bp_voting_template', 'default');
    
}

?>
