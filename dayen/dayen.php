<?php

/*
Plugin Name: Dayen Newslatter
Plugin URI:
Description: Description of plugin
Version: 2018.02.12
Author: siemah
Author URI: //hamis.comli.com
*/

/**
 * Copyright (c) `date "+%Y"` siemah. All rights reserved.
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

 /**
  *
  */
 class Dayen {

   function __construct()
   {
     include plugin_dir_path( __FILE__ ) . "/newslatter.php";
     $dayenNL = new Dayen_Newslatter();
     include plugin_dir_path( __FILE__ ) . "/recent.php";
     new Dayen_Recent();
     # run some code  run when the plugin is activated.
     register_activation_hook ( __FILE__, ["Dayen_Newslatter", 'install'] );
     # when the plugin is deactivated
     register_deactivation_hook ( __FILE__, [ 'Dayen_Newslatter', 'uninstall' ] );
     # run when the plugin is deleted
     register_uninstall_hook ( __FILE__, [ "Dayen_Newslatter", 'uninstall' ] );
     # run method when loaded a page or submit an form to curren page
     add_action( 'wp_loaded', [ $this, 'save_email' ] );
     # add plugin icon & link redirect to this plugin
     add_action( "admin_menu", [$this, "add_admin_menu"], 20 );
     # fired an event when WP is initialized (start of WP) is like wp_loaded but in backend not frontend for wp_loaded
     add_action( "admin_init", [ $this, "register_settings" ] );
   }

  /**
   * to save emails of newslatter
   */
   public function save_email() {
     # check if any var with the email field name is sended to the current page
     if( isset( $_POST['dayen_newslatter_email'] ) && !empty( $_POST['dayen_newslatter_email'] ) ) {
       global $wpdb;
       # check if this email is not exists
       $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}dayen_newsletter_email WHERE email = '{$_POST['dayen_newslatter_email']}'");
       if( is_null($row) ){
         # delete a error cookie if is exists
         $_COOKIE['dayen_newslatter_email_error'] = NULL;
         #insert the new email into DB
         $wpdb->insert("{$wpdb->prefix}dayen_newsletter_email", ["email" => $_POST['dayen_newslatter_email'] ]);

       } else {
         setcookie('dayen_newslatter_email_error', 'Votre address is already exists!', time() + 60 * 5);
       }
     }

   }

   /**
    * add an icon & a link to admin dashboard
    * @var $hook String retur from add_submenu_page
    */
    public function add_admin_menu() {
      # add a main menu
      add_menu_page(
        'Manage Dayen Newslatter plugin', # label showed into title tag
        'Dayen Plugin', # title showed in menu
        'manage_options', # capability
        'dayen_newslatter', # ID of menu
        [ $this, 'menu_html' ] # the callback called when render a page content
      );
      # add submenu & return a value of current page to use it when send a newslatter
      $hook = add_submenu_page(
        "dayen_newslatter", # parent manu ID
        "This is a submenu page",# label showed into title tag
        "Dayen Newslatter",# title showed in menu
        "manage_options",# capability
        "dayen_newslatter_submenu",# ID of menu
        [ $this, "menu_html" ]# the callback called when render a page conten
      );
      # listening to load-$hook event to retreive some data to start a send newslatter process
      add_action( "load-$hook", [ $this, "process_action"] );
    }

    /* checking method */
    public function process_action() {
      if( isset( $_POST['dayen_send_newslatter_action'] ) )
        $this->dayen_send_newslatter_action();
    }

    public function dayen_send_newslatter_action() {
      global $wpdb;
      $users  = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}dayen_newslatter;");
      $object = get_option('dayen_newslatter_object');
      $content= get_option('dayen_newslatter_content');
      $sender = get_option('dayen_newslatter_sender');
      $header = [ 'From:'.$sender ];
      foreach ($users as $currentUser)
        $res = wp_mail( $currentUser->email, $object, $content, $header );
    }

    /**
     * this method using when WP render a plugin main page
     */
     public function menu_html()  {
       ?>
       <h1><?= get_admin_page_title() ?></h1>
       <form class="" action="options.php" method="post">
         <?php settings_fields( 'dayen_newslatter_settings' ); ?>
         <?php do_settings_sections( 'dayen_newslatter_settings' ) ?>
         <?php submit_button(); ?>
       </form>
       <!-- this form is for sending a newslatter to users -->
       <form action="" method="post">
         <input type="hidden" name="dayen_send_newslatter_action" value="1" />
         <?php submit_button("Send a newslatter"); ?>
       </form>
       <?php
     }

    /**
    * register a new group options & new section settings
    * @see $this->menu_html() at line 87, thfunction settings_fields defined the name of options group
    */
     public function register_settings() {
      # to register a group of options in table prefix_meta_options
      # this is the field saved in DB is the email address
      register_setting(
        'dayen_newslatter_settings', # option group name like ID
        'dayen_newslatter_sender' # name of option group added to DB table meta_options in column key
      );
      # this is the field settings of object
      register_setting(
        'dayen_newslatter_settings',
        'dayen_newslatter_object'
      );
      # this is the field settings of content of newslatter
      register_setting(
        'dayen_newslatter_settings',
        'dayen_newslatter_content'
      );
      /* Add a new section to a settings page. allow us to add some fields inside
       * this form without editting the code source of rendering callback
       */
      add_settings_section(
        'dayen_newslatter_section', # like ID
        'Parametre d\'envoie', # title of this section
        [ $this, 'section_html'], #callback to call for rendering,
        'dayen_newslatter_settings' # The slug-name of the settings page on which to show the section (maybe is options group)
      );
      # add a input field to section given in this case it's the email address
      add_settings_field(
        "dayen_newslatter_sender",
        "Expedeteur",
        [ $this, "sender_html" ],
        "dayen_newslatter_settings",
        "dayen_newslatter_section"
      );
      # add a input field to section given in this case it's the email object of newslatter
      add_settings_field(
        'dayen_newslatter_object',
        'Object of newslatter',
        [ $this, 'object_html' ],
        'dayen_newslatter_settings',
        'dayen_newslatter_section'
      );
      # add a input field to section given in this case it's the email content of newslatter
      add_settings_field(
        "dayen_newslatter_content", # ID of field is the value of name attribute of this filed
        "Content Of newslatter", # label text
        [ $this, "content_html" ], # render callback
        "dayen_newslatter_settings", # page (oprion group)
        "dayen_newslatter_section" # name of section settings
      );
    }

    /**
    * called to render some html components
    */
     public function section_html() {
      echo 'Renseignez les paramètres d\'envoi de la newsletter.';
    }

     public function sender_html(){
      ?>
      <input type="text" name="dayen_newslatter_sender" value="<?= get_option('dayen_newslatter_sender') ?>" />
      <?php
    }

     public function object_html(){
      ?>
      <input type="text" name="dayen_newslatter_object" value="<?= get_option('dayen_newslatter_object') ?>" />
      <?php
    }

     public function content_html(){
        ?>
        <textarea name="dayen_newslatter_content"><?= get_option('dayen_newslatter_content') ?></textarea>
        <?php
      }

 }

 new Dayen();







 ?>
