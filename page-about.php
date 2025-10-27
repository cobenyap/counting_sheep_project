<?php
/*
Template Name: About Us
*/
get_header();
?>

<main class="about-us-page" role="main">

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


    <!-- === CEO Section (Optional ACF / Hardcoded fallback) === -->
    <section class="about-ceo">
        <div class="container">
            <div class="ceo-photo">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/ceo.jpg" alt="CEO of Counting Sheep Project" loading="lazy">
            </div>
            <div class="ceo-bio">
                <h2>Message from Our Founder</h2>
                <blockquote>
                    “Making sleep support accessible, engaging, and practical for all.”
                </blockquote>
                <p><strong>Chime Ngawang</strong><br>Co-Founder & CEO, Counting Sheep Project</p>
            </div>
        </div>
    </section>


    <!-- === Timeline Section (Milestones) === -->
    <section class="about-timeline" aria-labelledby="timeline-heading">
        <h2 id="timeline-heading">Our Journey</h2>
        <div class="timeline-container">
            <div class="timeline">
                <div class="timeline-item">
                    <span class="year">2021</span>
                    <p>Conceptualized Counting Sheep Project as a fun approach to better sleep.</p>
                </div>
                <div class="timeline-item">
                    <span class="year">2022</span>
                    <p>Launched our first community workshop and mobile prototype.</p>
                </div>
                <div class="timeline-item">
                    <span class="year">2024</span>
                    <p>Partnered with NYC, HYC, and SASW for youth well-being outreach.</p>
                </div>
                <div class="timeline-item">
                    <span class="year">2025</span>
                    <p>Expanded digital tools and interactive sleep experiences nationwide.</p>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>