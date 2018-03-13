<?php

/**
 * Newslatter widget to show in site
 */
class Zero_Newslatter_Widget extends WP_Widget {

  /**
  * fill the id, name & description of widget
  */
  function __construct() {
    parent::__construct(
      "zero_newslatter_widget",
      "Zero Newslatter Widget",
      [ 'description' => 'un formulaire d\'inscription de newslatter!' ]
    );
  }

  /**
   *
   * This method allow us to get a front of the widget
   * @param Array $args contain a class, id, name placeholder & outhers params
   * @param Array $instance to save some field int DB
   * @return Skeleton of the widget
   */
   public function widget( $args, $instance ) {
     echo "{$instance['before_widget']}";
     echo "{$instance['before_title']}";
     echo apply_filters ( 'widget_title', $instance['title'] );
     echo "{$instance['after_title']}";
     ?>
     <form action="" method="post" class='zero-form'>
       <label for="zero_newslatter_email" class='zero-label-form'><?php _e('Votre Email:') ?></label>
       <div class='zero-newslatter-input-group'>
         <input type="email" name="zero_newsletter_email" id='zero_newslatter_email' placeholder='pseudo@domain-name.domain' class="zero-form-control" />
         <input type='submit' class='btn btn-primary submit' value='&#x27BA;' />
       </div>
     </form>
     <?php
     echo "{$instance['after_widget']}";
   }


  /**
   * this function to save some data showed inside a widget on dashboard
   * @param Array $instance contain a data infos about title .. @see $this->widget() 2 param
   * @return String Skeleton of the form in dashboard section
   */
   public function form($instance) {
     $title = isset($instance['title'])? $instance['title'] : '';
      ?>
      <p>
        <label for="<?= $this->get_field_id('title') ?>"><?php _e('Title'); ?></label>
        <input type="text" class="widefat" name='<?= $this->get_field_name("title") ?>' value='<?= $title ?>' id='<?= $this->get_field_id("title") ?>' placeholder="Title" />
      </p>
      <?php
    }


}
