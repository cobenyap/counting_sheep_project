<?php get_header(); ?>

<main role="main">
    <!-- Hero Section -->
    <section class="hero" role="banner">
        <div class="hero-content">
            <h1>Better Sleep Starts Here</h1>
            <p>Count sheep, rest easy, and wake refreshed.</p>
        </div>

        <!-- Sheep + Fence -->
        <div class="hero-animation" aria-hidden="true">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/sheep.gif"
                alt="Animated sheep jumping over a fence" class="sheep" loading="lazy">
            <div class="fence"></div>
        </div>
    </section>

    <!-- Latest Posts Section -->
    <section class="latest-posts" aria-labelledby="latest-news-heading">
        <div class="latest-header">
            <h2 id="latest-news-heading">Latest News</h2>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('all-posts'))); ?>" class="view-all-btn">View All</a>
        </div>

        <div class="posts-container">
            <?php
            $latest_posts = new WP_Query(array(
                'posts_per_page' => 3,
                'post_status'    => 'publish',
            ));

            if ($latest_posts->have_posts()) :
                while ($latest_posts->have_posts()) : $latest_posts->the_post();
                    $type     = get_post_meta(get_the_ID(), 'post_type', true);
                    $brochure = wp_get_attachment_url(get_post_meta(get_the_ID(), 'brochure_image', true));
                    $link     = get_post_meta(get_the_ID(), 'post_link', true);
                    $thumbnail = has_post_thumbnail()
                        ? get_the_post_thumbnail_url(get_the_ID(), 'medium')
                        : get_template_directory_uri() . '/assets/logo_icon.png';
            ?>
                    <article class="post-card"
                        data-id="<?php echo get_the_ID(); ?>"
                        data-slug="<?php echo sanitize_title(get_the_title()); ?>"
                        data-type="<?php echo esc_attr($type); ?>"
                        data-link="<?php echo esc_url($link); ?>"
                        data-brochure="<?php echo esc_url($brochure); ?>"
                        itemscope itemtype="https://schema.org/BlogPosting">

                        <img src="<?php echo esc_url($thumbnail); ?>"
                            alt="<?php the_title_attribute(); ?>"
                            itemprop="image" loading="lazy">

                        <h3 itemprop="headline"><?php the_title(); ?></h3>
                        <p itemprop="description"><?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?></p>

                        <meta itemprop="url" content="<?php the_permalink(); ?>" />
                        <meta itemprop="datePublished" content="<?php echo get_the_date('c'); ?>" />
                        <meta itemprop="author" content="<?php the_author(); ?>" />
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else : ?>
                <h2>No posts found.</h2>
            <?php endif; ?>
        </div>
    </section>

    <!-- Sponsors Section -->
    <section class="sponsors" aria-labelledby="sponsors-heading">
        <h2 id="sponsors-heading">Our Partners</h2>
        <div class="sponsors-container">
            <?php
            $sponsors = [
                [
                    'name' => 'National Youth Council',
                    'logo' => 'https://isomer-user-content.by.gov.sg/139/218fed0b-dfd3-408b-921d-22eee54dce86/NYC_2025_Logo_RGB.png',
                    'url'  => 'https://www.nyc.gov.sg/'
                ],
                [
                    'name' => 'Humanistic Youth Council',
                    'logo' => 'https://hyc.tzuchi.org.sg/media/images/HYC_Logo_trans.original.png',
                    'url'  => 'https://hyc.tzuchi.org.sg/'
                ],
                [
                    'name' => 'Singapore Association of Social Workers',
                    'logo' => 'https://sasw.org.sg/wp-content/uploads/2020/12/sasw-logo.png',
                    'url'  => 'https://sasw.org.sg/'
                ],
                [
                    'name' => 'Youth Action Challenge Season 5',
                    'logo' => 'https://countingsheepproject.com/wp-content/uploads/2025/03/YAC-Season-5-Logo.png',
                    'url'  => 'https://www.nyc.gov.sg/key-initiatives/youth-action-challenge'
                ],
            ];

            foreach ($sponsors as $sponsor) : ?>
                <a href="<?php echo esc_url($sponsor['url']); ?>" target="_blank" rel="noopener noreferrer" class="sponsor-card">
                    <img src="<?php echo esc_url($sponsor['logo']); ?>"
                        alt="<?php echo esc_attr($sponsor['name']); ?>" loading="lazy">
                    <span class="visually-hidden"><?php echo esc_html($sponsor['name']); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Contact Call-to-Action Section -->
    <section class="contact-cta" aria-labelledby="contact-cta-heading">
        <div class="contact-cta-content">
            <h2 id="contact-cta-heading">Get in Touch With Us</h2>
            <p>Have questions or want to collaborate? We’d love to hear from you.</p>
            <button class="contact-cta-btn" aria-haspopup="dialog" aria-controls="dynamic-form-modal">
                Contact Us
            </button>
        </div>
    </section>

    <!-- Brochure Modal -->
    <div id="brochure-modal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title" hidden>
        <span class="close" aria-label="Close">&times;</span>
        <div class="modal-content brochure-modal">
            <div class="brochure-left">
                <img id="modal-img" alt="Brochure image" loading="lazy">
            </div>
            <div class="brochure-right">
                <h3 id="modal-title"></h3>
                <p id="modal-text"></p>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>