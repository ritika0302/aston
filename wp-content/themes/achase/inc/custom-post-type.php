<?php 

/**
 * Register a custom post type called "Team".
 */
add_action( 'init', 'custom_post_type_team_init' );
function custom_post_type_team_init() {

    $labels = array(
        'name'                  => _x( 'Team', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Team', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Team', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Team', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New Member', 'textdomain' ),
        'add_new_item'          => __( 'Add New Member', 'textdomain' ),
        'new_item'              => __( 'New Member', 'textdomain' ),
        'edit_item'             => __( 'Edit Member', 'textdomain' ),
        'view_item'             => __( 'View Member', 'textdomain' ),
        'all_items'             => __( 'All Members', 'textdomain' ),
        'search_items'          => __( 'Search Member', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Member:', 'textdomain' ),
        'not_found'             => __( 'No Member found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No Member found in Trash.', 'textdomain' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'team' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'           => 'dashicons-businessman',
        'supports'           => array( 'title', 'author', 'thumbnail' ),
    );
 
    register_post_type( 'team', $args );

    $area_lbl = array(
        'name'                  => _x( 'Areas', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Area', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Areas', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Areas', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New Area', 'textdomain' ),
        'add_new_item'          => __( 'Add New Area', 'textdomain' ),
        'new_item'              => __( 'New Area', 'textdomain' ),
        'edit_item'             => __( 'Edit Area', 'textdomain' ),
        'view_item'             => __( 'View Area', 'textdomain' ),
        'all_items'             => __( 'All Area', 'textdomain' ),
        'search_items'          => __( 'Search Areas', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Areas:', 'textdomain' ),
        'not_found'             => __( 'No areas found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No areas found in Trash.', 'textdomain' ),
    );
 
    $area_args = array(
        'labels'             => $area_lbl,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'areas' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'           => 'dashicons-businessman',
        'supports'           => array( 'title', 'thumbnail', 'editor' ),
    );
 
    register_post_type( 'areas', $area_args );


}

add_action( 'init', 'custom_post_type_create_team_taxonomies', 0 );
function custom_post_type_create_team_taxonomies() {

    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Category', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Search Category', 'textdomain' ),
        'all_items'         => __( 'All Category', 'textdomain' ),
        'parent_item'       => __( 'Parent Category', 'textdomain' ),
        'parent_item_colon' => __( 'Parent Category:', 'textdomain' ),
        'edit_item'         => __( 'Edit Category', 'textdomain' ),
        'update_item'       => __( 'Update Category', 'textdomain' ),
        'add_new_item'      => __( 'Add New Category', 'textdomain' ),
        'new_item_name'     => __( 'New Category Name', 'textdomain' ),
        'menu_name'         => __( 'Category', 'textdomain' ),
    );
 
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'team-category' ),
    );
 
    register_taxonomy( 'team-category', array( 'team' ), $args );

}

/* Add Thumbnail in Admin Table */
    add_filter('manage_team_posts_columns', 'posts_columns', 5);
    add_action('manage_team_posts_custom_column', 'posts_custom_columns', 5, 2);
     
    function posts_columns($columns){
        $new = array();
        foreach($columns as $key => $title) {
            if ($key=='author') // Put the Thumbnail column before the Author column
                $new['thumbnail'] = 'Image';
            $new[$key] = $title;
        }
        return $new;
    }
     
    function posts_custom_columns($column_name, $id){
        if($column_name === 'thumbnail'){
            echo get_the_post_thumbnail( $id, array( 80, 80 ) );
        }
    }
/* End */

?>