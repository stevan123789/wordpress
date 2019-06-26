<?php 
/* #Welcome to Post Management Page.
**
*/
/* Register a book post type.
** @link https://codex.wordpress.org/Function_Reference/register_taxonomy
*/

// hook into the init action and call create_book_taxonomies when it fires
############ Categories ################################
// create two taxonomies, genres and writers for the post type "book"

add_action( 'init', 'create_book_taxonomies', 0 );
function create_book_taxonomies() {
	$labels = array(
		'name'              => _x( 'Genres', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Genres', 'textdomain' ),
		'all_items'         => __( 'All Genres', 'textdomain' ),
		'parent_item'       => __( 'Parent Genre', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Genre:', 'textdomain' ),
		'edit_item'         => __( 'Edit Genre', 'textdomain' ),
		'update_item'       => __( 'Update Genre', 'textdomain' ),
		'add_new_item'      => __( 'Add New Genre', 'textdomain' ),
		'new_item_name'     => __( 'New Genre Name', 'textdomain' ),
		'menu_name'         => __( 'Genre', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'genre' ),
	);
	register_taxonomy( 'genre', array( 'book' ), $args );

  ############ Tags ################################
	$labels = array(
		'name'                       => _x( 'Writers', 'taxonomy general name', 'textdomain' ),
		'singular_name'              => _x( 'Writer', 'taxonomy singular name', 'textdomain' ),
		'search_items'               => __( 'Search Writers', 'textdomain' ),
		'popular_items'              => __( 'Popular Writers', 'textdomain' ),
		'all_items'                  => __( 'All Writers', 'textdomain' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Writer', 'textdomain' ),
		'update_item'                => __( 'Update Writer', 'textdomain' ),
		'add_new_item'               => __( 'Add New Writer', 'textdomain' ),
		'new_item_name'              => __( 'New Writer Name', 'textdomain' ),
		'separate_items_with_commas' => __( 'Separate writers with commas', 'textdomain' ),
		'add_or_remove_items'        => __( 'Add or remove writers', 'textdomain' ),
		'choose_from_most_used'      => __( 'Choose from the most used writers', 'textdomain' ),
		'not_found'                  => __( 'No writers found.', 'textdomain' ),
		'menu_name'                  => __( 'Writers', 'textdomain' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'writer' ),
	);
	register_taxonomy( 'writer', 'book', $args );
}

/* Get Terms.
** @link https://codex.wordpress.org/es:Function_Reference/get_terms
*/

/* Create / Add / Update =>  term from the string in formate "XYZ/ABC/QPR" in parent-child relation.
** @product_cat => taxonomy.
** @$post_id => post ID to add the term.
*/

$Category = "XYZ/ABC/QPR";
$array_Category = explode('/', $Category);
			
	$parent_arg = array(
		'parent' => null
	);

	foreach($array_Category as $key => $ac){

		if($key == 0){
			if (!term_exists((string)$ac, 'product_cat')) {
				$parent = wp_insert_term((string)$ac, 'product_cat');
			} else {
				$parent = get_term_by('slug', (string)$ac, 'product_cat');
			}
		}else{

			if($parent){

				if(is_array($parent)){
					$parent_arg['parent'] = $parent['term_id'];
				}else{
					$parent_arg['parent'] = $parent->term_id;
				}
			}

			if (!term_exists((string)$ac, 'product_cat')) {
				$parent = wp_insert_term((string)$ac, 'product_cat', $parent_arg);
			} else {
				$parent = get_term_by('slug', (string)$ac, 'product_cat');
			}

		}
	}

	if(is_array($parent)){
		$term_id = $parent['term_id'];
	}else{
		$term_id = $parent->term_id;
	}
	wp_set_object_terms($post_id, $term_id, 'product_cat');











?>
