<footer class="site-footer" role="contentinfo" aria-label="Site Footer">
    <div class="footer-container">
        <!-- Left: Site name / copyright -->
        <div class="footer-left">
            <p>&copy; <?php echo date('Y'); ?> Counting Sheep Project. All rights reserved.</p>
        </div>

        <!-- Right: Social media icons -->
        <div class="footer-social">
            <a href="https://www.linkedin.com/company/counting-sheep-project"
                target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"
                title="Follow us on LinkedIn">
                <span class="dashicons dashicons-linkedin" aria-hidden="true"></span>
            </a>
            <a href="https://www.instagram.com/countingsheepproject/"
                target="_blank" rel="noopener noreferrer" aria-label="Instagram"
                title="Follow us on Instagram">
                <span class="dashicons dashicons-instagram" aria-hidden="true"></span>
            </a>
            <a href="https://linktr.ee/countingsheep.sg"
                target="_blank" rel="noopener noreferrer" aria-label="Linktree"
                title="Visit our Linktree">
                <span class="dashicons dashicons-admin-links" aria-hidden="true"></span>
            </a>
            <button class="contact-us-btn" aria-haspopup="dialog" aria-controls="dynamic-form-modal">Contact Us</button>
        </div>
    </div>

    <!-- Easter Egg Popup -->
    <div id="easter-egg-popup" role="dialog" aria-modal="true" aria-labelledby="easter-egg-title" hidden>
        <h3 id="easter-egg-title">👋 Hello there</h3>
        <p>I’m Coben Yap and I developed this site.</p>
        <a href="https://www.linkedin.com/in/cobenyap/" target="_blank" rel="noopener noreferrer" title="View Coben Yap's LinkedIn">View my LinkedIn</a>
        <button id="close-easter-egg" aria-label="Close Easter Egg">✖</button>
    </div>
</footer>

<!-- Dynamic Form Modal -->
<div id="dynamic-form-modal" class="modal" role="dialog" aria-modal="true" aria-labelledby="form-title" hidden>
    <span class="close" aria-label="Close">&times;</span>
    <div class="modal-content form-modal">
        <h2 id="form-title">RSVP / Contact</h2>

        <div class="forminator-form-wrapper">
            <?php echo do_shortcode('[forminator_form id="4325"]'); ?>
        </div>

        <p id="form-message"></p>
    </div>
</div>


<?php wp_footer(); ?>
</body>

</html>