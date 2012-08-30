<?php

/**
 * Add the BP-voting submenu under the BuddyPress menu
 */
function bp_voting_add_admin_menu() {
	global $bp;

	if ( !is_super_admin() )
		return false;

	$hook = add_submenu_page( 'bp-general-settings', __( 'BP-voting', 'bp-voting' ), __( 'v-voting', 'bp-voting' ), 'manage_options', 'bp-voting-settings', 'bp_voting_admin_screen' );
        
        add_action( "admin_print_styles-$hook", 'bp_core_add_admin_menu_styles' );
}
add_action( bp_core_admin_hook(), 'bp_voting_add_admin_menu' );



/*
 * Checks for form submission, saves component settings and outputs admin screen HTML.
 */
function bp_voting_admin_screen() {

    /* If the form has been submitted and the admin referrer checks out, save the settings */
    if ( isset( $_POST['submit'] ) && check_admin_referer('voting-settings') ) {
            update_option( 'bp_voting_template', 'default' );
            update_option( 'bp_voting_desc_max_size', $_POST['description-max-size'] );
 global $wp_table,$wpdb;
   $table = $wpdb->prefix."events_voting";
$y=$_POST['description-max-size'];
$wpdb->get_results("update $table SET votevalue= $y;");
$setvcount=$_POST['active-template'];
$wpdb->get_results("update $table SET uservote_count= $setvcount;"); 
           $updated = true;
    }
    
    $description_max_size = get_option( 'bp_voting_desc_max_size' );
    $active_template = get_option( 'bp_voting_template' );
    
?>    
    <div class="wrap">
        
        <?php screen_icon( 'buddypress' ); ?>
        
	<h2><?php _e( 'v-voting Settings', 'bp-voting' ) ?></h2>
	<br />
        
        <?php if ( isset($updated) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Settings Updated.', 'bp-voting' ) . "</p></div>" ?><?php endif; ?>
        
        <form action="<?php echo site_url() . '/wp-admin/admin.php?page=bp-voting-settings' ?>" name="voting-settings-form" id="voting-settings-form" method="post">

                <table class="form-table">
                        <tr valign="top">
                                <th scope="row"><label for="target_uri"><?php _e( 'Default Number of Votes for every user', 'bp-voting' ) ?></label></th>
                                <td>
                                           
				 <input name="active-template" type="text" id="active-template" value="<?php echo esc_attr( 10 ); ?>" size="10" />
                                </td>
                        </tr>
                                <th scope="row"><label for="target_uri"><?php _e( 'Set Default Vote Value for every user', 'bp-voting' ) ?></label></th>
                                <td>
                                        <input name="description-max-size" type="text" id="description-max-size" value="<?php echo esc_attr( $description_max_size ); ?>" size="10" />
                                </td>
                        </tr>
                </table>
                <p class="submit">
                        <input type="submit" name="submit" value="<?php _e( 'Save Settings', 'bp-voting' ) ?>"/>
                </p>

                <?php
                /* This is very important, don't leave it out. */
                wp_nonce_field( 'voting-settings' );
                ?>
        </form>
        
    </div>


<?php
}

?>
