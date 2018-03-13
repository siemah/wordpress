<?php


  /**
   *
   */
  class Dayen_Shortcode {

    function __construct() {
      # add a shortcode to generate a contant form
      add_shortcode( 'dayencontacf_form', [ $this, 'dayen_form_container' ] );
      add_shortcode( 'textField', [ $this, 'dayen_textField' ] );
      add_shortcode( 'emailField', [ $this, 'dayen_emailField' ] );
      add_shortcode( 'textareaField', [ $this, 'dayen_textareaField' ] );
      add_shortcode( 'btnSubmit', [ $this, 'dayen_submit_button' ] );
    }

    /**
     * add some shortcode of text field, email field, textarea of content & outhers
     * @param $atts Array list of a attributes
     * @param $content String a content between a sortcode
     */
     public function dayen_form_container($atts, $content)  {
       $id = uniqid();
       $atts = shortcode_atts(
         [ 'name' => 'dayencontact_name', 'placeholder' => 'Your name', 'id' => $id, 'class' => "dayen_form_control" ],
         $atts
       );
       ?>
       <form id="<?= $id ?>" class="dayencontact-form-container" enctype="multipart/form-data" action="<?= get_permalink() ?>" method="post">
         <?= do_shortcode($content) ?>
       </form>
       <?php
     }

     public function dayen_textField($atts, $content) {
       $id = uniqid();
       $atts = shortcode_atts(
         [ 'name' => 'dayencontact_name', 'placeholder' => 'Your name', 'id' => $id, 'class' => "dayen_form_control" ],
         $atts
       );
       ?>
       <p>
         <label for="<?= $atts['id'] ?>">
           <?= $content ?>
           <input type='text' id="<?= $atts['id'] ?>" placeholder="<?= $atts['placeholder'] ?>" class="<?= $atts['class'] ?>"  name="<?= $atts['name'] ?>" >
         </label>
       </p>
       <?php
     }

    /**
     * add some shortcode of text field, email field, textarea of content & outhers
     * @param $atts Array list of a attributes
     * @param $content String a content between a sortcode
     */
     public function dayen_emailField($atts, $content) {
      $id = uniqid();
      $atts = shortcode_atts(
        [ 'name' => 'dayencontact_email', 'placeholder' => 'Your email', 'id' => $id, 'class' => "dayen_form_control" ],
        $atts
      );
      ?>
      <p>
        <label for="<?= $atts['id'] ?>">
          <?= $content ?>
          <input type='email' id="<?= $atts['id'] ?>" placeholder="<?= $atts['placeholder'] ?>" class="<?= $atts['class'] ?>"  name="<?= $atts['name'] ?>" >
        </label>
      </p>
      <?php
     }

     public function dayen_textareaField($atts, $content)  {
        $id = uniqid();
        $atts = shortcode_atts(
          [ 'name' => 'dayencontact_content', 'placeholder' => 'Your email', 'id' => $id, 'class' => "dayen_form_control" ],
          $atts
        );
        ?>
        <p>
          <label for="<?= $atts['id'] ?>">
            <?= strlen(trim($content)) == 0? 'Text area' : $content ?>
            <textarea type='email' id="<?= $atts['id'] ?>" placeholder="<?= $atts['placeholder'] ?>" class="<?= $atts['class'] ?>"  name="<?= $atts['name'] ?>" ></textarea>
          </label>
        </p>
        <?php
      }

    /**
     * add a submit button
     */
     public function dayen_submit_button($atts, $content)  {
       ?>
       <p>
         <input type="submit" name="dayen_contact_submit" class="dayen_btn" value="<?= strlen($content) == 0? "Submit" : esc_html($content) ?>">
       </p>
       <?php
     }


  }
