<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>

    <!-- Check if it's a custom blocks page template -->
    <?php if (is_page_template('template-custom-blocks.php') || is_front_page() ): ?>
            <div class="wrap" role="document">
              <div class="content">
                <main>
                    <?php include Wrapper\template_path(); ?>
                  </main>
                </div>
              </div>
  <!-- Check if it's a Woocommerce Shop Page-->
<?php elseif (is_shop() || is_product() || is_archive() || is_search()): ?>
        <div class="wrap" role="document">
          <div class="content container-fluid">
            <div class="mx-lg-5">
            <main>
                <?php include Wrapper\template_path(); ?>
              </main>
            </div>
            </div>
          </div>

        <!-- Check if it's a layout with sidebar-->
      <?php elseif(get_field('sidebar_layout') == 'yes'): ?>

              <div class="wrap container" role="document">
                <div class="content row">
                  <main class="main">
                    <?php include Wrapper\template_path(); ?>
                  </main><!-- /.main -->
                  <?php if (Setup\display_sidebar()) : ?>
                    <aside class="sidebar">
                    <?php include Wrapper\sidebar_path(); ?>
                    </aside><!-- /.sidebar -->
                  <?php endif; ?>
                </div><!-- /.content -->
              </div><!-- /.wrap -->

            <!-- /Finally, this is a default layout for all pages with no sidebar -->
            <?php else: ?>
              <div class="wrap container" role="document">
                <div class="content">
                  <main>
                      <?php include Wrapper\template_path(); ?>
                    </main>
                  </div>
                </div>
          <?php endif; ?>

    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
  </body>
</html>
