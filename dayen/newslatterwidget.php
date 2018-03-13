<?php

  /**
   *
   */
  class Dayen_Newslatter_Widget extends WP_Widget {

    function __construct() {
      parent::__construct( "dayen_newslatter", 'Dayen Newslatter', [ 'description' => "description of form" ] );
    }

    /**
     * @description this method allow us to create a new widget however, this function inherited from the parent class
     *
     */
    public function widget($args, $instance) {
      ?>
      <?= $args['before_widget'] ?>
      <?= $args['before_title'] ?>
      <?= apply_filters( 'widget_title', $instance['title'] ) ?>
      <?= $args['after_title'] ?>
      <form class="" action="" method="post">
        <p>
          <label for="dayen_newslatter_email">Votre Email</label>
          <input
            type="email" name="dayen_newslatter_email" id="dayen_newslatter_email"
            value="<?= isset( $_COOKIE['dayen_newslatter_email_error'] )? $_POST['dayen_newslatter_email'] : "" ?>"
            <?php if( isset( $_COOKIE['dayen_newslatter_email_error'] ) ) echo "style='border-color: red !important;'" ?> />
        </p>
        <input type="submit" name="submit" value="A wina inscrit" />
      </form>
      <?php
        echo $args['after_widget'];
    }

    /**
     * overload method
     * the same thing with this method is also inherited from WP_Widget to make a form into a widget section (Dashboard)
     */
     public function form($instance) {
        $title = isset($instance['title'])? $instance['title'] : "";
        ?>
        <p>
          <label for="<?= $this->get_field_id('title') ?>"><?php _e('Ru Title ara di binen g site:'); ?></label>
          <input type="text" name="<?= $this->get_field_name('title') ?>" id="<?= $this->get_field_id('title') ?>" class="widefat" value="<?= $title ?>">
        </p>
        <?php
      }


  }
