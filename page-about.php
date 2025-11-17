<?php
/*
Template Name: About Us
*/
get_header();
?>

<main class="about-us-page" role="main">
    <div id="floating-particles" class="floating-particles" aria-hidden="true"></div>


    <!-- === Hero Banner (Featured Image / Big Picture) === -->
    <section class="about-hero">
        <?php if (has_post_thumbnail()) : ?>
            <div class="about-hero-image">
                <?php the_post_thumbnail('full', ['alt' => get_the_title()]); ?>
            </div>
        <?php endif; ?>
        <h1 class="about-hero-title"><?php the_title(); ?></h1>
    </section>

    <!-- === Main Content: Editable through WP Editor === -->
    <section class="about-company">
        <div class="container">
            <?php
            while (have_posts()) : the_post();
                the_content(); // Fully editable block editor content
            endwhile;
            ?>
        </div>
    </section>

    <!-- === Founders Section (Dynamic) === -->
    <section class="about-founders">
        <div class="container">
            <h2>Meet Our Founders</h2>

            <?php
            $founders = [];
            for ($i = 1; $i <= 4; $i++) {
                $name     = get_theme_mod("founder_{$i}_name");
                $title    = get_theme_mod("founder_{$i}_title");
                $quote    = get_theme_mod("founder_{$i}_quote");
                $image    = get_theme_mod("founder_{$i}_image");
                $linkedin = get_theme_mod("founder_{$i}_linkedin");

                if ($name || $title || $quote || $image || $linkedin) {
                    $founders[] = compact('name', 'title', 'quote', 'image', 'linkedin');
                }
            }

            shuffle($founders); // Randomize order

            if (!empty($founders)) :
                foreach ($founders as $founder) :
                    // Randomly assign reverse layout about 50% of the time
                    $reverse = rand(0, 1) ? ' reverse' : '';
            ?>
                    <div class="founder-card<?php echo $reverse; ?>">

                        <div class="founder-photo">
                            <?php if (!empty($founder['image'])) : ?>
                                <img src="<?php echo esc_url($founder['image']); ?>"
                                    alt="<?php echo esc_attr($founder['name']); ?>" loading="lazy">
                            <?php endif; ?>
                        </div>

                        <div class="founder-info">
                            <div class="founder-header">
                                <h3><?php echo esc_html($founder['name']); ?></h3>
                                <?php if (!empty($founder['linkedin'])) : ?>
                                    <a class="founder-linkedin" href="<?php echo esc_url($founder['linkedin']); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn profile of <?php echo esc_attr($founder['name']); ?>">
                                        <span class="dashicons dashicons-linkedin" aria-hidden="true"></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <p class="founder-title"><?php echo esc_html($founder['title']); ?></p>
                            <blockquote><?php echo esc_html($founder['quote']); ?></blockquote>
                        </div>

                    </div>
            <?php endforeach;
            endif; ?>
        </div>
    </section>




    <!-- === Timeline Section (Milestones) === -->
    <section class="about-timeline" aria-labelledby="timeline-heading">
        <h2 id="timeline-heading">Our Journey</h2>

        <div class="timeline-container">
            <div class="timeline">

                <?php
                $timeline_query = new WP_Query(array(
                    'post_type'      => 'timeline',
                    'posts_per_page' => -1,
                    'orderby'        => 'meta_value',
                    'meta_key'       => 'timeline_year',
                    'order'          => 'ASC'
                ));

                if ($timeline_query->have_posts()) :
                    while ($timeline_query->have_posts()) : $timeline_query->the_post();

                        $year = get_field('timeline_year'); // ACF field
                ?>
                        <div class="timeline-item">
                            <span class="year"><?php the_title(); ?></span>
                            <p><?php echo wp_kses_post(get_the_content()); ?></p>
                        </div>

                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>No timeline events found.</p>';
                endif;
                ?>

            </div>
        </div>
    </section>


</main>

<?php get_footer(); ?>