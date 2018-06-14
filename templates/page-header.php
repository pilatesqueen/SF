<?php use Roots\Sage\Titles; ?>
<?php if ( function_exists('yoast_breadcrumb') && !is_front_page() )
{yoast_breadcrumb('<p id="breadcrumbs">','</p>');} ?>

<div class="page-header text-center">
  <h1><?= Titles\title(); ?></h1>
</div>
