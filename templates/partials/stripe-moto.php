<!-- This is Moto Display -->
<?php // check current row layout
      if( have_rows('col_content') ): ?>
<section id="testimonials">
  <div class="container-fluid">
    <div class="row">

        <?php  while( have_rows('col_content') ): the_row();?>

      <div class="col-md-4">
        <h4 class="testimonial-heading text-right"><?php the_sub_field('moto_title_line_1'); ?></h4>
        <p class="testimonial-heading text-right"><?php the_sub_field('moto_title_line_2'); ?></p>
        <p class="text-muted text-justify"><?php the_sub_field('moto_main_text'); ?></p>
      </div>


      <?php endwhile; ?>

    </div>
  </div>
</section>
<?php endif; ?>
