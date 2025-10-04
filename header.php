<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO: Dynamic title -->
    <title>
        <?php
        if (is_front_page()) {
            bloginfo('name');
            echo ' | ';
            bloginfo('description');
        } elseif (is_single() || is_page()) {
            the_title();
            echo ' | ';
            bloginfo('name');
        } elseif (is_archive()) {
            wp_title('');
            echo ' | ';
            bloginfo('name');
        } else {
            bloginfo('name');
        }
        ?>
    </title>

    <!-- SEO: Meta description -->
    <?php if (is_single() || is_page()) : ?>
        <meta name="description" content="<?php echo esc_attr(get_the_excerpt()); ?>">
    <?php else : ?>
        <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php endif; ?>

    <!-- SEO: Canonical URL -->
    <link rel="canonical" href="<?php echo esc_url(get_permalink()); ?>">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header class="navbar" role="banner">
        <!-- Left logo/icon -->
        <div class="navbar-logo">
            <a href="<?php echo home_url('/'); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/logo.png" alt="<?php bloginfo('name'); ?> Logo">
            </a>
        </div>

        <!-- Middle navigation -->
        <nav class="navbar-links" role="navigation" aria-label="Main Navigation">
            <a href="<?php echo home_url('/'); ?>">Home</a>
            <a href="https://shopee.sg/countingsheepproject" target="_blank" rel="noopener noreferrer">Shop</a>
        </nav>

        <!-- Mobile menu button (hamburger) -->
        <button class="navbar-toggle" aria-label="Open menu">
            ☰
        </button>
    </header>
