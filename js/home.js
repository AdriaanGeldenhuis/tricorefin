/* =========================================================
   Tri-Core Financial Group — homepage behaviour
   Hero ink, subtle parallax, scroll story, enquiry form (posts to /api/enquiry.php)
   ========================================================= */
(function () {
    'use strict';

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------- Hero: draw annotations after the headline lands ---------- */
    var hero = document.querySelector('.hero');
    if (hero) {
        if (reduceMotion) {
            hero.classList.add('is-drawn');
        } else {
            window.setTimeout(function () { hero.classList.add('is-drawn'); }, 150);
        }
    }

    /* ---------- Scroll-driven: hero parallax + story ---------- */
    var arch = document.querySelector('.hero-arch');
    var story = document.querySelector('.story');
    var storyLine = document.getElementById('storyLine');
    var words = story ? story.querySelectorAll('.story-word') : [];
    var lines = story ? story.querySelectorAll('.story-line') : [];
    var steps = story ? story.querySelectorAll('.story-steps li') : [];
    var points = story ? story.querySelectorAll('.sc-points circle') : [];
    var notes = story ? story.querySelectorAll('.sc-note') : [];
    var currentStage = -1;

    // Short screens (landscape phones) can't fit the pinned story, so it falls back to a normal stacked layout.
    function syncStoryMode() {
        if (story) story.classList.toggle('is-static', reduceMotion || window.innerHeight < 600);
    }

    function clamp(v, min, max) { return Math.min(max, Math.max(min, v)); }

    function setStage(stage) {
        if (stage === currentStage) return;
        currentStage = stage;
        for (var i = 0; i < words.length; i++) {
            words[i].classList.toggle('is-active', i === stage);
            words[i].classList.toggle('is-past', i < stage);
            if (lines[i]) lines[i].classList.toggle('is-active', i === stage);
            if (steps[i]) {
                steps[i].classList.toggle('is-active', i === stage);
                steps[i].classList.toggle('is-done', i < stage);
            }
        }
    }

    function updateStory(rect) {
        var travel = rect.height - window.innerHeight;
        if (travel <= 0) return;
        var p = clamp(-rect.top / travel, 0, 1);

        var drawn = clamp((p - 0.04) / 0.88, 0, 1);
        if (storyLine) storyLine.style.strokeDashoffset = String(1 - drawn);

        for (var i = 0; i < points.length; i++) {
            var on = drawn >= (i + 1) / points.length - 0.03;
            points[i].classList.toggle('is-on', on);
            if (notes[i]) notes[i].classList.toggle('is-on', on);
        }

        setStage(Math.min(words.length - 1, Math.floor(p * words.length)));
    }

    var ticking = false;
    function onScroll() {
        // Read layout first, then write, so the browser never has to recalculate mid-frame.
        var y = window.scrollY || window.pageYOffset;
        var storyRect = story && !story.classList.contains('is-static') ? story.getBoundingClientRect() : null;

        if (arch && y < window.innerHeight * 1.2) {
            arch.style.transform = 'translate3d(0,' + (y * 0.06).toFixed(1) + 'px,0)';
        }
        if (storyRect) updateStory(storyRect);
        ticking = false;
    }

    if (!reduceMotion) {
        window.addEventListener('scroll', function () {
            if (!ticking) { window.requestAnimationFrame(onScroll); ticking = true; }
        }, { passive: true });
        window.addEventListener('resize', function () { syncStoryMode(); onScroll(); });
    }
    // First measurement waits for the next frame, after the initial styles have settled.
    window.requestAnimationFrame(function () {
        syncStoryMode();
        if (!reduceMotion) onScroll();
    });

    /* ---------- "Discuss your requirements" pre-selects the service ---------- */
    var serviceSelect = document.getElementById('fService');
    document.querySelectorAll('[data-service]').forEach(function (link) {
        link.addEventListener('click', function () {
            if (!serviceSelect) return;
            var wanted = link.getAttribute('data-service');
            for (var i = 0; i < serviceSelect.options.length; i++) {
                if (serviceSelect.options[i].text === wanted) { serviceSelect.selectedIndex = i; break; }
            }
        });
    });

    /* ---------- Enquiry form ----------
       Validated here for instant feedback, then sent with fetch() to /api/enquiry.php, which
       validates everything again. Without JavaScript the form posts there directly. */
    var form = document.getElementById('enquiryForm');
    var statusEl = document.getElementById('formStatus');
    var directEmail = form ? form.getAttribute('data-email') : '';

    function setError(field, message) {
        var wrap = field.closest('.field');
        if (!wrap) return;
        var existing = wrap.querySelector('.field-error');
        if (message) {
            wrap.classList.add('is-invalid');
            field.setAttribute('aria-invalid', 'true');
            if (!existing) {
                existing = document.createElement('span');
                existing.className = 'field-error';
                existing.id = field.id + 'Error';
                wrap.appendChild(existing);
                field.setAttribute('aria-describedby', existing.id);
            }
            existing.textContent = message;
        } else {
            wrap.classList.remove('is-invalid');
            field.removeAttribute('aria-invalid');
            if (existing) existing.remove();
            field.removeAttribute('aria-describedby');
        }
    }

    function validate(field) {
        var v = field.type === 'checkbox' ? field.checked : field.value.trim();
        var msg = '';
        if (field.required && !v) {
            msg = field.type === 'checkbox' ? 'Please confirm to continue.' : 'This field is required.';
        } else if (field.type === 'email' && v && !/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v)) {
            msg = 'Please enter a valid email address.';
        } else if (field.type === 'tel' && v && !/^[0-9 +()\-]{7,30}$/.test(v)) {
            msg = 'Please enter a valid telephone number.';
        } else if (field.name === 'message' && v && v.length < 10) {
            msg = 'Please add a little more detail (at least 10 characters).';
        }
        setError(field, msg);
        return !msg;
    }

    // Shows a message under the form; failures also offer a direct email link.
    function showStatus(kind, message, offerEmail) {
        statusEl.className = 'form-status is-' + kind;
        statusEl.textContent = message + (offerEmail ? ' ' : '');
        if (offerEmail && directEmail) {
            var a = document.createElement('a');
            a.href = 'mailto:' + directEmail;
            a.textContent = directEmail;
            statusEl.appendChild(a);
        }
    }

    function setBusy(button, busy) {
        var label = button.querySelector('.btn-label');
        button.disabled = busy;
        button.setAttribute('aria-busy', busy ? 'true' : 'false');
        if (label) label.textContent = busy ? 'Sending…' : 'Send enquiry';
    }

    if (form && statusEl) {
        var fields = form.querySelectorAll('.field input, .field select, .field textarea');
        var submitBtn = form.querySelector('button[type="submit"]');

        fields.forEach(function (f) {
            f.addEventListener('blur', function () { if (f.value || f.type === 'checkbox') validate(f); });
            f.addEventListener('input', function () {
                if (f.closest('.field').classList.contains('is-invalid')) validate(f);
            });
        });

        form.addEventListener('submit', function (e) {
            var firstBad = null;
            fields.forEach(function (f) {
                if (!validate(f) && !firstBad) firstBad = f;
            });
            if (firstBad) { e.preventDefault(); firstBad.focus(); return; }

            if (!window.fetch || !window.FormData) return;   // let the browser post the form normally
            e.preventDefault();

            setBusy(submitBtn, true);
            statusEl.className = 'form-status';
            statusEl.textContent = '';

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            })
                .then(function (res) {
                    return res.json().catch(function () { return { ok: false, status: 'error' }; });
                })
                .then(function (res) {
                    if (res.ok) {
                        form.reset();
                        showStatus('success', res.message || 'Thank you — your enquiry has been sent.', false);
                        return;
                    }
                    var firstServerBad = null;
                    Object.keys(res.errors || {}).forEach(function (name) {
                        var field = form.elements[name];
                        if (field && field.closest) {
                            setError(field, res.errors[name]);
                            if (!firstServerBad) firstServerBad = field;
                        }
                    });
                    if (firstServerBad) firstServerBad.focus();
                    showStatus('error', res.message || 'Something went wrong.', res.status !== 'invalid');
                })
                .catch(function () {
                    showStatus('error', 'We could not reach the server. Please check your connection, or email us at', true);
                })
                .then(function () { setBusy(submitBtn, false); });
        });
    }
})();
