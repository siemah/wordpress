<?php

/**
 * Containe a dependency
 */
class Zero_Newslatter {

  function __construct() {

    // initial a widget to use it
    add_action ( 'widgets_init', function () {
      include_once plugin_dir_path( __FILE__ ) . "/newslatterwidget.php";
      register_widget( 'Zero_Newslatter_Widget' );
    } );

    // save emails sended from user
    add_action( 'wp_loaded', [ $this, 'save_mail'] );

  }

  /**
   * This function called every time the plugin is installed or enabled
   * @see wp_plugin_activation hook
   * to add some data into DB
   */
  public static function install() {
    global $wpdb;

    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}zero_newsletter_email (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) NOT NULL);");
  }

  /**
   * This function called every time the plugin is desabled or removed
   * to add some data into DB
   */
  public static function uninstall() {
    global $wpdb;

    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}zero_newsletter_email;");
  }

  /**
  * save email into table
  * @see 'wp_loaded' hook
  */
  public function save_mail () {
    if (isset($_POST['zero_newsletter_email']) && !empty($_POST['zero_newsletter_email'])) {
      global $wpdb;
      $email = $_POST['zero_newsletter_email'];

      $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}zero_newsletter_email WHERE email = '$email'");

      if (is_null($row)) $wpdb->insert("{$wpdb->prefix}zero_newsletter_email", array('email' => $email));

    }

  }


}
