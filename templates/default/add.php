<?php
    // Adding or editing page ?
    global $project;
    $edit_template = false;
    if(isset($project)) $edit_template = true;



?>

<?php get_header() ?>
<script type="text/javascript">
	//var $j = jQuery.noConflict();
	jQuery(function() {
		jQuery("#startdate-input").datepicker();
		jQuery("#enddate-input").datepicker();

	});
</script><div id="content">
		<div class="padder">

			<div id="item-header">
				<?php locate_template( array( 'members/single/member-header.php' ), true ) ?>
			</div>

			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav">
					<ul>
						<?php bp_get_displayed_user_nav() ?>
					</ul>
				</div>
			</div>

			<div id="item-body">

				<div class="item-list-tabs no-ajax" id="subnav">
					<ul>
						<?php bp_get_options_nav() ?>
					</ul>
				</div>
           
                                <?php if($edit_template) : ?>
                                    <h4><?php printf(__( 'Edit "%s" event', 'bp-voting' ), $project->query->post->post_title) ?></h4>
                                <?php else : ?>
                                    <h4><?php _e( 'Add a new event', 'bp-voting' ) ?></h4>
                                <?php endif; ?>
                                   

	<?php  //<form action="" method="post" id="achievement-grant-form" class="achievement-grant-form standard-form">
?>
	<?php //title form placed here?>
<form action="<?php ($edit_template) ? bp_voting_form_action( 'edit' ) : bp_voting_form_action( 'add' ) ?>" enctype="multipart/form-data" method="post" id="send_voting_form" class="standard-form" role="main">
	
	<div class="left-menu">
		<div id="grant-invite-list">
			<ul>
				<?php dpa_grant_achievement_userlist1() ?>
			</ul>
		</div>
	</div><!-- .left-menu -->

	<div class="main-column">
		<div id="message" class="info">
			<p><?php _e( 'Select people to join your event.'); ?></p>
		</div>

		<ul id="grant-user-list" class="item-list">
		</ul>
	</div><!-- .main-column -->
	<div class="clear"></div>
	

	<?php 
//</form>?>
<?php //new function for grant list
function dpa_grant_achievement_userlist1() {
	echo dpa_get_grant_achievement_userlist1();
}
function dpa_get_grant_achievement_userlist1() {

		global $bp, $wpdb;

		$options = array();

		if ( is_multisite() )
			$column = "spam";
		else
			$column = "user_status";

		$members = $wpdb->get_results( $wpdb->prepare( "SELECT ID, display_name FROM {$wpdb->users} WHERE {$column} = 0 ORDER BY display_name ASC" ) );
		foreach ( $members as $member )
			$options[] = sprintf( '<li><input type="checkbox" name="members[]" id="m-%1$d" value="%2$d" />%3$s', apply_filters( 'bp_get_member_user_id', $member->ID ), apply_filters( 'bp_get_member_user_id', $member->ID ), apply_filters( 'bp_get_member_user_nicename', $member->display_name ) );

		return implode( "\n", apply_filters( 'dpa_get_achievement_grant_userlist1', $options ) );
	}
//screen list



//end's here
?>
                                    <?php do_action( 'bp_before_voting_add_item' ) ?>

                                    <label for="title-input"><?php _e("Title", 'bp-voting') ?></label>
                                    <input type="text" name="title-input" id="title-input" value="<?php echo ($edit_template) ? $project->query->post->post_title : ''; ?>" />
                                   <?php //new field added date?>
                                    <label for="startdate-input"><?php _e("startdate", 'bp-voting') ?></label>
                                    <input type="text" name="startdate-input" id="startdate-input" value="<?php echo ($edit_template) ? get_post_meta($project->query->post->ID, 'bp_voting_startdate', true): ''; ?>" />
                                    
                                    <label for="enddate-input"><?php _e("enddate", 'bp-voting') ?></label>
                                    <input type="text" name="enddate-input" id="enddate-input" value="<?php echo ($edit_template) ? get_post_meta($project->query->post->ID, 'bp_voting_enddate', true): ''; ?>" />
                                    
                               
                                    <label for="description-input"><?php _e("Description", 'bp-voting') ?></label>
                                    <textarea name="description" id="description" rows="15" cols="40"><?php echo ($edit_template) ? $project->query->post->post_content : ''; ?></textarea>
                                    <p class="item-characters-left"><span id="charLeft"><?php echo BP_voting_DESC_MAX_SIZE; ?></span> <?php _e('characters left', 'bp-voting'); ?></p>
                                    
                                    <label for="screenshot-input"><?php _e("Screenshot", 'bp-voting') ?><?php if($edit_template) : ?><span style="font-weight: normal; font-style: italic; margin-left: 15px;"><?php _e('(Overwrite the previous one if it exists)', 'bp-voting'); ?></span><?php endif; ?></label>
                                    <input type="file" name="screenshot-input" id="screenshot-input" />

                                    

                                    <?php do_action( 'bp_before_voting_add_item' ) ?>

                                    <?php wp_nonce_field('project_form_nonce'); ?>
                                    
                                    <div class="submit">
                                            <input type="submit" value="<?php echo ($edit_template) ? __( "Edit this event", 'bp-voting' ) : __( "Add new event", 'bp-voting' ) ?>" name="<?php echo ($edit_template) ? 'edit' : 'add' ?>" id="<?php echo ($edit_template) ? 'edit' : 'add' ?>" />
                                    </div>

                                </form>

                        </div><!-- #item-body -->

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

        <script type="text/javascript">
                document.getElementById("title-input").focus();

                jq(document).ready(function() {
                	
                    var contentLen = jq('#description').val().length;
                    jq('#charLeft').text(<?php echo BP_voting_DESC_MAX_SIZE; ?> - contentLen);
                    
                    jq('#description').keyup(function() {
                        var len = this.value.length;
                        if (len >= <?php echo BP_voting_DESC_MAX_SIZE; ?>) {
                            this.value = this.value.substring(0, <?php echo BP_voting_DESC_MAX_SIZE; ?>);
                        }
                        jq('#charLeft').text(<?php echo BP_voting_DESC_MAX_SIZE; ?> - len);
                    });
                     

        </script>
                 

<?php get_footer() ?>
