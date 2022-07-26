<?php
// intividual posts template
//the_ID(); - id of this page
get_header();

while(have_posts()) {
  the_post();

  pageBanner();
?>

<div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p>
      <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> 
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
          $relatedProfessors = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
              array(
                'key' => 'related_programs', // array(12, 120, 1250) - the values will be serialized
                'compare' => 'LIKE', // array of related programs contain
                'value' => '"' . get_the_ID() . '"' // need to add quotes to make it search the exact value in the serialized array of ids
              )
            )
          ));

          if($relatedProfessors->have_posts()):

            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming '. get_the_title() . ' Events</h2>';
            echo '<ul class="professor-cards">';
            while($relatedProfessors->have_posts()):
              $relatedProfessors->the_post();
            ?>
              
                <li class="professor-card__list-otem">
                  <a class="professor-card" href="<?php the_permalink(); ?>">
                  <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>" alt="">
                  <span class="professor-card__name"><?php the_title(); ?></span>
                    
                  </a>
                </li>
                
            <?php endwhile; 
            echo '</ul>';
            wp_reset_postdata();
          endif;
          ?>

  <?php
          $today = date('Ymd');
          $relatedEvents = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'event',
            //'orderby' => 'post_date', //by default
            //'orderby' => 'title',
            'meta_key' => 'event_date',
            //'orderby' => 'meta_value',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            // filter out past events
            'meta_query' => array(
              array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              ),
              array(
                'key' => 'related_programs', // array(12, 120, 1250) - the values will be serialized
                'compare' => 'LIKE', // array of related programs contain
                'value' => '"' . get_the_ID() . '"' // need to add quotes to make it search the exact value in the serialized array of ids
              )
            )
          ));

          if($relatedEvents->have_posts()):

            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming '. get_the_title() . ' Events</h2>';
            while($relatedEvents->have_posts()):
              $relatedEvents->the_post();
              get_template_part('template-parts/content-event');
            endwhile; 
            wp_reset_postdata();
          endif;
          ?>
</div>
<?php
}

get_footer();
?>