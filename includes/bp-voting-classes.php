<?php


class BP_voting_Item {
    
    var $id;
    var $author_id;
    var $title;
    var $description;
    var $url;
    var $screenshot;
    var $created_at;
    var $updated_at;
    var $tags;
    var $query;
    var $prpage;
    var $num;
//new variables
    var $startdate;
    var $enddate;
    
    
    public function __construct( $args = array() ) {
        
        $defaults = array(
            'id' => 0,
            'author_id' => 0,
            'title' => null,
            'description' => null,
            'url' => null,
            'screenshot' => null,
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' ),
            'tags' => array(),
        	'startdate' => null,
        	'enddate' => null,
        );       
        
        $r = wp_parse_args( $args, $defaults );
        extract( $r );
        
        $this->prpage = isset( $_REQUEST['prpage'] ) ?  $_REQUEST['prpage'] : 1;
        $this->num  = isset( $_REQUEST['num'] ) ? $_REQUEST['num'] : 10;
        
        if(!is_numeric($this->prpage))
            $this->prpage = 1;
        if(!is_numeric($this->num))
            $this->num = 10;

        foreach( $r as $key => $value ) {
            $this->{$key} = $value;
        }
        
    }
    
    
    /**
     * Delete the post     
     */
    public function delete() {
        $this->id = apply_filters( 'bp_voting_data_id_before_save', $this->id, $this->id );
        
        do_action( 'bp_voting_data_before_delete', $this );
         global $wpdb;
          $table = $wpdb->prefix."events_voting";
        $structure ="DELETE FROM $table WHERE event_id=$this->id;"; //query to create event_voting table these will contain three cloumns: event_id,user_id and uservote_count which will help to declare the winner at the end
        $wpdb->query($structure);
        $result = wp_delete_post( $this->id );
        return $result;
        
        do_action( 'bp_voting_data_after_delete', $this );
    }
    
    
    /*
     * Save the object in the database and dynamically switch between INSERT and UPDATE
     */
    public function save() {

        global $wpdb, $bp;
        
        $this->id = apply_filters( 'bp_voting_data_id_before_save', $this->id, $this->id );
        $this->author_id = apply_filters( 'bp_voting_data_author_id_before_save', $this->author_id, $this->id );
        $this->title = apply_filters( 'bp_voting_data_title_before_save', $this->title, $this->id );
        $this->description = apply_filters( 'bp_voting_data_description_before_save', $this->description, $this->id );
      
        $this->screenshot = apply_filters( 'bp_voting_data_screenshot_before_save', $this->screenshot, $this->id );
        $this->created_at = apply_filters( 'bp_voting_data_created_at_before_save', $this->created_at, $this->id );
        $this->updated_at = apply_filters( 'bp_voting_data_updated_at_before_save', $this->updated_at, $this->id );
//new thing start and end date
      $this->startdate = apply_filters( 'bp_voting_data_startdate_before_save', $this->startdate, $this->id );//add filter 
        $this->enddate = apply_filters( 'bp_voting_data_enddate_before_save', $this->enddate, $this->id );
        $this->tags = apply_filters( 'bp_voting_data_tags_before_save', $this->tags, $this->id );
         //field can be used later
        //do_action( 'bp_voting_data_before_save', $this );
       // echo "hello ru thr".$this->title;
        
        if ( $this->id ) {
            
            $wp_update_post_args = array(
                    'ID'		=> $this->id,
                    'post_author'	=> $this->author_id,
                    'post_title'	=> $this->title,
                    'post_content'      => $this->description,//new fields
            	
            );
            
            // We update the existing item if a new screenshot is sent
            if(is_array($this->screenshot)) {
                $attach_id = fileupload_process($this->screenshot);
                $wp_update_post_args['post_parent'] = $attach_id;
            }
            
            $result = wp_update_post( $wp_update_post_args );
            
            //edit and Update post metas
            if ( $result ) {//these is how we added the start date column using post meta in wp_postmeta table with postid
                  
            	update_post_meta( $result, 'bp_voting_startdate', $this->startdate );  
            	update_post_meta( $result, 'bp_voting_enddate', $this->enddate );
            	 
            	}
            
          //adding data into the event_voting database // get_post_meta($result, 'post_id', true)
            global $wpdb;
            $t = $_POST['members'];
          
            
	foreach ($t as $key=>$val) {
		$table = $wpdb->prefix."events_voting";
		$structure = "INSERT INTO $table (event_id, user_id)VALUES ($result, $val);";
		//query to create event_voting table these will contain three cloumns: event_id,user_id and uservote_count which will help to declare the winner at the end
		$wpdb->query($structure);
		
	}
            
        } else {
            
            // We insert a new item
            $attach_id = fileupload_process($this->screenshot);
            
            $wp_insert_post_args = array(
                    'post_status'	=> 'publish',
                    'post_type'         => 'voting',
                    'post_author'	=> $this->author_id,
                    'post_title'	=> $this->title,
                    'post_content'      => $this->description,
                    'post_parent'       => $attach_id
		     
            );
            
            $result = wp_insert_post( $wp_insert_post_args );
            
            // Insert post metas
            if ( $result ) {
            	//these is how we added the start date column using post meta in wp_postmeta table with postid
            	  update_post_meta( $result, 'bp_voting_startdate', $this->startdate );
            	  update_post_meta( $result, 'bp_voting_enddate', $this->enddate );
            	 
            }
        }

        
        do_action( 'bp_voting_data_after_save', $this );

        return $result;
        
    }
    
    
    /**
    * Fire the WP_Query
    */
    public function get( $args = array() ) {
        if(empty($this->query)) {
            
            $default = array(
                'id' => 0,
                'author_id' => 0,
                'title' => null,
                'description' => null,
                'url' => null,
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' ),
                'tags' => array(),
                'search_terms' => null
            );

            $r = wp_parse_args( $args, $defaults );
            extract( $r );           

            $this->prpage = isset( $page ) ?  $page : 1;
            $this->num = isset( $posts_per_page ) ?  $posts_per_page : 10;
            
            $query_args = array(
                    'post_status'           => 'publish',
                    'post_type'             => 'voting',
                    'posts_per_page'        => $this->num,
                    'paged'                 => $this->prpage,
                    'meta_query'            => array(),
            );
            
            
            // Filter by post id
            $id = ($id) ? $id : $this->id;
            if ( $id ) {
                    $query_args['p'] = $id;
            }

            // Filter by author
            $author_id = ($author_id) ? $author_id : $this->author_id;
            if ( $author_id ) {
                    $query_args['author'] = $author_id;
            }
            
            // Filter by search terms
            if ( isset($search_terms) AND ($search_terms != bp_get_search_default_text( 'voting' ))) {
                $query_args['s'] = $search_terms;
            }
            
            $this->query = new WP_Query( $query_args );

            // Set up some pagination
            $this->pag_links = paginate_links( array(
                    'base'      => add_query_arg( array( 'prpage' => '%#%', 'num' => (int)$this->num ) ),
                    'format'    => '',
                    'total'     => ceil( (int)$this->query->found_posts / (int)$this->num ),
                    'current'   => (int) $this->prpage,
                    'prev_text' => _x( '&larr;', 'Event pagination previous text', 'buddypress' ),
                    'next_text' => _x( '&rarr;', 'Event pagination next text', 'buddypress' ),
                    'mid_size'  => 1
            ) );
            
        }   
    }
    
    

    function have_posts() {
        return $this->query->have_posts();
    }
    
    
    function the_post() {
        return $this->query->the_post();
    }
    
    
}


?>
