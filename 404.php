<?php get_header(); ?>

<main class="error-page" role="main" itemscope itemtype="https://schema.org/WebPage">
    <section class="error-hero">
        <header>
            <h1 itemprop="name">Oops! Page Not Found 🐑</h1>
            <p>Looks like this sheep wandered off…</p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="error-btn">Take Me Home</a>
        </header>

        <div class="error-graphic" aria-hidden="true">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/sheep.gif" alt="" loading="lazy">
        </div>
    </section>
</main>

<?php get_footer(); ?>
