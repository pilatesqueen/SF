<article <?php post_class(); ?>>
  <header>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php get_template_part('templates/entry-meta'); ?>
  </header>
  <div class="entry-content col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
  <?php if ( has_post_thumbnail()) :
    $thumbnail_id = get_post_thumbnail_id();
    $thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'full', false );?>
<img class="img-fluid alignwide mx-auto" src="<?php echo $thumbnail_url[0]; ?>" alt="<?php the_title(); ?>">
 <?php endif; ?>
  <div class="entry-summary excerpt-text white" >
    <?php the_excerpt(); ?>
  </div>
  <p class="text-center"><a href="<?php the_permalink(); ?>" class="btn btn-primary btn-xl">Read Full Post</a>
  </p>
</div>
</article>
