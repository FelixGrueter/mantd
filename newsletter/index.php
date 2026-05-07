<?php
session_start();
?>
<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Newsletter – MANTD | Make All Nations To Disciples</title>
  <meta name="description"
    content="Melde dich für den MANTD-Newsletter an und bleibe auf dem Laufenden über Mission Trips, Visionen und Gottes Wirken.">
  <meta name="robots" content="noindex, nofollow">
  <link rel="stylesheet" href="assets/fonts.css">
  <link rel="stylesheet" href="style.css">
  <style>
    /* ===== PAGE-SPECIFIC OVERRIDES ===== */

    /* Minimal header – kein fixed nav, kein Burger */
    .nl-header {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: var(--space-8) var(--space-6);
      border-bottom: 1px solid var(--color-border);
      background: var(--color-base);
    }

    .nl-header__logo-img {
      height: 40px;
      width: auto;
      display: block;
      filter: brightness(1.1) drop-shadow(0 0 8px rgba(240, 237, 232, 0.15));
    }

    /* ===== HERO / MAIN SECTION ===== */
    .nl-hero {
      position: relative;
      min-height: calc(100svh - 80px);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      padding: var(--space-24) 0;
    }

    /* Ambient gradient background */
    .nl-hero::before {
      content: '';
      position: absolute;
      top: -20%;
      left: 50%;
      transform: translateX(-50%);
      width: 80%;
      height: 140%;
      background: radial-gradient(ellipse at center top,
          rgba(232, 98, 44, 0.12) 0%,
          rgba(26, 123, 255, 0.04) 50%,
          transparent 70%);
      pointer-events: none;
      z-index: 0;
    }

    .nl-hero::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: var(--color-border);
    }

    .nl-hero__inner {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 640px;
      margin-inline: auto;
      padding-inline: clamp(1.25rem, 5vw, 2.5rem);
      text-align: center;
    }

    /* Icon badge */
    .nl-badge {
      display: inline-flex;
      align-items: center;
      gap: var(--space-2);
      padding: 0.45em 1.1em;
      background: rgba(232, 98, 44, 0.1);
      border: 1px solid rgba(232, 98, 44, 0.25);
      border-radius: 50px;
      font-size: var(--text-xs);
      font-weight: 600;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--color-accent);
      margin-bottom: var(--space-8);
      animation: badgePulse 3s ease-in-out infinite;
    }

    @keyframes badgePulse {
      0%, 100% { box-shadow: 0 0 0 0 rgba(232, 98, 44, 0); }
      50% { box-shadow: 0 0 0 6px rgba(232, 98, 44, 0.08); }
    }

    .nl-badge__dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--color-accent);
      animation: dotBlink 1.5s ease-in-out infinite;
    }

    @keyframes dotBlink {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.3; }
    }

    /* Headings */
    .nl-hero__title {
      font-family: var(--font-display);
      font-size: clamp(3rem, 8vw, 5.5rem);
      line-height: 0.95;
      letter-spacing: 0.02em;
      text-transform: uppercase;
      margin-bottom: var(--space-6);
    }

    .nl-hero__title .accent {
      color: var(--color-accent);
    }

    .nl-hero__subtitle {
      font-size: var(--text-lg);
      color: var(--color-muted);
      font-weight: 300;
      line-height: 1.7;
      margin-bottom: var(--space-12);
      max-width: 500px;
      margin-inline: auto;
      margin-bottom: var(--space-12);
    }

    /* Divider ornament */
    .nl-divider {
      display: flex;
      align-items: center;
      gap: var(--space-4);
      margin-bottom: var(--space-12);
      opacity: 0.3;
    }

    .nl-divider::before,
    .nl-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--color-border);
    }

    .nl-divider__icon {
      font-size: 0.9rem;
      color: var(--color-accent);
    }

    /* ===== NEWSLETTER FORM CARD ===== */
    .nl-card {
      background: var(--color-surface-2);
      border: 1px solid var(--color-border);
      border-radius: 4px;
      padding: clamp(var(--space-8), 6vw, var(--space-12));
      position: relative;
      overflow: hidden;
      box-shadow: 0 24px 60px rgba(0, 0, 0, 0.4);
    }

    /* Accent top bar */
    .nl-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--color-accent), var(--color-accent-blue));
    }

    /* Subtle gradient shimmer inside */
    .nl-card::after {
      content: '';
      position: absolute;
      inset: -1px;
      background: linear-gradient(135deg, rgba(232, 98, 44, 0.06) 0%, transparent 60%);
      z-index: 0;
      border-radius: inherit;
      pointer-events: none;
    }

    .nl-card__content {
      position: relative;
      z-index: 1;
    }

    .nl-card__icon {
      font-size: 2.5rem;
      margin-bottom: var(--space-4);
      display: block;
      filter: drop-shadow(0 0 12px rgba(232, 98, 44, 0.4));
    }

    .nl-card__heading {
      font-family: var(--font-display);
      font-size: var(--text-2xl);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: var(--space-3);
    }

    .nl-card__text {
      font-size: var(--text-base);
      color: var(--color-muted);
      font-weight: 300;
      line-height: 1.7;
      margin-bottom: var(--space-8);
    }

    /* Form */
    .nl-form {
      display: flex;
      flex-direction: column;
      gap: var(--space-4);
    }

    .nl-form__input {
      font-family: var(--font-body);
      font-size: var(--text-sm);
      padding: 1em 1.25em;
      background: var(--color-surface);
      border: 1px solid var(--color-border);
      border-radius: 2px;
      color: var(--color-text);
      transition: border-color 0.3s, box-shadow 0.3s;
      outline: none;
      width: 100%;
    }

    .nl-form__input:focus {
      border-color: var(--color-accent);
      box-shadow: 0 0 0 3px rgba(232, 98, 44, 0.12), 0 0 15px rgba(232, 98, 44, 0.1);
    }

    .nl-form__input::placeholder {
      color: var(--color-muted);
      opacity: 0.7;
    }

    .nl-form__submit {
      width: 100%;
      justify-content: center;
      padding: 1em 2em;
      font-size: var(--text-base);
      font-weight: 700;
      letter-spacing: 0.03em;
    }

    /* Loading state */
    .nl-form__submit[disabled] {
      opacity: 0.7;
      cursor: not-allowed;
      transform: none !important;
    }

    /* Success state */
    .nl-success {
      display: none;
      text-align: center;
      padding: var(--space-8) 0;
    }

    .nl-success__icon {
      font-size: 3rem;
      margin-bottom: var(--space-4);
      display: block;
      animation: successPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes successPop {
      from { transform: scale(0); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    .nl-success__title {
      font-family: var(--font-display);
      font-size: var(--text-xl);
      text-transform: uppercase;
      color: var(--color-accent);
      margin-bottom: var(--space-3);
    }

    .nl-success__text {
      font-size: var(--text-sm);
      color: var(--color-muted);
      font-weight: 300;
      line-height: 1.7;
    }

    /* Error message */
    .nl-error {
      display: none;
      color: #f87171;
      font-size: var(--text-sm);
      font-weight: 500;
      margin-top: var(--space-2);
    }

    .nl-error.visible {
      display: block;
    }

    /* ===== TRUST INDICATORS ===== */
    .nl-trust {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: var(--space-6);
      margin-top: var(--space-8);
    }

    .nl-trust__item {
      display: flex;
      align-items: center;
      gap: var(--space-2);
      font-size: var(--text-xs);
      color: var(--color-muted);
      font-weight: 500;
    }

    .nl-trust__item svg {
      width: 14px;
      height: 14px;
      color: var(--color-accent);
      flex-shrink: 0;
    }

    /* ===== VERSE SECTION ===== */
    .nl-verse {
      padding: var(--space-16) 0;
      text-align: center;
      border-top: 1px solid var(--color-border);
    }

    .nl-verse__text {
      font-family: var(--font-script);
      font-size: clamp(1.4rem, 3vw, 2rem);
      color: var(--color-muted);
      max-width: 650px;
      margin: 0 auto var(--space-3);
      line-height: 1.55;
    }

    .nl-verse__ref {
      font-size: var(--text-xs);
      text-transform: uppercase;
      letter-spacing: 0.15em;
      color: var(--color-accent);
    }

    /* ===== FOOTER ===== */
    /* Uses existing .footer styles from style.css, just override link list */
    .footer__links--minimal {
      gap: var(--space-4) var(--space-8);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 480px) {
      .nl-trust {
        flex-direction: column;
        align-items: center;
        gap: var(--space-3);
      }
    }
  </style>
</head>

<body>

  <!-- ======= MINIMAL HEADER ======= -->
  <header class="nl-header" role="banner">
    <a href="index.php" aria-label="MANTD – Startseite">
      <img src="assets/images/mantd-logo-weiss.png" alt="MANTD Logo" class="nl-header__logo-img">
    </a>
  </header>

  <!-- ======= MAIN HERO / SIGNUP ======= -->
  <main>
    <section class="nl-hero" id="newsletter-anmeldung">
      <div class="nl-hero__inner">

        <!-- Badge -->
        <div class="nl-badge">
          <span class="nl-badge__dot"></span>
          Newsletter
        </div>

        <!-- Headline -->
        <h1 class="nl-hero__title">
          Bleib<br>
          <span class="accent">verbunden.</span>
        </h1>
        <p class="nl-hero__subtitle">
          Hol dir Updates über Mission Trips, Visionen und Gottes Wirken direkt in dein Postfach.
          Kein Spam – nur das, was wirklich zählt.
        </p>

        <!-- Divider -->
        <div class="nl-divider">
          <span class="nl-divider__icon">✦</span>
        </div>

        <!-- Newsletter Card -->
        <div class="nl-card" role="region" aria-label="Newsletter Anmeldung">
          <div class="nl-card__content">
            <span class="nl-card__icon">✉️</span>
            <h2 class="nl-card__heading">Newsletter abonnieren</h2>
            <p class="nl-card__text">
              Trag deine E-Mail-Adresse ein und werde Teil der MANTD-Community.
              Du kannst dich jederzeit wieder abmelden.
            </p>

            <!-- Form -->
            <form class="nl-form" id="nlForm" novalidate>
              <label for="nlEmail" class="visually-hidden">E-Mail-Adresse</label>
              <input
                type="email"
                id="nlEmail"
                name="email"
                class="nl-form__input"
                placeholder="Deine E-Mail-Adresse"
                required
                autocomplete="email"
                inputmode="email"
              >
              <p class="nl-error" id="nlError" role="alert" aria-live="assertive"></p>
              <button type="submit" id="nlSubmit" class="btn btn--primary nl-form__submit">
                Jetzt anmelden
              </button>
            </form>

            <!-- Success State (hidden initially) -->
            <div class="nl-success" id="nlSuccess" role="status" aria-live="polite">
              <span class="nl-success__icon">🎉</span>
              <p class="nl-success__title">Willkommen im Team!</p>
              <p class="nl-success__text">Wir haben dir eine Bestätigungs-E-Mail geschickt.<br>Bitte bestätige deine Adresse, um die Anmeldung abzuschließen.</p>
            </div>
          </div>
        </div>

        <!-- Trust indicators -->
        <div class="nl-trust">
          <span class="nl-trust__item">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Sicher &amp; verschlüsselt
          </span>
          <span class="nl-trust__item">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            Kein Spam
          </span>
          <span class="nl-trust__item">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
            Jederzeit abmeldbar
          </span>
        </div>

      </div>
    </section>

    <!-- ======= VERSE ======= -->
    <section class="nl-verse">
      <p class="nl-verse__text">
        „So geht nun hin und macht zu Jüngern alle Völker."
      </p>
      <p class="nl-verse__ref">Mt 28:19</p>
    </section>
  </main>

  <!-- ======= FOOTER ======= -->
  <footer class="footer" role="contentinfo">
    <div class="container footer__inner">
      <a href="index.php" class="footer__logo">MANTD</a>
      <ul class="footer__links footer__links--minimal">
        <li><a href="datenschutz.html">Datenschutz</a></li>
        <li><a href="impressum.html">Impressum</a></li>
        <li><a href="index.php">Zurück zur Startseite</a></li>
      </ul>
      <p class="footer__copy">&copy; 2026 MANTD – Make All Nations To Disciples. Mt. 28:19</p>
    </div>
  </footer>

  <!-- ======= SCRIPTS ======= -->
  <style>
    /* Visually hidden (accessible label) */
    .visually-hidden {
      position: absolute;
      width: 1px;
      height: 1px;
      padding: 0;
      margin: -1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      white-space: nowrap;
      border: 0;
    }
  </style>

  <script>
    const nlForm     = document.getElementById('nlForm');
    const nlSubmit   = document.getElementById('nlSubmit');
    const nlError    = document.getElementById('nlError');
    const nlSuccess  = document.getElementById('nlSuccess');
    const nlEmailInput = document.getElementById('nlEmail');

    nlForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      // Reset state
      nlError.textContent = '';
      nlError.classList.remove('visible');

      const email = nlEmailInput.value.trim();

      // Client-side validation
      if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        nlError.textContent = 'Bitte gib eine gültige E-Mail-Adresse ein.';
        nlError.classList.add('visible');
        nlEmailInput.focus();
        return;
      }

      // UI – loading
      const originalText = nlSubmit.textContent;
      nlSubmit.disabled = true;
      nlSubmit.setAttribute('aria-busy', 'true');
      nlSubmit.textContent = '…';

      try {
        const formData = new FormData();
        formData.append('email', email);

        const response = await fetch('newsletter_subscribe.php', {
          method: 'POST',
          body: formData
        });

        const result = await response.json();

        if (result.success) {
          // Show success, hide form
          nlForm.style.display = 'none';
          nlSuccess.style.display = 'block';
        } else {
          nlError.textContent = result.message || 'Ein Fehler ist aufgetreten. Bitte versuche es erneut.';
          nlError.classList.add('visible');
          nlSubmit.disabled = false;
          nlSubmit.removeAttribute('aria-busy');
          nlSubmit.textContent = originalText;
        }
      } catch (err) {
        nlError.textContent = 'Ein technischer Fehler ist aufgetreten. Bitte versuche es erneut.';
        nlError.classList.add('visible');
        nlSubmit.disabled = false;
        nlSubmit.removeAttribute('aria-busy');
        nlSubmit.textContent = originalText;
      }
    });

    // Real-time input feedback
    nlEmailInput.addEventListener('input', () => {
      if (nlError.classList.contains('visible')) {
        nlError.classList.remove('visible');
      }
    });
  </script>

</body>

</html>
