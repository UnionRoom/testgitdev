<?php
/* Category */

get_header();
$paged          = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$cat_id         = get_queried_object_id();
$posts_per_page = 3;
?>

    <section class="clearfix">
        <div class="container">
            <div class="load-more-container"><!-- For Ajax posts-->
				<?php
				$pagination_options['wp_query'] = array(
					'category__in'   => $cat_id,
					'post_status'    => 'publish',
					'order'          => 'DESC',
				);

				$pagination_options['options'] = array(
					'template'                  => 'card-post',             //name of file to include per post
					'template_directory'        => 'partials',              //defaults to partials
					'paged'                     => $paged,
					'posts_per_page'            => $posts_per_page,
					'button_text'               => 'Load More',             //ajax pagination only
					'button_class'              => 'btn btn--secondary',    //ajax pagination only
					'button_hover_text'         => 'Loading More',          //ajax pagination only
					'pagination_options'        => array(
//						'type'                  => 'ajax',                  // default or ajax
						'render_with_posts'     => true,
					)
				);

				$query = new UR_Pagination( $pagination_options );
				$query->render();   // render posts and pagination
				//$query->pagination();   // render just pagination if render_with_posts is false
				?>
            </div>
        </div>
    </section>

<?php
get_footer();
