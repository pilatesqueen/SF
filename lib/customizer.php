<?php

namespace Roots\Sage\Customizer;

use Roots\Sage\Assets;

/**
 * Add postMessage support
 */
function customize_register($wp_customize) {
  // Rename 'Site Title & Tagline' to ‘Branding'
    $wp_customize->get_section('title_tagline')->title = __('Branding',
    'sage');
    $wp_customize->get_section('title_tagline')->priority = 1;
  	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_control( 'blogdescription' )->label  = esc_html__('Hero Text', 'sage');
    $wp_customize->remove_control('display_header_text');
    $wp_customize->add_setting('top_cta', array(
			'capability' => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'top_cta', array(
				'type'     => 'text',
				'description' => __('Enter top strip call to action', 'sage'),
				'priority' => 15,
				'section' => 'title_tagline',
				'label'    => __('Top CTA', 'sage')
		) );


  //	Header Button

  $wp_customize->add_setting('btn_url', 'sanitize_callback' == 'esc_url_raw' );
  $wp_customize->add_control( 'btn_url', array(
      'type'     => 'url',
      'description' => __('Link to an external page.', 'sage'),
      'priority' => 40,
      'section' => 'title_tagline',
      'label'    => __('Hero Button Link', 'sage')
  ) );

  $wp_customize->add_setting('btn_text', array(
    'default' => '',
    'capability' => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control( 'btn_text', array(
      'type'     => 'text',
      'description' => __('Enter Call to Action Text that will appear on the button', 'sage'),
      'priority' => 50,
      'section' => 'title_tagline',
      'label'    => __('Button Text', 'sage')
  ) );


    //Footer Settings section
  	 $wp_customize->add_section('social_setting', array(
  	  'priority' => 60,
  	  'title' => __('Footer', 'sage'),
  	  ));

      $wp_customize->add_setting('footer_1', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
      ));
      $wp_customize->add_control( 'footer_1', array(
          'type'     => 'text',
          'description' => __('Enter footer privacy text', 'sage'),
          'priority' => 10,
          'section' => 'social_setting',
          'label'    => __('Privacy text', 'sage')
      ) );

      $wp_customize->add_setting('footer_2', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
      ));
      $wp_customize->add_control( 'footer_2', array(
          'type'     => 'text',
          'description' => __('Footer Privacy links Privacy', 'sage'),
          'priority' => 20,
          'section' => 'social_setting',
          'label'    => __('Privacy links', 'sage')
      ) );

  	   //social facebook link
  	 $wp_customize->add_setting('social_facebook', array(
  	  'default' => '',
  	  'sanitize_callback' => 'esc_url_raw',
  	  ));

  	 $wp_customize->add_control('social_facebook',array(
  	  'type' => 'url',
  	  'label' => __('Facebook URL','sage'),
  	  'section' => 'social_setting',
  	  ));

  	    //social twitter link
  	 $wp_customize->add_setting('social_twitter', array(
  	  'default' => '',
  	  'sanitize_callback' => 'esc_url_raw',
  	  ));

  	 $wp_customize->add_control('social_twitter',array(
  	  'type' => 'url',
  	  'label' => __('Twitter URL','sage'),
  	  'section' => 'social_setting',
  	  ));

      //social instagram link
   $wp_customize->add_setting('social_instagram', array(
    'default' => '',
    'sanitize_callback' => 'esc_url_raw',
    ));

   $wp_customize->add_control('social_instagram',array(
    'type' => 'url',
    'label' => __('Instragram URL','sage'),
    'section' => 'social_setting',
    ));
    //social instagram link
 $wp_customize->add_setting('social_youtube', array(
  'default' => '',
  'sanitize_callback' => 'esc_url_raw',
  ));

 $wp_customize->add_control('social_youtube',array(
  'type' => 'url',
  'label' => __('Youtube URL','sage'),
  'section' => 'social_setting',
  ));




}
add_action('customize_register', __NAMESPACE__ . '\\customize_register');


/* Sanitize Callbacks*/


/**
 * Customizer JS
 */
function customize_preview_js() {
  wp_enqueue_script('sage/customizer', Assets\asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
}
add_action('customize_preview_init', __NAMESPACE__ . '\\customize_preview_js');
