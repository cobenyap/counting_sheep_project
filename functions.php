<?php
// === Theme Setup ===
function mytheme_setup()
{
    // Post thumbnails (featured images) support
    // page thumbnails support
    add_theme_support('post-thumbnails', array('post', 'page'));

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

// Register custom menus for header and footer
function cs_register_menus()
{
    register_nav_menus(array(
        'header_menu' => __('Header Menu', 'countingsheep'),
        'footer_menu' => __('Footer Menu', 'countingsheep'),
    ));
}
add_action('after_setup_theme', 'cs_register_menus');


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


add_action('customize_register', function ($wp_customize) {

    $wp_customize->add_panel('csp_about_panel', [
        'title'    => __('About Sections', 'counting-sheep'),
        'priority' => 160,
    ]);

    for ($i = 1; $i <= 3; $i++) {
        $section_id = "csp_about_{$i}";
        $wp_customize->add_section($section_id, [
            'title' => "About Section {$i}",
            'panel' => 'csp_about_panel',
        ]);

        // Title
        $wp_customize->add_setting("csp_about_{$i}_title", [
            'default' => "About Section {$i} Title",
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("csp_about_{$i}_title", [
            'label' => __('Title', 'counting-sheep'),
            'section' => $section_id,
            'type' => 'text',
        ]);

        // Paragraph
        $wp_customize->add_setting("csp_about_{$i}_text", [
            'default' => "Default paragraph for section {$i}.",
            'sanitize_callback' => 'wp_kses_post',
        ]);
        $wp_customize->add_control("csp_about_{$i}_text", [
            'label' => __('Paragraph', 'counting-sheep'),
            'section' => $section_id,
            'type' => 'textarea',
        ]);

        // 3 images + captions
        for ($j = 1; $j <= 3; $j++) {
            $wp_customize->add_setting("csp_about_{$i}_img{$j}", [
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ]);
            $wp_customize->add_control(new WP_Customize_Image_Control(
                $wp_customize,
                "csp_about_{$i}_img{$j}",
                [
                    'label' => "Image {$j}",
                    'section' => $section_id,
                ]
            ));

            $wp_customize->add_setting("csp_about_{$i}_cap{$j}", [
                'default' => "Caption {$j}",
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control("csp_about_{$i}_cap{$j}", [
                'label' => "Caption {$j}",
                'section' => $section_id,
                'type' => 'text',
            ]);
        }
    }
});

// === Add Founders Section to Customizer ===
// === Add Founders Section to Customizer ===
function countingsheep_customize_register_founders($wp_customize) {
    $wp_customize->add_section('founders_section', array(
        'title'    => __('Founders Section', 'countingsheep'),
        'priority' => 30,
    ));

    // Loop for 4 founders
    for ($i = 1; $i <= 4; $i++) {
        // Founder Image
        $wp_customize->add_setting("founder_{$i}_image");
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                "founder_{$i}_image",
                array(
                    'label'    => __("Founder {$i} Photo", 'countingsheep'),
                    'section'  => 'founders_section',
                    'settings' => "founder_{$i}_image"
                )
            )
        );

        // Founder Name
        $wp_customize->add_setting("founder_{$i}_name", array('default' => ''));
        $wp_customize->add_control("founder_{$i}_name", array(
            'label'   => __("Founder {$i} Name", 'countingsheep'),
            'section' => 'founders_section',
            'type'    => 'text',
        ));

        // Founder Title / Role
        $wp_customize->add_setting("founder_{$i}_title", array('default' => ''));
        $wp_customize->add_control("founder_{$i}_title", array(
            'label'   => __("Founder {$i} Title/Role", 'countingsheep'),
            'section' => 'founders_section',
            'type'    => 'text',
        ));

        // Founder Quote
        $wp_customize->add_setting("founder_{$i}_quote", array('default' => ''));
        $wp_customize->add_control("founder_{$i}_quote", array(
            'label'   => __("Founder {$i} Quote/Message", 'countingsheep'),
            'section' => 'founders_section',
            'type'    => 'textarea',
        ));

        // Founder LinkedIn
        $wp_customize->add_setting("founder_{$i}_linkedin", array('default' => ''));
        $wp_customize->add_control("founder_{$i}_linkedin", array(
            'label'   => __("Founder {$i} LinkedIn URL", 'countingsheep'),
            'section' => 'founders_section',
            'type'    => 'url',
        ));
    }
}
add_action('customize_register', 'countingsheep_customize_register_founders');


function create_timeline_post_type() {

    $labels = array(
        'name'               => 'Timeline',
        'singular_name'      => 'Timeline Item',
        'menu_name'          => 'Timeline',
        'add_new'            => 'Add New Item',
        'add_new_item'       => 'Add New Timeline Item',
        'edit_item'          => 'Edit Timeline Item',
        'new_item'           => 'New Timeline Item',
        'view_item'          => 'View Timeline Item',
        'search_items'       => 'Search Timeline Items',
        'not_found'          => 'No items found',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_rest'       => true, // Gutenberg + API
        'supports'           => array('title', 'editor', 'thumbnail'),
        'has_archive'        => false,
        'menu_icon'          => 'dashicons-clock', // optional icon
    );

    register_post_type('timeline', $args);
}
add_action('init', 'create_timeline_post_type');
