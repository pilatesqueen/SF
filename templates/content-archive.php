

  <?php


  $thumbnail_id = get_post_thumbnail_id();
  $thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'postgrid-thumb', true );
?>

  <div class="col-xl-3 col-md-4 col-sm-6 portfolio-item">
    <a class="portfolio-link" href="<?php the_permalink(); ?>">
      <div class="portfolio-hover">
        <div class="portfolio-hover-content">
          <i class="fa fa-plus fa-3x"></i>
        </div>
      </div>
      <?php if ( has_post_thumbnail()) : ?>
      <img class="img-fluid" src="<?php echo $thumbnail_url[0]; ?>" alt="<?php the_title(); ?> ">
    <?php else: ?>
      <img class="img-fluid" src="<?= get_template_directory_uri(); ?>/dist/images/placeholder.jpg" alt="<?php the_title(); ?> ">
    <?php endif; ?>
    </a>
    <div class="portfolio-caption">
      <h4><?php the_title(); ?></h4>
      <p class="text-muted"><?php
          the_tags('', ', ', '')
          ?></p>
    </div>
  </div>
