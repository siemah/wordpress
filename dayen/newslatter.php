<?php

include plugin_dir_path( __FILE__ ) . "/newslatterwidget.php";

/**
 *
 */
class Dayen_Newslatter {

  function __construct() {

    # register a widget when widgets_init event has been fired
    add_action( 'widgets_init', function () {
      register_widget( "Dayen_Newslatter_Widget" );
    });
  }

  /**
   * this method called when plugin is activated (when user active this plugin, this event fire once)
   * @var $wpdb WP global var ( this global var of WordPress is a class to use when want make a query to DB )
   */
   public static function install() {
        global $wpdb;
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dayen_newsletter_email (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) NOT NULL);");
   }

  /**
    * called when the plugin is desactivared or delted
    */
   public static function uninstall(){
      global $wpdb;
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}dayen_newsletter_email;");
    }

}
