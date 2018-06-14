<?php get_template_part('templates/page', 'header'); ?>
<?php get_template_part( 'templates/sidebar', 'archive' ); ?>


<div  id="portfolio" >
<div class="row">
  <?php if (!have_posts()) : ?>
    <div class="alert alert-warning">
      <?php _e('Sorry, no results were found.', 'sage'); ?>
    </div>
    <?php get_search_form(); ?>
  <?php endif; ?>



    		<?php if ( have_posts() ) : ?>

    			<?php /* Start the Loop */ ?>
    			<?php while (have_posts() ) : the_post(); ?>

    				<?php

    					/*
    					 * Include the Post-Format-specific template for the content.
    					 * If you want to override this in a child theme, then include a file
    					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
    					 */
    					get_template_part( 'templates/content', 'archive' );
    				?>

    			<?php endwhile; ?>




</div>
<div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">

        <?php

        global $wp_query;

        $big = 999999999; // need an unlikely integer

        echo paginate_links( array(
        	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        	'format' => '?paged=%#%',
        	'current' => max( 1, get_query_var('paged') ),
        	'total' => $wp_query->max_num_pages
        ) );
        ?>
    </div>
  </div>
<?php endif; ?>
</div>
