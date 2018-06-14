<?php while (have_posts()) : the_post();

	// are there any rows within within our flexible content?
	 if( have_rows('front_page_rows') ):

		// loop through all the rows of flexible content
		while ( have_rows('front_page_rows') ) : the_row();

		// Moto/ Main Features
		if( get_row_layout() == '3_col_moto' )
			get_template_part('templates/partials/stripe', 'moto');

		// Call to Action
		if( get_row_layout() == 'cta' )
			get_template_part('templates/partials/stripe', 'cta');

      // 2 Column Focus Image and Text
  		if( get_row_layout() == '2_col' )
  			get_template_part('templates/partials/stripe', 'focus');


		// TESTIMONIAL
		if( get_row_layout() == 'testimonials' )
			get_template_part('templates/partials/stripe', 'testimonials');

		// Feature Mentions
		if( get_row_layout() == 'feature_mentions' )
			get_template_part('templates/partials/stripe', 'feature');

      // Blog GRid
  		if( get_row_layout() == 'blog_grid' )
  			get_template_part('templates/partials/stripe', 'grid');

				// Latest Blog Post
	  		if( get_row_layout() == 'latest_blog_post' )
	  			get_template_part('templates/partials/stripe', 'post');

			// Content Block
  		if( get_row_layout() == 'content_block' )
  			get_template_part('templates/partials/stripe', 'block');



		endwhile; // close the loop of flexible content
	endif; // close flexible content conditional

endwhile;
// close the WordPress loop ?>
