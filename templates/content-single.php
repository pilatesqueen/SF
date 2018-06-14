<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>

    <header class="text-center">
      <?php if ( function_exists('yoast_breadcrumb') )
      {yoast_breadcrumb('<p id="breadcrumbs">','</p>');} ?>
      <h1 class="entry-title text-center"><?php the_title(); ?></h1>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
      <?php if ( has_post_thumbnail()) :
        $thumbnail_id = get_post_thumbnail_id();
  		  $thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'full', false );?>
    <img class="img-fluid alignwide mx-auto" src="<?php echo $thumbnail_url[0]; ?>" alt="<?php the_title(); ?>">
     <?php endif; ?>
      <?php the_content(); ?>
    </div>
    <footer>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
