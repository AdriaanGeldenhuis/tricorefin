/* =========================================================
   Tri-Core Financial Group — homepage behaviour
   Hero ink, subtle parallax, scroll story, enquiry form
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

    if (story && reduceMotion) {
        story.classList.add('is-static');
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

    function updateStory() {
        var rect = story.getBoundingClientRect();
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
        var y = window.scrollY || window.pageYOffset;
        if (arch && y < window.innerHeight * 1.2) {
            arch.style.transform = 'translate3d(0,' + (y * 0.06).toFixed(1) + 'px,0)';
        }
        if (story && !story.classList.contains('is-static')) updateStory();
        ticking = false;
    }

    if (!reduceMotion) {
        window.addEventListener('scroll', function () {
            if (!ticking) { window.requestAnimationFrame(onScroll); ticking = true; }
        }, { passive: true });
        window.addEventListener('resize', onScroll);
        onScroll();
    }

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

    /* ---------- Enquiry form (client-side validation) ----------
       Server-side sending (CSRF, rate limiting, validation) is the next build
       step. Until then a valid form opens a pre-filled email instead, so no
       enquiry is silently lost. */
    var form = document.getElementById('enquiryForm');
    var statusEl = document.getElementById('formStatus');

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
        }
        setError(field, msg);
        return !msg;
    }

    if (form) {
        var fields = form.querySelectorAll('input, select, textarea');

        fields.forEach(function (f) {
            f.addEventListener('blur', function () { if (f.value || f.type === 'checkbox') validate(f); });
            f.addEventListener('input', function () {
                if (f.closest('.field').classList.contains('is-invalid')) validate(f);
            });
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var ok = true;
            var firstBad = null;
            fields.forEach(function (f) {
                if (!validate(f)) { ok = false; if (!firstBad) firstBad = f; }
            });
            if (!ok) { firstBad.focus(); return; }

            var data = new FormData(form);
            var to = form.getAttribute('data-email');
            var subject = 'Website enquiry — ' + data.get('service');
            var body = [
                'Name: ' + data.get('name'),
                'Company: ' + (data.get('company') || '-'),
                'Email: ' + data.get('email'),
                'Telephone: ' + (data.get('phone') || '-'),
                'Service: ' + data.get('service'),
                '',
                data.get('message')
            ].join('\n');
            var href = 'mailto:' + to + '?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);

            statusEl.innerHTML = '';
            statusEl.appendChild(document.createTextNode('Thank you. Online submission is being connected — your email app will open with your message ready to send. If it doesn\'t, '));
            var a = document.createElement('a');
            a.href = href;
            a.textContent = 'click here to email ' + to;
            statusEl.appendChild(a);
            statusEl.appendChild(document.createTextNode('.'));

            window.location.href = href;
        });
    }
})();
