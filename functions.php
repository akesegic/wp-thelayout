<?php
/**
 * Functions and definitions.
 *
 * @package WordPress
 * @subpackage lucasr-child
 */


function lucasr_delete_thelayout_on_new_post() {
     delete_transient( 'thelayout_posts' );
     delete_transient( 'thelayout_future_posts' );
}
add_action( 'publish_post', 'lucasr_delete_thelayout_on_new_post' );


function lucasr_get_thelayout_posts( $future = false ) {
    $thelayout_posts = get_transient( $future ? 'thelayout_future_posts' : 'thelayout_posts' );

    if ( $thelayout_posts === false ) {
        $thelayout_posts = new WP_Query( array(
            'posts_per_page' => 20,
            'offset' => 0,
            'post_status' => ( $future ? 'draft' : 'publish' ) ,
            'order' => 'DESC',
            'category_name' => 'the-layout',
            'orderby' => 'date'
        ) );

        set_transient( 'thelayout_posts', $thelayout_posts, 24 * HOUR_IN_SECONDS );
    }

    return $thelayout_posts;
}


function lucasr_get_thelayout_future_posts() {
    return lucasr_get_thelayout_posts( true );
}
