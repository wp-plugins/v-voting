<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;




class BP_voting_Component extends BP_Component {
    
    /**
     * Initialize the component
     */
    public function __construct() {
        global $bp;
        
        parent::start(
                'voting', __('voting', 'bp-voting'), BP_voting_PLUGIN_DIR
        );
        
        $this->includes();
        $bp->active_components[$this->id] = '1';//1 default
        // add_action('init', array(&$this, 'register_post_types'));
    }
    
    
    
    /**
     * Include component's files 
     */
    public function includes() {
        $includes = array(
            'includes/bp-voting-actions.php',
            'includes/bp-voting-screens.php',
            'includes/bp-voting-filters.php',
            'includes/bp-voting-classes.php',
            'includes/bp-voting-activity.php',
            'includes/bp-voting-functions.php',
            'includes/bp-voting-widgets.php',
            'includes/bp-voting-cssjs.php',
            'includes/bp-voting-ajax.php',
            'includes/bp-voting-template.php'
        );
        
        parent::includes($includes);
        
        // Load the admin required file
        if (is_admin() || is_network_admin()) {
            include( BP_voting_PLUGIN_DIR . '/includes/bp-voting-admin.php' );
        }
    }
    
    
    
    /**
     * Set up plugin's globals 
     */
    function setup_globals() {
        global $bp;
        
        if (!defined('BP_voting_SLUG'))
            define('BP_voting_SLUG', $this->id);
        
        if(!defined('BP_voting_DESC_MAX_SIZE'))
            define('BP_voting_DESC_MAX_SIZE', get_option('bp_voting_desc_max_size'));
        
        if(!defined('BP_voting_TEMPLATE'))
            define('BP_voting_TEMPLATE', get_option('bp_voting_template'));
        
        
        $global_tables = array(
            'table_items_name' => $bp->table_prefix . BP_voting_ITEMS_TABLE
        );
        
        $globals = array(
            'slug' => BP_voting_SLUG,
            'root_slug' => isset($bp->pages->{$this->id}->slug) ? $bp->pages->{$this->id}->slug : BP_voting_SLUG,
            'has_directory' => true,
            'notification_callback' => 'bp_voting_format_notifications',
            'search_string' => __('Search events...', 'bp-voting'),
            'global_tables' => $global_tables
        );
        
        parent::setup_globals($globals);
    }
    
    
    /**
     * Set the component's navigation 
     */
    public function setup_nav() {
        
        // Main navigation
        $main_nav = array(
            'name' => sprintf( __( 'Event <span>%s</span>', 'bp-voting' ), bp_voting_get_user_projects_count(bp_displayed_user_id() ) ),
            'slug' => bp_get_voting_slug(),
            'position' => 80,
            'screen_function' => 'bp_voting_screen_personal',
            'default_subnav_slug' => 'voting'
        );
        
        $voting_link =trailingslashit(bp_loggedin_user_domain() . bp_get_voting_slug());

        // Add a few subnav items under the main voting tab
        $sub_nav[] = array(
            'name' => __('Personal', 'bp-voting'),
            'slug' => 'personal',
            'parent_url' => $voting_link,
            'parent_slug' => bp_get_voting_slug(),
            'screen_function' => 'bp_voting_screen_personal',
            'position' => 10
        );
        
        
       // if(bp_displayed_user_id() == bp_loggedin_user_id() ) {
            // Add a few subnav items under the main voting tab
            $sub_nav[] = array(
                'name' => __('Add', 'bp-voting'),
                'slug' => 'add',
                'parent_url' => $voting_link,
                'parent_slug' =>bp_get_voting_slug(),
                'screen_function' => 'bp_voting_screen_add',
                'position' => 10
            );
$sub_nav[] = array(
                'name' => __('Invited events', 'bp-voting'),
                'slug' => 'Invited',
                'parent_url' => $voting_link,
                'parent_slug' =>bp_get_voting_slug(),
                'screen_function' => 'bp_voting_screen_invited',
                'position' => 10
            );

        //}
$sub_nav[] = array(
		'name' => __('Cast vote', 'bp-voting'),
		'slug' => 'castvote',
		'parent_url' => $voting_link,
		'parent_slug' =>bp_get_voting_slug(),
		'screen_function' => 'bp_voting_screen_castvote',
		'position' => 10
);
        parent::setup_nav($main_nav, $sub_nav);
    }
    
    
    /**
     * Register the new post type "voting"
     */
    function register_post_types() {
        $labels = array(
            'name' => __('votings', 'bp-voting'),
            'singular' => __('voting', 'bp-voting')
        );

        // Set up the argument array for register_post_type()
        $args = array(
            'label' => __('voting', 'bp-voting'),
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'supports' => array('title'),
            'rewrite' => TRUE,
            'rewrite' => array(
                'slug' => 'event',
                'with_front' => FALSE,
            ),
        );

        register_post_type('voting', $args);
        parent::register_post_types();
    }
    
}



/**
 * Load component into the $bp global
 */
function bp_voting_load_core_component() {
    global $bp;

    $bp->voting = new BP_voting_Component;
}

add_action('bp_loaded', 'bp_voting_load_core_component');

?>
