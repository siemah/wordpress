<?php
/**
 * Plugin Name: Zero
 * Description: is plugin
 * License: GPL
 * Version: 1.0.0
 */

 /**
  *
  */
 class Zero_Plugin
 {

   function __construct()
   {
     $this->zero_load_scripts_and_styles();
     include_once plugin_dir_path( __FILE__ ) . "/inc/newslatter.php";
     new Zero_Newslatter();

     // call to install function add table to DB
     register_activation_hook( __FILE__, [ "Zero_Newslatter", "install" ] );
     // call to install function add table to DB
     register_deactivation_hook( __FILE__, [ 'Zero_Newslatter', 'uninstall' ] );
     // call to uninstall function remove table from DB
     register_uninstall_hook( __FILE__, array('Zero_Newslatter', 'uninstall'));

   }

   public function zero_load_scripts_and_styles() {
     add_action( 'wp_enqueue_scripts' , function () {
       wp_enqueue_style( 'zero-newslatter-style', plugins_url() . '/zero/assets/css/style.css' );
     }, 11);
   }

 }

 new Zero_Plugin();
