<!-- This is Feature Logos Display -->
<?php // check current row layout
      if( have_rows('feature') ): ?>
  <section class="press py-5">
    <div class="container">
      <div class="row">

      <?php  while( have_rows('feature') ): the_row();?>

        <div class="col-md-3 col-sm-6">
            <a data-toggle="collapse" href="#<?php the_sub_field('title'); ?>" role="button" aria-expanded="false" aria-controls="#<?php the_sub_field('title'); ?>">
            <?php
            $image = get_sub_field('image'); ?>
              <img class="img-fluid d-block mx-auto" src="<?php echo $image[url]; ?>" alt="<?php echo $image['alt']; ?>">
            </a>
        </div>


      <?php endwhile; ?>

    </div>
  </div>
</section>
<?php endif; ?>
