<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?php echo is_singular() ? 'article' : 'website'; ?>" />
    <meta property="og:title" content="<?php echo wp_get_document_title(); ?>" />
    <meta property="og:description" content="<?php echo is_singular() ? esc_attr(wp_strip_all_tags(get_the_excerpt())) : esc_attr(get_bloginfo('description')); ?>" />
    <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>" />
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />

    <?php if (is_singular() && has_post_thumbnail()) : ?>
        <meta property="og:image" content="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" />
    <?php else : ?>
        <meta property="og:image" content="<?php echo esc_url(get_template_directory_uri() . '/assets/logo_with_text.png'); ?>" />
    <?php endif; ?>

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo wp_get_document_title(); ?>" />
    <meta name="twitter:description" content="<?php echo is_singular() ? esc_attr(wp_strip_all_tags(get_the_excerpt())) : esc_attr(get_bloginfo('description')); ?>" />

    <?php if (is_singular() && has_post_thumbnail()) : ?>
        <meta name="twitter:image" content="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" />
    <?php else : ?>
        <meta name="twitter:image" content="<?php echo esc_url(get_template_directory_uri() . '/assets/logo_with_text.png'); ?>" />
    <?php endif; ?>


    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO: Meta description -->
    <?php if (is_singular()) : ?>
        <meta name="description" content="<?php echo esc_attr(wp_strip_all_tags(get_the_excerpt(), true)); ?>">
    <?php else : ?>
        <meta name="description" content="<?php echo esc_attr(get_bloginfo('description')); ?>">
    <?php endif; ?>

    <!-- SEO: Canonical URL -->
    <link rel="canonical" href="<?php echo esc_url(wp_get_canonical_url()); ?>">

    <!-- Favicons (recommended for SEO + branding) -->
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/favicon.ico" type="image/x-icon">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header class="navbar" role="banner">
        <!-- Left logo/icon -->
        <div class="navbar-logo">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/logo_with_text.png"
                    alt="<?php echo esc_attr(get_bloginfo('name')); ?> Logo">
            </a>
        </div>

        <!-- Middle navigation -->
        <nav class="navbar-links" role="navigation" aria-label="Main Navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'header_menu',
                'container'      => false,
                'menu_class'     => 'navbar-links-list',
                'fallback_cb'    => false,
                'depth'          => 1,
            ));
            ?>
        </nav>


        <!-- Mobile menu button (hamburger) -->
        <button class="navbar-toggle" aria-label="Open menu">
            ☰
        </button>
    </header>