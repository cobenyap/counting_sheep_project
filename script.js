document.addEventListener("DOMContentLoaded", () => {
    console.log("JS loaded ✅");

    // ---------- Scroll-triggered sheep jump ----------
    const sheep = document.querySelector(".sheep");

    // Timeline distances (scroll px for each phase)
    const runUpScroll = 50;   // scroll px for run-up
    const jumpScroll = 120;    // scroll px for jump
    const runOutScroll = 200;  // scroll px for run-out

    // Geometry
    const jumpHeight = 150;    // peak height
    const jumpLength = 170;    // forward distance during jump
    const runUpLength = 150;   // forward distance before jump
    const runOutLength = 300;  // forward distance after jump

    // Total scroll for full sequence
    const totalScroll = runUpScroll + jumpScroll + runOutScroll;

    if (sheep) {
        window.addEventListener("scroll", () => {
            let scroll = Math.min(window.scrollY, totalScroll);

            let x = 0;
            let y = 0;

            // --- Phase 1: Run-up ---
            if (scroll <= runUpScroll) {
                let t = scroll / runUpScroll; // 0 → 1
                x = t * runUpLength;
                y = 0;

                // --- Phase 2: Jump ---
            } else if (scroll <= runUpScroll + jumpScroll) {
                let t = (scroll - runUpScroll) / jumpScroll; // 0 → 1
                x = runUpLength + t * jumpLength;
                y = -4 * jumpHeight * (t - 0.5) * (t - 0.5) + jumpHeight;

                // --- Phase 3: Run-out ---
            } else {
                let t = (scroll - runUpScroll - jumpScroll) / runOutScroll; // 0 → 1
                x = runUpLength + jumpLength + t * runOutLength;
                y = 0;
            }

            // Apply transform
            sheep.style.transform = `translateX(${x}px) translateY(${-y}px)`;

            // Handle going behind fence
            if (scroll > runUpScroll + jumpScroll * 0.8) {
                sheep.style.zIndex = 1;
                // golden filter
                if (scroll > runUpScroll + jumpScroll * 0.95) {
                    sheep.classList.add("happy"); // glow
                }
            }
            else {
                sheep.style.zIndex = 3; // in front
                sheep.classList.remove("happy"); // remove glow
            }
        });
    }

    // ---------- Mobile hamburger toggle ----------
    const toggle = document.querySelector(".navbar-toggle");
    if (toggle) {
        toggle.addEventListener("click", () => {
            document.body.classList.toggle("nav-open");
        });
    }

    const track = document.querySelector(".carousel-track");
    const images = document.querySelectorAll(".carousel-track img");
    const prevBtn = document.querySelector(".carousel-btn.prev");
    const nextBtn = document.querySelector(".carousel-btn.next");
    // ===== Carousel Functionality =====
    if (track && images && prevBtn && nextBtn) {

        if (images.length === 0) return;

        let index = 0;
        const total = images.length;
        let intervalId;

        const updateCarousel = () => {
            track.style.transform = `translateX(-${index * 100}%)`;
        };

        const nextSlide = () => {
            index = (index + 1) % total;
            updateCarousel();
        };

        const prevSlide = () => {
            index = (index - 1 + total) % total;
            updateCarousel();
        };

        // ---- Interval management ----
        const startAutoSlide = () => {
            intervalId = setInterval(nextSlide, 5000);
        };

        const resetAutoSlide = () => {
            clearInterval(intervalId);
            startAutoSlide(); // restart countdown
        };

        // ---- Button events ----
        nextBtn.addEventListener("click", () => {
            nextSlide();
            resetAutoSlide(); // reset on manual click
        });

        prevBtn.addEventListener("click", () => {
            prevSlide();
            resetAutoSlide(); // reset on manual click
        });

        // ---- Start auto-slide ----
        startAutoSlide();
    }

    let scrollPosition = 0;
    // ---------- Brochure Modal ----------
    function openBrochureModal(url, title = "", text = "") {
        const modal = document.getElementById('brochure-modal');
        const modalImg = document.getElementById('modal-img');
        const modalTitle = document.getElementById('modal-title');
        const modalText = document.getElementById('modal-text');

        if (!modal || !modalImg || !modalTitle || !modalText) return;

        // Save current scroll position
        scrollPosition = window.scrollY;

        // Freeze the background but keep visual position
        document.body.style.position = 'fixed';
        document.body.style.top = `-${scrollPosition}px`;
        document.body.style.left = '0';
        document.body.style.right = '0';

        modal.style.display = 'flex';
        modalImg.src = url;
        modalTitle.textContent = title;
        modalText.textContent = text;
    }

    // ---------- Contact / Dynamic Form Modal ----------
    const formModal = document.getElementById('dynamic-form-modal');
    const formCloseBtn = formModal?.querySelector('.close');
    const formTitle = document.getElementById('form-title');
    const contactBtn = document.querySelector('.contact-us-btn');
    const contactCtaBtn = document.querySelector('.contact-cta-btn');

    // Open modal when contact button is clicked
    if (contactBtn) {
        contactBtn.addEventListener('click', openFormModal);
    }
    if (contactCtaBtn) {
        contactCtaBtn.addEventListener('click', openFormModal);
    }

    // Open modal
    function openFormModal() {
        if (!formModal || !formTitle) return;
        formTitle.textContent = "Contact Us";
        formModal.style.display = 'block';
        // Save current scroll position
        scrollPosition = window.scrollY;

        // Freeze the background but keep visual position
        document.body.style.position = 'fixed';
        document.body.style.top = `-${scrollPosition}px`;
        document.body.style.left = '0';
        document.body.style.right = '0';
    }

    // Close modal when X is clicked
    if (formCloseBtn) {
        formCloseBtn.addEventListener('click', () => {
            formModal.style.display = 'none';
            // Restore scroll
            resetScrollModalClose();
        });
    }

    function resetScrollModalClose() {
        // Restore scroll
        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.left = '';
        document.body.style.right = '';
        window.scrollTo(0, scrollPosition);
    }

    // Close modal when background is clicked
    if (formModal) {
        formModal.addEventListener('click', e => {
            if (e.target === formModal) {
                formModal.style.display = 'none';
                resetScrollModalClose();
            }
        });
    }

    // ---------- Post card load for sharing ----------
    function checkBrochureHash() {
        const hash = window.location.hash;
        if (hash.startsWith("#brochure=")) {
            const param = hash.replace("#brochure=", "");
            const parts = param.split("-");
            const postId = parts[parts.length - 1];

            const card = document.querySelector(`.post-card[data-id='${postId}']`);
            if (card) {
                const title = card.querySelector("h3")?.textContent || "";
                const text = card.querySelector("p")?.textContent || "";
                const brochure = card.dataset.brochure;
                openBrochureModal(brochure, title, text);
            } else {
                // If posts aren't loaded yet, try again after 300ms
                setTimeout(checkBrochureHash, 300);
            }
        }
    }
    checkBrochureHash();


    // ---------- Post card clicks ----------
    function attachPostCardListeners() {
        const postCards = document.querySelectorAll(".post-card");
        postCards.forEach(card => {
            card.addEventListener("click", function () {
                const type = this.dataset.type;
                const link = this.dataset.link;
                const brochure = this.dataset.brochure;
                const title = this.querySelector("h3")?.textContent || "";
                const text = this.querySelector("p")?.textContent || "";

                if (type === "link" && link) {
                    window.open(link, "_blank");
                } else if (type === "brochure" && brochure) {
                    const postId = this.getAttribute("data-id");
                    const slug = this.dataset.slug;
                    openBrochureModal(brochure, title, text);

                    // Update URL (slug + ID for uniqueness)
                    const encodedSlug = encodeURIComponent(slug);
                    history.pushState({ brochure: postId }, "", `#brochure=${encodedSlug}-${postId}`);
                }
            });
        });
    }

    attachPostCardListeners();
    // ---------- Post card close ----------
    const brochureModal = document.getElementById('brochure-modal');
    if (brochureModal) {
        const closeBtn = brochureModal.querySelector('.close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                brochureModal.style.display = 'none';
                // Restore scroll
                document.body.style.position = '';
                document.body.style.top = '';
                document.body.style.left = '';
                document.body.style.right = '';
                window.scrollTo(0, scrollPosition);
                history.pushState({}, "", window.location.pathname); // clear hash
            });
        }

        brochureModal.addEventListener('click', e => {
            if (e.target === brochureModal) brochureModal.style.display = 'none';
            // Restore scroll
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.left = '';
            document.body.style.right = '';
            window.scrollTo(0, scrollPosition);
            history.pushState({}, "", window.location.pathname); // clear hash
        });
    }

    const searchInput = document.getElementById("search-posts");
    const dateSelect = document.getElementById("filter-date");
    const results = document.getElementById("posts-results");

    // ---------- all posts page ----------
    if (searchInput && dateSelect && results) {
        function fetchPosts() {
            const search = searchInput.value;
            const date = dateSelect.value;

            const formData = new FormData();
            formData.append("action", "cs_filter_posts");
            formData.append("search", search);
            formData.append("date", date);

            fetch(cs_ajax.ajax_url, {
                method: "POST",
                body: formData
            })
                .then(res => res.text())
                .then(data => {
                    results.innerHTML = data;
                    checkBrochureHash();
                    attachPostCardListeners();
                });
        }

        // Live search with delay
        let searchTimeout;
        searchInput.addEventListener("input", () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(fetchPosts, 500);
        });
        dateSelect.addEventListener("change", fetchPosts);

        // Initial load
        fetchPosts();
    }

    // ---------- Easter Egg ----------
    const easterBtn = document.querySelector(".footer-left p"); // copyright trigger
    const easterPopup = document.getElementById("easter-egg-popup");
    const closeEasterBtn = document.getElementById("close-easter-egg");

    if (easterBtn && easterPopup) {
        let clickCount = 0;
        easterBtn.addEventListener("click", () => {
            clickCount++;
            if (clickCount === 3) {
                easterPopup.style.display = "block";
                clickCount = 0;
            }
            setTimeout(() => clickCount = 0, 600);
        });
    }

    if (closeEasterBtn && easterPopup) {
        closeEasterBtn.addEventListener("click", () => {
            easterPopup.style.display = "none";
        });
    }

});
