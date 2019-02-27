<?php
/* Search */

get_header();
$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
$posts_per_page = 3;
?>

    <section class="section align--left bg--white">
        <div class="container">
            <div class="load-more-container"><!-- For Ajax posts-->
	            <?php
	            $pagination_options['wp_query'] = array(
                    's'              => get_search_query(),
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
//                    'type'                  => 'ajax',                      // default or ajax
                    'render_with_posts'     => true,
                    )
                );

                $query = new UR_Pagination( $pagination_options );
	            $query->render();   // render posts and rebders pagination if render_with_posts is true
	            //$query->pagination();   // render just pagination if render_with_posts is false
                ?>
            </div>
        </div>
    </section>

<?php
get_footer();
?>