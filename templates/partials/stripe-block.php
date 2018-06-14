<!-- Focus Call to Action -->
<section id="front-block">
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
            <div class="col-lg-12 text-center">
              <?php the_sub_field('content'); ?>
            </div>
      </div>
    


  </div>
</section>
