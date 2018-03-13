<?php


  /**
   * @version 2018.02.18
   * @author siemah
   * install some dependancies and remove theme when user active, remove or deactive this plugin
   */
  class Dayen_Dependancies {

    /**
     * fire this function when user active this plugin
     * @var Object $wpdb is a WP variable
     */
    public static function install() {
      global $wpdb;
      $wpdb->query(
        "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dayencontact
          (
            id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
            name VARCHAR(255) ,
            email VARCHAR(255),
            message TEXT,
            sended_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
          )"
      );
    }

    /**
     * fire this function when user active this plugin
     * @var Object $wpdb is a WP variable
     */
    public static function uninstall() {
      global $wpdb;
      $wpdb->query(
        "DROP TABLE IF EXISTS {$wpdb->prefix}dayencontact"
      );
    }

  }
