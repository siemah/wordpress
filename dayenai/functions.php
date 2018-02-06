<?php

  function dayenai_enqueue_scripts()
  {
    //include stylesheet files
    wp_enqueue_style('bootstrap4-css', "//127.0.0.1/bootstrap4/css/bootstrap.min.css");
    wp_enqueue_style('custom-style', get_stylesheet_uri());
    //include javascript files like jquery
    wp_enqueue_script('bootstrap4-js', "//127.0.0.1/bootstrap4/js/bootstrap.min.js", ['jquery']);
    wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . "/js/custom.js", ['jquery']);
  }

  add_action('wp_enqueue_scripts', 'dayenai_enqueue_scripts');
