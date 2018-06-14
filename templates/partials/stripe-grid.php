<!-- Blog Grid for Home Page -->
<!-- Portfolio Grid -->
<section class="bg-light" id="portfolio">
  <div class="container-fluid">
  <?php if ( !empty(get_sub_field('title')) ) : ?>
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2 class="section-heading script-font text-uppercase"><?php the_sub_field('title'); ?></h2>
          <?php if ( !empty(get_sub_field('subtitle')) ) : ?>
        <h3 class="section-subheading text-muted"><?php the_sub_field('subtitle'); ?></h3>
      <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>
    <div class="row">

      <?php
      $args = array(
        'post_type' => 'post',
        'posts_per_page' => '6',
        'category__in' => get_sub_field('category')
      );
			$postlist = new WP_Query ( $args );
      if ( $postlist->have_posts() ) :
      while ( $postlist->have_posts() ) : $postlist->the_post();

      $thumbnail_id = get_post_thumbnail_id();
		  $thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'postgrid-thumb', true );
    ?>

      <div class="col-md-4 col-sm-6 portfolio-item">
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

  <?php  endwhile;

wp_reset_postdata();
    endif; ?>

    </div>
    <?php $link = get_sub_field('link');
    if( $link ): ?>
    <div class="row">
      <div class="col text-center">
        <a href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>" class="btn btn-primary btn-xl">
          <?php echo $link['title']; ?></a>
      </div>
    </div>
  <?php endif; ?>
  </div>
</section>
