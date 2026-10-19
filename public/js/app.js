// ── Mobile nav toggle ──
document.getElementById('navToggle')?.addEventListener('click', () => {
  document.getElementById('mobileNav').classList.toggle('open');
});

// ── Hero slider (home) ──
(function () {
  const slides = document.querySelectorAll('.hero-slide');
  const dots   = document.querySelectorAll('.hero-dot');
  if (slides.length < 2) return;
  let current = 0, timer;

  function goTo(n) {
    slides[current].classList.remove('active');
    dots[current].classList.remove('active');
    current = (n + slides.length) % slides.length;
    slides[current].classList.add('active');
    dots[current].classList.add('active');
  }

  function startTimer() { timer = setInterval(() => goTo(current + 1), 5000); }

  dots.forEach((dot, i) => dot.addEventListener('click', () => {
    clearInterval(timer);
    goTo(i);
    startTimer();
  }));

  startTimer();
})();

// ── Nav scroll-spy (home only: links point at in-page anchors) ──
(function () {
  const navLinks = document.querySelectorAll('.nav-links > li > a[href^="#"], .mobile-nav a[href^="#"]');
  if (!navLinks.length) return;
  let scrollLocked = false, lockTimer;

  function setNavActive(href) {
    navLinks.forEach(a => a.classList.toggle('active', a.getAttribute('href') === href));
  }

  navLinks.forEach(a => a.addEventListener('click', () => {
    setNavActive(a.getAttribute('href'));
    scrollLocked = true;
    clearTimeout(lockTimer);
    lockTimer = setTimeout(() => { scrollLocked = false; }, 1500);
  }));

  const observer = new IntersectionObserver(entries => {
    if (scrollLocked) return;
    entries.forEach(entry => {
      if (entry.isIntersecting) setNavActive('#' + entry.target.id);
    });
  }, { rootMargin: '-40% 0px -55% 0px' });

  document.querySelectorAll('section[id]').forEach(s => observer.observe(s));

  function checkTop() {
    if (!scrollLocked && window.scrollY < 80) setNavActive('#top');
  }
  window.addEventListener('scroll', checkTop, { passive: true });
  checkTop();
})();

// ── Card filters: event tabs (home) and toolkit stages (self-learning) ──
function bindFilter(buttonSelector, cardSelector, key) {
  const buttons = document.querySelectorAll(buttonSelector);
  buttons.forEach(btn => btn.addEventListener('click', () => {
    buttons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const value = btn.dataset[key];
    document.querySelectorAll(cardSelector).forEach(card => {
      card.hidden = value !== 'all' && card.dataset[key] !== value;
    });
  }));
}
bindFilter('.event-tabs button.tab-btn', '#eventsGrid .event-card', 'type');
bindFilter('.toolkit-filter button', '.toolkit-card', 'stage');

// ── Smooth scroll for in-page anchors ──
document.querySelectorAll('a[href^="#"]:not(.nav-parent)').forEach(a => {
  a.addEventListener('click', e => {
    const href = a.getAttribute('href');
    if (href === '#top') {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
      return;
    }
    if (href.length < 2) return;
    const target = document.querySelector(href);
    if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
  });
});

// ── Video modal ──
(function () {
  const modal   = document.getElementById('videoModal');
  const frame   = document.getElementById('videoFrame');
  if (!modal || !frame) return;

  function toEmbedUrl(url) {
    try {
      const u = new URL(url);
      // youtube.com/watch?v=ID  or  youtu.be/ID
      if (u.hostname.includes('youtube.com')) {
        const id = u.searchParams.get('v');
        return id ? `https://www.youtube.com/embed/${id}?autoplay=1` : url;
      }
      if (u.hostname === 'youtu.be') {
        return `https://www.youtube.com/embed${u.pathname}?autoplay=1`;
      }
      // vimeo.com/ID
      if (u.hostname.includes('vimeo.com')) {
        return `https://player.vimeo.com/video${u.pathname}?autoplay=1`;
      }
    } catch (_) {}
    return url;
  }

  function openModal(videoUrl) {
    frame.src = toEmbedUrl(videoUrl);
    modal.hidden = false;
    document.body.style.overflow = 'hidden';
    modal.querySelector('.video-modal-close').focus();
  }

  function closeModal() {
    modal.hidden = true;
    frame.src = '';
    document.body.style.overflow = '';
  }

  document.querySelectorAll('.play-btn[data-video]').forEach(btn => {
    btn.addEventListener('click', () => openModal(btn.dataset.video));
  });

  modal.querySelector('.video-modal-close').addEventListener('click', closeModal);
  modal.querySelector('.video-modal-backdrop').addEventListener('click', closeModal);
  document.addEventListener('keydown', e => { if (e.key === 'Escape' && !modal.hidden) closeModal(); });
})();

// ── Password visibility (auth pages) ──
function toggleEye(inputId, btn) {
  const input = document.getElementById(inputId);
  const isText = input.type === 'text';
  input.type = isText ? 'password' : 'text';
  btn.querySelector('.eye-off').style.display = isText ? '' : 'none';
  btn.querySelector('.eye-on').style.display  = isText ? 'none' : '';
}
