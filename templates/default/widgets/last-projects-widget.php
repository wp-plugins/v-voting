<?php
global $bp_voting_widget_last_projects_max;

$projects = new BP_voting_Item();
$projects->get(array('posts_per_page' => $bp_voting_widget_last_projects_max));
//print_r($projects);
?>

<?php
foreach($projects->query->posts as $project) :
    
    $attachment = wp_get_attachment_image_src($project->post_parent, 'voting-widget-thumb');        
    if($attachment != 0)
        $thumbnail = apply_filters( 'bp_voting_get_item_thumbnail', $attachment[0]);
    else
        $thumbnail = apply_filters( 'bp_voting_get_item_thumbnail', BP_voting_PLUGIN_URL . '/templates/' . BP_voting_TEMPLATE . '/img/default.png');
?>

    <div class="widget-item-project">
        <div class="widget-item-project-pictures">
            <img src="<?php echo $thumbnail; ?>" width="36px" height="36px" />
        </div>
        <div class="widget-item-project-content">
            <p>
                <a href="<?php echo bp_core_get_user_domain( $project->post_author ) . BP_voting_SLUG; ?>" title="<?php echo sprintf(__('from %s', 'bp-voting'), bp_core_get_user_displayname( $project->post_author )); ?>"><?php echo $project->post_title; ?></a>
            </p>
        </div>
    </div>

<?php
endforeach;
?>

<span class="widget-all-projects"><a href="<?php echo trailingslashit(site_url()) . BP_voting_SLUG; ?>"><?php _e('See all projects', 'bp-voting'); ?></a></span>
