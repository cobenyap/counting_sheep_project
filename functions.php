<?php
// === Theme Setup ===
function mytheme_setup()
{
    // Post thumbnails (featured images) support
    add_theme_support('post-thumbnails', array('post'));

    // Title tag support (lets WP manage <title> for SEO)
    add_theme_support('title-tag');

    // HTML5 markup support for cleaner SEO-friendly code
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));

    // Add automatic feed links for SEO / RSS
    add_theme_support('automatic-feed-links');
}
add_action('after_setup_theme', 'mytheme_setup');


// === Enqueue Google Fonts (Nunito) ===
function mytheme_enqueue_fonts()
{
    wp_enqueue_style(
        'nunito-font',
        'https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap',
        array(),
        null, // let Google handle versioning
        'all'
    );
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_fonts');


// === Enqueue Theme Assets ===
function mytheme_enqueue_assets()
{
    // Main stylesheet (cache-busted)
    wp_enqueue_style(
        'mytheme-style',
        get_stylesheet_uri(),
        array(),
        filemtime(get_stylesheet_directory() . '/style.css'),
        'all'
    );

    // Main JS (cache-busted, footer-loaded)
    wp_enqueue_script(
        'mytheme-script',
        get_template_directory_uri() . '/script.js',
        array(),
        filemtime(get_template_directory() . '/script.js'),
        true
    );

    // Localize script for AJAX calls
    wp_localize_script('mytheme-script', 'cs_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_assets');

// Enable Dashicons on frontend
function mytheme_load_dashicons()
{
    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'mytheme_load_dashicons');


// === AJAX Filter Posts ===
function cs_ajax_filter_posts()
{
    $search_query = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $date_filter  = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        's'              => $search_query,
    );

    if ($date_filter) {
        $args['m'] = $date_filter; // WP expects YYYYMM
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
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
                    alt="<?php echo esc_attr(get_the_title()); ?>"
                    itemprop="image" loading="lazy">

                <h3 itemprop="headline"><?php the_title(); ?></h3>
                <p itemprop="description"><?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?></p>

                <meta itemprop="url" content="<?php the_permalink(); ?>" />
                <meta itemprop="datePublished" content="<?php echo get_the_date('c'); ?>" />
                <meta itemprop="author" content="<?php the_author(); ?>" />
            </article>
    <?php
        endwhile;
    else :
        echo "<h2>No posts found.</h2>";
    endif;

    wp_die();
}
add_action('wp_ajax_cs_filter_posts', 'cs_ajax_filter_posts');
add_action('wp_ajax_nopriv_cs_filter_posts', 'cs_ajax_filter_posts');

function mytheme_add_schema()
{
    ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "Counting Sheep Project",
            "url": "<?php echo esc_url(home_url('/')); ?>",
            "logo": "<?php echo esc_url(get_template_directory_uri() . '/assets/logo_with_text.png'); ?>",
            "sameAs": [
                "https://www.linkedin.com/company/counting-sheep-project",
                "https://www.instagram.com/countingsheepproject/",
                "https://linktr.ee/countingsheep.sg"
            ]
        }
    </script>
<?php
}
add_action('wp_footer', 'mytheme_add_schema');
