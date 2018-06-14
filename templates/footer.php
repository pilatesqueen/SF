<!-- Contact -->
<section id="newsletter">
  <div class="container">

    <div class="row">
              <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">Subscribe and Never Miss a Sale</h2>
                <h3 class="section-subheading text-muted">Receive latest Free Videos and News from the Blog</h3>
              </div>
            </div>


    <div class="row">
  <div class="col-lg-12 text-center">
<?php dynamic_sidebar('sidebar-footer-main'); ?>

      <form action="https://balanceinme.us2.list-manage.com/subscribe/post?u=ecab685af969494e19c5a3a54&amp;id=21a8c3a361" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
                <input type="text" value="" name="FNAME" class="" id="mce-FNAME" placeholder="Your Name *" required data-validation-required-message="Please enter your name.">
            <p class="help-block text-danger"></p>
          </div>

        </div>
        <div class="col-md-6">
          <div class="form-group">
            <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Your Email *" required data-validation-required-message="Please enter your email address.">
        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
          <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_ecab685af969494e19c5a3a54_21a8c3a361" tabindex="-1" value=""></div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-12 text-center">

          <button type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn btn-secondary btn-xl text-uppercase" >Sign UP </button>
        </div>
      </div>
    </form>
  </div>
</div>


</div>

</section>

<!-- Footer -->
<footer>
  <div class="footer-block-1">
  <div class="container">
    <div class="row social">
    <div class="col-md-12">
        <ul class="list-inline social-buttons">
              <?php if ( get_theme_mod('social_facebook') != ''): ?>
                <li class="list-inline-item">
            <a target="_blank" href="<?php echo get_theme_mod('social_facebook'); ?>">
              <i class="fa fa-facebook"></i>
            </a>
          </li>
          <?php endif; ?>
          <?php if ( get_theme_mod('social_instagram') != ''): ?>
          <li class="list-inline-item">
            <a  target="_blank" href="<?php echo get_theme_mod('social_instagram'); ?>">
              <i class="fa fa-instagram"></i>
            </a>
          </li>
        <?php endif; ?>
      <?php if ( get_theme_mod('social_twitter') != ''): ?>
          <li class="list-inline-item">
            <a  target="_blank" href="<?php echo get_theme_mod('social_twitter'); ?>">
              <i class="fa fa-twitter"></i>
            </a>
          </li>
          <?php endif; ?>
          <?php if ( get_theme_mod('social_youtube') != ''): ?>
              <li class="list-inline-item">
                <a  target="_blank" href="<?php echo get_theme_mod('social_youtube'); ?>">
                  <i class="fa fa-youtube"></i>
                </a>
              </li>
              <?php endif; ?>
        </ul>
        <?php dynamic_sidebar('sidebar-footer-center'); ?>
      </div>

    </div>

    <div class="row align-items-center">
      <div class="col-sm-9">
      <?php dynamic_sidebar('sidebar-footer-1');
  if (has_nav_menu('footer_navigation')) :
    wp_nav_menu(['theme_location' => 'footer_navigation',
                  'container_class' => 'menu-footer-container row',
                  'walker' => new wp_footer_navwalker(),
                  'items_wrap' => '<div class="col"><ul id="%1$s" class="%2$s">%3$s</ul></div>']);
  endif;
  ?>
</div>
      <div class="col-sm-3 text-right">
          <?php dynamic_sidebar('sidebar-footer-2'); ?>
      </div>
    </div>
    </div>

  </div>
</div>
<div class="footer-block-2">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <?php if ( get_theme_mod('footer_1') != ''): ?>
            <?php echo get_theme_mod('footer_1'); ?>
            <?php endif; ?>


      </div>

      <div class="col-md-4 text-right">
        <?php if ( get_theme_mod('footer_2') != ''): ?>
            <?php echo get_theme_mod('footer_2'); ?>
            <?php endif; ?><br>
            &copy; <?php bloginfo('name'); ?> <?php echo date( 'Y' ); ?> - All Rights Reserved.<br>
Site by <a href="http://anastasiyagoers.com" target="_blank" rel="designer">Anastasiya Goers</a>

      </div>
    </div>
  </div>
</div>
</footer>
