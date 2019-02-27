<?php

class UR_Pagination {
	public $query_args;                          // Used to store WP_QUERY arguments
	public $wp_query;                            // Stored object of executed WP_QUERY
	private $posts_per_page;                      // Posts to display per page
	private $options = array(
		'template' => '',
		'template_directory' => 'partials',
		'paged' => '',
		'page_type' => 'page',
		'page_link' => ''
	);                                           // Used to store extra option arguments
	private $pagination_options = array(          // Pagination
		'type'              => 'default',
		'render_with_posts' => true
	);
	private $html = '';                           // Stored html to be returned on render function

	/**
	 * UR_Pagination constructor.
	 * initialises object if options are set
	 *
	 * @param array $options
	 */
	public function __construct( $options = array()) {
		if ( ! empty( $options ) ) {
			$this->init( $options);
		}
	}

	/**
	 * initialises object
	 *
	 * @param array $options
	 */
	public function init( $options) {

		//wp_query args
		if ( isset( $options['wp_query'] ) ) {
			$this->query_args = $options['wp_query'];
		}

		//options
		if ( isset( $options['options'] ) ) {
			$this->options = array_merge( $this->options, $options['options'] );
		}

		//pagination options
		if ( isset( $this->options['pagination_options'] ) ) {
			$this->pagination_options = array_merge($this->pagination_options, $this->options['pagination_options']);
		}

		if($this->pagination_options['type'] == 'default'){
			$this->query_args['posts_per_page'] = $this->options['posts_per_page'];
			$this->query_args['paged'] = $this->options['paged'];
		}else{
			$this->query_args['posts_per_page'] = ( $this->options['paged'] == 1 ? $this->options['posts_per_page'] : $this->options['paged'] * $this->options['posts_per_page'] );
		}

		//posts per page
		if ( isset( $this->query_args['posts_per_page'] ) ) {
			if ( $this->query_args['posts_per_page'] == '' ) {
				$this->posts_per_page = 9;
			} else {
				$this->posts_per_page = $this->query_args['posts_per_page'];
			}
		}

		//get page type
		$this->page_type();

		//store variables in session
		$session_options            = array(
			'wp_query' => $this->query_args,
			'options'  => $this->options,
		);
		set_transient('ur_pagination', $session_options);
	}

	/**
	 * Sets page_type variable
	 * depening if its a category or a page
	 * script works differently
	 */
	private function page_type() {
		//if category
		if ( is_category( get_queried_object_id() ) ) {
			$this->options['page_type'] = 'category';
		} elseif ( is_search() ) {
			$this->options['page_type'] = 'search';
		}

		//if not ajax set page link
		if ( $this->options['page_link'] == '' ) {
			if ( $this->options['page_type'] == 'search' ) {
				//search page url variable
				$this->options['page_link'] = add_query_arg( array(
					's' => get_search_query()
				), site_url() );
			} elseif($this->options['page_type'] == 'category') {
				//category page url variable
				$this->options['page_link'] = get_category_link($this->query_args['category__in']);
			} else {
				//normal page url variable
				$this->options['page_link'] = get_permalink();
			}
		}

		//remove trailing slash
		if ( substr( $this->options['page_link'], - 1, 1 ) == '/' ) {
			$this->options['page_link'] = substr_replace( $this->options['page_link'], "", - 1 );
		}
	}

	/**
	 * Executes the WP_QUERY object
	 * generated from the constructers
	 * initial arguments
	 */
	private function execute_query() {
		$wp_query       = new WP_Query( $this->query_args );
		$this->wp_query = $wp_query;
	}

	/**
	 * Uses $this->wp_query to render
	 * the posts, also uses the $this->options['template']
	 * to display the styling for each post
	 */
	private function generate_html() {
		if ( $this->wp_query->have_posts() ) {
			while ( $this->wp_query->have_posts() ) : $this->wp_query->the_post();
				ob_start();
				get_template_part( '/' . $this->options['template_directory'] . '/' . $this->options['template'] );
				$this->html .= ob_get_clean();
			endwhile;
		} else {
			$this->html .= '<p class="no-results">Sorry, there are no posts in this category.</p>';
		}
	}

	/**
	 * Uses the $this->pagination_options['type']
	 * to display the pagination
	 */
	public function generate_pagination(){
		//choose to display the load more button
		$this->html .= "<div class='clearfix'></div>";
		if($this->pagination_options['type'] == 'default'){
			//if user wants pagination items rendered with posts
			if($this->pagination_options['render_with_posts']){
				$this->html .= $this->pagination();
			}
		}elseif($this->pagination_options['type'] == 'ajax'){
			$this->html .= $this->ajax_more_posts();
		}
	}

	/**
	 * Is called by the user where they want
	 * the rendered html at
	 */
	public function render() {
		if ( isset( $this->query_args ) ) {
			$this->execute_query();
			$this->generate_html();
			$this->generate_pagination();
			echo $this->html;
		} else {
			return false;
		}
	}

	/**
	 * This is used to decide wether to display
	 * the load more button depending on
	 * how many posts are left
	 */
	private function ajax_more_posts() {
		//find next and max page
		$max_pages = ceil( $this->wp_query->found_posts / $this->options['posts_per_page'] );
		$next_page = $this->options['paged'] + 1;

		// if there is more pages to render
		if ( $this->options['paged'] < $max_pages ) {
			// load more button
			$this->html .= "<div class='ur-load-more col--100'><a href='" . $this->get_page_link( $next_page ). "'";

			// data variables used to pass information back to class on ajax
			$this->html .= " class='ur-load-more-link " . ( isset( $this->options['button_class'] ) ? $this->options['button_class'] : '' ) . "' 
				data-js-hover='" . ( isset( $this->options['button_hover_text'] ) ? $this->options['button_hover_text'] : 'Loading More' ) . "' 
				data-ppp='" . $this->options['posts_per_page'] . "' 
				data-found-posts='" . $this->wp_query->found_posts . "' 
				data-page-type='" . $this->options['page_type'] . "' 
				data-page='" . $this->options['page_link'] . "' 
				data-current='" . $this->options['paged'] . "'  
				data-next='" . ( $next_page ) . "'
				data-max='" . $max_pages . "'>
				" . ( isset( $this->options['button_text'] ) ? $this->options['button_text'] : 'Load More' ) . "
			</a></div>";
		}
	}

	/**
	 * Generates pagination links
	 */
	public function pagination() {
		$range = 2;
		$showitems = ($range * 2)+1;

		$paged = $this->options['paged'];

		$pages = ceil( $this->wp_query->found_posts / $this->options['posts_per_page'] );
		if(!$pages) {
			$pages = 1;
		}

		$pagination_html = '';

		if(1 != $pages) {
			$pagination_html .= "<div class='pagination col--100'><ul class='clearfix'>";

			if($paged > 2 && $paged > $range+1 && $showitems < $pages) {
				$pagination_html .= "<li class='pagination-item'><a href='".$this->get_page_link(1)."'><i class='icon-left'></i></a></li>";
			}
			if($paged > 1 && $showitems < $pages){
				$pagination_html .= "<li class='pagination-item'><a href='".$this->get_page_link($paged - 1)."'><i class='icon-double-left'></i></a></li>";
			}

			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
					$pagination_html .= ($paged == $i)? "<li class='pagination-item active'>".$i."</li>":"<li class='pagination-item'><a href='".$this->get_page_link($i)."' class='inactive' >".$i."</a></li>";
				}
			}

			if ($paged < $pages && $showitems < $pages) {
				$pagination_html .= "<li class='pagination-item'><a href='" . $this->get_page_link( $paged + 1 ) . "'><i class='icon-right'></i></a></li>";
			}

			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {
				$pagination_html .= "<li class='pagination-item'><a href='" . $this->get_page_link( $pages ) . "'><i class='icon-double-right'></i></a></li>";
			}
			$pagination_html .= "</ul></div>\n";
		}
		return $pagination_html;
	}

	public function get_page_link($page){
		$link = '';
		if ( $this->options['page_type'] == 'category' ) {
			$link = $this->options['page_link'] . "/page/".$page;
		} elseif ( $this->options['page_type'] == 'search' ) {
			$link = $this->options['page_link'] . "&page=".$page;
		} else {
			$link = $this->options['page_link'] . "/".$page;
		}

		return $link;
	}

	/**
	 * This is used by the wordpress wp_ajax
	 * to reconstruct the object from the session
	 *
	 * @param string $page
	 * @param string $page_type
	 */
	public static function ajax( $page, $page_type = 'page' ) {
		//get variables from session and recreate the object
		$session = unserialize( $_SESSION['ur_pagination'] );
		$options = get_transient('ur_pagination');
		$object  = new UR_Pagination( $options );

		//set ajax specific variables
		$object->query_args['paged']          = $page;
		$object->options['paged']             = $page;
		$object->query_args['posts_per_page'] = $object->options['posts_per_page'];
		$object->options['page_type'] = $page_type;

		//render html
		echo $object->render();
	}
}