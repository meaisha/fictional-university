<?php
// intividual posts template

get_header();

while(have_posts()) {
  the_post();

  pageBanner();
?>

<div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p>
      <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Event Home</a> 
      <span class="metabox__main">
      <?php

        $eventDate = new DateTime(get_field('event_date'));
        echo $eventDate->format('d.m.Y');

      ?>
      </span>
    </p>
  </div>
  <div class="generic-content">
    <?php the_content(); ?>
  </div>
  <?php 
  $relatedPrograms = get_field('related_programs');
  if($relatedPrograms):
  ?>
  <hr class="section-break">
  <h2 class="headline headline--medium">Related Program(s)</h2>
  <ul class="link-list min-list">
  <?php 
    

    foreach($relatedPrograms as $program):
      $title = get_the_title($program);
  ?>
  <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo $title; ?></a></li>
  <?php endforeach; ?>

  </ul>
  <?php endif; ?>
</div>
<?php
}

get_footer();
?>