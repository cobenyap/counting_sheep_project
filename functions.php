<?php
// Enable post thumbnails
function mytheme_setup()
{
    add_theme_support('post-thumbnails', array('post'));
}
add_action('after_setup_theme', 'mytheme_setup');

// Enqueue Google Fonts (Roboto)
function mytheme_enqueue_fonts()
{
    wp_enqueue_style(
        'nunito-font',
        'https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap',
        false
    );
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_fonts');

// Enqueue CSS & JS
function mytheme_enqueue_assets()
{
    // custom css
    wp_enqueue_style(
        'mytheme-style',
        get_stylesheet_uri(),
        array(),
        filemtime(get_stylesheet_directory() . '/style.css') // cache-busting
    );
    // custom script
    wp_enqueue_script(
        'mytheme-script',
        get_template_directory_uri() . '/script.js',
        array(),
        filemtime(get_template_directory() . '/script.js'), // cache-busting
        true // load in footer
    );
    // 🔑 Pass AJAX URL to JS
    wp_localize_script('mytheme-script', 'cs_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_assets');


// AJAX filter posts
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
        $args['m'] = $date_filter; // WordPress expects YYYYMM
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
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
                data-brochure="<?php echo esc_url($brochure); ?>">

                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php the_title_attribute(); ?>">
                <h3><?php the_title(); ?></h3>
                <p><?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?></p>
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
