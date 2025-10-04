<?php get_header(); ?>

<main class="error-page" role="main">
    <section class="error-hero">
        <header>
            <h1>Oops! Page Not Found 🐑</h1>
            <p>Looks like this sheep wandered off…</p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="error-btn">Take Me Home</a>
        </header>

        <div class="error-graphic" aria-hidden="true">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/sheep.gif" alt="Lost Sheep">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/fence.png" alt="Fence">
        </div>
    </section>
</main>

<?php get_footer(); ?>
