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

        <div class="posts-filter-form">
            <div class="search-wrapper">
                <input type="text" id="search-posts" placeholder="Search posts...">
                <button type="button" id="search-icon" aria-label="Search">
                    <span class="dashicons dashicons-search"></span>
                </button>
            </div>

            <select id="filter-date">
                <option value="">All Dates</option>
                <?php
                global $wpdb;
                $months = $wpdb->get_results("
            SELECT DISTINCT YEAR(post_date) AS year, MONTH(post_date) AS month 
            FROM $wpdb->posts 
            WHERE post_type='post' AND post_status='publish' 
            ORDER BY post_date DESC
        ");
                foreach ($months as $m) :
                    $month = zeroise($m->month, 2);
                    $value = $m->year . $month;
                    $label = date("F Y", mktime(0, 0, 0, $m->month, 1, $m->year));
                    echo "<option value='$value'>$label</option>";
                endforeach;
                ?>
            </select>
        </div>

        <div class="posts-container" id="posts-results">
            <!-- Results will be injected here -->
        </div>

    </section>

    <!-- Brochure Modal -->
    <div id="brochure-modal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <span class="close" aria-label="Close">&times;</span>
        <div class="modal-content brochure-modal">
            <div class="brochure-left">
                <button class="brochure-nav-arrow prev" aria-label="Previous image">&#10094;</button>

                <div class="brochure-image-slider">
                    <!-- Images will be injected here later -->
                    <img class="slide active" src="" alt="Brochure image">
                </div>

                <button class="brochure-nav-arrow next" aria-label="Next image">&#10095;</button>
            </div>

            <div class="brochure-right">
                <h3 id="modal-title"></h3>
                <p id="modal-text"></p>
            </div>
        </div>
    </div>

</main>

<?php get_footer(); ?>