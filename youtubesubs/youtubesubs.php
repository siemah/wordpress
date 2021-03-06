<?php

  /*
  Plugin Name: YoutubeSubs
  Plugin URI:
  Description: Display a youtube channel an other things like a subscriber ..
  Version: 1.0.0.0
  Author: siemah
  Author URI: //github.com/siemah
  */

  /**
   * Copyright (c) 16/02/2018 siemah. All rights reserved.
   *
   * Released under the GPL license
   * http://www.opensource.org/licenses/gpl-license.php
   *
   * This is an add-on for WordPress
   * http://wordpress.org/
   *
   * **********************************************************************
   * This program is free software; you can redistribute it and/or modify
   * it under the terms of the GNU General Public License as published by
   * the Free Software Foundation; either version 2 of the License, or
   * (at your option) any later version.
   *
   * This program is distributed in the hope that it will be useful,
   * but WITHOUT ANY WARRANTY; without even the implied warranty of
   * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   * GNU General Public License for more details.
   * **********************************************************************
   */

   # exit if accessed directly
  if( !defined("ABSPATH") )
    exit;

  require_once plugin_dir_path( __FILE__ ) . '/inc/youtubesubs-scripts.php';
  require_once plugin_dir_path( __FILE__ ) . '/inc/youtubesubs-widget.php';


  function register_yts()  {
    register_widget( 'YTS_widget' );
  }

  add_action( 'widgets_init' , 'register_yts' );
