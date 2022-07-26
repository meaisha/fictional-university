<?php
// intividual posts template

get_header();

while(have_posts()) {
  the_post();
  pageBanner(array(
    'title' => the_title(),
    'subtitle' => get_field('page_banner_subtitle')
  ));
?>
<div class="container container--narrow page-section">
  
  <div class="generic-content">
<div class="row group">
  <div class="one-third"><?php the_post_thumbnail('professorPortrait'); ?></div>
  <div class="two-thirds"><?php the_content(); ?></div>
</div>
    
    
  </div>
  <?php 
  $relatedPrograms = get_field('related_programs');
  if($relatedPrograms):
  ?>
  <hr class="section-break">
  <h2 class="headline headline--medium">Subject(s) Taught</h2>
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