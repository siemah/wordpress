<?php

  /**
   * listed a recent post using a shortcode
   * @version 2018.02.18
   * @author siemah
   */
  class Dayen_Recent {

    function __construct()  {
      add_shortcode( 'dayen_recent_post', [ $this, 'dayen_recent_list_of_post'] );
    }

    public function dayen_recent_list_of_post($atts, $content) {
      $atts = shortcode_atts( ['numberposts' => 5], $atts );
      $posts= get_posts( $atts );

      $html = [];
      $html[] = $content;
      $html[] = '<ul>';

      foreach ($posts as $post)
        $html[] = "<li><a href='".get_permalink($post)."'>{$post->post_title}</a></li>";

      $html[] = '</ul>';
      echo implode('', $html);
    }

  }
