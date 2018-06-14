<!-- Latest Blog Post for Homepage -->
<section class="bg-light" id="portfolio">
  <div class="container-fluid">
      <?php if ( !empty(get_sub_field('section_title')) ) : ?>
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading text-uppercase"><?php the_sub_field('section_title'); ?></h2>
          </div>
        </div>
      <?php endif; ?>
    <div class="row">
      <?php
      $args = array(
        'post_type' => 'post',
        'posts_per_page' => '1',
        'category__not_in' => get_sub_field('cat_exclude')
      );
			$postlist = new WP_Query ( $args );
      if ( $postlist->have_posts() ) :
      while ( $postlist->have_posts() ) : $postlist->the_post();

      $thumbnail_id = get_post_thumbnail_id();
		  $thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'full', false );
    ?>

    <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2 col-md-10 offset-md-1">
        <?php if ( has_post_thumbnail()) : ?>
      <img class="img-fluid alignwide mx-auto" src="<?php echo $thumbnail_url[0]; ?>" alt="<?php the_title(); ?>">
    <?php endif; ?>
    <h2 class="section-heading text-uppercase text-center alignwide"><?php the_title(); ?></h2>

      <div class="excerpt-text">
            <?php the_excerpt(); ?>
        </div>
        <p class="text-center"><a href="<?php the_permalink(); ?>" class="btn btn-primary btn-xl">Read Full Post</a>
        </p>

  <?php  endwhile;

wp_reset_postdata();
    endif; ?>

    </div>

  </div>
</section>
