<?php

  /*
  Plugin Name: DayenContact
  Plugin URI: //hamis.comli.com
  Description: Contact Plugin to display in your website
  Version: 2018.02.18
  Author: siemah
  Author URI: //github.com/siemah
  */

  /**
   * Copyright (c) 2018/02/18 siemah. All rights reserved.
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
   * @version 2018.02.18
   * @author siemah
   *
   */
  class Dayen_Contact {

    function __construct() {

      # include a Dayen_Shortcode class allow us to use a shortcode
      require_once plugin_dir_path( __FILE__ ) . '/inc/dayenshortcode.php';
      new Dayen_Shortcode();
      require_once plugin_dir_path( __FILE__ ) . '/inc/dayen_dependancies.php';
      # install all dependancies and remove theme when active or deactive this plugin
      register_activation_hook( __FILE__, [ 'Dayen_Dependancies', 'install' ] );
      # run those when remove or deactivate a plugin
      register_deactivation_hook( __FILE__, [ 'Dayen_Dependancies', 'uninstall' ] );
      register_uninstall_hook( __FILE__, [ 'Dayen_Dependancies', 'uninstall' ] );

      # load a style and script
      $this->load_styles_and_scripts();

      # add our plugin to admin menu inside a dashboard
      add_action( 'admin_menu' , [ $this, 'add_admin_menu' ] );
      # receive a contact field submited by users
      add_action( 'wp_loaded', [ $this, 'receive_user_data_submited' ] );
      # Fires as an admin screen or script is being initialized. to output some settings
      add_action( 'admin_init', [ $this, 'register_settings' ]);
    }

    public function receive_user_data_submited() {

      if( isset($_POST['dayencontact_name'], $_POST['dayencontact_email'], $_POST['dayencontact_content']) ) {
        global $wpdb;
        extract($_POST);
        $wpdb->query(
          "INSERT INTO {$wpdb->prefix}dayencontact VALUES (\N, '$dayencontact_name', '$dayencontact_email', '$dayencontact_content', NOW())"
        );
      }

    }

    /**
     * load a styles & script
     */
     public function load_styles_and_scripts()  {
       wp_enqueue_style ( 'dayen-contact-style', plugins_url() . '/dayencontact/assets/dayen_style.css' );
     }

    /**
     * add a plugin to admin menu
     */
     public function add_admin_menu() {
       # add a main menu
       add_menu_page(
         "Dayen Contact Plugin",
         "DayenContact",
         "manage_categories",
         "dayen_contact_menu",
         [ $this, "admin_menu_html" ],
         plugins_url() . "/dayencontact/assets/img/icon.png"
       );
       # add a submenu
       $hook = add_submenu_page(
         "dayen_contact_menu",
         "Response to user contact",
         "Response",
         'manage_categories',
         'dayen_response_submenu',
         [ $this, 'admin_submenu_html' ]
       );
       # receive a data ended by plugin user
       add_action( "load-$hook", [ $this, "receive_data" ] );
     }

    /**
     * receive a data sended by user when a admin page loaded
     */
     public function receive_data() {
       if( isset( $_GET['contact'] ) ) {
         global $wpdb;
         $contact = $wpdb->get_row(
           "SELECT * FROM {$wpdb->prefix}dayencontact WHERE id = '{$_GET['contact']}'",
           ARRAY_A
         );

         if( !empty( $contact ) ) {
           $GLOBALS['dayencontact_user_data'] = $contact;
           wp_mail(
             $contact['email'],
             get_option('dayencontact_object'),
             get_option( 'dayencontact_message' ),
             [ 'Content-Type: text/html; charset=UTF-8', 'From: '. get_option('dayencontact_from_email_address') ]
           );
         }
       }
     }

     # register settings fields
     public function register_settings()  {
       # register some settings in meta_options table
       register_setting (
         'dayencontact_settings', # a settings group name
         'dayencontact_from_email_address' # name of an option to sanitize & save
       );
       # the object of response to user contact
       register_setting (
         "dayencontact_settings",
         "dayencontact_object"
       );
       # message content to send
       register_setting (
         'dayencontact_settings',
         'dayencontact_message'
       );

       # Add a new section to a settings page.
       add_settings_section (
         "dayencontact_response_to_user_contact_section",# id of section to display like an html id
         "Send Params", # content to show in heading element
         [ $this, 'section_html' ], # callback called to render html
         "dayencontact_settings"# the slug-name of the settings page to show the section
       );

       #register a fields
       add_settings_field(
         "dayencontact_from_email_address", # id
         "Your email address of reply-to", # titlz display in label element
         [ $this, "dayencontact_from_email_address_html" ], # callback called to display
         "dayencontact_settings", # The slug-name of the settings page on which to show the section
         "dayencontact_response_to_user_contact_section" # section slug name
       );

       add_settings_field (
         "dayencontact_object",
         "Response title:",
         [ $this, "dayencontact_object_html" ],
         "dayencontact_settings",
         "dayencontact_response_to_user_contact_section" # section slug name
       );

       add_settings_field (
         "dayencontact_message",
         "Your message",
         [ $this, "dayencontact_message_html" ],
         "dayencontact_settings",
         "dayencontact_response_to_user_contact_section" # section slug name
       );
     }


   /**
    * add a submenu html
    */
    public function admin_submenu_html()  {
      ?>
      <h1><?= get_admin_page_title() ?></h1>
      <form class="" action="options.php" method="post">
        <!-- output nonce, action and option_page fields for a settings page -->
        <?php settings_fields( 'dayencontact_settings' ); ?>
        <?php do_settings_sections( 'dayencontact_settings' ) ?>
        <?php submit_button(); ?>
      </form>
      <form class="" action="" method="post">
        <input type="hidden" name="contact" value="<? !empty($_GET['contact'])? $_GET['contact'] : 0 ?>">
        <?php
          global $dayencontact_user_data;
          if( isset( $dayencontact_user_data ) ): ?>
          <blockquote cite="">
            Response to a <b><?= $dayencontact_user_data['name'] ?><b><br>
            About: <b><?= $dayencontact_user_data['message'] ?><b><br>
            Sended at: <b><?= $dayencontact_user_data['sended_at'] ?><b>
          </blockquote>
        <?php endif; ?>
        <?php submit_button( 'Answer' ); ?>
      </form>
      <?php
    }

    public function section_html() {
      echo "section field callback rendering";
    }

    public function dayencontact_from_email_address_html() {
       ?>
       <input type="email" name="dayencontact_from_email_address" value="<?= get_option( 'dayencontact_from_email_address' ) ?>">
       <?php
     }

    public function dayencontact_object_html(){
       ?>
       <input type="text" name="dayencontact_object" value="<?= get_option('dayencontact_object') ?>">
       <?php
     }

    public function dayencontact_message_html(){
       ?>
       <textarea name="dayencontact_message" rows="8" cols="80"><?= get_option('dayencontact_message') ?></textarea>
       <?php
     }

    /**
     * show a contact data in dashboard
     */
     public function admin_menu_html() {
       global $wpdb;
       $contacts = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}dayencontact", ARRAY_A );
       ?>
       <h1><?= get_admin_page_title() ?></h1>
       <table>
         <thead>
           <tr>
             <td>#</td>
             <td>ID</td>
             <td>Sender name</td>
             <td>Sender email</td>
             <td>Sender Date</td>
             <td>Date</td>
             <td>Reply</td>
           </tr>
         </thead>
         <tbody>
           <?php $i=0;foreach ($contacts as $contact): ?>
             <tr>
               <td><?= ++$i; ?></td>
               <td><?= $contact['id'] ?></td>
               <td><?= $contact['name'] ?></td>
               <td><?= $contact['email'] ?></td>
               <td><?= $contact['message'] ?></td>
               <td><?= $contact['sended_at'] ?></td>
               <td><a href="?page=dayen_response_submenu&contact=<?= $contact['id'] ?>">response</a>  </td>
             </tr>
           <?php endforeach; ?>
         </tbody>
       </table>
       <?php
     }

  }

  new Dayen_Contact();
