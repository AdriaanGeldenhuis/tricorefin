<?php
declare(strict_types=1);

require __DIR__ . '/includes/helpers.php';
$site = require __DIR__ . '/config/site.php';

$page = [
    'title'       => 'Tri-Core Financial Group | Audit, Accounting & Advisory',
    'description' => $site['description'],
    'path'        => '/',
    'css'         => ['/css/home.css'],
    'js'          => ['/js/home.js'],
];

require __DIR__ . '/includes/header.php';
?>
<main id="main">

    <!-- ============ HERO ============ -->
    <section class="hero" id="top" aria-labelledby="heroTitle">
        <div class="hero-bg" aria-hidden="true">
            <svg class="hero-arch" viewBox="0 0 1200 800" preserveAspectRatio="xMidYMid slice">
                <g class="arch-lines">
                    <path d="M600 -40 L-200 840"/><path d="M600 -40 L80 840"/><path d="M600 -40 L340 840"/>
                    <path d="M600 -40 L600 840"/><path d="M600 -40 L860 840"/><path d="M600 -40 L1120 840"/>
                    <path d="M600 -40 L1400 840"/>
                    <path d="M-100 300 H1300"/><path d="M-100 430 H1300"/><path d="M-100 590 H1300"/><path d="M-100 790 H1300"/>
                </g>
                <g class="arch-tri">
                    <path d="M600 120 L860 570 L340 570 Z"/>
                    <path d="M600 190 L800 536 L400 536 Z"/>
                    <path d="M600 260 L740 502 L460 502 Z"/>
                </g>
            </svg>
            <div class="hero-glow"></div>
        </div>

        <div class="container hero-grid">
            <div class="hero-copy">
                <p class="eyebrow">Audit <i></i> Accounting <i></i> Tax <i></i> Advisory</p>

                <h1 class="hero-title" id="heroTitle">
                    <span class="line"><span class="line-in">Financial <span class="circled">clarity.<svg class="ink ink-circle" viewBox="0 0 300 120" preserveAspectRatio="none" aria-hidden="true"><path pathLength="1" d="M168 14 C 92 6, 16 22, 10 60 C 4 98, 96 112, 172 106 C 246 100, 294 82, 290 52 C 286 20, 214 4, 124 12"/></svg></span></span></span>
                    <span class="line"><span class="line-in"><em>Built around</em></span></span>
                    <span class="line"><span class="line-in"><em>your business.</em></span></span>
                </h1>

                <p class="hand hero-note" aria-hidden="true">
                    <svg class="ink ink-arrow" viewBox="0 0 90 60" aria-hidden="true"><path pathLength="1" d="M84 52 C 58 52, 24 42, 14 10"/><path pathLength="1" d="M5 22 L13 8 L27 17"/></svg>
                    <span class="hand-write">where every engagement begins</span>
                </p>

                <p class="lead">Audit, accounting and advisory expertise designed to strengthen compliance, improve financial visibility and support better business decisions.</p>

                <div class="hero-actions">
                    <a class="btn btn-gold" href="#services">Explore our services
                        <svg width="14" height="14" viewBox="0 0 14 14" aria-hidden="true"><path d="M2 7h10M8 3l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <a class="btn btn-line" href="#contact">Speak to our team</a>
                </div>
            </div>

            <div class="hero-visual">
                <figure class="ledger" aria-label="Illustrative example of a management review with adviser notes">
                    <div class="ledger-head">
                        <span class="ledger-kicker">Management review</span>
                        <span class="ledger-tag">Illustrative</span>
                    </div>
                    <p class="ledger-title">Quarterly performance summary</p>

                    <div class="ledger-rows">
                        <div class="ledger-row" data-row="1">
                            <span class="l-label">Revenue</span>
                            <span class="l-bar"><i style="--w:82%"></i></span>
                            <span class="l-val">R 4 820k</span>
                            <span class="note note-tick hand hand-write" aria-hidden="true">
                                <svg class="ink" viewBox="0 0 30 26"><path pathLength="1" d="M3 14 L11 22 L27 4"/></svg>
                                reconciled
                            </span>
                        </div>
                        <div class="ledger-row" data-row="2">
                            <span class="l-label">Gross margin</span>
                            <span class="l-bar"><i style="--w:58%"></i></span>
                            <span class="l-val l-underline">38.4%
                                <svg class="ink ink-under" viewBox="0 0 120 14" preserveAspectRatio="none" aria-hidden="true"><path pathLength="1" d="M3 9 C 30 3, 70 4, 92 7 S 114 10, 117 5"/></svg>
                            </span>
                        </div>
                        <div class="ledger-row" data-row="3">
                            <span class="l-label">Operating costs</span>
                            <span class="l-bar"><i style="--w:46%"></i></span>
                            <span class="l-val">R 1 260k</span>
                        </div>
                        <div class="ledger-row" data-row="4">
                            <span class="l-label">Debtor days</span>
                            <span class="l-bar"><i style="--w:74%" class="warn"></i></span>
                            <span class="l-val l-circle">74
                                <svg class="ink ink-ring" viewBox="0 0 100 60" preserveAspectRatio="none" aria-hidden="true"><path pathLength="1" d="M58 6 C 26 2, 4 14, 5 32 C 6 52, 44 58, 70 54 C 92 50, 98 34, 92 20 C 86 8, 62 2, 40 8"/></svg>
                            </span>
                        </div>
                        <div class="ledger-row" data-row="5">
                            <span class="l-label">Cash runway</span>
                            <span class="l-bar"><i style="--w:38%"></i></span>
                            <span class="l-val">5.2 mo</span>
                        </div>
                    </div>

                    <div class="ledger-chart" aria-hidden="true">
                        <svg viewBox="0 0 320 80" preserveAspectRatio="none">
                            <path class="chart-area" d="M0 70 C 30 66, 50 58, 80 60 S 130 46, 160 48 S 210 30, 240 32 S 290 14, 320 10 V 80 H 0 Z"/>
                            <path class="chart-line" pathLength="1" d="M0 70 C 30 66, 50 58, 80 60 S 130 46, 160 48 S 210 30, 240 32 S 290 14, 320 10"/>
                        </svg>
                    </div>

                    <p class="ledger-foot hand hand-write" aria-hidden="true">
                        <svg class="ink ink-arrow-sm" viewBox="0 0 60 30"><path pathLength="1" d="M4 22 C 18 8, 36 6, 52 12"/><path pathLength="1" d="M42 4 L53 12 L42 19"/></svg>
                        follow up debtors → cash-flow plan
                    </p>
                </figure>
            </div>
        </div>

        <a class="scroll-cue" href="#pillars" aria-label="Scroll to the next section"><span></span></a>
    </section>

    <!-- ============ TRUST STRIP ============ -->
    <section class="trust" id="pillars" aria-label="Our principles">
        <div class="container trust-inner">
            <p><span class="tri-dot" aria-hidden="true"></span>Independent thinking.</p>
            <p><span class="tri-dot" aria-hidden="true"></span>Technical precision.</p>
            <p><span class="tri-dot" aria-hidden="true"></span>Practical financial insight.</p>
        </div>
    </section>

    <!-- ============ ABOUT ============ -->
    <section class="section about" id="about" aria-labelledby="aboutTitle">
        <div class="container about-grid">
            <div class="about-head reveal">
                <p class="eyebrow">About Tri-Core</p>
                <h2 id="aboutTitle">More than <span class="underlined">financial reporting.<svg class="ink ink-under" viewBox="0 0 300 20" preserveAspectRatio="none" aria-hidden="true"><path pathLength="1" d="M4 13 C 70 5, 150 4, 220 9 S 286 14, 296 6"/></svg></span></h2>
                <p class="hand hand-write about-note" aria-hidden="true">plain language — always.</p>
            </div>
            <div class="about-body reveal">
                <p class="big">Tri-Core Financial Group helps businesses understand the numbers behind their organisation, meet their regulatory responsibilities and make stronger financial decisions.</p>
                <p>We combine technical financial expertise with practical commercial thinking, giving our clients clear information rather than unnecessary complexity.</p>
            </div>
        </div>

        <div class="container values">
            <article class="value reveal">
                <span class="value-letter" aria-hidden="true">C</span>
                <h3>Clarity</h3>
                <p>Complex financial matters explained plainly, so decisions are made on understanding — not guesswork.</p>
            </article>
            <article class="value reveal">
                <span class="value-letter" aria-hidden="true">I</span>
                <h3>Integrity</h3>
                <p>Independent, objective work that you and your stakeholders can rely on.</p>
            </article>
            <article class="value reveal">
                <span class="value-letter" aria-hidden="true">P</span>
                <h3>Precision</h3>
                <p>Disciplined methods and careful attention to the detail that matters.</p>
            </article>
        </div>
    </section>

    <!-- ============ THREE CORES ============ -->
    <section class="section cores" id="services" aria-labelledby="coresTitle">
        <div class="container">
            <div class="section-head reveal">
                <div>
                    <p class="eyebrow">What we do</p>
                    <h2 id="coresTitle">One financial partner.<br><em>Three core disciplines.</em></h2>
                </div>
                <p>Tri-Core is structured around the financial information businesses need most: reliable reporting, sound compliance and practical insight for decision-making.</p>
            </div>

            <div class="core-grid">
                <article class="core reveal" id="core-01">
                    <span class="core-no" aria-hidden="true">01</span>
                    <p class="core-kicker">Core 01 — Assurance</p>
                    <h3>Audit &amp; Assurance</h3>
                    <p>Independent insight and assurance designed to strengthen confidence in financial reporting, governance and controls.</p>
                    <ul class="core-list">
                        <li>External audit<sup>*</sup></li>
                        <li>Independent reviews<sup>*</sup></li>
                        <li>Assurance engagements<sup>*</sup></li>
                        <li>Internal controls &amp; risk assessment</li>
                        <li>Compliance reporting</li>
                    </ul>
                    <a class="core-link" href="#contact" data-service="Audit &amp; Assurance">Discuss your requirements <span aria-hidden="true">→</span></a>
                </article>

                <article class="core reveal" id="core-02">
                    <span class="core-no" aria-hidden="true">02</span>
                    <p class="core-kicker">Core 02 — Reporting</p>
                    <h3>Accounting &amp; Tax</h3>
                    <p>Accurate financial reporting, accounting and tax support structured around the needs of your organisation.</p>
                    <ul class="core-list">
                        <li>Annual financial statements</li>
                        <li>Monthly accounting &amp; bookkeeping</li>
                        <li>Tax compliance<sup>*</sup></li>
                        <li>Payroll<sup>*</sup></li>
                        <li>Company secretarial<sup>*</sup></li>
                    </ul>
                    <a class="core-link" href="#contact" data-service="Accounting &amp; Tax">Discuss your requirements <span aria-hidden="true">→</span></a>
                </article>

                <article class="core reveal" id="core-03">
                    <span class="core-no" aria-hidden="true">03</span>
                    <p class="core-kicker">Core 03 — Insight</p>
                    <h3>Advisory</h3>
                    <p>Financial intelligence and practical guidance that help management understand performance and make informed decisions.</p>
                    <ul class="core-list">
                        <li>Management reporting</li>
                        <li>Budgeting &amp; cash-flow planning</li>
                        <li>Financial modelling</li>
                        <li>Business advisory</li>
                        <li>Due diligence<sup>*</sup></li>
                    </ul>
                    <a class="core-link" href="#contact" data-service="Advisory">Discuss your requirements <span aria-hidden="true">→</span></a>
                </article>
            </div>

            <p class="footnote"><sup>*</sup> Service availability and regulated-service wording will be confirmed against Tri-Core's professional registrations before launch.</p>
        </div>
    </section>

    <!-- ============ SCROLL STORY ============ -->
    <section class="story" id="insight" aria-labelledby="storyTitle">
        <div class="story-sticky">
            <div class="container story-grid">
                <div class="story-copy">
                    <p class="eyebrow">See the business behind the numbers</p>
                    <h2 class="story-word-wrap" id="storyTitle">
                        <span class="sr-only">Compliance, clarity, control, growth.</span>
                        <span class="story-word is-active" aria-hidden="true">Compliance</span>
                        <span class="story-word" aria-hidden="true">Clarity</span>
                        <span class="story-word" aria-hidden="true">Control</span>
                        <span class="story-word" aria-hidden="true">Growth</span>
                    </h2>
                    <div class="story-lines">
                        <p class="story-line is-active">Meet your obligations accurately and on time — the foundation everything else is built on.</p>
                        <p class="story-line">Turn compliant records into information management can actually read and use.</p>
                        <p class="story-line">Clear information exposes risk early, so you can act before it becomes a problem.</p>
                        <p class="story-line">With control in place, decisions about the future are made with confidence.</p>
                    </div>
                    <ol class="story-steps" aria-hidden="true">
                        <li class="is-active"><span>01</span></li>
                        <li><span>02</span></li>
                        <li><span>03</span></li>
                        <li><span>04</span></li>
                    </ol>
                </div>

                <div class="story-chart" aria-hidden="true">
                    <svg viewBox="0 0 600 400" preserveAspectRatio="xMidYMid meet">
                        <g class="sc-grid">
                            <path d="M40 60 H580"/><path d="M40 140 H580"/><path d="M40 220 H580"/><path d="M40 300 H580"/>
                            <path d="M40 360 H580"/>
                        </g>
                        <path class="sc-line-ghost" d="M40 330 C 90 326, 120 310, 170 300 S 240 268, 300 250 S 380 176, 440 160 S 520 92, 570 64"/>
                        <path class="sc-line" id="storyLine" pathLength="1" d="M40 330 C 90 326, 120 310, 170 300 S 240 268, 300 250 S 380 176, 440 160 S 520 92, 570 64"/>
                        <g class="sc-points">
                            <circle cx="170" cy="300" r="6"/><circle cx="300" cy="250" r="6"/><circle cx="440" cy="160" r="6"/><circle cx="570" cy="64" r="6"/>
                        </g>
                    </svg>
                    <span class="sc-note hand" style="--x:28.3%;--y:75%">compliant ✓</span>
                    <span class="sc-note hand" style="--x:50%;--y:62.5%">now it reads clearly</span>
                    <span class="sc-note hand" style="--x:73.3%;--y:40%">risk spotted early</span>
                    <span class="sc-note hand" style="--x:95%;--y:16%">room to grow ↗</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ WHY TRI-CORE ============ -->
    <section class="section why" aria-labelledby="whyTitle">
        <div class="container">
            <div class="why-head reveal">
                <p class="eyebrow">Why Tri-Core</p>
                <h2 id="whyTitle">Numbers tell you what happened.<br><em>We help you understand <span class="underlined">what comes next.<svg class="ink ink-under" viewBox="0 0 300 20" preserveAspectRatio="none" aria-hidden="true"><path pathLength="1" d="M4 10 C 60 15, 140 4, 210 8 S 280 13, 296 7"/></svg></span></em></h2>
            </div>

            <div class="why-grid">
                <article class="why-item reveal">
                    <span class="why-no">01</span>
                    <h3>Technical precision</h3>
                    <p>Accurate, disciplined financial work you can build on.</p>
                </article>
                <article class="why-item reveal">
                    <span class="why-no">02</span>
                    <h3>Commercial perspective</h3>
                    <p>We look beyond compliance to the business decisions behind the numbers.</p>
                </article>
                <article class="why-item reveal">
                    <span class="why-no">03</span>
                    <h3>Direct communication</h3>
                    <p>Complex financial matters explained clearly, by the people doing the work.</p>
                </article>
                <article class="why-item reveal">
                    <span class="why-no">04</span>
                    <h3>Long-term thinking</h3>
                    <p>Reporting and financial structures designed to support sustainable growth.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- ============ INDUSTRIES ============ -->
    <section class="section industries" id="industries" aria-labelledby="indTitle">
        <div class="container">
            <div class="section-head reveal">
                <div>
                    <p class="eyebrow">Who we work with</p>
                    <h2 id="indTitle">Financial support that fits<br><em>the way you operate.</em></h2>
                </div>
                <p class="hand hand-write ind-note" aria-hidden="true">don't see yours? ask us →</p>
            </div>

            <ul class="ind-grid">
                <li class="reveal"><span class="ind-no">01</span>Owner-managed businesses &amp; SMEs</li>
                <li class="reveal"><span class="ind-no">02</span>Professional services</li>
                <li class="reveal"><span class="ind-no">03</span>Property &amp; construction</li>
                <li class="reveal"><span class="ind-no">04</span>Retail &amp; commerce</li>
                <li class="reveal"><span class="ind-no">05</span>Manufacturing</li>
                <li class="reveal"><span class="ind-no">06</span>Corporate organisations</li>
            </ul>
        </div>
    </section>

    <!-- ============ PROCESS ============ -->
    <section class="section process" id="approach" aria-labelledby="procTitle">
        <div class="container">
            <div class="section-head reveal">
                <div>
                    <p class="eyebrow">Our approach</p>
                    <h2 id="procTitle">A clear method,<br><em>from first meeting to forward plan.</em></h2>
                </div>
                <p>Every engagement follows the same disciplined path, so you always know where things stand and what happens next.</p>
            </div>

            <ol class="steps">
                <li class="step reveal">
                    <span class="step-no">01</span>
                    <h3>Discover</h3>
                    <p>We start with your objectives, the numbers and the operating reality behind them.</p>
                    <svg class="ink step-arrow" viewBox="0 0 80 40" aria-hidden="true"><path pathLength="1" d="M4 26 C 24 8, 50 6, 72 18"/><path pathLength="1" d="M60 10 L73 18 L62 28"/></svg>
                </li>
                <li class="step reveal">
                    <span class="step-no">02</span>
                    <h3>Analyse</h3>
                    <p>We focus on material risks, reporting requirements and financial priorities.</p>
                    <svg class="ink step-arrow" viewBox="0 0 80 40" aria-hidden="true"><path pathLength="1" d="M4 14 C 26 30, 52 30, 72 16"/><path pathLength="1" d="M60 10 L73 16 L64 27"/></svg>
                </li>
                <li class="step reveal">
                    <span class="step-no">03</span>
                    <h3>Deliver</h3>
                    <p>Structured work, concise reporting and direct communication throughout.</p>
                    <svg class="ink step-arrow" viewBox="0 0 80 40" aria-hidden="true"><path pathLength="1" d="M4 26 C 24 8, 50 6, 72 18"/><path pathLength="1" d="M60 10 L73 18 L62 28"/></svg>
                </li>
                <li class="step reveal">
                    <span class="step-no">04</span>
                    <h3>Advise</h3>
                    <p>We turn financial information into practical insight for your next decision.</p>
                </li>
            </ol>
        </div>
    </section>

    <!-- ============ CTA ============ -->
    <section class="cta" aria-labelledby="ctaTitle">
        <div class="container cta-inner reveal">
            <h2 id="ctaTitle">Better financial decisions<br><em>start with better information.</em></h2>
            <p>Speak to Tri-Core Financial Group about your accounting, assurance and advisory requirements.</p>
            <div class="cta-actions">
                <a class="btn btn-gold" href="#contact">Arrange a consultation</a>
                <span class="hand cta-hand" aria-hidden="true">let's talk
                    <svg class="ink ink-under" viewBox="0 0 160 16" preserveAspectRatio="none"><path pathLength="1" d="M3 10 C 40 4, 100 4, 156 9"/></svg>
                </span>
            </div>
        </div>
    </section>

    <!-- ============ CONTACT ============ -->
    <section class="section contact" id="contact" aria-labelledby="contactTitle">
        <div class="container contact-grid">
            <div class="contact-panel reveal">
                <p class="eyebrow">Start a conversation</p>
                <h2 id="contactTitle">Let's talk.</h2>
                <p>Tell us what you need and we'll route your enquiry to the right part of Tri-Core Financial Group.</p>

                <ul class="contact-list">
                    <li>
                        <span class="c-label">General enquiries</span>
                        <a href="mailto:<?= e($site['emails']['admin']) ?>"><?= e($site['emails']['admin']) ?></a>
                    </li>
                    <li>
                        <span class="c-label">Ricardo</span>
                        <a href="mailto:<?= e($site['emails']['ricardo']) ?>"><?= e($site['emails']['ricardo']) ?></a>
                    </li>
                </ul>

                <p class="contact-warn">Please don't send confidential documents through this form. If secure document exchange is needed, we'll arrange it with you directly.</p>
            </div>

            <div class="form-panel reveal">
                <form class="enquiry" id="enquiryForm" novalidate data-email="<?= e($site['emails']['admin']) ?>">
                    <div class="form-grid">
                        <div class="field">
                            <label for="fName">Name</label>
                            <input id="fName" name="name" type="text" autocomplete="name" maxlength="120" required>
                        </div>
                        <div class="field">
                            <label for="fCompany">Company <span class="opt">optional</span></label>
                            <input id="fCompany" name="company" type="text" autocomplete="organization" maxlength="160">
                        </div>
                        <div class="field">
                            <label for="fEmail">Email</label>
                            <input id="fEmail" name="email" type="email" autocomplete="email" maxlength="160" required>
                        </div>
                        <div class="field">
                            <label for="fPhone">Telephone <span class="opt">optional</span></label>
                            <input id="fPhone" name="phone" type="tel" autocomplete="tel" maxlength="30" inputmode="tel">
                        </div>
                        <div class="field full">
                            <label for="fService">Service required</label>
                            <select id="fService" name="service" required>
                                <option value="">Select a service…</option>
                                <option>Audit &amp; Assurance</option>
                                <option>Accounting &amp; Tax</option>
                                <option>Advisory</option>
                                <option>General enquiry</option>
                            </select>
                        </div>
                        <div class="field full">
                            <label for="fMessage">How can we help?</label>
                            <textarea id="fMessage" name="message" rows="5" maxlength="3000" required></textarea>
                        </div>
                        <div class="field full check">
                            <input id="fConsent" name="consent" type="checkbox" required>
                            <label for="fConsent">I agree that Tri-Core may use these details to respond to my enquiry.</label>
                        </div>
                        <div class="field full">
                            <button class="btn btn-gold btn-block" type="submit">Send enquiry</button>
                        </div>
                    </div>
                    <p class="form-status" id="formStatus" role="status" aria-live="polite"></p>
                </form>
            </div>
        </div>
    </section>

</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
