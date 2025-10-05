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
        });
    }

    // ---------- Contact / Dynamic Form Modal ----------
    const formModal = document.getElementById('dynamic-form-modal');
    const dynamicForm = document.getElementById('dynamic-form');
    if (formModal && dynamicForm) {
        const formCloseBtn = formModal.querySelector('.close');
        const formTitle = document.getElementById('form-title');
        const formMode = document.getElementById('form-mode');
        const workshopField = document.getElementById('workshop-name');

        function openFormModal(mode, workshopName = '') {
            if (!formModal || !formTitle || !formMode || !workshopField) return;

            formMode.value = mode;

            if (mode === 'rsvp') {
                formTitle.textContent = "RSVP for " + workshopName;
                workshopField.value = workshopName;
                workshopField.parentElement.style.display = 'block';
            } else if (mode === 'contact') {
                formTitle.textContent = "Contact Us";
                workshopField.value = '';
                workshopField.parentElement.style.display = 'none';
            }

            formModal.style.display = 'block';
        }

        if (formCloseBtn) {
            formCloseBtn.addEventListener('click', () => {
                formModal.style.display = 'none';
            });
        }

        formModal.addEventListener('click', e => {
            if (e.target === formModal) formModal.style.display = 'none';
        });

        document.querySelectorAll('.rsvp-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const workshop = btn.dataset.workshop || '';
                openFormModal('rsvp', workshop);
            });
        });

        const contactBtn = document.querySelector('.contact-us-btn');
        if (contactBtn) {
            contactBtn.addEventListener('click', () => openFormModal('contact'));
        }

        dynamicForm.addEventListener('submit', e => {
            e.preventDefault();
            const formData = new FormData(dynamicForm);

            // Optional AJAX submission here
            // const response = await fetch('<?php echo admin_url('admin-ajax.php'); ?>', { method: 'POST', body: formData });

            document.getElementById('form-message').textContent = "Submitted successfully!";
            dynamicForm.reset();
            formModal.style.display = 'none';
        });
    }

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
                    openBrochureModal(brochure, title, text);
                }
            });
        });
    }

    attachPostCardListeners();

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
                    attachPostCardListeners(); // rebind new cards
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
