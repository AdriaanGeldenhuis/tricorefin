/* =========================================================
   Tri-Core Financial Group — shared site behaviour
   Theme toggle, header, mobile menu, mega menu, reveal + ink
   ========================================================= */
(function () {
    'use strict';

    var root = document.documentElement;
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------- Theme ---------- */
    var themeToggle = document.getElementById('themeToggle');

    function syncThemeLabel() {
        if (!themeToggle) return;
        var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        themeToggle.setAttribute('aria-label', 'Switch to ' + next + ' mode');
    }

    if (themeToggle) {
        syncThemeLabel();
        themeToggle.addEventListener('click', function () {
            var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-theme', next);
            try { localStorage.setItem('tricore-theme', next); } catch (err) { /* storage blocked */ }
            syncThemeLabel();
        });
    }

    /* ---------- Header state ---------- */
    var header = document.getElementById('siteHeader');
    var mobileCta = document.getElementById('mobileCta');
    var contact = document.getElementById('contact');
    var ticking = false;

    function onScroll() {
        var y = window.scrollY || window.pageYOffset;
        if (header) header.classList.toggle('is-scrolled', y > 12);

        if (mobileCta) {
            var pastHero = y > window.innerHeight * 0.8;
            var nearContact = false;
            if (contact) {
                var r = contact.getBoundingClientRect();
                nearContact = r.top < window.innerHeight && r.bottom > 0;
            }
            var show = pastHero && !nearContact;
            mobileCta.classList.toggle('is-shown', show);
            mobileCta.setAttribute('aria-hidden', show ? 'false' : 'true');
            mobileCta.tabIndex = show ? 0 : -1;
        }
        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) { window.requestAnimationFrame(onScroll); ticking = true; }
    }, { passive: true });
    onScroll();

    /* ---------- Mobile menu ---------- */
    var menuToggle = document.getElementById('menuToggle');
    var nav = document.getElementById('primaryNav');

    function setMenu(open) {
        if (!menuToggle || !nav) return;
        nav.classList.toggle('is-open', open);
        document.body.classList.toggle('menu-open', open);
        menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        menuToggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    }

    if (menuToggle && nav) {
        menuToggle.addEventListener('click', function () {
            setMenu(!nav.classList.contains('is-open'));
        });
        nav.addEventListener('click', function (e) {
            if (e.target.closest('a')) setMenu(false);
        });
        window.addEventListener('resize', function () {
            if (window.innerWidth > 920) setMenu(false);
        });
    }

    /* ---------- Mega menu ---------- */
    var megaTrigger = document.querySelector('.mega-trigger');
    var mega = document.getElementById('megaServices');

    function setMega(open) {
        if (!megaTrigger || !mega) return;
        megaTrigger.setAttribute('aria-expanded', open ? 'true' : 'false');
        mega.classList.toggle('is-open', open);
    }

    if (megaTrigger && mega) {
        megaTrigger.addEventListener('click', function () {
            setMega(megaTrigger.getAttribute('aria-expanded') !== 'true');
        });
        mega.addEventListener('click', function (e) {
            if (e.target.closest('a')) setMega(false);
        });
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.has-mega')) setMega(false);
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        if (mega && mega.classList.contains('is-open')) { setMega(false); megaTrigger.focus(); }
        if (nav && nav.classList.contains('is-open')) { setMenu(false); menuToggle.focus(); }
    });

    /* ---------- Reveal + hand-drawn ink ---------- */
    var revealTargets = document.querySelectorAll('.reveal, .section .ink, .cta .ink, .hand-write:not(.hero .hand-write)');

    if (reduceMotion || !('IntersectionObserver' in window)) {
        revealTargets.forEach(function (el) { el.classList.add('is-visible', 'is-drawn'); });
        return;
    }

    // Stagger siblings that reveal together.
    document.querySelectorAll('.values, .core-grid, .why-grid, .ind-grid, .steps').forEach(function (group) {
        Array.prototype.forEach.call(group.querySelectorAll('.reveal'), function (el, i) {
            el.style.setProperty('--d', (i * 0.09).toFixed(2) + 's');
        });
    });

    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible', 'is-drawn');
            io.unobserve(entry.target);
        });
    }, { threshold: 0.2, rootMargin: '0px 0px -8% 0px' });

    revealTargets.forEach(function (el) { io.observe(el); });
})();
