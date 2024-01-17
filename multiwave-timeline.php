<?php
/**
 * Plugin Name: Multiwave Timeline
 * Description: Adds a timeline using the shortcode [multiwave-timeline]
 * Version: 1.0
 * Author: Eproductions - Ares Ioakimidis
 */


 function custom_post_type_init() {
  $args = array(
      'public' => true,
      'label'  => 'Timeline Entries',
      'supports' => array( 'title', 'editor' ),
      'menu_icon' => 'dashicons-hourglass'
  );
  register_post_type( 'timeline_entry', $args );
}




function multiwave_timeline_shortcode() {
  $output = '';

  $args = array(
      'post_type' => 'timeline_entry',
      'posts_per_page' => -1,
      'orderby' => 'date',
      'order' => 'ASC'
  );
  $the_query = new WP_Query( $args );

  //The Loop
  if ( $the_query->have_posts() ) {
      $output .= '<div class="timeline-container">';
      while ( $the_query->have_posts() ) {
          $the_query->the_post();
          $output .='<div class="timeline-item">';
          $output .='<div class="timeline-dot"></div>';
          $output .='<div class="timeline-content">';
          $output .= '<h2 class="timeline-content_title">' . get_the_title() . '</h2>';
          $output .= '<p>' . get_the_content() . '</p>';
          $output .='</div>';  
          $output .='</div>';  
      }
      $output .= '</div>';
      wp_reset_postdata();
  } else {
      // No posts found
      $output .= '<p>No timeline entries found.</p>';
  }

  return $output;
}

wp_enqueue_style('multiwave-timeline-style', plugins_url('css/style.css', __FILE__));
add_action( 'init', 'custom_post_type_init' );
add_shortcode('multiwave-timeline', 'multiwave_timeline_shortcode');
