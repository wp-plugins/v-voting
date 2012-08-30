
<?php get_header() ?>

	<div id="content">
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
                            
                                <div class="item-list-projects">
                                
                                    <h4><?php _e( 'Invited events', 'bp-voting' ) ?></h4>
                                <?php global $wpdb; 
                                    $table = $wpdb->prefix."events_voting";
                                    $uid = bp_displayed_user_id();
                                    //query to create event_voting table these will contain three cloumns: event_id,user_id and uservote_count which will help to declare the winner at the end
                                   
$fivesdrafts = $wpdb->get_results("SELECT event_id FROM $table WHERE user_id = $uid;");
foreach ( $fivesdrafts as $fivesdraft ) 
{
	//echo $fivesdraft->event_id;

 $eid = $fivesdraft->event_id;
//echo $eid;
	$post_id = $eid;   // specify the post id to retrieve
$specific_post = get_post( $post_id );
//echo $specific_post-> post_title;
$thumbnail = wp_get_attachment_image_src($specific_post->post_parent, $type);
if($thumbnail != 0)
               $url12=apply_filters( 'bp_voting_get_item_thumbnail', $thumbnail[0]);
            else
                $url12= apply_filters( 'bp_voting_get_item_thumbnail', BP_voting_PLUGIN_URL . '/templates/' . BP_voting_TEMPLATE . '/img/default.png');
?>
 <div class="item-project">
                                            <div class="item-project-pictures">
                                             <img src="<?php echo $url12; ?>" width="250px" height="170px" />
</div>
                                            <div class="item-project-content">
                                                <h3>
                                                    <?php echo $specific_post-> post_title;?>
                                                    <?php if(bp_is_my_profile()) :?>
                                                    <div class="item-project-content-meta">
                                                        
                                                       <span class="edit"><a  href=" <?php echo bp_core_get_user_domain(bp_loggedin_user_id()).bp_get_voting_slug().'/castvote/join.php?voteevent='.$eid;?>"><?php _e('Join', 'bp-voting');?></a></span>
                                                     
                                                       </div>
                                                    <?php endif; ?>
                                                </h3>
                                               <span><a href="<?php bp_voting_item_startdate() ?>"><?php echo get_post_meta($specific_post-> ID, 'bp_voting_startdate', true); ?></a></span>
                                                <span><a href="<?php bp_voting_item_enddate() ?>"><?php echo get_post_meta($specific_post-> ID, 'bp_voting_enddate', true);?></a></span><p><?php bp_voting_item_description() ?></p>
                                                <p><?php echo $specific_post->post_content; ?></p>
                                            </div>
                                            <br />
                                        </div>
                                    
                                        <div class="item-project-separator"></div>
            <?php }?>                              

                                    
                                </div>
                            
                            
                        </div><!-- #item-body -->

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>
