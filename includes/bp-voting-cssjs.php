<?php

/**
 * Add required CSS and JS files
 */
function bp_voting_add_css() {
	global $bp;

        wp_register_style( 'bp-voting-css', BP_voting_PLUGIN_URL . '/templates/' . BP_voting_TEMPLATE . '/css/general.css' );
        
	if ( ($bp->current_component == $bp->voting->slug) OR ($bp->current_component == $bp->activity->slug) ) {
            wp_enqueue_style( 'bp-voting-css' );
        }
}
add_action( 'wp_print_styles', 'bp_voting_add_css');

?>
