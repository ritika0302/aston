<?php
/**
 * Class Add_Find_In_Set_Compare_To_Meta_Query
 */
class Add_Find_In_Set_Compare_To_Meta_Query {

  /**
   *
   */
  function __construct() {
    add_action( 'posts_where', array( $this, 'posts_where' ), 10, 2 );
  }

  /**
   * Adds value 'find_in_set' to meta query 'compare' var for WP_Query 
   *
   * query['meta_query'][{n}]['compare'] => 'find_in_set'
   * @example This will find in set where _related_post_ids is a string of comma separated post IDs.
   *
   *    $query = new WP_Query( array(
   *      'posts_per_page' => -1,
   *      'post_type' => 'post'
   *      'meta_query' => array(
   *        array(
   *          'key' => '_related_post_ids',
   *          'value' => $related_post->ID,
   *          'compare' => 'find_in_set',
   *        )
   *      ),
   *    );
   *
   * @param array $where
   * @param object $query
   *
   * @return array
   */
  function posts_where( $where, $query ) {
    global $wpdb;
    foreach( $query->meta_query->queries as $index => $meta_query ) {
      if ( isset( $meta_query['compare'] ) && 'find_in_set' == strtolower( $meta_query['compare'] ) ) {
        $regex = "#\(({$wpdb->postmeta}.meta_key = '" . preg_quote( $meta_query['key'] ) . "')" .
        " AND (CAST\({$wpdb->postmeta}.meta_value AS CHAR\)) = ('" . preg_quote( $meta_query['value'] ) . "')\)#";
        /**
         * Replace the compare '=' with compare 'find_in_set'
         */
        $where = preg_replace( $regex, "($1 AND FIND_IN_SET($3,$2))", $where );
      }
    }
    return $where;
  }

}
new Add_Find_In_Set_Compare_To_Meta_Query();

?>