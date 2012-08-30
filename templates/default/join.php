
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
                                
                                    <h4><?php _e( 'Cast vote for events', 'bp-voting' ) ?></h4>
                  <?php $variable = (isset($_GET['voteevent'])) ? $_GET['voteevent'] : null; 
					//we are teking the event id from invited page directly here to name
					$name = $_GET['voteevent'];
if(isset($_GET['voteevent']))
{
//echo $_GET['voteevent'];

               ?>
                                <?php global $wpdb; 
                                    $table = $wpdb->prefix."events_voting";
                                    $uid = bp_displayed_user_id();
                                    //query to create event_voting table these will contain three cloumns: event_id,user_id and uservote_count which will help to declare the winner at the end
$username = $wpdb->get_results("SELECT user_id FROM $table WHERE event_id = $name;");    
	
$post_id = $name;   // specify the post id to retrieve
$specific_post = get_post( $post_id );
$thumbnail = wp_get_attachment_image_src($specific_post->post_parent, $type);
//complete event details are shown below
  if($thumbnail != 0)
               $url1=apply_filters( 'bp_voting_get_item_thumbnail', $thumbnail[0]);
            else
                $url1= apply_filters( 'bp_voting_get_item_thumbnail', BP_voting_PLUGIN_URL . '/templates/' . BP_voting_TEMPLATE . '/img/default.png');
?>

 <div class="item-project">
<div class="item-project-pictures">
                   <img src="<?php echo $url1; ?>" width="250px" height="170px" />
</div>
                                              <div class="item-project-content">
                                                <h3>
                                                    <?php echo $specific_post-> post_title;?>
                                                    <?php if(bp_is_my_profile()) :?>
                                                    <div class="item-project-content-meta">
                                                        
                                                      </div>
                                                    <?php endif; ?>
                                                </h3>
                                                <?php $checkenddate=get_post_meta($specific_post-> ID, 'bp_voting_enddate', true);?>
                                               <span><a href="<?php bp_voting_item_startdate() ?>"><?php echo get_post_meta($specific_post-> ID, 'bp_voting_startdate', true); ?></a></span>
                                                <span><a href="<?php bp_voting_item_enddate() ?>"><?php echo get_post_meta($specific_post-> ID, 'bp_voting_enddate', true);?></a></span><p><?php bp_voting_item_description() ?></p>
                                                <p><?php echo $specific_post->post_content; ?></p>
                                            </div>
                                            <br />
                                        </div>
                                    
                                        <div class="item-project-separator"></div>
                                

                                    
                                </div>
                            
                            
                        </div>
 <div class="main-column">                       
<ul id="grant-user-list" class="item-list">
<?php
$ucrrentdate=date('m/d/Y');
//echo  $ucrrentdate;
global $wpdb;
$table = $wpdb->prefix."events_voting";
if($checkenddate<=$ucrrentdate)
{
	global $wpdb;
	$table = $wpdb->prefix."events_voting";
	//CURRENT USER DETAILS ARE UPDATED HERE
	$topthreeuser = $wpdb->get_results("SELECT user_id , event_id , totalvalue,uservote_count FROM $table WHERE event_id =$name ORDER BY totalvalue DESC;");
	echo "<div id=topthree>Top Three Users</div>";
	foreach ( $topthreeuser as $usr1 )
	{
	
		echo "<br>";
		global $bp;
		$user = new BP_Core_User( $usr1->user_id );
			echo '<li id="uid-' . $user->id . '">';
			echo $user->avatar_thumb;
			echo '<h4>' . $user->user_link . '</h4>';
			echo '<span class="activity">' . esc_attr( $user->last_active ) . '</span>';
			$winner= '<div id=winner>'.$usr1->uservote_count.' votes';			
			$winner.= '</div>';
			echo $winner;			
			echo '</li>';
			echo "<br>"	;
		
	}
}
else
{
//users for that particular event are displayed are shown below


foreach ( $username as $usr ) 
{
	
	echo "<br>";
	global $bp;
	$user = new BP_Core_User( $usr->user_id );
	if($user->id!=$uid)
	{
	echo '<li id="uid-' . $user->id . '">';
	echo $user->avatar_thumb;
	echo '<h4>' . $user->user_link . '</h4>';
	echo '<span class="activity">' . esc_attr( $user->last_active ) . '</span>';
	$votemecount = $wpdb->get_results("SELECT uservote_count FROM $table WHERE event_id = $name AND user_id= $usr->user_id;");
	//$link = $votemecount.' <a onclick="votemeaddvote('.$post_ID.');">'.'Vote'.'</a>';
foreach ($votemecount as $vmc)
{
	//echo $vmc->uservote_count;
	//<a href='javascript:;' onclick='show_more_menu();'>More >>></a>
	$link = '<div id="voteme-'.$user->id.'" >';
	$link .= $vmc->uservote_count.' <a onclick="votemeaddvote('.$user->id.','.$name.','.$uid.');">'.'Vote'.'</a>';
	$link .= '</div>';
	echo $link;
}

	//echo $link;
	echo '</li>';
	echo "<br>"	;
	}
} 
}   ?>	
<div id='grant-user-list'></div>
<?php 
function voteadding()
{
	echo "vote added";
}

?>
<?php
}
else
{
echo "select event";

?>
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
               $url13=apply_filters( 'bp_voting_get_item_thumbnail', $thumbnail[0]);
            else
                $url13= apply_filters( 'bp_voting_get_item_thumbnail', BP_voting_PLUGIN_URL . '/templates/' . BP_voting_TEMPLATE . '/img/default.png');

?>
 <div class="item-project">
                                            <div class="item-project-pictures">
                                               <img src="<?php echo $url13; ?>" width="250px" height="170px" />
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
            <?php }}?>

<script type="text/javascript">
	

</script>
</ul>
</div>
	</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>

