<?php
/*
Template Name: All Posts
*/
get_header();
?>

<main class="all-posts-page" role="main">

    <section class="all-posts">
        <header>
            <h1>All Blog Posts</h1>
        </header>

        <div class="posts-container">
            <?php
            $all_posts = new WP_Query(array(
                'posts_per_page' => -1, // all posts
                'post_status'    => 'publish',
            ));

            if ($all_posts->have_posts()) :
                while ($all_posts->have_posts()) : $all_posts->the_post();
                    $type = get_post_meta(get_the_ID(), 'post_type', true);
                    $brochure = wp_get_attachment_url(get_post_meta(get_the_ID(), 'brochure_image', true));
                    $link = get_post_meta(get_the_ID(), 'post_link', true);
                    $thumbnail = has_post_thumbnail()
                        ? get_the_post_thumbnail_url(get_the_ID(), 'medium')
                        : get_template_directory_uri() . '/assets/logo.png';
            ?>
                    <article class="post-card"
                        data-type="<?php echo esc_attr($type); ?>"
                        data-link="<?php echo esc_url($link); ?>"
                        data-brochure="<?php echo esc_url($brochure); ?>"
                        itemscope itemtype="https://schema.org/BlogPosting">


                        <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" itemprop="image">


                        <h3 itemprop="headline">
                            <?php the_title(); ?>
                        </h3>

                        <p itemprop="description"><?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?></p>
                    </article>
                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <h2>No posts found.</h2>
            <?php endif; ?>
        </div>
    </section>

    <!-- Brochure Modal -->
    <div id="brochure-modal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title" hidden>
        <span class="close" aria-label="Close">&times;</span>
        <div class="modal-content brochure-modal">
            <div class="brochure-left">
                <img id="modal-img" alt="Brochure">
            </div>
            <div class="brochure-right">
                <h3 id="modal-title"></h3>
                <p id="modal-text"></p>
            </div>
        </div>
    </div>

</main>

<?php get_footer(); ?>