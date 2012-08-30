<?php //print_r(bp_ajax_querystring( 'projects' ));?>
<?php if(bp_voting_has_items( bp_ajax_querystring( 'projects' ) )) :?>
    <div id="pag-top" class="pagination">

            <div class="pag-count" id="projects-dir-count-top">

                    <?php bp_voting_pagination_count(); ?>

            </div>

            <div class="pagination-links" id="projects-dir-pag-top">

                    <?php bp_voting_item_pagination(); ?>

            </div>

    </div>
<?php endif; ?>

<?php while ( bp_voting_has_items(bp_ajax_querystring( 'projects' ) ) ) : bp_voting_the_item(); ?>

    <div class="item-project">
        <div class="item-project-pictures">
            <img src="<?php bp_voting_item_thumbnail( 'voting-thumb' ) ?>" width="250px" height="170px" />
        </div>
        <div class="item-project-content">
            <h3>
                <?php bp_voting_item_title() ?>
                <div class="item-project-content-avatar">
                    <a href="<?php echo bp_core_get_user_domain( bp_voting_get_user_id() ) ?>"><?php bp_voting_user_avatar();?></a>
                </div>
            </h3>
            <span><a href="<?php bp_voting_item_url() ?>"><?php bp_voting_item_url() ?></a></span>
            <p><?php bp_voting_item_description() ?></p>
        </div>
        <br />
    </div>

    <div class="item-project-separator"></div>


<?php endwhile; ?>

<?php if(bp_voting_has_items( bp_ajax_querystring( 'projects' ) )) :?>
    <div id="pag-bottom" class="pagination">

            <div class="pag-count" id="projects-dir-count-bottom">

                    <?php bp_voting_pagination_count(); ?>

            </div>

            <div class="pagination-links" id="projects-dir-pag-bottom">

                    <?php bp_voting_item_pagination(); ?>

            </div>

    </div>
<?php endif; ?>
