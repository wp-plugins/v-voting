<?php get_header() ?>

	<?php do_action( 'bp_before_directory_voting_page' ); ?>

	<div id="content">
		<div class="padder">

                <?php do_action( 'bp_before_directory_voting' ); ?>

                    <h3><?php _e('Events directory', 'bp-voting'); ?></h3>
                    
                    <?php do_action( 'bp_before_directory_groups_content' ); ?>

                    <div id="projects-dir-search" class="dir-search" role="search">

                            <?php bp_voting_projects_search_form() ?>

                    </div>

                    
                    <?php do_action( 'template_notices' ); ?>

			<div class="item-list-tabs" role="navigation">
                                <ul>
                                        <li class="selected" id="projects-all"><a href="<?php echo trailingslashit( bp_get_root_domain() . '/' . bp_get_voting_root_slug() ); ?>"><?php printf( __( 'All events <span>%s</span>', 'bp-voting' ), bp_voting_get_total_projects_count() ); ?></a></li>

                                        <?php do_action( 'bp_voting_directory_voting_filter' ); ?>

                                </ul>
                        </div><!-- .item-list-tabs -->
                    
                    
                    <div id="projects-dir-list" class="projects dir-list">

                        <?php load_sub_template( array( BP_voting_TEMPLATE . '/search.php' ) ); ?>
                        
                    </div>
                
                <?php do_action( 'bp_after_directory_voting' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php do_action( 'bp_after_directory_voting_page' ); ?>

<?php get_sidebar( 'buddypress' ); ?>
<?php get_footer( 'buddypress' ); ?>
