<?php


function bp_voting_has_items( $args = array() ) {
	global $bp, $items_template;

       
	// This keeps us from firing the query more than once
	if ( empty( $items_template ) ) {
            
		$default = array(
                    'id' => $eid,
                    'author_id' => null,
                    'title' => null,
                    'description' => null,
                    'url' => null,
                    'created_at' => date( 'Y-m-d H:i:s' ),
                    'updated_at' => date( 'Y-m-d H:i:s' ),
                    'tags' => array(),
                    'posts_per_page'	=> 10,
                    'page'	=> 1,
                    'search_terms' => null
                );
                
		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );

		$items_template = new BP_voting_Item();
		$items_template->get( $r );
	}

	return $items_template->have_posts();
}

function bp_voting_the_item() {
	global $items_template;
	return $items_template->query->the_post();
}

/**
 * Get the title of the project 
 */
function bp_voting_item_title() {
	echo bp_voting_get_item_title();
}

	function bp_voting_get_item_title() {
		global $items_template;
		echo apply_filters( 'bp_voting_get_item_title', $items_template->query->post->post_title );
	}
        
   /**

/**
 * Get the permalink of the project 
 */
function bp_voting_item_permalink() {
	echo bp_voting_get_item_permalink();
}

	function bp_voting_get_item_permalink() {
		global $items_template;
		echo apply_filters( 'bp_voting_get_item_permalink', get_permalink( get_the_ID() ) );
	}

/**
 * Get the title of the project 
 */
function bp_voting_item_description() {
	echo bp_voting_get_item_description();
}

	function bp_voting_get_item_description() {
		global $items_template;
		echo apply_filters( 'bp_voting_get_item_description', $items_template->query->post->post_content );
	}

        
/**
 * Get the url of the project 
 */
function bp_voting_item_startdate() {
	echo bp_voting_get_item_startdate();
}

        /**
        * Return the url of the project 
        */
function bp_voting_get_item_startdate() {
		return apply_filters( 'bp_voting_get_item_startdate', get_post_meta(get_the_ID(), 'bp_voting_startdate', true) );
	}
     //end date function   
	function bp_voting_item_enddate() {
		echo bp_voting_get_item_enddate();
	}
	
	/**
	 * Return the url of the project
	 */
	function bp_voting_get_item_enddate() {
		return apply_filters( 'bp_voting_get_item_enddate', get_post_meta(get_the_ID(), 'bp_voting_enddate', true) );
	}
	
/**
 * Get the author of the project 
 */
function bp_voting_item_author() {
	echo bp_voting_get_item_author();
}

        /**
        * Return the author of the project 
        */
	function bp_voting_get_item_author() {
		return apply_filters( 'bp_voting_get_item_author', bp_core_get_user_displayname( get_the_author_ID() ) );
	}


/**
 * Get the thumbnail of the project 
 */
function bp_voting_item_thumbnail( $type = 'thumbnail' ) {
    echo bp_voting_get_item_thumbnail( $type );
}

        /**
        * Return the thumbnail of the project 
        */
        function bp_voting_get_item_thumbnail( $type = 'thumbnail' ) {
            global $items_template;
            $thumbnail = wp_get_attachment_image_src($items_template->query->post->post_parent, $type);
            
            if($thumbnail != 0)
                return apply_filters( 'bp_voting_get_item_thumbnail', $thumbnail[0]);
            else
                return apply_filters( 'bp_voting_get_item_thumbnail', BP_voting_PLUGIN_URL . '/templates/' . BP_voting_TEMPLATE . '/img/default.png');
        }

//new thumbnails for particuler event
        function bp_voting_invitedevent_thumbnail( $type = 'thumbnail' ) {
        	echo bp_voting_get_invitedevent_thumbnail( $type );
        }
        
        /**
         * Return the thumbnail of the project
         */
        function bp_voting_get_invitedevent_thumbnail( $type = 'thumbnail' ) {
        	global $items_template;
        	$thumbnail = wp_get_attachment_image_src($specific_post->post_parent, $type);
        
        	if($thumbnail != 0)
        		return apply_filters( 'bp_voting_get_item_thumbnail', $thumbnail[0]);
        	else
        		return apply_filters( 'bp_voting_get_item_thumbnail', BP_voting_PLUGIN_URL . '/templates/' . BP_voting_TEMPLATE . '/img/default.png');
        }

/**
 * Is this page part of the voting component?
 */
function bp_is_voting_component() {
	$is_voting_component = bp_is_current_component( 'voting' );

	return apply_filters( 'bp_is_voting_component', $is_voting_component );
}


/**
 * Echo the component's slug
 */
function bp_voting_slug() {
	echo bp_get_voting_slug();
}
	/**
	 * Return the component's slug	 
	 */
	function bp_get_voting_slug() {
		global $bp;
                
		$voting_slug = isset( $bp->voting->slug ) ? $bp->voting->slug : '';

		return apply_filters( 'bp_get_voting_slug', $voting_slug );
	}

        
        
/**
 * Echo the component's root slug
 */
function bp_voting_root_slug() {
	echo bp_get_voting_root_slug();
}
	/**
	 * Return the component's root slug
	 */
	function bp_get_voting_root_slug() {
		global $bp;

		$voting_root_slug = isset( $bp->voting->root_slug ) ? $bp->voting->root_slug : '';

		return apply_filters( 'bp_get_voting_root_slug', $voting_root_slug );
	}

        

/**
 * Echoes the form action for voting HTML forms
 */
function bp_voting_form_action( $action ) {
	echo bp_get_voting_form_action( $action );
}
	/**
	 * Returns the form action for voting HTML forms
	 */
	function bp_get_voting_form_action( $action ) {
		return apply_filters( 'bp_get_voting_form_action', trailingslashit( bp_loggedin_user_domain() . bp_get_voting_slug() . '/' . $action . '/' . bp_action_variable( 0 ) ) );
	}
    

        
/**
 * Echo "Viewing x of y pages"
 */
function bp_voting_pagination_count() {
	echo bp_voting_get_pagination_count();
}
	/**
	 * Return "Viewing x of y pages"
	 */
	function bp_voting_get_pagination_count() {
		global $items_template;
		$pagination_count = sprintf( __( 'Viewing page %1$s of %2$s', 'bp-voting' ), $items_template->query->query_vars['paged'], $items_template->query->max_num_pages );

		return apply_filters( 'bp_voting_get_pagination_count', $pagination_count );
	}
        
        
/**
 * Echo pagination links
 */
function bp_voting_item_pagination() {
	echo bp_voting_get_item_pagination();
}
	/**
	 * return pagination links
	 */
	function bp_voting_get_item_pagination() {
		global $items_template;
		return apply_filters( 'bp_voting_get_item_pagination', $items_template->pag_links );
	}
        
        
/**
 * Echo the total of all projects
 */
function bp_voting_total_projects_count() {
	echo bp_voting_get_total_projects_count();
}
	/**
	 * Return the total of all projects
	 */
	function bp_voting_get_total_projects_count() {
		$projects = new BP_voting_Item();
		$projects->get();

		return apply_filters( 'bp_voting_get_total_projects_count', $projects->query->found_posts, $projects );
	}
    
        
/**
 * Echo the total of projects for a particular user
 */
function bp_voting_user_projects_count( $user_id ) {
    echo bp_voting_get_user_projects_count( $user_id );
}
        /**
        * Return the total of projects for a particular user
        */
        function bp_voting_get_user_projects_count( $user_id ) {
            
            if(isset($user_id) && is_int($user_id)) {
                $projects = new BP_voting_Item();
                $projects->get(array('author_id' => $user_id));

                return apply_filters('bp_voting_get_user_projects_count', $projects->query->found_posts, $projects);
            } else {
                return 0;
            }
        }
        
        
/**
 * Echo the user's avatar
 */    
function bp_voting_user_avatar( $args = '' ) {
    echo bp_voting_get_user_avatar( $args );
}
    function bp_voting_get_user_avatar( $args = '' ) {
            global $bp;

            $defaults = array(
                    'type'   => 'thumb',
                    'width'  => false,
                    'height' => false,
                    'html'   => true,
                    'class'  => false,
                    'alt'    => __( 'Avatar of %s', 'buddypress' )
            );

            $r = wp_parse_args( $args, $defaults );
            extract( $r, EXTR_SKIP );

            return apply_filters( 'bp_voting_get_user_avatar', bp_core_fetch_avatar( array( 'item_id' => get_the_author_ID(), 'type' => $type, 'width' => $width, 'height' => $height, 'html' => $html, 'class' => $class, 'alt' => $alt ) ) );
    }
    
    
    
/**
 * Echo the user's ID
 */    
function bp_voting_user_id() {
    echo bp_voting_get_user_id();
}
    function bp_voting_get_user_id() {
            return get_the_author_ID();
    }

    
/**
 * Echo the search form
 */
function bp_voting_projects_search_form() {
	global $bp;

	$default_search_value = bp_get_search_default_text( 'voting' );
	$search_value         = !empty( $_REQUEST['s'] ) ? stripslashes( $_REQUEST['s'] ) : $default_search_value; ?>

	<form action="" method="get" id="search-projects-form">
		<label><input type="text" name="s" id="projects_search" value="<?php echo esc_attr( $search_value ) ?>"  onfocus="if (this.value == '<?php echo $default_search_value ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $default_search_value ?>';}" /></label>
		<input type="submit" id="projects_search_submit" name="projects_search_submit" value="<?php _e( 'Search', 'buddypress' ) ?>" />
	</form>

<?php
}
    

?>
