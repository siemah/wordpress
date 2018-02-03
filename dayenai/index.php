<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php wp_title() ?></title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="<?php  ?>">
    <!-- style -->
    <style media="screen">
      .jumbotron {
        background: url('<?= get_stylesheet_directory_uri() ?>/img/bg-jumbotron.jpg') no-repeat center;
        background-size: cover;
      }
    </style>
    <?php wp_head() ?>
  </head>
  <body>

    <div class="jumbotron pt-4 rounded-0">
      <div class="gradient-bg"></div>
      <div class="container">
        <!-- Main menu -->
        <nav class="main-nav ">
          <ul class="nav-block p-0 pt-3 float-left">
            <li class="nav-item"><a href="#" class="nav-link">item1</a></li>
            <li class="nav-item"><a href="#" class="nav-link">item2</a></li>
            <li class="nav-item"><a href="#" class="nav-link">item3</a></li>
          </ul>
          <a href="#" class="nav-brand text-center">
            <img src="<?= get_stylesheet_directory_uri() ?>/img/logo.png" alt="logo">
            <span class="website-name text-uppercase"><?php bloginfo('name') ?></span>
          </a>
          <ul class="nav-block text-right p-0 pt-3 float-right">
            <li class="nav-item"><a href="#" class="nav-link">item1</a></li>
            <li class="nav-item"><a href="#" class="nav-link">item2</a></li>
            <li class="nav-item"><a href="#" class="nav-link">item3</a></li>
          </ul>
        </nav>
        <!-- Some blabla -->
        <div class="block mt-5 pt-5 text-center">
          <h3>Abrid gh Ain Legradj</h3>
          <h1>Thala</h1>
          <!-- <img src="<?= get_template_directory_uri() ?>/img/road.png" class="mb-3 mt-1" alt="road.png"> -->
          <a href="#" class="btn custom-btn pl-4 pr-4 rounded-0">Arewah ghurnegh</a>
        </div>
      </div><!-- /.container -->

    </div><!-- /.jumbotron -->


    <div class="slide-container mt-5">

      <div class="container text-center">
        <h4 class="well text-muted">What should i prepared for?</h4>
        <h3 class="display-3 dark-blue">PROGRAM</h3>

        <div class="carousel slide" data-ride="carousel" id="slide-1">
          <ol class="carousel-indicators">
            <li class="active" data-slide-to='0' data-target='#slide-1'></li>
            <li data-slide-to='1' data-target='#slide-1'></li>
            <li data-slide-to='2' data-target='#slide-1'></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="<?= get_template_directory_uri() ?>/img/jumbotron-bg.jpg" class="d-block w-100">
              <div class="carousel-caption d-none d-md-block">
                <h5>Day 15</h5>
                <p>Dayen amek a wina</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="<?= get_template_directory_uri() ?>/img/jumbotron-bg.jpg" class="d-block w-100">
              <div class="carousel-caption d-none d-md-block">
                <h5>Day 19</h5>
                <p>Dayen amek a wina</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="<?= get_template_directory_uri() ?>/img/jumbotron-bg.jpg" class="d-block w-100">
              <div class="carousel-caption d-none d-md-block">
                <h5>Day 16</h5>
                <p>Dayen amek a wina</p>
              </div>
            </div>
          </div>
          <a class="carousel-control-prev" href="#slide-1" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#slide-1" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

      </div>


    </div>




    <?php wp_footer() ?>
  </body>
</html>
