<?php
  // This file assumes that you have included the nav walker from https://github.com/twittem/wp-bootstrap-navwalker
  // somewhere in your theme.
?>

    <div class="topbar">
    <?php echo get_theme_mod('top_cta'); ?></a>
  </div>

<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
  <div class="container-fluid">


        <a class="navbar-brand" href="<?= esc_url(home_url('/')); ?>">    <?php $custom_logo_id = get_theme_mod( 'custom_logo' );
                $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                if ( has_custom_logo() ) {
                        echo '<img class="logo" src="'. esc_url( $logo[0] ) .'">';
                } else {
                        echo '<h1>'. get_bloginfo( 'name' ) .'</h1>';
                } ?></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="sr-only"><?= __('Toggle navigation', 'sage'); ?></span>
          <i class="fa fa-bars"></i>
      </button>

    <div class="collapse justify-content-end navbar-collapse flex-column ml-lg-0 ml-3" role="navigation" id="navbarNav">

      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'walker' => new wp_bootstrap_navwalker(), 'menu_class' => 'navbar-nav text-uppercase ml-auto', 'container_class' => 'menu-primary-menu-container mb-2 mb-md-0 ml-auto']);
      endif;
      ?>

    </div>
  </div>
</nav>


<!-- Header -->

<?php if( is_front_page() ) : ?>
<header class="masthead" style="background-image:url('<?php header_image(); ?>')">
  <div class="container-fluid">
    <div class="intro-text">
      <div class="intro-heading text-uppercase">Feel <span class="text-display">FREE</span> in Your Body</div>
      <?php if ( get_theme_mod('btn_url') != ''):
        ?>
              <a class="btn btn-primary btn-xl text-uppercase" href="<?php echo get_theme_mod('btn_url'); ?>">
              <?php echo get_theme_mod('btn_text'); ?>
            </a>
      <?php endif;
      ?>

    </div>
  </div>
</header>
<?php elseif// Check if this is a post or page and Featured Image header is enabled, if it has a thumbnail, and if it's a big one
        ( is_page() && current_theme_supports( 'post-thumbnails' ) &&
                            has_post_thumbnail( $post->ID ) &&
                            ( /* $src, $width, $height */ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ) ) &&
                            $image[1] >= '1900'
                            && get_field( 'custom_header_title' ) != '' ): ?>

                            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ) ?>
      <header class="masthead page" style="background-image:url('<?php echo $image[0]; ?>')">
			<div class="container" >
				<div class="intro-text">
            <div class="intro-heading text-uppercase text-display">
						<span class="text-display"><?php if (is_page() && get_field( 'custom_header_title' ) != ''): the_field('custom_header_title');?></span>
					   <?php endif; ?></div>
              <div class="intro-description text-muted">
                 <?php if (is_page() && get_field( 'custom_header_description' ) != ''): ?>
                    <p><?php the_field('custom_header_description');?></p>
                  <?php endif; ?>
                </div>
					</div>
			</div>
    </header>
<?php elseif (is_page() && current_theme_supports( 'post-thumbnails' ) &&
                    has_post_thumbnail( $post->ID ) ):
                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ) ?>

                  <div class="text-center">
                    <img src="<?php echo $image[0]; ?>" class="img-fluid">
                  </div>
<?php else: ?>

<?php endif; ?>
