<!-- This is Testimonials Display in 3 columns -->

<section id="testimonials">
  <div class="container-fluid">

<?php if( !empty(get_sub_field('section_title')) ): ?>
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading script-font text-uppercase">
            <?php the_sub_field('section_title'); ?></h2>
          <h3 class="section-subheading text-muted">
            <?php the_sub_field('section_subtitle'); ?></h3>
        </div>
      </div>
<?php endif; ?>

      <?php // check current row layout
            if( have_rows('col_content') ): ?>
            <div class="row">
        <?php  while( have_rows('col_content') ): the_row();?>

      <div class="col-lg-4">
        <h3 class="testimonial-heading text-center"><?php the_sub_field('title'); ?></h4>

        <?php
        $image = get_sub_field('image'); ?>
        <img src="<?php echo $image[url]; ?>" alt="<?php echo $image['alt']; ?>" class="img-fluid">

        <p class="text-muted text-justify"><?php the_sub_field('text'); ?></p>
      </div>


      <?php endwhile; ?>
    </div>
      <?php if( !empty(get_sub_field('section_footer')) ): ?>

      <div class="col-lg-12 text-center">
    <p class="text-muted">
      <?php the_sub_field('section_footer'); ?>
    </p>
        </div>
      <?php endif; ?>

    </div>
</section>
<?php endif; ?>
