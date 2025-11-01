<?php
/*
Template Name: About Us
*/
get_header();
?>

<main class="about-us-page" role="main">
    <div class="floating-particles" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span><span></span>
    </div>

    <!-- === Hero Banner (Featured Image / Big Picture) === -->
    <section class="about-hero">
        <?php if (has_post_thumbnail()) : ?>
            <div class="about-hero-image">
                <?php the_post_thumbnail('full', ['alt' => get_the_title()]); ?>
            </div>
        <?php endif; ?>
        <h1 class="about-hero-title"><?php the_title(); ?></h1>
    </section>

    <!-- === Main Content: Editable through WP Editor === -->
    <section class="about-company">
        <div class="container">
            <?php
            while (have_posts()) : the_post();
                the_content(); // Fully editable block editor content
            endwhile;
            ?>
        </div>
    </section>

    <!-- === Founders Section (Dynamic) === -->
    <section class="about-founders">
        <div class="container">
            <h2>Meet Our Founders</h2>

            <?php
            $founders = [];
            for ($i = 1; $i <= 4; $i++) {
                $name     = get_theme_mod("founder_{$i}_name");
                $title    = get_theme_mod("founder_{$i}_title");
                $quote    = get_theme_mod("founder_{$i}_quote");
                $image    = get_theme_mod("founder_{$i}_image");
                $linkedin = get_theme_mod("founder_{$i}_linkedin");

                if ($name || $title || $quote || $image || $linkedin) {
                    $founders[] = compact('name', 'title', 'quote', 'image', 'linkedin');
                }
            }

            shuffle($founders); // Randomize order

            if (!empty($founders)) :
                foreach ($founders as $founder) :
                    // Randomly assign reverse layout about 50% of the time
                    $reverse = rand(0, 1) ? ' reverse' : '';
            ?>
                    <div class="founder-card<?php echo $reverse; ?>">

                        <div class="founder-photo">
                            <?php if (!empty($founder['image'])) : ?>
                                <img src="<?php echo esc_url($founder['image']); ?>"
                                    alt="<?php echo esc_attr($founder['name']); ?>" loading="lazy">
                            <?php endif; ?>
                        </div>

                        <div class="founder-info">
                            <div class="founder-header">
                                <h3><?php echo esc_html($founder['name']); ?></h3>
                                <?php if (!empty($founder['linkedin'])) : ?>
                                    <a class="founder-linkedin" href="<?php echo esc_url($founder['linkedin']); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn profile of <?php echo esc_attr($founder['name']); ?>">
                                        <span class="dashicons dashicons-linkedin" aria-hidden="true"></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <p class="founder-title"><?php echo esc_html($founder['title']); ?></p>
                            <blockquote><?php echo esc_html($founder['quote']); ?></blockquote>
                        </div>

                    </div>
            <?php endforeach;
            endif; ?>
        </div>
    </section>




    <!-- === Timeline Section (Milestones) === -->
    <section class="about-timeline" aria-labelledby="timeline-heading">
        <h2 id="timeline-heading">Our Journey</h2>
        <div class="timeline-container">
            <div class="timeline">
                <div class="timeline-item">
                    <span class="year">Oct 2023 – Apr 2024</span>
                    <p>Took part in the National Youth Council’s Youth Action Challenge (Season 5),
                        emerging as an awardee under the Well-being & Resilience – Healthy Living category.
                    </p>
                </div>

                <div class="timeline-item">
                    <span class="year">Jul 2024</span>
                    <p>Engaged over 50 participants at HPB’s Project Showcase and developed the first version
                        of the Sleep Activity Booklet.
                    </p>
                </div>

                <div class="timeline-item">
                    <span class="year">Sep 2024</span>
                    <p>Reached over 150 visitors through an interactive booth at Parking Day 2024 held at
                        Tzu Chi Humanistic Youth Centre, in collaboration with Bold at Work.
                        Introduced conversational games on sleep such as Sleep Tarot Cards and Build Your Own Sleep Sanctuary.
                    </p>
                </div>

                <div class="timeline-item">
                    <span class="year">Oct 2024</span>
                    <p>
                        Conducted a public workshop, “Building Better Sleep Habits”, attended by 30 participants,
                        featuring Ms Jamie Ng, Associate Psychologist at a local Polyclinic CBT-I Clinic.
                    </p>
                </div>

                <div class="timeline-item">
                    <span class="year">Jan 2025</span>
                    <p>
                        Ran “Sleep Strategies for Social Workers” workshop with 24 professionals,
                        featuring Ms Jamie Ng as guest speaker.
                    </p>
                </div>

                <div class="timeline-item">
                    <span class="year">Feb 2025</span>
                    <p>
                        Delivered a second “Sleep Strategies for Social Workers” workshop at SASW,
                        attended by 15 professionals, featuring Dr June Lo, Cognitive Psychologist at NUS Medicine.
                    </p>
                </div>

                <div class="timeline-item">
                    <span class="year">Apr 2025</span>
                    <p>
                        Facilitated “Sleep Strategies for Young Families” workshop with 20 parents and
                        children at Yishun FSC’s Kakihealth Community, using Lego play and conversational tools to
                        promote family sleep health.
                    </p>
                </div>

                <div class="timeline-item">
                    <span class="year">May 2025</span>
                    <p>
                        Conducted a second Kakihealth Community workshop with 25 parents and children,
                        using zine-making and guided dialogues on bedtime routines, nutrition, and screen time.
                    </p>
                </div>

                <div class="timeline-item">
                    <span class="year">Jul 2025</span>
                    <p>
                        Organised a public workshop, “Understanding Obstructive Sleep Apnea: What You Can Do and
                        Where Experts Can Help”, attended by 18 participants, featuring Dr Tan Mei Hui, \
                        Oral Surgeon at Mount Elizabeth Novena Specialist Centre.
                    </p>
                </div>

                <div class="timeline-item">
                    <span class="year">Sep 2025</span>
                    <p>
                        Engaged over 200 visitors at Parking Day 2025, held at Jurong East in collaboration with
                        Bold at Work, introducing the Counting Sheep Sleep Assessment Quiz and other interactive tools.
                    </p>
                </div>

                <div class="timeline-item">
                    <span class="year">Oct 2025</span>
                    <p>
                        Reached over 250 participants at Singapore Children’s Society’s YFC Anniversary Carnival,
                        featuring Sleep Myths & Facts Cards and other games for sleep education.
                    </p>
                </div>

                <div class="timeline-item">
                    <span class="year">Nov 2025</span>
                    <p>
                        Hosted “Sleeping Well in Stressful Times” workshop with 20 participants,
                        featuring Dr Leonard Eng, Consultant Psychiatrist at SGH and the SingHealth
                        Duke-NUS Sleep Centre, on managing sleep-related anxiety.
                    </p>
                </div>

            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>