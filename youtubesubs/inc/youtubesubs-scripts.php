<?php

  # include some files of CSS & JS
  function yts_load_scripts() {
    # load CSS
    wp_enqueue_style( 'yts-style', plugins_url() . '/youtubesubs/assets/style.css' );
    # load a main js
    wp_enqueue_script( 'yts-js', plugins_url() .'/youtubesubs/assets/main.js' );
    # load a google js
    wp_register_script( 'google-youtube-js', '//apis.google.com/js/platform.js' );
    wp_enqueue_script( 'google-youtube-js' );
  }
  add_action( 'wp_enqueue_scripts', 'yts_load_scripts' );
